<?php

class ControllerServiceSettings extends Controller {

    public function index() {
        
        $this->load->model('tool/layout');
        $this->load->model('service/tools');
        
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        
        $data['handlTypes'] = $this->model_service_tools->getHandlTypes();
        
        $this->response->setOutput($this->load->view('service/settings', $data));
    }
    
    public function showHTDetails() {
        $this->load->model('service/tools');
        
        $handlType = $this->request->post['ht'];
        
        $cities = $this->model_service_tools->getCity();
        foreach ($cities as $city) {
            $data['city'][$city['city_id']] = $city;
            $data['city'][$city['city_id']]['agents'] = $this->model_service_tools->getAgents($handlType, $city['city_id']);
        }
        $data['handlType'] = $handlType;
        echo $this->load->view('service/htdetails', $data);
    }
}

