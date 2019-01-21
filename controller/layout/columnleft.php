<?php

class ControllerLayoutColumnleft extends Controller {
    public function index(){
        if (isset($this->request->cookie['token']) && isset($this->session->data['token']) && ($this->request->cookie['token'] == $this->session->data['token'])) {
            $this->load->model('user/user');
            $this->load->model('tool/image');
            $user_info = $this->model_user_user->getUser($this->user->getId());
            if ($user_info) {
                    $data['firstname'] = $user_info['firstname'];
                    $data['lastname'] = $user_info['lastname'];
                    $data['user_group'] = $user_info['user_group'];
                    if (is_file(DIR_IMAGE . $user_info['image'])) {
                            $data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
                    } else {
                            $data['image'] = '';
                    }
            } else {
                    $data['firstname'] = '';
                    $data['lastname'] = '';
                    $data['user_group'] = '';
                    $data['image'] = '';
            }
            $layout= $this->user->getLayout();
            $data['main_menu'] = $layout['leftcolumn'];
//            $tmp = explode("/", $this->request->get['route']);
//            $data['module'] = $tmp[0];
//            $data['controller'] = $tmp[1];
        }
        
        
        return $this->load->view('layout/column_left', $data);
    }
}
