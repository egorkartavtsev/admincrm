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
        echo json_encode($data);
    }
    
}