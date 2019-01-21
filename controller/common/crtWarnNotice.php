<<<<<<< Upstream, based on origin/master
<?php

class ControllerCommonCrtWarnNotice extends Controller{
    
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $autor = $this->user->getUserInfo();
        $data['users'] = $this->model_tool_layout->getUserList();
        $data['autor'] = $autor['firstname'].' '.$autor['lastname'];
        if(isset($this->request->post['users'])){
            if($this->request->post['text']!=''){
                $sup = $this->request->post;
                $users = $sup['users'];
                unset($sup['users']);
                $this->model_tool_layout->createNewWarnMessage($sup, $users);
            }
        }
        $this->response->setOutput($this->load->view('common/crtWarnNotice', $data));
    }    
}

=======
<<<<<<< HEAD
<?php

class ControllerCommonCrtWarnNotice extends Controller{
    
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $autor = $this->user->getUserInfo();
        $data['users'] = $this->model_tool_layout->getUserList();
        $data['autor'] = $autor['firstname'].' '.$autor['lastname'];
        if(isset($this->request->post['users'])){
            if($this->request->post['text']!=''){
                $sup = $this->request->post;
                $users = $sup['users'];
                unset($sup['users']);
                $this->model_tool_layout->createNewWarnMessage($sup, $users);
            }
        }
        $this->response->setOutput($this->load->view('common/crtWarnNotice', $data));
    }    
}

=======
<?php

class ControllerCommonCrtWarnNotice extends Controller{
    
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $autor = $this->user->getUserInfo();
        $data['users'] = $this->model_tool_layout->getUserList();
        $data['autor'] = $autor['firstname'].' '.$autor['lastname'];
        if(isset($this->request->post['users'])){
            if($this->request->post['text']!=''){
                $sup = $this->request->post;
                $users = $sup['users'];
                unset($sup['users']);
                $this->model_tool_layout->createNewWarnMessage($sup, $users);
            }
        }
        $this->response->setOutput($this->load->view('common/crtWarnNotice', $data));
    }    
}

>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
