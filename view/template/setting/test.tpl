<?php echo $header; ?><?php echo $column_left; ?>
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
          <div class="alert alert-danger">
              <p><?php echo var_dump($user->getUserInfo());?></p>
              <p><?php echo var_dump($user->isAdmin());?></p>
              <p><?php echo var_dump($user->isLogged());?></p>
          </div>
          <div class="alert alert-danger"><?php echo var_dump($tegggg);?></div>
          <div class="alert alert-success"><?php echo var_dump($simple->row);?></div>
          <div class="alert alert-info"><?php echo var_dump($simple->rows);?></div>
          <div class="alert alert-warning"><?php echo var_dump($simple->num_rows);?></div>
      </div>
  </div>
</div>

<?php echo $footer; ?>
