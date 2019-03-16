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
        $data['handlingType'] = $handlType;
        $data['clearModal'] = $this->load->view('modals/clear', [
            'target' => 'serv_setts',
            'key'    => 's_sets',
            'header' => 'Настройки услуги'
        ]);
        echo $this->load->view('service/htdetails', $data);
    }
    
    public function showServices(){
        $this->load->model('service/tools');
        $services = $this->model_service_tools->getServices($this->request->post['agent']);
        $reqs = $this->model_service_tools->getReqs($this->request->post['agent']);
        $result = '<div class="col-lg-12">';
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>Юр.адрес</label>';
                $result.='<input type="text" class="form-control" data-field="field-legal_adr" value="'.$reqs['legal_adr'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>ОГРН</label>';
                $result.='<input type="text" class="form-control" data-field="field-ogrn" value="'.$reqs['ogrn'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>ИНН</label>';
                $result.='<input type="text" class="form-control" data-field="field-inn" value="'.$reqs['inn'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>Р/С</label>';
                $result.='<input type="text" class="form-control" data-field="field-check_acc" value="'.$reqs['check_acc'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>Наименование банка</label>';
                $result.='<input type="text" class="form-control" data-field="field-bank" value="'.$reqs['bank'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>БИК</label>';
                $result.='<input type="text" class="form-control" data-field="field-bik" value="'.$reqs['bik'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label>К/С</label>';
                $result.='<input type="text" class="form-control" data-field="field-cor_acc" value="'.$reqs['cor_acc'].'">';
            $result.= "</div>";
            $result.= '<div class="form-group col-sm-6">';
                $result.='<label></label>';
                $result.='<button class="btn btn-success btn-block" btn-type="saveAgentReqs" data-target="'.$this->request->post['agent'].'"><i class="fa fa-floppy-o"></i> сохранить</button>';
            $result.= "</div>";
        $result.= "</div>";
        $result.= '<div class="col-lg-12">';
        
        foreach ($services as $serv) {
            $result.= '<div style="float: left; margin-right: 5px; margin-bottom: 5px;"><button class="btn btn-info" btn-type="showServDetails" data-source="'.$serv['service_id'].'" data-toggle="modal" data-target="#serv_settsModal">'.$serv['name'].'</button></div>';
        }
        $result.= "</div>";
        echo $result;
    }
    
    public function saveAgentReqs(){
        $this->load->model('service/tools');
        $testPost = $this->request->post;
        array_shift($testPost);
        if(count($testPost)<7){
            echo 'Заполните все поля!!!';
        } else {
            $this->model_service_tools->saveReqs($this->request->post);
            echo 'Сохранено успешно';
        }
    }
    
    public function showServiceDetails() {
        $this->load->model('service/tools');
        $data = [];
        $data['details'] = $this->model_service_tools->getServDetails($this->request->post['serv']);
        $data['agents'] = $this->model_service_tools->getTotalAgents();        
        $data['docs'] = $this->model_service_tools->getDocuments();

        
        echo $this->load->view('form/serv_dets', $data);
    }
    
    public function saveServDets() {
        $this->load->model('service/tools');
        $this->model_service_tools->saveServ($this->request->post);
        echo 'Сохранено успешно!!!';
    }
}

