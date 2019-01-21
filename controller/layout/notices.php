<<<<<<< Upstream, based on origin/master
<?php

class ControllerLayoutNotices extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getnoticeTotals();
        return $this->load->view('layout/notices', $data);
    }
}

=======
<<<<<<< HEAD
<?php

class ControllerLayoutNotices extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getnoticeTotals();
        return $this->load->view('layout/notices', $data);
    }
}

=======
<?php

class ControllerLayoutNotices extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getnoticeTotals();
        return $this->load->view('layout/notices', $data);
    }
}

>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
