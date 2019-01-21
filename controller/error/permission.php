<<<<<<< Upstream, based on origin/master
<?php
class ControllerErrorPermission extends Controller {
	public function index() {
		$this->load->model('tool/layout');
                $data = $this->model_tool_layout->getLayout('error/permission');
                $data['text_permission'] = 'Доступ запрещён. У Вас не хватает прав доступа к данной странице.';
		$this->response->setOutput($this->load->view('error/permission', $data));
	}
}
=======
<<<<<<< HEAD
<?php
class ControllerErrorPermission extends Controller {
	public function index() {
		$this->load->model('tool/layout');
                $data = $this->model_tool_layout->getLayout('error/permission');
                $data['text_permission'] = 'Доступ запрещён. У Вас не хватает прав доступа к данной странице.';
		$this->response->setOutput($this->load->view('error/permission', $data));
	}
}
=======
<?php
class ControllerErrorPermission extends Controller {
	public function index() {
		$this->load->model('tool/layout');
                $data = $this->model_tool_layout->getLayout('error/permission');
                $data['text_permission'] = 'Доступ запрещён. У Вас не хватает прав доступа к данной странице.';
		$this->response->setOutput($this->load->view('error/permission', $data));
	}
}
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
