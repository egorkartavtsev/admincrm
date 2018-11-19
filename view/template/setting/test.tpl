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
      
      <div>
        <div class="col-lg-6">
            <div class="testdiv testdivred">
                 <p class="testp"><?php echo $email;?></p>
                <p class="testp newtestone"><?php echo $firstmane." ".$lastname ;?></p>
                <p class="testp"><?php echo $userAL;?></p>
                <p class="testp"><?php echo $user_group;?></p>
            </div>
        </div>       
      </div> 
<div>
        <div class="col-lg-6">
            <div class="testdiv testdivgreen">
                <p class="testp"><?php echo $user_group;?></p>
                <p class="testp newtestone"><?php echo $firstmane." ".$lastname ;?></p>
                <p class="testp"><?php echo $userAL;?></p>
                <p class="testp"><?php echo $email;?></p>
            </div>
        </div>       
      </div>             
  </div>
</div>

<?php echo $footer; ?>
