<?php
    class ControllerCommonExcelDrom extends Controller {
        
           public function index($err = 0, $mat = 0) {

            $this->load->model("tool/layout");
            $this->load->model("common/excel");
            $this->load->model("tool/excel");
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
          
            $active_sheet->setCellValue('A1','Наименование товара');
            $active_sheet->setCellValue('B1','Новый/б.у.');
            $active_sheet->setCellValue('C1','Марка');
            $active_sheet->setCellValue('D1','Модель');
            $active_sheet->setCellValue('E1','внутренний номер');
            $active_sheet->setCellValue('F1','Примечание');
            $active_sheet->setCellValue('G1','Цена');
            $active_sheet->setCellValue('H1','Фотография');
            $active_sheet->setCellValue('I1','Описание');
            $active_sheet->setCellValue('J1','Каталожный номер');
            $active_sheet->setCellValue('K1','Количество');
            $exlxe = $this->db->query("SELECT "
                . "p.product_id AS pid, "
                . "p.podcateg AS podcat, " //Наименование товара
                . "p.type AS type, "      // б/у, новое
                . "p.brand AS brand, "    //Марка
                . "p.model AS model, "    //Модель
                . "p.vin AS vin, "        //внутренний номер
                . "p.price AS price, "      //Цена
                . "p.quantity AS quant, " //Количество 
                . "p.avito AS avito, "
                . "p.modR AS modRow, "
                . "p.note AS note, "
                . "p.catn AS catN, "
                . "p.comp AS comp, "
                . "p.cond AS cond, "
                . "p.compability AS compability,  "
                . "p.dop AS dop, "
                . "p.stock AS stock, "
                . "p.drom AS drom "
                . "FROM ".DB_PREFIX."product p "
                . "WHERE (p.quantity > 0) AND (p.podcateg != '') AND (p.price > 0)" );
           $complects_bd = $this->model_common_excelDrom->getComplectDrom();
            //exit(var_dump($exlxe));
            $lp=2;
              foreach ($exlxe->rows as $sqlr) {
              if ($sqlr['comp'] === '') {
                                      //$photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                      //$description = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['vin'].'');
                                      //$active_sheet->setCellValue('F'.$lp.'',''..'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['price'].'');
                                      //$active_sheet->setCellValue('H'.$lp.'',''.$photoDrom.'');
                                      //$active_sheet->setCellValue('I'.$lp.'',''.$description.'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $lp = $lp+1;
                                        }
          
          }
            foreach ($complects_bd as $sqlrt) {
                foreach ($exlxe->rows as $sqlr){
                if ((($sqlr['comp'] === $sqlrt['head'])or($sqlr['comp'] === $sqlrt['cid']))||($sqlrt['c_whole'] === 0)){
                    //$photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                      //$description = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['vin'].'');
                                      //$active_sheet->setCellValue('F'.$lp.'',''..'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['price'].'');
                                      //$active_sheet->setCellValue('H'.$lp.'',''.$photoDrom.'');
                                      //$active_sheet->setCellValue('I'.$lp.'',''.$description.'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $lp = $lp+1;
                }
                else { 
                    if (($sqlrt['cid'] === $sqlr['comp']) || ($sqlrt['c_whole'] === 1)) {
                                      //$photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                      //$description = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['vin'].'');
                                      //$active_sheet->setCellValue('F'.$lp.'',''..'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlrt['c_price'].'');
                                      //$active_sheet->setCellValue('H'.$lp.'',''.$photoDrom.'');
                                      //$active_sheet->setCellValue('I'.$lp.'',''.$description.'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $lp = $lp+1; 
                    }
                    
                    }
            }
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
    