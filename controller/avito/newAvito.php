<?php

class ControllerAvitonewAvito extends Controller {
    public function index()
    {
        $this->load->model('tool/layout');
        $this->load->model('tool/image');
        $this->load->model('product/avitoXML');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);

        $data['url'] = 'index.php?route='.$this->request->get['route'].'&token='.$this->session->data['token'];
        // <editor-fold defaultstate="collapsed" desc="filter block">
        $url = '';
        $page = 0;
        $filter = array(
            'priceFrom' => 0,
            'priceTo'   => 100000,
            'date'      => '1976-01-01',
            'donor'     => '',
            'name'     => '',
            'mess'     => '',
            'vin'     => '',
            'start'     => 0,
            'limit'     => 10
        );

        if(isset($this->request->get['page'])){
            $page = $this->request->get['page'];
            $filter['start'] = ($page-1)*$filter['limit'];
        }
        if(isset($this->request->get['filter_stock'])){
            $data['filter']['stock'] = $this->request->get['filter_stock'];
            $data['url'].= '&filter_stock='.$data['filter']['stock'];
            $url.= '&filter_stock='.$data['filter']['stock'];
            $filter['stock'] = $this->request->get['filter_stock'];
        }
        if(isset($this->request->get['filter_donor'])){
            $data['filter']['donor'] = $this->request->get['filter_donor'];
            $data['url'].= '&filter_donor='.$data['filter']['donor'];
            $url.= '&filter_donor='.$data['filter']['donor'];
            $filter['donor'] = $this->request->get['filter_donor'];
        }
        if(isset($this->request->get['filter_name'])){
            $data['filter']['name'] = $this->request->get['filter_name'];
            $data['url'].= '&filter_name='.$data['filter']['name'];
            $url.= '&filter_name='.$data['filter']['name'];
            $filter['name'] = $this->request->get['filter_name'];
        }
        if(isset($this->request->get['filter_vin'])){
            $data['filter']['vin'] = $this->request->get['filter_vin'];
            $data['url'].= '&filter_vin='.$data['filter']['vin'];
            $url.= '&filter_vin='.$data['filter']['vin'];
            $filter['vin'] = $this->request->get['filter_vin'];
        }
        if(isset($this->request->get['filter_priceFrom'])){
            $data['filter']['priceFrom'] = $this->request->get['filter_priceFrom'];
            $data['url'].= '&filter_priceFrom='.$data['filter']['priceFrom'];
            $url.= '&filter_priceFrom='.$data['filter']['priceFrom'];
            $filter['priceFrom'] = $this->request->get['filter_priceFrom'];
        }

        if(isset($this->request->get['filter_priceTo'])){
            $data['filter']['priceTo'] = $this->request->get['filter_priceTo'];
            $data['url'].= '&filter_priceTo='.$data['filter']['priceTo'];
            $url.= '&filter_priceTo='.$data['filter']['priceTo'];
            $filter['priceTo'] = $this->request->get['filter_priceTo'];
        }
        if(isset($this->request->get['filter_date'])){
            $data['filter']['date'] = date('Y-m-d', strtotime($this->request->get['filter_date']));
            $data['url'].= '&filter_date='.$data['filter']['date'];
            $url.= '&filter_date='.$data['filter']['date'];
            $filter['date'] = date('Y-m-d', strtotime($this->request->get['filter_date']));
        }
        if(isset($this->request->get['filter_mess'])){
            $data['filter']['mess'] = $this->request->get['filter_mess'];
            $data['url'].= '&filter_mess='.$data['filter']['mess'];
            $url.= '&filter_mess='.$data['filter']['mess'];
            $filter['mess'] = trim($this->request->get['filter_mess']);
        }
    // </editor-fold>

        $prods = $this->model_product_avitoXML->getProds($filter);
        $data["prods"] = array();

        foreach($prods['prods'] as $pr) {
            $data["prods"][] = array(
                "DateBegin" => $pr["DateBegin"],
                "DateEnd" => $pr["DateEnd"],
                "Id" => $pr["Id"],
                "Price" => $pr["Price"],
                "Image" => $this->model_tool_image->resize($pr['mainImage'], 70, 70),
                "Name" => $pr["name"],
                "class" => strtotime($pr["DateEnd"].' 23:59:59') < strtotime("Now") ? 'elderAD' : 'noteld'
            );
        }

        $pagination = new Pagination();
        $pagination->total = $prods['total'];
        $pagination->page = $page;
        $pagination->limit = $filter['limit'];
        $pagination->url = $this->url->link('avito/newAvito', $url . '&page={page}', true);
        $data['pagination'] = $pagination->render();

        $this->response->setOutput($this->load->view('avito/newList', $data));
    }
}