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
            <div class="well well-sm"><i class="fa fa-warning"></i> <?php echo $description; ?></div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="alert alert-success">
            <h4>Фильтры</h4>
            <div class="col-md-4">
                <div class="form-group col-md-6">
                    <label>Цена от:</label>
                    <input type="text" class="form-control" target="filter" target-name="priceFrom"
                           value="<?php echo isset($filter['priceFrom'])?$filter['priceFrom']:'';?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Цена до:</label>
                    <input type="text" class="form-control" target="filter" target-name="priceTo"
                           value="<?php echo isset($filter['priceTo'])?$filter['priceTo']:'';?>">
                </div>
                <div class="form-group-sm">
                    <label>Статус: </label>
                    <select class="form-control" target="filter" target-name="mess">
                        <option value=" ">Все</option>
                        <option value="1"
                        <?php echo (isset($filter['mess']) && (int)$filter['mess'])?'selected':'';?>>Активно</option>
                        <option value="0"
                        <?php echo (isset($filter['mess']) && !(int)$filter['mess'])?'selected':'';?>>Неактивно</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Окончание активации с:</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' target="filter" target-name="date" class="form-control date"
                               value="<?php echo isset($filter['date'])?date('d.m.Y',strtotime($filter['date'])):'';?>"/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group-sm">
                    <label>Наименование:</label>
                    <input type="text" class="form-control" target="filter" target-name="name"
                           value="<?php echo isset($filter['name'])?$filter['name']:'';?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Внутренний номер:</label>
                    <input type="text" class="form-control" target="filter" target-name="vin"
                           value="<?php echo isset($filter['vin'])?$filter['vin']:'';?>">
                </div>
                <div class="form-group-sm">
                    <label>Донор</label>
                    <input type="text" class="form-control" target="filter" target-name="donor"
                           value="<?php echo isset($filter['donor'])?$filter['donor']:'';?>">
                </div>
                <div class="clearfix"><p></p></div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button class="btn btn-sm bnt-block btn-primary" id="button-filter">применить фильтры</button>
                    <button class="btn btn-sm bnt-block btn-danger" id="clear-filter">очистить фильтры</button>
                </div>
            </div>
        </div>
        <?php echo $pagination;?>
        <table class="table table-hover">
            <thead>
            <tr>
                <td colspan="2">Товар</td>
                <td>Действие</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($prods as $ad){ ?>
                <tr class="<?php echo $ad['class'];?>">
                    <td><img src="<?php echo $ad['image']?>" alt="<?php echo $ad['Name']; ?>" class="img-thumbnail center-block left"></td>
                    <td class="h4">
                        <b><?php echo $ad['Name']?></b><br>
                        Внутренний номер: <b><?php echo $ad['Id']?></b><br>
                        Цена: <b><?php echo $ad['Price']?></b> руб.<br>
                        Активация с <b><?php echo date('d.m.Y',strtotime($ad['DateBegin']));?></b> по <span class="label label-<?php if($ad['DateEnd']<date('Y-m-d')){echo 'danger'; } else {echo 'info';}?>"><?php echo date('d.m.Y',strtotime($ad['DateEnd']));?></span><br>
                    </td>
                    <td>
                        <?php if($ad['DateEnd']<date('Y-m-d')){ ?>
                            <button btn_type="react" target-arg="<?php echo $ad['Id'];?>" class="btn btn-block btn-success text-center">Активировать заново</button>
                        <?php } else { ?>
                            <button btn_type="deact" target-arg="<?php echo $ad['Id'];?>" class="btn btn-block btn-success text-center">Прекратить активацию</button>
                        <?php }?>
                        <button btn_type="dropAd" target-arg="<?php echo $ad['Id'];?>" class="btn btn-block btn-danger text-center">Удалить с авито</button>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <?php echo $pagination;?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(document).find("[id*='datetimepicker']").each(function () {
            $(this).datetimepicker();
        })
        $('.date').datetimepicker({
            pickTime: false
        });
    });
    $(document).on('keydown', '[target=filter]', function (e) {
        if (e.keyCode == 13) {
            $('#button-filter').trigger('click');
        }
    });
    $(document).on('click', '#button-filter', function () {
        var url = 'index.php?route=avito/newAvito';
        $(this).parent().parent().parent().find('[target=filter]').each(function () {
            if ($(this).val() != '' && $(this).val() != ' ') {
                url = url + '&filter_' + $(this).attr('target-name') + '=' + $(this).val();
            }
        });
        location.href = url;
    });
    $(document).on('click', '#clear-filter', function () {
        location.href = 'index.php?route=avito/newAvito';
    });
    $(document).on('change', '[target=sort]', function () {
        location.href = $(this).val();
    });
    $(document).on('change', '[target=order]', function () {
        location.href = $(this).val();
    });
</script>
<?php echo $footer; ?>
