<?php

class ControllerSettingTest extends Controller{
    public function index() {
        $this->load->model('tool/image');
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
        $this->load->model('setting/test');
        if(empty($this->request->post)){
            $filter = $this->request->post;
            $tmp = $this->model_setting_test->getTestProduct();
        } else {
            $filter = $this->request->post;
            $tmp = $this->model_setting_test->lightFiltr($filter);
        }
        $data['filter']=$filter;
        foreach ($tmp as $prod) {
            $data['products'][] = [
                'nametest' => $prod['nametest'],
                'vintest' => $prod['vintest'],
                'pricetest' => $prod['pricetest'],
                'imagetest' => $this->model_tool_image->resize($prod['imagetest'], 150, 150)
            ];
        }
        $this->response->setOutput($this->load->view('setting/test', $data));  
    }
    
  /*  public function filtered() {
       $this->load->model('tool/layout'); 
       $data = $this->model_tool_layout->getLayout($this->request->get['route']);
       /*----------------------------------------------------------*/
   /*     $filter = $this->request->post;
        $this->load->model('setting/test');
        $sup = $this->model_setting_test->lightFiltr($filter);
       $data['products1'] = $sup;
       foreach ($sup as $prod) {
            $data['products'][] = [
                'nametest' => $prod['nametest'],
                'vintest' => $prod['vintest'],
                'pricetest' => $prod['pricetest'],
                'imagetest' => $this->model_tool_image->resize($prod['imagetest'], 150, 150)
            ];
        }
       /*----------------------------------------------------------*/
      /* $this->response->setOutput($this->load->view('setting/tt_1', $data)); 
    }*/
}
