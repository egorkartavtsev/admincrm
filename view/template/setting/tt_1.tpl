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
    <form method="post" action="index.php?route=setting/test/filtered">
        <div class="form-group">
            <label for="brandTest">Марка</label>
            <input type="search" class="form-control" name="brandTest" placeholder="Бренд">
        </div>
         <div class="form-group">
            <label for="minpriceTest">Цена от:</label>
            <input type="number" class="form-control" name="minpriceTest" placeholder="Цена от">
        </div>
        <div class="form-group">
            <label for="maxpriceTest">Цена до:</label>
            <input type="number" class="form-control" name="maxpriceTest" placeholder="Цена до:">
        </div>
        <div>
            <button type="submit" class="btn btn-default">Фильтровать</button>
        </div>
    </form>
<table class="table table-striped">
 <tr>
     <th>Название товара</th>
     <th>Внутриний номер</th>
     <th>Цена</th>
     <th>Изображение</th>
 </tr>   
    <?php foreach($products as $prostata){ ?>
        <tr>
            <td><?php echo $prostata['nametest'];?></td>
            <td><?php echo $prostata['vintest'];?></td>
            <td><?php echo $prostata['pricetest'];?></td>
            <td><img src="<?php echo $prostata['imagetest'];?>" class="img-circle"></td>
        </tr>
    <?php } ?>
</table>
</div>
<?php echo $footer; ?>
