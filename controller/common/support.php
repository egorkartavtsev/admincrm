<?php

class ControllerCommonSupport extends Controller {

    public function index() {
        
        $this->load->model('tool/layout');
        $this->load->model('tool/product');
        $this->load->model('product/product');
        $sup = [];
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['logfile'] = '';
        $file = 'access_log.txt';
        $pattern = "/[\s]/";
        if(file_exists($file)){
            $tmp = file($file);
            $data['logfile'][] = $tmp;
//            foreach ($tmp as $row) {
//                $data['logfile'][] = preg_split($pattern, $row);
//            }
        } else {
            $data['logfile'] = "empty";
        }
        
        
        $this->response->setOutput($this->load->view('common/support', $data));
    }
}