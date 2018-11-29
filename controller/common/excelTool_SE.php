<?php
    class ControllerCommonExcelToolSE extends Controller {
        
        
        public function FormNewOrderShiping()  {
            $order_id = $this->request->get['order_id'];
            $OrderSQL = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE `order_id` = '$order_id'");
        //    EXIT( var_dump($OrderSQL));
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
    //      $active_sheet->setTitle('$OrderYouID');
    //      Место для картинки возможно запихнуть ее в колонтитулы
            // ***Формат основных ячеек***
            $active_sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleArray = array(
                     'borders' => array(
	             'allborders' => array(
	              'style' => PHPExcel_Style_Border::BORDER_THIN
	                                  )
                                        )
                                );
            $active_sheet->getStyle('A2:I9')->applyFromArray($styleArray);
            $active_sheet->getStyle('A11:I14')->applyFromArray($styleArray);
            $active_sheet->getStyle('A16:I16')->applyFromArray($styleArray);
            $active_sheet->mergeCells('A1:I1');
            $active_sheet->mergeCells('A2:I2');
            for ($i = 3; $i <= 9; $i++) {
            $active_sheet->mergeCells('A'.$i.':C'.$i.'');
            $active_sheet->mergeCells('D'.$i.':I'.$i.'');
            }
            $active_sheet->mergeCells('A11:I11');
            for ($i = 12; $i <= 14; $i++) {
            $active_sheet->mergeCells('A'.$i.':C'.$i.'');
            $active_sheet->mergeCells('D'.$i.':I'.$i.'');
            }
            for ($i = 16; $i <= 25; $i++) {
            $active_sheet->mergeCells('C'.$i.':H'.$i.'');
            }
            $active_sheet->getColumnDimension('A')->setWidth(40);
            $imagePath = DIR_IMAGE.'excel1.png';
            if (file_exists($imagePath)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setPath($imagePath);
            $logo->setCoordinates('A1');				
            $logo->setOffsetX(150);
            $logo->setOffsetY(20);	
            $active_sheet->getRowDimension(1)->setRowHeight(128);
            $logo->setWorksheet($active_sheet);
            }
            // ***Введенные не изменяемые данные***
            $active_sheet->setCellValue('A2','Получатель');
            $active_sheet->setCellValue('A3','Город');
            $active_sheet->setCellValue('A4','Ф.И.О.');
            $active_sheet->setCellValue('A5','Паспорт (серия, номер)');
            $active_sheet->setCellValue('A6','Конт. телефон');
            $active_sheet->setCellValue('A7','Транспортная компания');
            $active_sheet->setCellValue('A8','Доп. упаковка');
            $active_sheet->setCellValue('A9','Стоимость груза');
            $active_sheet->setCellValue('A11','Отправитель');
            $active_sheet->setCellValue('A12','Город');
            $active_sheet->setCellValue('D12','Магнитогорск');
            $active_sheet->setCellValue('A13','Ф.И.О.');
            $active_sheet->setCellValue('A14','Конт. телефон');
            $active_sheet->setCellValue('D14','+7 912 475 0870');
            $active_sheet->setCellValue('A16','№ п/п');
            $active_sheet->setCellValue('B16','Артикул');
            $active_sheet->setCellValue('C16','Наименования');
            $active_sheet->setCellValue('I16','Кол-во');

            $active_sheet->setCellValue('D3',''.$OrderSQL->row['payment_zone'].' '.$OrderSQL->row['payment_city'].'');
            $active_sheet->setCellValue('D4',''.$OrderSQL->row['firstname'].' '.$OrderSQL->row['lastname'].' '.$OrderSQL->row['patron'].'');
            $active_sheet->setCellValue('D6','+7'.$OrderSQL->row['telephone'].'');
            $active_sheet->setCellValue('D7',''.$OrderSQL->row['ship_comp'].'');
            $totalinc = $OrderSQL->row['total'];
            $active_sheet->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $active_sheet->setCellValue('D9',''.$totalinc.'');
            $lp=16;
            $OrderSQL1 = $this->db->query("SELECT 
                                          pro.vin,
                                          op.name,
                                          op.quantity
                                          FROM " . DB_PREFIX . "order_product  op
                                            LEFT JOIN " .DB_PREFIX. "product pro on op.product_id = pro.product_id
                                            WHERE `order_id` = '$order_id'");
           foreach ($OrderSQL1->rows as $sqlr) {
            $lp=$lp+1;
            $active_sheet->getStyle('A'.$lp.':I'.$lp.'')->applyFromArray($styleArray);
            $active_sheet->setCellValue('A'.$lp.'',''.($lp-16).'');
            $active_sheet->getStyle('A'.$lp.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['vin'].'');
            $active_sheet->getStyle('B'.$lp.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['name'].'');
            $active_sheet->setCellValue('I'.$lp.'',''.$sqlr['quantity'].'');
            $active_sheet->getStyle('I'.$lp.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           }
          
            $active_sheet->getColumnDimension('A')->getWidth(64);
            $active_sheet->getColumnDimension('B')->getWidth(96);
            $active_sheet->getColumnDimension('C')->getWidth(67);
            $active_sheet->getColumnDimension('D')->getWidth(76);
            $active_sheet->getColumnDimension('I')->getWidth(78);
            $active_sheet->getRowDimension('1')->getRowHeight(141);
            
            
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
  /*      public function downloadAllProds() {
            $this->load->model("tool/excel");
            $flag = $this->request->get['flag'];
            $file = $this->model_tool_excel->updateFile($flag);
            if (file_exists($file)) {
                // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
                // если этого не сделать файл будет читаться в память полностью!
                if (ob_get_level()) {
                  ob_end_clean();
                }
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                // читаем файл и отправляем его пользователю
                readfile($file);
          }
            $this->response->redirect($this->url->link('common/excel', 'token='.$this->session->data['token']));
        }
    }*/
    