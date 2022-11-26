<?php

class ControllerAvitoAvitoTool extends Controller{
    public function hideNotice(){
        $this->load->model('product/avito');
        $this->model_product_avito->hideNotice($this->request->post['vin']);
        echo 'robit';
    }
    public function deact(){
        $this->load->model('product/avitoXML');
        $this->model_product_avitoXML->DeactivateAd($this->request->post['vin']);
        echo 'robit';
    }
    public function react(){
        $this->load->model('product/avitoXML');
        $this->model_product_avitoXML->ActivateAd($this->request->post['vin']);
        echo 'robit';
    }
    public function drop(){
        $this->load->model('product/avitoXML');
        $this->model_product_avitoXML->DropAd($this->request->post['vin']);
        echo 'robit';
    }
}

