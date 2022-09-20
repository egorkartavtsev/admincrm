<?php

class ControllerReportDonor extends Controller{
    public function index() {
        /*-------------------------------------------------------------------------------------------------------*/
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['token_add'] = $this->session->data['token'];
        /*----------------------------------------------------------------------------------------------------------*/
        
        $this->response->setOutput($this->load->view('report/donor', $data));
    }
    
    public function getVars() {
        $request = $this->request->post['request'];
        $this->load->model('report/donor');
        $variants = $this->model_report_donor->getVariants($request);
        $result = '';
        if($variants){
            foreach ($variants as $var) {
                $result.= '<li onclick="getDonor(\''.$var['numb'].'\', \''.$var['name'].'\');" class="dsitem">'.$var['name'].'</li>';
            }
        } else {
            $result = '<li class="dsitem" disabled>По данному запросу ничего не найдено. Попробуйте изменить запрос.</li>';
        }
        echo $result;
    }
    
    public function getDonor() {
        $numb = $this->request->post['request'];
        $this->load->model('report/donor');
        $this->load->model('tool/image');
        $info = $this->model_report_donor->getDonorInfo($numb);
        if (is_file(DIR_IMAGE . $info['info']['image'])) {
                $dimage = $this->model_tool_image->resize($info['info']['image'], 240, 240);
        } else {
                $dimage = $this->model_tool_image->resize('no_image.png', 240, 240);
        }
        $info['info']['sumPrice'] = $info['info']['totalItemPrice']+$info['info']['totalSalePrice'];
        //-------------------image-------------------
            $result = '<div class="col-md-3">';
                $result.='<img src="'.$dimage.'" alt="'.$info['info']['name'].'" class="img-thumbnail" />';
            $result.= '</div>';
        //-----------------mainInfo------------------
            $result.= '<div class="col-md-4 alert alert-success">';
                $result.= '<table class="table table-hover table-bordered table-condensed">'
                                .'<tr><td><b>Внутренний номер: </b></td><td>'.$info['info']['numb'].'</td></tr>'
                                .'<tr><td><b>Тип кузова: </b></td><td>'.$info['info']['ctype'].'</td></tr>'
                                .'<tr><td><b>VIN: </b></td><td>'.$info['info']['vin'].'</td></tr>'
                                .'<tr><td><b>Марка: </b></td><td>'.$info['info']['brand'].'</td></tr>'
                                .'<tr><td><b>Модель: </b></td><td>'.$info['info']['model'].'</td></tr>'
                                .'<tr><td><b>Модельный ряд: </b></td><td>'.$info['info']['modR'].'</td></tr>'
                                .'<tr><td><b>ДВС: </b></td><td>'.$info['info']['dvs'].'</td></tr>'
                                .'<tr><td><b>Цвет: </b></td><td>'.$info['info']['color'].'</td></tr>'
                                .'<tr><td><b>Трансмиссия: </b></td><td>'.$info['info']['trmiss'].'</td></tr>'
                                .'<tr><td><b>Пробег: </b></td><td>'.$info['info']['kmeters'].'</td></tr>'
                                .'<tr><td><b>Привод: </b></td><td>'.$info['info']['priv'].'</td></tr>'
                                .'<tr><td><b>Год выпуска: </b></td><td>'.$info['info']['year'].'</td></tr>'
                            .'</table><p><b>Примечание: </b>'.$info['info']['note'].'</p>';
            $result.= '</div>';
        //-----------------saleInfo-------------------
            $result.= '<div class="col-md-5">';
                $result.= '<div class="well well-sm" style="font-size: 12pt;">'
                                .'<p>Общее количество деталей: <span class="label label-success">'.$info['info']['totalQuant'].'</span></p>'
                                .'<p>Общая стоимость деталей: <span class="label label-success">'.$info['info']['sumPrice'].'</span></p>'
                                .'<p>Общее количество оставшихся деталей: <span class="label label-success">'.$info['info']['currQuant'].'</span></p>'
                                .'<p>Общяя стоимость оставшихся деталей: <span class="label label-success">'.$info['info']['totalItemPrice'].'</span></p>'
                                .'<p>Общее количество проданных деталей: <span class="label label-success">'.$info['info']['saleQuant'].'</span></p>'
                                .'<p>Общая стоимость проданных деталей: <span class="label label-success">'.$info['info']['totalSalePrice'].'</span></p>'
                                .'<p>Общая стоимость донора: <span class="label label-success">'.$info['info']['price'].'</span></p>'
                                .'<p>На сколько окупил себя донор: </p>'
                                .'<div class="progress">'
                                    .'<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'.$info['info']['percent'].'" aria-valuemin="0" aria-valuemax="200" style="width: '.$info['info']['percent'].'%;"><span style="color: black;">'.$info['info']['percent'].'%</span></div>'
                                .'</div>'

                           .'</div>';
            $result.= '</div>';
        $result.= '</div>'.$info['info']['tableItems'];
        
        
        echo $result;
    }
      public function getExlDonor() {
          
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
            $active_sheet->setCellValue('A1','Категория');
            $active_sheet->setCellValue('B1','Подкатегория');
            $active_sheet->setCellValue('C1','Внутренний номер');
            $active_sheet->setCellValue('D1','Расположение');
            $active_sheet->setCellValue('E1','Цена');
            $active_sheet->setCellValue('F1','Количество');
            $active_sheet->setCellValue('G1','Статус');
            $active_sheet->setCellValue('H1','Дата создания');
            $numb = $this->request->post['request'];
            $sql = "SELECT "
                //-----------------------
                    . "p.product_id AS pid, "
                    . "p.vin AS vin, "
                    . "p.stock AS stock, "
                    . "p.podcateg AS podcat, "
                    . "p.location AS loc, "
                    . "p.price AS price, "
                    . "p.category AS cat, "
                    . "p.quantity AS quant, "
                    . "p.status AS status, "
                    . "p.date_added AS date_added "
                    ."FROM `".DB_PREFIX."product` p "
                    ."WHERE p.numb = '".$numb."'";
            foreach ($sql->rows as $sqlr) {
                if ($sqlr['quant'] !== '0') {
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['cat'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['loc'].' '.$sqlr['stock'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('F'.$lp.'',''.$sqlr['status'].'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['quant'].'');
                                        $active_sheet->setCellValue('H'.$lp.'',''.$sqlr['date_added'].'');
                                        $lp = $lp+1;
                                        }
                else {
                                        $active_sheet->setCellValue('A'.$lp.'',''.$sqlr['cat'].'');
                                        $active_sheet->setCellValue('B'.$lp.'',''.$sqlr['podcat'].'');
                                        $active_sheet->setCellValue('C'.$lp.'',''.$sqlr['vin'].'');
                                        $active_sheet->setCellValue('D'.$lp.'',''.$sqlr['loc'].' '.$sqlr['stock'].'');
                                        $active_sheet->setCellValue('E'.$lp.'',''.$sqlr['price'].'');
                                        $active_sheet->setCellValue('F'.$lp.'',''.$sqlr['status'].'');
                                        $active_sheet->setCellValue('G'.$lp.'',''.$sqlr['quant'].'');
                                        $active_sheet->setCellValue('H'.$lp.'',''.$sqlr['date_added'].'');
                                        $lp = $lp+1;
                                        }
            }
            // header ( "Expires: " . gmdate("D,d M YH:i:s") . " GMT" );
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

