<?php

class ControllerToolWordTool extends Controller {
    public function index() {
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $document = $PHPWord->loadTemplate(DIR_DOCS.'Template.docx');
        
        $this->load->model('service/service');
        $service_data = $this->model_service_service->getData($this->request->post['target']);
        foreach($service_data as $var => $value){
            $document->setValue($var, $value); // номер договора
        }
        $document->saveAs(DIR_DOCS.'Template_ddd.docx'); // имя заполненного шаблона
        
        echo HTTP_DOCS.'Template_ddd.docx'; //имя заполненного шаблона
    }
}