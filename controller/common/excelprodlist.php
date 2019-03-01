<?php
    class ControllerCommonExcelprodlist extends Controller {
        
           public function index($err = 0, $mat = 0) {

            $this->load->model("tool/layout");
            $this->load->model("common/excel");
        //    $this->load->model("tool/excel");
            $this->load->model("common/excelDrom");
            $data = $this->model_tool_layout->getLayout($this->request->get['route']);
      
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
          
            $active_sheet->setCellValue('A1','id');
            $active_sheet->setCellValue('B1','name');
            $active_sheet->setCellValue('C1','vin');
            $active_sheet->setCellValue('D1','price');
            $active_sheet->setCellValue('E1','date');
            $exlxe = $this->db->query("SELECT "
                    . "si.id AS id, "
                    . "si.name AS name, "
                    . "si.sku AS vin, "
                    . "si.summ AS price, "
                    . "si.loc AS loc, "
                    . "si.date AS date "
                . "FROM ".DB_PREFIX."sales_info si "
                . "WHERE (si.id >= 2528 ) AND ( si.loc NOT LIKE '%KM%') AND (si.id <= 2692 )");
            //exit(var_dump($exlxe));
            $lp=2;
              foreach ($exlxe->rows as $sqlr) {
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['id'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['name'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['date'].'');
                                        $lp = $lp+1;
                                        }
            
            header ( "Expires: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-type: application/vnd.ms-excel" );
            header ( "Content-Disposition: attachment; filename=temp.xls" );


            $objWriter = PHPExcel_IOFactory::createWriter($OrderExcel, 'Excel5');
            $objWriter->save('php://output');
            //return $this->$OrderExcel;
        }
    }
    