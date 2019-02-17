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
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php $i = 1; foreach($plans as $key => $plan){ ?>
                <li role="presentation" class="<?php echo ($i>0)?'active':''; $i--?>"><a href="#plan<?php echo $plan['id'];?>Tab" aria-controls="plan<?php echo $plan['id'];?>Tab" role="tab" data-toggle="tab"><?php echo $key;?></a></li>
            <?php }?>
        </ul>
          <?php //exit(var_dump($plans));?>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php $i = 1; foreach($plans as $key => $plan){ ?>
                <div role="tabpanel" class="tab-pane fade in <?php echo ($i>0)?'active':''; $i--?>" id="plan<?php echo $plan['id'];?>Tab">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div id="status" style="display: none;">
                                <div class="alert alert-success h3"><i class="fa fa-check"></i> Сохранено!</div>
                            </div>
                        </div>
                        <div class="form-group col-sm-9">
                            <label>План на текущий месяц:</label>
                            <input type="number" id="currentPlan" value="<?php echo $plan['current']?$plan['current']:'';?>" class="form-control">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-success" btn_type="savePlan" addr="<?php echo $key;?>" disabled><i class="fa fa-floppy-o"></i></button>
                        </div>
                        <div>
                            <h4><b>История выполнения плана в текущем месяце:</b></h4>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">День</th>
                                        <th class="col-sm-1">План</th>
                                        <th class="col-sm-1">Факт</th>
                                        <th class="col-sm-1">Продажы за данный день, руб.</th>
                                        <th class="col-sm-1">Сумма для выполнения плана, руб.</th>
                                        <th class="col-sm-7">%</th>
                                    </tr>
                                </thead>
                                <tbody id="ppd">
                                    <?php foreach($plan['planPerDay'] as $ppd){ ?>
                                    <tr style="<?php echo ($ppd['date']===date('d.m.Y')?'background-color: #d9edf7;':'')?>">
                                            <td><?php echo $ppd['date'];?></td>
                                            <td><?php echo $ppd['plan'];?></td>
                                            <td><?php echo $ppd['fact'];?></td>
                                            <td><?php echo $ppd['sumday'];?></td>
                                            <td><?php echo $ppd['sumfp'];?></td>
                                            <td><?php echo $ppd['percent'];?></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class=" alert alert-info">
                            <h4>На текущий день план отбит на <b><span id="totalPerc"><?php echo $plan['totalPercent'];?></span>%</b></h4>
                            <p>План: <b><span id="current"><?php echo $plan['current'];?></span></b> руб.</p>
                            <p>Факт: <b><span id="curFact"><?php echo $plan['curFact'];?></span></b> руб.</p>
                            <p>Продажы за текущий день: <b><span id="curEvDay"><?php echo $plan['curEvDay'];?></span></b> руб.</p>
                            <p>Необходимая сумма для выполнения плана: <b><span id="sumLast"><?php echo $plan['sumLast'];?></span></b> руб.</p>
                            <div id="tp-bar">
                                <div class="progress">
                                  <div class="progress-bar progress-bar-<?php echo ($plan['totalPercent']>=100)?'success':'danger';?> progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $plan['totalPercent'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($plan['totalPercent']>100)?'100':$plan['totalPercent'];?>%">
                                    <?php echo $plan['totalPercent'];?>%
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class=" alert alert-success">
                            <h4><b>История изменения плана в текущем месяце:</b></h4>
                            <table class="table table-striped" id="histCurrMounth">
                                <?php foreach($plan['currHist'] as $fact){ ?>
                                <tr>
                                    <td><?php echo $fact['date'];?></td>
                                    <td><?php echo $fact['firstname']." ".$fact['lastname'];?></td>
                                    <td><?php echo $fact['comment'];?></td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h4><b>История выполнения планов за предыдущие месяцы:</b></h4>
                            <table >
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">Месяц</th>
                                        <th class="col-sm-1">План</th>
                                        <th class="col-sm-1">Факт</th>
                                        <th class="col-sm-9">%</th>
                                    </tr>
                                </thead>
                                <tbody id="ppd">
                                    <?php foreach($plan['history'] as $histFact){ ?>
                                        <tr>
                                            <td><?php echo $histFact['date'];?></td>
                                            <td><?php echo $histFact['plan'];?></td>
                                            <td><?php echo $histFact['fact'];?></td>
                                            <td>
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-<?php echo ($histFact['percent']>=100)?'success':'danger';?> progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $histFact['percent'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($histFact['percent']>100)?'100':$histFact['percent'];?>%">
                                                    <?php echo $histFact['percent'];?>%
                                                  </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                    </div>
                </div>
            <?php }?>
        </div>

      </div>
  </div>
</div>
<script type="text/javascript">
    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    $(document).on('input', '#currentPlan', function(){
        var trCh = /[0-9]/;
        if($(this).val()!=='' && trCh.test($(this).val())){
            $(this).parent().parent().find('[btn_type=savePlan]').removeAttr('disabled');
        } else {
            $(this).parent().parent().find('[btn_type=savePlan]').attr('disabled', 'true');
        }
    });
    
    $(document).on('click', '[btn_type=savePlan]', function(){
        var plan = $(this).parent().parent().find('#currentPlan').val();
        var btn = $(this);
        $.ajax({
            url:'index.php?route=report/planing/saveCurr',
            datatype:'json',
            method:'post',
            data:{ curr:plan, addr:btn.attr('addr')},
            success:function(resp){
                console.log(resp);
                btn.attr('disabled', 'disabled');
                sup = JSON.parse(resp);
                btn.parent().parent().parent().find('#histCurrMounth').html('');
                $.each(sup['history'], function(){
                    btn.parent().parent().parent().find('#histCurrMounth').append("<tr><td>"+$(this)[0]['date']+"</td><td>"+$(this)[0]['firstname']+" "+$(this)[0]['lastname']+"</td><td>"+$(this)[0]['comment']+"</td></tr>");
                });
                btn.parent().parent().parent().find('#ppd').html('');
                $.each(sup['planPerDay'], function(){
                    btn.parent().parent().parent().find('#ppd').append("<tr><td>"+$(this)[0]['date']+"</td><td>"+$(this)[0]['plan']+"</td><td>"+$(this)[0]['fact']+"</td><td>"+$(this)[0]['percent']+"</td></tr>");
                });
                btn.parent().parent().parent().find('#status').fadeIn(600);
                setTimeout(function(){
                    btn.parent().parent().parent().find('#status').fadeOut(800);
                }, 2000);
                
                btn.parent().parent().parent().find('#totalPerc').text(sup['totalPercent']);
                btn.parent().parent().parent().find('#current').text(sup['current']);
                btn.parent().parent().parent().find('#curFact').text(sup['curFact']);
                btn.parent().parent().parent().find('#tp-bar').find('.progress-bar').text(sup['totalPercent']+'%');
                width = sup['totalPercent']>100?100:sup['totalPercent'];
                btn.parent().parent().parent().find('#tp-bar').find('.progress-bar').css('width', width+'%');
                btn.parent().parent().parent().find('#tp-bar').find('.progress-bar').attr('aria-valuenow', sup['totalPercent']);
            }
        });
    });
</script>
<?php echo $footer; ?>