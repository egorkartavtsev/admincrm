<?php
    class ControllerCommonExcelBibinet extends Controller {
        
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
          
            $active_sheet->setCellValue('A1','Инвентарный номер');
            $active_sheet->setCellValue('B1','Наименование');
            $active_sheet->setCellValue('C1','Марка');
            $active_sheet->setCellValue('D1','Модель');
            $active_sheet->setCellValue('E1','Кузов');
            $active_sheet->setCellValue('F1','Номер оптики');
            $active_sheet->setCellValue('G1','Двигатель');
            $active_sheet->setCellValue('H1','Перед/Зад');
            $active_sheet->setCellValue('I1','Право/Лево');
            $active_sheet->setCellValue('J1','Верх/Низ');
            $active_sheet->setCellValue('K1','Цвет');
            $active_sheet->setCellValue('L1','Год');
            $active_sheet->setCellValue('M1','Стоимость');
            $active_sheet->setCellValue('N1','Примечание');
            $active_sheet->setCellValue('O1','Фотографии');  
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
                  $sqlr['dsh'] = 'Запчасть';
              if ($sqlr['comp'] === '') {
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        //$sqlr['price'] =  ceil(104*$sqlr['price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('M'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('N'.$lp.'',''.$getnote.'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$photoDrom.'');
                                        $lp = $lp+1;
                                        }
                 else {
           foreach ($complects_bd as $sqlrt) {
              if ($sqlrt['c_whole'] === '0'){
                             if (($sqlr['comp'] === $sqlrt['head'])or($sqlr['comp'] === $sqlrt['cid'])){
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        //$sqlr['price'] =  ceil(104*$sqlr['price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('M'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('N'.$lp.'',''.$getnote.'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$photoDrom.'');
                                   
                                        $lp = $lp+1;
                } 
              }
             else { 
                   if ($sqlrt['cid'] === $sqlr['comp'])  {
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescriptionCompl($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'','Комплект '.$sqlr['podcat'].'');
                                         $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'','Комплект '.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['brand'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['model'].'');
                                        //$sqlrt['c_price'] =  ceil(104*$sqlrt['c_price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('M'.$lp.'',''.$sqlrt['c_price'].'');
                                        $active_sheet->setCellValue('N'.$lp.'',''.$getnote.'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$photoDrom.'');
                                   
                                        $lp = $lp+1; 
                    }
                    
                    }
                            }
           }
              }
            
           // header ( "Expires: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-type: application/vnd.ms-excel" );
            header ( "Content-Disposition: attachment; filename=BIBINET.xls" );


            $objWriter = PHPExcel_IOFactory::createWriter($OrderExcel, 'Excel5');
            $objWriter->save('downloadXcelFiles/BIBINET.xls');
            //return $this->$OrderExcel;
        }
    }
    