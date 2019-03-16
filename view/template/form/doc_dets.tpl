<div class="row">
    <form action="index.php?route=service/docs/saveDocDets" method="post" enctype="multipart/form-data">
        <div class="form-group col-sm-12">
            <label>Название</label>
            <input type="text" class="form-control" name="name" value="<?php echo $details['name']?>">
        </div>
        <div class="form-group col-sm-12">
            <label>Документ</label> <?php if($details['file']!=''){ ?><span class="label label-success">прикреплено <?php echo $details['file'];?></span><?php } ?>
            <input type="file" name="file" >
            <input type="hidden" name="doc_id" value="<?php echo ($details['doc_id']!=''?$details['doc_id']:'new-doc')?>"> 
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <button class="btn btn-success btn-sm btn-block">
                <i class="fa fa-floppy-o"></i> сохранить
            </button>
        </div>
    </form>
</div>