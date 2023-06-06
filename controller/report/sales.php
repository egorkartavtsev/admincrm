<?php

class ControllerReportSales extends Controller{
    
    public function index(){
        $this->load->model('tool/layout');
        $this->load->model('tool/reports');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['sales'] = $this->model_tool_reports->getDefaultSales();
        $this->response->setOutput($this->load->view('report/sales', $data));
    }
    
    public function getData() {
        $filter = [];
        if(isset($this->request->post['filter'])){
            $filter_data = $this->request->post['filter'];
            foreach($filter_data as $filter_item){
                $filter[$filter_item['name']] = $filter_item['val'];
            }
        }
        $this->load->model('tool/reports');       
        $data = $this->model_tool_reports->getSales($filter);
        // $sumrow = 0;
        // exit(var_dump($data));
        // foreach($data as  $saleRows){
        //     $sumrow = $sumrow + $saleRows['summ'];
        // };
        echo json_encode($data);
        
    }
	
	public function downloadReport() {
		$this->load->model('tool/reports');
		
		$filter = [];
        if(isset($this->request->post['filter'])){
            $filter_data = $this->request->post['filter'];
            foreach($filter_data as $filter_item){
                $filter[$filter_item['name']] = $filter_item['val'];
            }
        }
		
		$data = $this->model_tool_reports->getSales($filter);
		
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
		$active_sheet->getColumnDimension('L')->setAutoSize(true);
	  
		$active_sheet->setCellValue('A1','Подкатегория');
		$active_sheet->setCellValue('B1','Марка');
		$active_sheet->setCellValue('C1','Модель');
		$active_sheet->setCellValue('D1','Донор');
		$active_sheet->setCellValue('E1','Внутр.номер');
		$active_sheet->setCellValue('F1','Цена продажи');
		$active_sheet->setCellValue('G1','Поставщик');
		$active_sheet->setCellValue('H1','Адрес');
		$active_sheet->setCellValue('I1','Дата продажи');
		$active_sheet->setCellValue('J1','Способ оплаты');
		$active_sheet->setCellValue('K1','Способ прожажи');
		$active_sheet->setCellValue('L1','Город покупателя');
		$lp=2;
		foreach ($data['saleRows'] as $row) {
			$active_sheet->setCellValue('A'.$lp.'',''.$row['podcateg'].'');
			$active_sheet->setCellValue('B'.$lp.'',''.$row['brand'].'');
			$active_sheet->setCellValue('C'.$lp.'',''.$row['model'].'');
			$active_sheet->setCellValue('D'.$lp.'',''.$row['numb'].'');
			$active_sheet->setCellValue('E'.$lp.'',''.$row['vin'].'');
			$active_sheet->setCellValue('F'.$lp.'',''.$row['saleprice'].'');
			$active_sheet->setCellValue('G'.$lp.'',''.$row['postаvsik'].'');
			$active_sheet->setCellValue('H'.$lp.'',''.$row['adress'].'');
			$active_sheet->setCellValue('I'.$lp.'',''.$row['date'].'');
			$active_sheet->setCellValue('J'.$lp.'',''.$row['opl_type'].'');
			$active_sheet->setCellValue('K'.$lp.'',''.$row['wherefrom'].'');
			$active_sheet->setCellValue('L'.$lp.'',''.$row['city'].'');
			$lp = $lp+1;
		}
		$objWriter = new PHPExcel_Writer_Excel5($OrderExcel);
		$path = "downloadXcelFiles/sales-report.xls";
		$objWriter->save("" . $path . "");
		echo ($path);
	}
    
}