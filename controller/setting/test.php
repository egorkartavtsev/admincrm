<?php

class ControllerSettingTest extends Controller{
    public function index() {
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $this->response->setOutput($this->load->view('setting/test', $data));
    }
}
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <div class="h4 well well-sm"><i class="fa fa-warning fw"></i> <?php echo $description; ?></div>
    </div>
  </div>
  <div class="container-fluid">
      <div class="col-lg-12">
          <div class="testdiv">
              <p><?php echo var_dump($user->getUserName());?></p>
              <p><?php echo var_dump($user->getId());?></p>
              <p><?php echo var_dump($user->getGroupId());?></p>
          </div>
      </div>       
  </div>
</div>

<?php echo $footer; ?>
