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
      <?php if(isset($success)){ ?><div class="h4 alert alert-success"><i class="fa fa-warning fw"></i> <?php echo $success; ?></div><?php }?>
    </div>
  </div>
    <div class="container-fluid">    
        <div class="row">
            <div class="col-sm-3">
                <div class="btn-group-vertical pull-right" role="group">
                    <?php foreach($handlTypes as $ht){ ?>
                        <button class="btn btn-info" btn-type="showHTInfo" data-target="<?php echo $ht['ht_id'];?>">
                            <?php echo $ht['name'];?>
                        </button>
                    <?php }?>
                    <button class="btn btn-success" btn-type="createHT">
                        <i class="fa fa-plus-square-o"></i> добавить
                    </button>
                </div>
            </div>
            <div class="col-sm-9" id="HTInfo">
            </div>
        </div>
    </div>
</div>
<?php echo isset($modal_contract)?$modal_contract:''; ?>
<?php echo $footer; ?>
