<?php echo $header; echo $column_left; ?>
<div id="content">
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
    <div class="alert alert-success">
	  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	    <div class="panel panel-default">
		  <div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
			  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				Выбрать категорию
			  </a>
			</h4>
		  </div>
		  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
			  <div class="row">
			    <div class="col-lg-3">
				  <a class="btn btn-block btn-success" href="index.php?route=production/autoload_drom/download&minPrice=0&maxPrice=1000"> Выгрузить товары до 1000 р. </a>
				  <a class="btn btn-block btn-success" href="index.php?route=production/autoload_drom/download&minPrice=1000&maxPrice=10000"> Выгрузить товары от 1000 р. до 10000 р. </a>
				  <a class="btn btn-block btn-success" href="index.php?route=production/autoload_drom/download&minPrice=10000&maxPrice= 999999"> Выгрузить товары дороже 10000 р. </a>
			    </div>
			  </div>
			</div>
		  </div>
		</div>
	    <div class="panel panel-default">
		  <div class="panel-heading" role="tab" id="headingTwo">
			<h4 class="panel-title">
			  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				Ввести цену вручную
			  </a>
			</h4>
		  </div>
		  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
			  <div class="form-group col-lg-6">
			   <label>Цена от: </label>
			   <input type="number" name="filter_min_price" placeholder="Минимальная цена" id="input-min_price" class="form-control" />
			  </div>
			  <div class="form-group col-lg-6">
				<label>Цена до: </label>
				<input type="number" name="filter_max_price" placeholder="Максимальная цена" id="input-max_price" class="form-control" />
			  </div>
			  <button type="button" id="button-download" class="btn btn-success"> Выгрузить товары </button>
			  <button type="button" id="button-download-all" class="btn btn-success"> Выгрузить все товары </button>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<script type="text/javascript">
	$('#button-download').on('click', function() {
		var filter_min_price = $('input[name=\'filter_min_price\']').val();
		if (!filter_min_price) {
			$('input[name=\'filter_min_price\']').val(0);
		}
		var filter_max_price = $('input[name=\'filter_max_price\']').val();
		if (!filter_max_price) {
			$('input[name=\'filter_max_price\']').val(999999);
		}
		download();	
	});
	$('#button-download-all').on('click', function() {
		$('input[name=\'filter_min_price\']').val(0);		
		$('input[name=\'filter_max_price\']').val(999999);
		download();
	});
	function download(){
		var url = 'index.php?route=production/autoload_drom/download';
		var filter_min_price = $('input[name=\'filter_min_price\']').val();
		url += '&minPrice=' + encodeURIComponent(filter_min_price);
		var filter_max_price = $('input[name=\'filter_max_price\']').val();
		url += '&maxPrice=' + encodeURIComponent(filter_max_price);
		location = url;
	};
	
	
	
</script>
<?php echo $footer;?>

