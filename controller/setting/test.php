<?php

class ControllerSettingTest extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['simple'] = $this->db->query("SELECT * FROM ".DB_PREFIX."modules WHERE id = 15");
        $data['tegggg'] = uniqid();
        $data['user'] = $this->user;
        $user = $this->user->getUserInfo();
        $data['firstmane'] = $user['firstname'];
        $data['lastname'] = $user['lastname'];
        $data['userAL'] = $user['userAL'];
        $data['user_group'] = $user['user_group'];
        $data['email'] = $user['email'];
        $this->response->setOutput($this->load->view('setting/test', $data));
    }
}

