  <div class="container-fluid" id="createcontract" num="createauto">
      <div class="col-md-6 form-group-sm" name="contract-handl_type">
          <label>Тип обращения</label>
          <select class="form-control" id="contract-handl_type" select_type="librSelect" child="subagent">
              <option disabled selected>Выберите тип обращения</option>
              <?php foreach($handl_types as $htype){ ?>
                <option value="<?php echo $htype['id'];?>" <?php echo (isset($handl_type) && $handl_type==$htype['name'])?'selected':''?>><?php echo $htype['name'];?></option>
              <?php }?>
          </select>
      </div>
      <div class="col-md-6 form-group-sm" id="subagent" name="contract-agent">
          <label>Контрагент</label>
          <?php if(isset($model)){ ?>
            <select class="form-control" id="contract-agent">
              <option value="<?php echo $model['id'];?>"><?php echo $model['name'];?></option>
            </select>
          <?php } else { ?>
            <select class="form-control">
            </select>
          <?php }?>
      </div>
      <div class="col-md-6 form-group-sm" id="serv_type" name="contract-serv_type">
          <label>Услуга</label>
          <?php if(isset($model)){ ?>
            <select class="form-control" id="contract-serv_type">
              <option value="<?php echo $model['id'];?>"><?php echo $model['name'];?></option>
            </select>
          <?php } else { ?>
            <select class="form-control">
            </select>
          <?php }?>
      </div>
      <div class="col-md-6 form-group-sm">
        <label>&nbsp;</label>
        <?php if(isset($contract)){ ?><a class="col-md-6 btn btn-success btn-block btn-sm">ДОГОВОР</a><?php }?>
      </div>
      <div class="clearfix"></div>
      <div class="form-group-sm">
          <label>Примечание к услуге:</label>
          <input type="text" class="form-control" name="contract-note" value="" />
          <input type="hidden" class="form-control" name="contract-handling" value="<?php echo $handling;?>" />
      </div>
      <div class="clearfix"></div>
      <div class="clearfix"><p></p></div>
      <button btn_type="addcontract" class="btn btn-success" data-dismiss="modal">Сохранить</button>
  </div>
