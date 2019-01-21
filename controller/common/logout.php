<<<<<<< Upstream, based on origin/master
<?php
class ControllerCommonLogout extends Controller {
	public function index() {
		$this->user->logout();

		unset($this->session->data['token']);

		$this->response->redirect($this->url->link('common/login', '', true));
	}
}
=======
<<<<<<< HEAD
<?php
class ControllerCommonLogout extends Controller {
	public function index() {
		$this->user->logout();

		unset($this->session->data['token']);

		$this->response->redirect($this->url->link('common/login', '', true));
	}
=======
<?php
class ControllerCommonLogout extends Controller {
	public function index() {
		$this->user->logout();

		unset($this->session->data['token']);

		$this->response->redirect($this->url->link('common/login', '', true));
	}
>>>>>>> origin/master
}
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
