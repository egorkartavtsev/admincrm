<?php

class ControllerServiceClientHandling extends Controller {
    public function index() {
        $this->load->model('tool/layout');
        $this->load->model('service/tools');
        $this->load->model('service/handling');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['client'] = $this->model_service_tools->getClientInfo($this->request->get['client_id']);
        $data['auto'] = $this->model_service_tools->getClientAuto($this->request->get['client_id']);
        $data['action'] = "index.php?route=service/client_handling/createHandling&token=".$data['token'];
        $data['modal_contract'] = $this->load->view('modals/clear', array('target'=>'contractcreate', 'header'=>'Добавить услугу', 'key'=>'contract'));
        
        if(isset($this->request->get['handling'])){
            $handl= $this->model_service_handling->getHandlingInfo($this->request->get['handling']);
            $data['handling'] = $handl['info'];
            $data['services'] = $handl['services'];
            $data['action'] = "index.php?route=service/client_handling/updateHandling&handling=".$this->request->get['handling'];
            if((int)$data['handling']['accident']){
                $data['accident'] = $this->model_service_handling->getAccidentInfo($data['handling']['accident']);
                $data['accident']['insurences'] = $this->model_service_tools->getInsurences();
                $data['accident']['commissars'] = $this->model_service_tools->getCommissars();
                $data['accident_form'] = $this->load->view('form/accident', $data['accident']);
            }
        }
        
        $this->response->setOutput($this->load->view('service/client_handling', $data));
    }
    
    public function getAccidentForm() {
        $this->load->model('service/tools');
        $data['commissars'] = $this->model_service_tools->getCommissars();
        $data['insurences'] = $this->model_service_tools->getInsurences();
        echo $this->load->view('form/accident', $data);
    }
    
    public function showContract() {
        $this->load->model('service/tools');
        $data = array();
        $data['handl_types'] = $this->model_service_tools->getHandlTypes();
        $data['handling'] = $this->request->post['handling'];
        echo $this->load->view('form/contract', $data);
    }
    
    public function createContract() {
        $this->load->model('service/handling');
        $res = [];
        $contract = explode(";;", $this->request->post['contract']);
        foreach($contract as $cont){
            $tmp = explode(":=", $cont);
            if(isset($tmp[1])) {$res[str_replace("contract-", "", $tmp[0])] = $tmp[1];}
        }
        $result = $this->model_service_handling->createContract($res);
        
        echo json_encode($result);
    }
    
    public function createHandling() {
        $this->load->model('service/handling');
        $handling = $this->request->post['handling'];
        unset($this->request->post['handling']);
        if(!empty($this->request->post)){
            $accident = $this->request->post;
            $accident_id = $this->model_service_handling->createAccident($accident);
            $handling['accident'] = $accident_id;
        } else {
            $handling['accident'] = 0;
        }
        $handl = $this->model_service_handling->createHandling($handling);
        
        $this->response->redirect($this->url->link('service/client_handling', 'token='.$this->session->data['token'].'&client_id='.$handling['client'].'&handling='.$handl));
//        exit(var_dump($this->request->post));
    }
    
    public function getStats() {
        $this->load->model("service/handling");
        $stats = $this->model_service_handling->getEditableData($this->request->post['contract']);
        $note='<input type="text" name="note" class="form-control" value="'.$stats['contr']['note'].'">';
        $stt = '<select class="form-control" name="stat">';
        $paystat = '<select class="form-control" name="paystat">';
        foreach($stats['stats'] as $stat){
            $stt.= '<option value="'.$stat['contract_status_id'].'" '.($stat['contract_status_id']==$stats['contr']['cont_stat']?'selected':'').'>'.$stat['contract_status_name'].'</option>';
        }
        foreach($stats['paystats'] as $stat){
            $paystat.= '<option value="'.$stat['contract_payment_status_id'].'"  '.($stat['contract_payment_status_id']==$stats['contr']['payment_stat']?'selected':'').'>'.$stat['contract_payment_status_name'].'</option>';
        }
        $stt.= '</select>';
        $paystat.= '</select>';
        $res = [
          'note'    => $note,  
          'stat'    => $stt,  
          'paystat' => $paystat  
        ];
        echo json_encode($res);
    }
    
    public function updateContract() {
        $this->load->model("service/handling");
        $stats = $this->model_service_handling->updateContractData($this->request->post);
        
        $res = [
            'note' => $stats['note'],
            'paystat' => '<h5><span style="font-size: 100%;" class="label label-'.$stats['payment_stat_class'].'">'.$stats['payment_stat'].'</h5>',
            'stat' => '<h5><span style="font-size: 100%;" class="label label-'.$stats['cont_stat_class'].'">'.$stats['cont_stat'].'</h5>'
        ];
        
        echo json_encode($res);
    }
    
    public function changeCD(){
        $this->load->model("service/tools");
        $items = $this->model_service_tools->getItems($this->request->post);
        echo json_encode($items);
    }
}

