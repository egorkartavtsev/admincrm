<?php
class ControllerProductionAutoloadDrom extends Controller {
	public function index() {
		$this->load->model('tool/layout');
		$this->load->model("tool/excel");
		$this->load->model('tool/forms');
		$this->load->language('catalog/product');		
		$this->document->setTitle($this->language->get('heading_title'));		
		$data = $this->model_tool_layout->getLayout($this->request->get['route']);
		$user = $this->user->getUserInfo();
		$data['user'] = array(
			'access' => (int)$user['userAL']
		);
		$data['stocks'] = $this->model_tool_excel->getStocks();
		$filter_data = [];
		$data['filtLocation'] = $this->model_tool_forms->constructFiltLocationForm($filter_data);
		$this->response->setOutput($this->load->view('catalog/autoload_drom', $data));
	}
	
	public function download() {
		$this->load->model("common/excelDrom");
		
		$minPrice = $this->request->get['minPrice'];
		$maxPrice = $this->request->get['maxPrice'];
		
		$OrderExcel = new PHPExcel();
		$active_sheet_index = $OrderExcel->setActiveSheetIndex(0);
		$active_sheet = $OrderExcel->getActiveSheet(0);
		$active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$active_sheet->getColumnDimension('A')->setAutoSize(true);
		$active_sheet->getColumnDimension('B')->setAutoSize(true);
		$active_sheet->getColumnDimension('C')->setAutoSize(true);
		$active_sheet->getColumnDimension('D')->setAutoSize(true);
		$active_sheet->getColumnDimension('E')->setAutoSize(true);
		$active_sheet->getColumnDimension('F')->setAutoSize(true);
		$active_sheet->getColumnDimension('G')->setAutoSize(true);
		$active_sheet->getColumnDimension('H')->setAutoSize(true);
		$active_sheet->getColumnDimension('I')->setAutoSize(true);
		$active_sheet->getColumnDimension('J')->setAutoSize(true);
		$active_sheet->getColumnDimension('K')->setAutoSize(true);
	  
		$active_sheet->setCellValue('A1','Наименование товара');
		$active_sheet->setCellValue('B1','Новый/б.у.');
		$active_sheet->setCellValue('C1','Марка');
		$active_sheet->setCellValue('D1','Модель');
		$active_sheet->setCellValue('E1','Кузов');
		$active_sheet->setCellValue('F1','Номер');
		$active_sheet->setCellValue('G1','Двигатель');
		$active_sheet->setCellValue('H1','Год');
		$active_sheet->setCellValue('I1','L-R');
		$active_sheet->setCellValue('J1','F-R');
		$active_sheet->setCellValue('K1','U-D');
		$active_sheet->setCellValue('L1','Цвет');
		$active_sheet->setCellValue('M1','Примечание');
		$active_sheet->setCellValue('N1','Количество');
		$active_sheet->setCellValue('O1','Цена');
		$active_sheet->setCellValue('P1','Валюта');
		$active_sheet->setCellValue('Q1','Наличие');
		$active_sheet->setCellValue('R1','Срок доставки');
		$active_sheet->setCellValue('S1','Фотография');
		$Rur = 'RUR';
		$Avail = 'В наличии';
		$exlx = $this->model_common_excelDrom->getExlx($minPrice, $maxPrice);
		//exit(var_dump($exlx));
		$lp=2;
		foreach ($exlx->rows as $sqlr) {
			$sqlr['dsh'] = 'Запчасть';
			$sqlr['getdescr'] = $this->model_common_excelDrom->getDromDescription($sqlr);
			$sqlr['price'] = ceil(104*$sqlr['price']/5000) * 50;
			// если товар продаётся в комплекте, а комплект целиком, то некоторые поля изменятся в getCompInfo
			if(!empty($sqlr['comp']) && $sqlr['comp'] !== '0'){
				$sqlr = $this->model_common_excelDrom->getCompInfo($sqlr);
			}
			$photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
			$active_sheet->setCellValue('A'.$lp.'',''.$sqlr['podcat'].'');
			$active_sheet->setCellValue('B'.$lp.'',''.$sqlr['type'].'');
			$active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
			$active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
			$active_sheet->setCellValue('F'.$lp.'',''.$sqlr['vin'].'');
			$active_sheet->setCellValue('M'.$lp.'',''.$sqlr['getdescr'].'');
			$active_sheet->setCellValue('N'.$lp.'',''.$sqlr['quant'].'');
			$active_sheet->setCellValue('O'.$lp.'',''.$sqlr['price'].'');
			$active_sheet->setCellValue('P'.$lp.'','RUR');
			$active_sheet->setCellValue('Q'.$lp.'','В наличии');
			$active_sheet->setCellValue('S'.$lp.'',''.$photoDrom.'');
			$lp = $lp+1;
		}
		
	   // header ( "Expires: " . gmdate("D,d M YH:i:s") . " GMT" );
		header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		header ( "Cache-Control: no-cache, must-revalidate" );
		header ( "Pragma: no-cache" );
		header ( "Content-type: application/vnd.ms-excel" );
		header ( "Content-Disposition: attachment; filename=auto-parts-MGNAUTO.xls" );


		//$objWriter = PHPExcel_IOFactory::createWriter($OrderExcel, 'Excel5');
		//$objWriter->save('downloadXcelFiles/auto-parts-MGNAUTO.xls');
		$objWriter = new PHPExcel_Writer_Excel5($OrderExcel);
		$objWriter->save('php://output');
	}
	
}