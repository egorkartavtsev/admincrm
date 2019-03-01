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
        <?php if(!(int)$client['legal']){ ?>
            <h3><?php echo $client['name'];?></h3>
        <?php } else { ?>
            <h3><?php echo $client['secondname'];?> <?php echo $client['firstname'];?> <?php echo $client['patronymic'];?></h3>
        <?php }?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Общая информация</a></li>
            <?php if(isset($handling)){ ?><li role="presentation"><a href="#service" aria-controls="service" role="tab" data-toggle="tab">Услуги</a></li>
            <li role="presentation"><a href="#work" aria-controls="work" role="tab" data-toggle="tab">Работы</a></li><?php }?>
        </ul>
        
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general">
                <form action="<?php echo $action;?>" method="POST">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Выберите авто</label>
                            <select class="form-control" name="handling[auto]" id="auto_id">
                                <?php foreach($auto as $car){ ?>
                                    <option value="<?php echo $car['id'];?>" <?php echo (isset($handling) && $handling['auto']==$car['id'])?'selected':''; ?>><?php echo $car['numb'];?> <?php echo $car['brand'];?> <?php echo $car['model'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Примечание</label>
                            <input type="text" name="handling[note]" class="form-control" id="note" value="<?php echo isset($handling)?$handling['note']:''; ?>">
                            <input type="hidden" name="handling[client]" class="form-control" id="client" value="<?php echo $client['id'];?>">
                        </div>
                        <div class="form-group">
                            <label>Тип обращения</label>
                            <select select_type="handling_acc" class="form-control" id="auto_id" <?php echo (isset($handling) && isset($accident))?'disabled':''; ?>>
                                <option value="0">Обычное обращение</option>
                                <option value="1" <?php echo (isset($handling) && isset($accident))?'selected':''; ?>>Обращение по ДТП</option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"><p></p></div>
                        <button type="submit" class="btn btn-success" title="Сохраняет обращение в базу. После сохранения можно прикреплять услуги">СОХРАНИТЬ</button>
                        <button type="button" class="btn btn-primary" btn_type="enable_edit">РЕДАКТИРОВАТЬ</button>
                        <div class="clearfix"></div>
                        <div class="clearfix"><p></p></div>
                    </div>
                    <div class="col-md-6" id="accident_info">
                        <?php if(isset($accident_form)){ echo $accident_form; }?>
                    </div>
                </form>
            </div>
        <?php if(isset($handling)){ ?>
            <div role="tabpanel" class="tab-pane" id="service">
                <h3>Список услуг, оказанных по обращению: </h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Номер</th>
                            <th>Тип обращения</th>
                            <th>Контрагент</th>
                            <th>Тип услуги</th>
                            <th>Статус</th>
                            <th>Статус оплаты</th>
                            <th>Примечание</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="contracts">
                    <?php foreach($services as $serv){ ?>
                        <tr cont="<?php echo $serv['id'];?>">
                            <td><?php echo $serv['contn'];?></td>
                            <td><?php echo $serv['handl_type'];?></td>
                            <td><?php echo $serv['agent'];?></td>
                            <td><?php echo $serv['serv_type'];?></td>
                            <td target-data="stat"><h5><?php echo '<span style="font-size: 100%;" class="label label-'.$serv['cont_stat_class'].'">'.$serv['cont_stat'];?></h5></td>
                            <td target-data="paystat"><h5><?php echo '<span style="font-size: 100%;" class="label label-'.$serv['payment_stat_class'].'">'.$serv['payment_stat'];?></h5></td>
                            <td target-data="note"><?php echo $serv['note'];?></td>
                            <td>
                                <button class="btn btn-primary" btn-type="contEdit"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-success" btn-type="contDownload"><i class="fa fa-download"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <a class="btn btn-success" btn_type="contract" data-toggle="modal" data-target="#contractcreateModal" target-contract="<?php echo $handling['id'];?>"><i class="fa fa-plus-circle"></i> добавить</a>
            </div>
            <div role="tabpanel" class="tab-pane" id="work"></div>
        <?php }?>
        </div>
        
    </div>
</div>
<?php echo isset($modal_contract)?$modal_contract:''; ?>
<?php echo $footer; ?>
