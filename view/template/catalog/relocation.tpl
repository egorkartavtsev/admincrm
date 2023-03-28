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
	</div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default">
	  <div class="panel-heading" id="panel-heading-f" style='cursor: pointer;' data-toggle="tooltip" title="" data-original-title="Показать/скрыть фильтр">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
	  <div clasa="panel-body">
	    <div class="well" id="panel-body-f">
		  <div class="row">
		    <div class="col-sm-4">
			  <h3 class="panel-title" align="center"><b>Поиск товара</b></h3>
			  <div class="form-group">
			    <label class="row paddingrow" for="input-vin">Внутренний номер: </label>
				<input type="text" name="filter_vin" value="<?php echo $filter_vin; ?>" placeholder="Внутренний номер" id="input-vin" class="form-control" />
			  </div>
			  <?php echo $filtLocation;?><br>
			  <h4><input type="checkbox" name="isExact" <?php echo $checked; ?>/> <span class="label label-default">Указан точный адрес</span></h4>
			  <button type="button" id="button-filter" class="btn btn-primary pull-left"><i class="fa fa-filter"></i> Применить фильтры</button>
              <button type="button" id="btn-clear-filters" class="btn btn-danger pull-left"><i class="fa fa-binoculars"></i> Очистить фильтры</button>
			</div>
			<div class="col-sm-2">
			</div>
			<div class="col-sm-4">
			  <h3 class="panel-title" align="center"><b>Новое местоположение товара</b></h3><br>
			  <?php echo $form;?> <br>
		<form action="<?php echo $relocate; ?>" method="post" enctype="multipart/form-data" id="form-product">
		  <button type="button" id='btn-relocate' class="btn btn-success pull-right">Переместить товар</button>
			</div>
			<div class="col-sm-2">
				<h3 class="panel-title" align="left"><b>Недавно использованные адреса:</b></h3><br>
				<?php foreach($previousAddr as $addr){?>
					<button type="button" name="previousAddr" class="btn btn-success pull-right" value="<?php echo $addr['adress']; ?>:<?php echo $addr['location']; ?>" onclick="chooseAddr(this)"> <?php echo $addr['adress']; ?><br><?php echo $addr['location']; ?></button><br>
				<?php } ?>
			</div>
		  </div>
		</div>
		  <div class="table-responsive">
		    <table class="table table-bordered table-hover table-responsive">
			  <thead>
			    <tr>
				  <?php if($user['access'] == 19 || $user['access'] == 99999) { ?>
                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <?php } else { ?>
                    <td class="text-center"><i class="fa fa-android"></i></td>
                  <?php }?>
				  <td class="text-center col-sm-2">Изображение</td>
				  <td>Наименование товара</td>
				  <td>Внутренний номер</td>
				  <td>Адрес</td>
				  <td>Расположение</td>
				  <td>Цена</td>
				  <td>Кол-во</td>
				  <td>Статус</td>				  
				</tr>
			  </thead>
			  <tbody>
			    <?php if($products) { ?>
				  <?php foreach ($products as $product) { ?>
				    <tr>
					  <?php if($user['access'] == 19 || $user['access'] == 99999) { ?><td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
						<input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
					  <?php } else { ?>
						<input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                      <?php } ?></td><?php }?>
					  <td class="text-center">
						<div id="carousel-example-generic<?php echo $product['product_id']; ?>" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators" style="display: none;">
								<?php foreach($product['image'] as $image) { ?>
									<?php if (isset($image['main']) && $image['main'] == true) { ?> 
										<li data-target="#carousel-example-generic<?php echo $product['product_id']; ?>" data-slide-to="<?php echo $image['lid']?>" class="active"></li>
									<?php } else { ?>
										<li data-target="#carousel-example-generic<?php echo $product['product_id']; ?>" data-slide-to="<?php echo $image['lid']?>"></li>
									<?php }?>
								<?php }?> 
							</ol>
							<div class="carousel-inner" role="listbox">
									<?php foreach($product['image'] as $image) { ?> 
										<?php if (isset($image['main']) && $image['main'] == true) { ?> 
										   <div class="item active">
										<?php } else { ?>
										   <div class="item">
										<?php }?>
										<a class="plus-pupup" href="<?php echo $image['popup'].'?'.time();?>"><img src="<?php echo $image['thumb'];?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail d-block w-100" /></a>
										</div>   
									<?php }?>  
							</div>
							<a class="left carousel-control" href="#carousel-example-generic<?php echo $product['product_id']; ?>" role="button" data-slide="prev">
								<span class="fa fa-angle-left fa-2x" style="margin-top: 200%" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#carousel-example-generic<?php echo $product['product_id']; ?>" role="button" data-slide="next">
								<span class="fa fa-angle-right fa-2x" style="margin-top: 200%" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>            
						</div>
						<script type="text/javascript" async>
								$('#carousel-example-generic<?php echo $product['product_id']; ?>').carousel();    
						</script>     
					  </td>
					  <td class="text-left"><a href="<?php echo $go_site; ?><?php echo $product['product_id']; ?>" target="blank" data-toggle="tooltip" title="" data-original-title="Перейти к продукту"><?php echo $product['name']; ?>
					  <td><?php echo $product['vin']; ?></td>
					  <td><?php echo $product['adress']?></td>
					  <td><?php echo $product['stock'].'/'.$product['stell'].'/'.$product['jar'].'/'.$product['shelf'].'/'.$product['box']; ?></td>
					  <td class="text-right"><?php echo $product['price']; ?></td>
					  <td class="text-right"><?php if ($product['quantity'] <= 0) { ?>
						<span class="label label-warning"><?php echo $product['quantity']; ?></span>
						<?php } elseif ($product['quantity'] <= 5) { ?>
						<span class="label label-danger"><?php echo $product['quantity']; ?></span>
						<?php } else { ?>
						<span class="label label-success"><?php echo $product['quantity']; ?></span>
						<?php } ?></td>
					  <td class="text-left"><?php echo $product['status']; ?></td>
					</tr>
				  <?php } ?>
				<?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
			  </tbody>
			</table>
		  </div>
		</form>
		<div class="row">
          <div class="pag-block hidden-xs"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-left hidden-sm hidden-lg hidden-md"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
	  </div>
	</div>
	</div>
    <script type="text/javascript" src="view/javascript/jquery/magnific/jquery.magnific-popup.min.js"></script>
	<link href="view/javascript/jquery/magnific/magnific-popup.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript">
        $('.plus-pupup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            image: {
                    verticalFit: false
            }
        });
    </script>
	<script type="text/javascript"> 
		
		$('#btn-clear-filters').on('click', function(){
			var url = 'index.php?route=production/relocation';
			location = url;
        });
		$('#btn-relocate').on('click', function(){
          var result = confirm('Сохранить перемещение?');
          if(result){
			var products = $('input[name=\'selected[]\']:checked').prop("checked");
			if(products){
				$('#form-product').submit();
			}else{
				alert('Выберите товары для перемещения');
			}
          }else{
            return false;
          }
        });
		$('#panel-heading-f').on('click', function(){
			$('#panel-body-f').toggle('slow', function(){});
        });
		$('#button-filter').on('click', function() {
			var url = 'index.php?route=production/relocation';
			
			var filter_vin = $('input[name=\'filter_vin\']').val();
			var filter_vin = filter_vin.replace(/\s+/g," ");
			$('input[name=\'filter_vin\']').val($.trim(filter_vin));
			if (filter_vin) {
				url += '&filter_vin=' + encodeURIComponent(filter_vin);
			}
			
			var filter_adress = $('select[name=\'filter_adress\']').val();
			if(filter_adress && filter_adress != "-") {
				url +='&filter_adress='+ encodeURIComponent(filter_adress);
			}
			var filter_stock = $('select[name=\'filter_stock\']').val();
			if(filter_stock && filter_stock != "-") {
				url +='&filter_stock='+ encodeURIComponent(filter_stock);
			}
			var filter_stell = $('select[name=\'filter_stell\']').val();
			if(filter_stell && filter_stell != "-") {
				url +='&filter_stell='+ encodeURIComponent(filter_stell);
			}
			var filter_jar = $('select[name=\'filter_jar\']').val();
			if(filter_jar && filter_jar != "-") {
				url +='&filter_jar='+ encodeURIComponent(filter_jar);
			}
			var filter_shelf = $('select[name=\'filter_shelf\']').val();
			if(filter_shelf && filter_shelf != "-") {
				url +='&filter_shelf='+ encodeURIComponent(filter_shelf);
			}
			var filter_box = $('select[name=\'filter_box\']').val();
			if(filter_box && filter_box != "-") {
				url +='&filter_box='+ encodeURIComponent(filter_box);
			}
			var isExact = document.querySelector('input[name=\'isExact\']');
            if(isExact.checked) {
                url+='&isExact=yes';
            }
			location = url;
		});
		function chooseAddr(elem){
			var selected_addr = $(elem).val();
			$.ajax ({
				url: 'index.php?route=production/relocation/fillNewAddr',
				type: "post",
				data: ({selectedAddr:selected_addr}),
				dataType: "html",
				beforeSend: function(){
					$(elem).button('loading');
				},
				success: funcSuccess,
				error: function(){
					alert('Возникла ошибка при заполнении');
				}
			});
		};
		function funcSuccess(data){
			$('button[name=\'previousAddr\']').button('reset');
			$('div[num=\'relocation\']').html(data);
		};
    </script>
  </div>

<?php echo $footer; ?>
