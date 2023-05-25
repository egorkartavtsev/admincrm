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
            <button class="btn btn-info" type="applyFilter" locate="sales"><i class="fa fa-check-circle-o"></i> применить настройки</button>
			<a class="btn btn-success" type="downloadReport" id="button-download"> Скачать отчёт </a>
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
                        <option value="sum">Суммы продаж</option>
                        <option value="count">Количество продаж</option>
                    </select>
                </div>
            </div>
            <div class="alert alert-success">
                <h4>Настройка оси X:</h4>
                <div class="form-group-sm">
                    <label>Выберите тип условий:</label>
                    <select class="form-control" name="xAxis">
                        <option value="date">Время</option>
                        <option value="wherefrom">Источник</option>
                        <option value="manager">Менеджер заводивший товар</option>
                        <option value="adress">Склад</option>
                        <title><option value="numb">Донор</option></title>
                        <option value="city">Город назначения(текущий/доставка)</option>
                        <option value="type">Тип товара</option>
                        <option value="brand">Марка</option>
                        <option value="model">Модель</option>
                        <option value="category">Категория товара</option>
                        <option value="price">Ценовые диопазоны</option>
                        <option value="opl_type">Тип оплаты</option>

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
			<div class="alert alert-success"> 
				<div class="form-group-sm">
					<label>Выберите тип товара:</label>
					<select class="form-control" name="type">
						<option value="all">Все</option>
						<option value="НОВЫЙ">Новые</option>
						<option value="Б/У">Б/У</option>
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
                          <th>Подкатегория</th>
                          <th>Марка</th>
                          <th>Модель</th>
                          <th>Донор</th>
                          <th>Внутр.номер</th>
                          <th>Цена продажи</th>
                          <th>Поставщик</th>
                          <th>Адрес</th>
                          <th>Дата продажи</th>
                          <th>Способ оплаты</th>
                          <th>Способ прожажи</th>
                          <th>Город покупателя</th>
                      </tr>
                  </thead>
                  <tbody id="saleRowsTable">
                  </tbody>
                  <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Итого</th>
                        <th><div id="itogo_sales"></div></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                  </tfoot>
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
        getDefault('sales');
    });
</script>
<?php echo $footer; ?>
