<?php

class ControllerCommonSupport extends Controller {

    public function index() {
        
        $this->load->model('tool/layout');
        $this->load->model('tool/product');
        $this->load->model('product/product');
        $sup = [];
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['start'] = strtotime(date("Y-m-d H:i:s"));
        //$data['adm'] = $this->user->isAdmin();
        //$tmpId = array_search($sup['Id'], array_column($tmp->rows, 'vin'));
        
        $tmp = $this->db->query("SELECT si.city, p.manager, p.type, si.saleprice, lf.id AS categ, si.date  FROM ".DB_PREFIX."sales_info si "
                                . "LEFT JOIN ".DB_PREFIX."product p ON si.sku = p.vin "
                                . "LEFT JOIN ".DB_PREFIX."lib_fills lf ON lf.name = p.category "
                                . "WHERE !LOCATE('complect', p.vin) AND si.saleprice>0");
        
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $i = 1;
        foreach ($tmp->rows as $sale) {
            ++$i;
            $sheet->setCellValueExplicit('A'.$i,($sale['city']==='Магнитогорск')?1:0);
            $sheet->setCellValueExplicit('B'.$i,($sale['type']!=='Б/У')?1:0);
            $sheet->setCellValueExplicit('C'.$i, (int)$sale['manager']);
            $sheet->setCellValueExplicit('D'.$i,$sale['categ']);
            $sheet->setCellValueExplicit('E'.$i,date('m', strtotime($sale['date'])));
            $sheet->setCellValueExplicit('F'.$i,$sale['saleprice'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        }
        header ( "Expires: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=list.xls" );

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');
        echo date("Y-m-d H:i:s").'<br>';
        // Timezone
        date_default_timezone_set('Asia/Vladivostok');
        echo date("Y-m-d H:i:s").'<br>';
        // Timezone2
        date_default_timezone_set('Asia/Yekaterinburg');
        echo date("Y-m-d H:i:s").'<br>';
		        
        exit(var_dump(strtotime(date("Y-m-d H:i:s"))-$data['start']));
        
        // попробуй!!!!!!!!!!
        // in_array($field['libraries'], array_column($items->rows, 'item_id'));
        
        $this->response->setOutput($this->load->view('common/support', $data));
    }
}