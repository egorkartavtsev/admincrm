<?php
    class ControllerCommonExcelDromDisk extends Controller {
        
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
          
            $active_sheet->setCellValue('A1','Артикул');
            $active_sheet->setCellValue('B1','Товар');
            $active_sheet->setCellValue('C1','Наименование');
            $active_sheet->setCellValue('D1','Индекс нагрузки');
            $active_sheet->setCellValue('E1','Индекс Скорости');
            $active_sheet->setCellValue('F1','Маркировка');
            $active_sheet->setCellValue('G1','Сезонность');
            $active_sheet->setCellValue('H1','Шиповка');
            $active_sheet->setCellValue('I1','Тип шины');
            $active_sheet->setCellValue('J1','Тип диска');
            $active_sheet->setCellValue('K1','Остаток');
            $active_sheet->setCellValue('L1','Продажа');
            $active_sheet->setCellValue('M1','Описание');
            $active_sheet->setCellValue('N1','Цена');
            $active_sheet->setCellValue('O1','Состояние');
            $active_sheet->setCellValue('P1','Наличие');
            $active_sheet->setCellValue('Q1','Срок доставки');
            $active_sheet->setCellValue('R1','Фотография');
            $Rur = 'RUR';
            $Avail = 'В наличии';
            $exlxe = $this->db->query("SELECT "
                . "p.product_id AS pid, "
                . "p.podcateg AS podcat, " //Наименование товара
                . "p.type AS type, "      // б/у, новое
                . "p.brand AS brand, "    //Марка
                . "p.model AS model, "    //Модель
                . "p.vin AS vin, "        //внутренний номер
                . "p.price AS price, "      //Цена
                . "p.quantity AS quant, " //Количество 
                . "p.modR AS modRow, "
                . "p.note AS note, "
                . "p.catn AS catN, "
                . "p.comp AS comp, "
                . "p.hardindex AS hardindex, "
                . "p.speedIndex AS speedIndex, "
                . "p.season AS season, "
                . "p.disctype AS disctype, "
                . "p.structure AS structure, "
                . "p.cond AS cond, "
                . "p.avito AS avito, "
                . "p.compability AS compability,  "
                . "p.dop AS dop, "
                . "p.stock AS stock, "
                . "p.drom AS drom "
                . "FROM ".DB_PREFIX."product p "
                . "WHERE (p.quantity > '0') AND (p.price > '0') AND ((p.structure = 2) OR (p.structure = 3))" );
           $complects_bd = $this->model_common_excelDrom->getComplectDrom();
            //exit(var_dump($exlxe));
            $lp=2;
              foreach ($exlxe->rows as $sqlr) {
              if($sqlr['structure']==='2'){
                  $sqlr['dsh'] = 'Шина';
              } 
              if($sqlr['structure']==='3'){
                  $sqlr['dsh'] = 'Диск';
              }
              if ($sqlr['comp'] === '') {
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['dsh'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['avito'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['hardindex'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['speedIndex'].'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['season'].'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $active_sheet->setCellValue('J'.$lp.'',''.$sqlr['disctype'].'');
                                        $active_sheet->setCellValue('L'.$lp.'','шт.');
                                        $active_sheet->setCellValue('M'.$lp.'',''.$getnote.'');
                                        $sqlr['price'] =  ceil(104*$sqlr['price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('N'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('P'.$lp.'','В наличии');
                                        $active_sheet->setCellValue('R'.$lp.'',''.$photoDrom.'');
                                        $lp = $lp+1;
                                        }
                 else {
           foreach ($complects_bd as $sqlrt) {
              if ($sqlrt['c_whole'] === '0'){
                             if (($sqlr['comp'] === $sqlrt['head'])or($sqlr['comp'] === $sqlrt['cid'])){
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescription($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['dsh'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['avito'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['hardindex'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['speedIndex'].'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['season'].'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $active_sheet->setCellValue('J'.$lp.'',''.$sqlr['disctype'].'');
                                        $active_sheet->setCellValue('L'.$lp.'','шт.');
                                        $active_sheet->setCellValue('M'.$lp.'',''.$getnote.'');
                                        $sqlr['price'] =  ceil(104*$sqlr['price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('N'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('P'.$lp.'','В наличии');
                                        $active_sheet->setCellValue('R'.$lp.'',''.$photoDrom.'');
                                        $lp = $lp+1;
                } 
              }
             else { 
                   if ($sqlrt['cid'] === $sqlr['comp'])  {
                                        $photoDrom = $this->model_common_excelDrom->getPhotoDrom($sqlr['pid']);
                                        $getnote = $this->model_common_excelDrom->getDromDescriptionCompl($sqlr);
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('B'.$lp.'','Комплект '.$sqlr['dsh'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['avito'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['hardindex'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['speedIndex'].'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['season'].'');
                                        $active_sheet->setCellValue('K'.$lp.'',''.$sqlr['quant'].'');
                                        $active_sheet->setCellValue('J'.$lp.'',''.$sqlr['disctype'].'');
                                        $active_sheet->setCellValue('L'.$lp.'','шт.');
                                        $active_sheet->setCellValue('M'.$lp.'',''.$getnote.'');
                                        $sqlrt['c_price'] =  ceil(104*$sqlrt['c_price']/5000) * 50 ; 
                                        $active_sheet->setCellValue('N'.$lp.'',''.$sqlrt['c_price'].'');
                                        $active_sheet->setCellValue('O'.$lp.'',''.$sqlr['type'].'');
                                        $active_sheet->setCellValue('P'.$lp.'','В наличии');
                                        $active_sheet->setCellValue('R'.$lp.'',''.$photoDrom.'');
                                   
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
            header ( "Content-Disposition: attachment; filename=disk.xls" );


            $objWriter = PHPExcel_IOFactory::createWriter($OrderExcel, 'Excel5');
            $objWriter->save('php://output');
            //return $this->$OrderExcel;
        }
    }
    