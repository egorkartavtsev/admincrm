<?php
    class ControllerCommonExcelToolSE extends Controller {
        
        
        public function FormNewOrderShiping()  {
         //   $order_id = $this->request->get['order_id'];
        //    $OrderSQL = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE `order_id` = '$order_id'");
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
            $active_sheet->getColumnDimension('J')->setAutoSize(true);
            $active_sheet->getColumnDimension('K')->setAutoSize(true);
            // ***Введенные не изменяемые данные***
            $active_sheet->setCellValue('A1','Наименование товара');
            $active_sheet->setCellValue('B1','Новый/б.у.');
            $active_sheet->setCellValue('C1','Марка');
            $active_sheet->setCellValue('D1','Модель');
            $active_sheet->setCellValue('E1','Внутренний номер');
            $active_sheet->setCellValue('F1','Примечание');
            $active_sheet->setCellValue('G1','Цена');
            $active_sheet->setCellValue('H1','Фотография');
            $active_sheet->setCellValue('I1','Описание');
            $active_sheet->setCellValue('J1','Каталожный номер');
            $active_sheet->setCellValue('K1','Количество');

            
            
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
    