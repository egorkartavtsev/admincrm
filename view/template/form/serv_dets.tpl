<div class="row">
    <div class="form-group col-sm-12">
        <label>Название</label>
        <input type="text" class="form-control" data-field="serv_name" value="<?php echo $details['name']?>">
    </div>
    <div class="form-group col-sm-12">
        <label>Документ</label>
        <select class="form-control" data-field="doc">
            <option disabled>Выберите связанный документ</option>
            <option value="">Нет связанных документов</option>
            <?php foreach($docs as $val){ ?>
                <option <?php echo ($val['doc_id']==$details['doc_id'])?'selected':''; ?> value="<?php echo $val['doc_id'];?>"><?php echo $val['name'];?></option>
            <?php }?>
        </select>
    </div>
    <div class="form-group col-sm-12">
        <label>Закл.поумолч.</label>
        <select class="form-control" data-field="link">
            <option value="0">С клиентом</option>
            <?php foreach($agents as $val){ ?>
                <option <?php echo ($val['agent_id']==$details['link'])?'selected':''; ?> value="<?php echo $val['agent_id'];?>"><?php echo $val['agent'];?> (<?php echo $val['htype'];?>) (<?php echo $val['city_name'];?>)</option>
            <?php }?>
        </select>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <button btn-type="saveServDets" class="btn btn-success btn-sm btn-block" data-source="<?php echo $details['service_id']?>"><i class="fa fa-floppy-o"></i> сохранить</button>
    </div>
</div>