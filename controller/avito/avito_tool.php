<<<<<<< Upstream, based on origin/master
<?php

class ControllerAvitoAvitoTool extends Controller{
    public function hideNotice(){
        $this->load->model('product/avito');
        $this->model_product_avito->hideNotice($this->request->post['vin']);
        echo 'robit';
    }
    public function deact(){
        $this->load->model('product/avito');
        $this->model_product_avito->deactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function react(){
        $this->load->model('product/avito');
        $this->model_product_avito->reactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function drop(){
        $this->load->model('product/avito');
        $this->model_product_avito->dropAD($this->request->post['vin']);
        echo 'robit';
    }
}

=======
<<<<<<< HEAD
<?php

class ControllerAvitoAvitoTool extends Controller{
    public function hideNotice(){
        $this->load->model('product/avito');
        $this->model_product_avito->hideNotice($this->request->post['vin']);
        echo 'robit';
    }
    public function deact(){
        $this->load->model('product/avito');
        $this->model_product_avito->deactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function react(){
        $this->load->model('product/avito');
        $this->model_product_avito->reactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function drop(){
        $this->load->model('product/avito');
        $this->model_product_avito->dropAD($this->request->post['vin']);
        echo 'robit';
    }
}

=======
<?php

class ControllerAvitoAvitoTool extends Controller{
    public function hideNotice(){
        $this->load->model('product/avito');
        $this->model_product_avito->hideNotice($this->request->post['vin']);
        echo 'robit';
    }
    public function deact(){
        $this->load->model('product/avito');
        $this->model_product_avito->deactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function react(){
        $this->load->model('product/avito');
        $this->model_product_avito->reactAD($this->request->post['vin']);
        echo 'robit';
    }
    public function drop(){
        $this->load->model('product/avito');
        $this->model_product_avito->dropAD($this->request->post['vin']);
        echo 'robit';
    }
}

>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
