  <div class="container-fluid" id="createcontract" num="createauto">
      <div class="col-md-6 form-group-sm" name="contract-handl_type">
          <label>Тип обращения</label>
          <select class="form-control" select_type="contDetSelect" child="subagent">
              <option disabled selected>Выберите тип обращения</option>
              <?php foreach($handl_types as $htype){ ?>
                <option value="<?php echo $htype['ht_id'];?>" <?php echo (isset($handl_type) && $handl_type==$htype['ht_id'])?'selected':''?>><?php echo $htype['name'];?></option>
              <?php }?>
          </select>
      </div>
      <div class="col-md-6 form-group-sm" name="contract-agent">
          <label>Контрагент</label>
          <select class="form-control" target="subagent" select_type="contDetSelect" child="service">
          </select>
      </div>
      <div class="col-md-6 form-group-sm" name="contract-serv_type">
          <label>Услуга</label>
          <select class="form-control" target="service">
          </select>
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
      <button btn_type="addcontract" class="btn btn-success">Сохранить</button>
  </div>
