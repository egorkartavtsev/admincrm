<?php

class ControllerAvitoYulaTool extends Controller{
    public function hideNoticeYulap(){
        $this->load->model('product/avito');
        $this->model_product_avito->hideNoticeYula($this->request->post['vin']);
        echo 'robit';
    }
    public function deactYulap(){
        $this->load->model('product/avito');
        $this->model_product_avito->deactYula($this->request->post['vin']);
        echo 'robit';
    }
    public function reactYulap(){
        $this->load->model('product/avito');
        $this->model_product_avito->reactYula($this->request->post['vin']);
        echo 'robit';
    }
    public function dropYulap(){
        $this->load->model('product/avito');
        $this->model_product_avito->dropYula($this->request->post['vin']);
        echo 'robit';
    }
}

