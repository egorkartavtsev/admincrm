<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<script src="view/dist/chartist.min.js"></script>
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-8">
              <h2 id="chart-title">График:</h2>
              <div class="ct-chart ct-perfect-fourth" id="salesChart">
                  <h3 class="text-center">Пожалуйста, подождите...</h3>
                  <img src="wait.gif" class="center-block" width="150"/>
              </div>
          </div>
          <div class="col-md-4" type="filter">
            <h2>Настройки Графика:</h2>
            <button class="btn btn-info" type="applyFilter" locate="added"><i class="fa fa-check-circle-o"></i> применить настройки</button>
            <p>&nbsp;</p>
            <div class="alert alert-success">
                <h4>Отчётный период:</h4>
                <div class="form-group-sm">
                    <label>Начало</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="startdate" class="form-control" value="01.01.<?php echo date('Y'); ?> 00:00"/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group-sm">
                    <label>Конец</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="enddate" class="form-control" value="<?php echo date('d.m.Y H:i'); ?>"/>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="alert alert-success">
                <h4>Тип диаграммы:</h4>
                <div class="form-group-sm">
                    <label>Выберите вид значений:</label>
                    <select class="form-control" name="typeChart">
                        <option value="Line">График</option>
                        <option value="Bar">Столбчатая диаграмма</option>
                        <option value="Pie" disabled>Круглая диаграмма</option>
                    </select>
                </div>
            </div>
            <div class="alert alert-success">
                <h4>Настройка оси Y:</h4>
                <div class="form-group-sm">
                    <label>Выберите вид значений:</label>
                    <select class="form-control" name="yAxis">
                        <option value="sum_added">Суммы цен товаров</option>
                        <option value="count_added">Количество товаров</option>
                    </select>
                </div>
            </div>
            <div class="alert alert-success">
                <h4>Настройка оси X:</h4>
                <div class="form-group-sm">
                    <label>Выберите тип условий:</label>
                    <select class="form-control" name="xAxis">
                        <option value="date_added">Время</option>
                        <option value="manager">Менеджер заводивший товар</option>
                        <option value="adress">Склад</option>
                        <option value="type">Тип товара</option>
                        <option value="brand">Марка</option>
                        <option value="model">Модель</option>
                        <option value="category">Категория товара</option>
                    </select>
                </div>
                <div class="form-group-sm">
                    <label>Выберите уровень детализации(только для отображения по времени):</label>
                    <select class="form-control" name="timeDetalise">
                        <option value="m">Месяцы</option>
                        <option value="d">Дни</option>
                        <option value="y">Года</option>
                    </select>
                </div>
            </div>
          </div>
      </div>
      <div class="row">
          <div>
              <table class="table-bordered table-responsive table-striped col-lg-12">
                  <thead>
                      <tr>
                          <th rowspan="2" class="col-lg-3 text-center">Показатель</th>
                          <th colspan="9" class="text-center">Результаты</th>
                      </tr>
                      <tr>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                          <th>#</th>
                      </tr>
                  </thead>
              </table>
          </div>
      </div>
  </div>
</div>
<div class="pointdesc hide">
</div>
<script type="text/javascript">
    
    
    $(document).ready(function(){
        $(document).find("[id*='datetimepicker']").each(function(){
            $(this).datetimepicker();
        });
        $('.date').datetimepicker({
            pickTime: false
        });
        getDefault('added');
    });
</script>
<?php echo $footer; ?>