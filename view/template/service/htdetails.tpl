<div>
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach($city as $ct){ ?>
            <li role="presentation" class="<?php echo ($ct['city_id']=='1')?'active':''?>">
                <a href="#<?php echo $ct['city_code'];?>" aria-controls="<?php echo $ct['city_code'];?>" role="tab" data-toggle="tab"><?php echo $ct['city_code'];?></a>
            </li>
        <?php }?>
    </ul>
    <div class="col-lg-12">
        <div class="tab-content">
            <?php foreach($city as $ct){ ?>
                <div role="tabpanel" class="tab-pane <?php echo ($ct['city_id']=='1')?'active':''?>" id="<?php echo $ct['city_code'];?>">
                    <h4><?php echo $ct['city_name'];?></h4>
                    <hr>
                    <div class="col-sm-6">
                        <div class="btn-group-vertical" role="group">
                            <?php foreach($ct['agents'] as $agent){ ?>
                                <button class="btn btn-primary" btn-type="showServices" data-target="<?php echo $agent['agent_id'];?>">
                                    <?php echo $agent['name'];?>
                                </button>
                            <?php }?>
                            <button class="btn btn-success" btn-type="createAgent" data-target="<?php echo $handlingType;?>">
                                <i class="fa fa-plus-square-o"></i> добавить
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-6" id="HTInfo">
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>