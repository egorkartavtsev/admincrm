<?php

class ControllerAvitoTestList extends Controller
{
    public function index()
    {
        $this->load->model('product/avito');
        $data = $this->model_product_avito->getAllAds();
        echo json_encode($data);
    }
}