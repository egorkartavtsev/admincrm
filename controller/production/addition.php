<<<<<<< Upstream, based on origin/master
<?php

class ControllerProductionAddition extends Controller{
    
    public function index() {
        $this->load->model('tool/product');
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $types = $this->model_tool_product->getStructures();
        $data['addWindow'] = $this->load->view('modals/clear', array(
            'target' => 'addWindow',
            'header' => 'Добавить товар',
            'key' => 'addForm'
        ));
        $data['firstSelect'] = '<select class="form-control">';
        foreach ($types as $type) {
            $data['firstSelect'].='<option value="'.$type['type_id'].'">'.$type['text'].'</option>';
        }
        $data['firstSelect'].='</select>';
        $this->response->setOutput($this->load->view('product/product_add', $data));
    }
    //add prodAddForm to new prods list
    public function addToList() {
        $this->load->model('tool/forms');
        $form = $this->model_tool_forms->constructAddForm($this->request->post['type']);
        echo $form;
    }
}

=======
<<<<<<< HEAD
<?php

class ControllerProductionAddition extends Controller{
    
    public function index() {
        $this->load->model('tool/product');
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $types = $this->model_tool_product->getStructures();
        $data['addWindow'] = $this->load->view('modals/clear', array(
            'target' => 'addWindow',
            'header' => 'Добавить товар',
            'key' => 'addForm'
        ));
        $data['firstSelect'] = '<select class="form-control">';
        foreach ($types as $type) {
            $data['firstSelect'].='<option value="'.$type['type_id'].'">'.$type['text'].'</option>';
        }
        $data['firstSelect'].='</select>';
        $this->response->setOutput($this->load->view('product/product_add', $data));
    }
    //add prodAddForm to new prods list
    public function addToList() {
        $this->load->model('tool/forms');
        $form = $this->model_tool_forms->constructAddForm($this->request->post['type']);
        echo $form;
    }
}

=======
<?php

class ControllerProductionAddition extends Controller{
    
    public function index() {
        $this->load->model('tool/product');
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $types = $this->model_tool_product->getStructures();
        $data['addWindow'] = $this->load->view('modals/clear', array(
            'target' => 'addWindow',
            'header' => 'Добавить товар',
            'key' => 'addForm'
        ));
        $data['firstSelect'] = '<select class="form-control">';
        foreach ($types as $type) {
            $data['firstSelect'].='<option value="'.$type['type_id'].'">'.$type['text'].'</option>';
        }
        $data['firstSelect'].='</select>';
        $this->response->setOutput($this->load->view('product/product_add', $data));
    }
    //add prodAddForm to new prods list
    public function addToList() {
        $this->load->model('tool/forms');
        $form = $this->model_tool_forms->constructAddForm($this->request->post['type']);
        echo $form;
    }
}

>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
