<?php

class ControllerSettingTest extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['simple'] = $this->db->query("SELECT * FROM ".DB_PREFIX."modules WHERE id = 15");
        $data['tegggg'] = uniqid();
        $data['user'] = $this->user;
        $this->response->setOutput($this->load->view('setting/test', $data));
    }
}

