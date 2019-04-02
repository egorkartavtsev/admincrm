<?php

class ControllerServiceDocs extends Controller {
    public function index(){
        $this->load->model('tool/layout');
        $this->load->model('service/tools');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['docs'] = $this->model_service_tools->getDocuments();
        $this->response->setOutput($this->load->view('service/docsGen', $data));
    }
    
    public function showDocDets() {
        $this->load->model('service/tools');
        $doc = $this->request->post['doc'];
        $data['details'] = $this->model_service_tools->getDocDetails($doc); 
//        exit(var_dump($data));
        echo $this->load->view('form/doc_dets', $data);
    }
    
    public function saveDocDets() {
        $this->load->model('service/tools');
        $doc = $this->request->post;
//        exit(var_dump($doc));
        $allow = false;
        $file = $this->request->files['file'];
        $data = [
            'errors' => [],
            'success' => []
        ];
        
        if($file['error'] == '0' && ($file['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $file['type'] == 'application/msword')){
            $filename = str_replace(' ', '_', $file['name']);
            move_uploaded_file($file['tmp_name'], DIR_DOCS.$filename);
            $doc['file'] = $filename;
            $allow = TRUE;
        } 
        if($allow){
            $this->model_service_tools->saveDocDetails($doc);
        }
        $this->response->redirect($this->url->link('service/docs'));
    }
}

