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
                <div class="btn-group-vertical pull-right col-lg-12" role="group" id="totalDocs">
                    <button class="btn btn-success" btn-type="showDocInfo" data-target="">
                        <i class="fa fa-plus-square-o"></i> добавить
                    </button>
                    <?php foreach($docs as $doc){ ?>
                        <button class="btn btn-info btn-block" btn-type="showDocInfo" data-target="<?php echo $doc['doc_id'];?>">
                            <?php echo $doc['name'];?>
                        </button>
                    <?php }?>
                </div>
            </div>
            <div class="col-sm-9" id="docInfo">
            </div>
        </div>
    </div>
</div>
<?php echo isset($modal_contract)?$modal_contract:''; ?>
<?php echo $footer; ?>