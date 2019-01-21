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
        <div class="col-lg-6">
            <div class="testdiv testdivred">
                 <p class="testp"><?php echo $email;?></p>
                <p class="testp newtestone"><?php echo $firstmane." ".$lastname ;?></p>
                <p class="testp"><?php echo $userAL;?></p>
                <p class="testp"><?php echo $user_group;?></p>
            </div>
        </div>       
      </div> 
<div>
        <div class="col-lg-6">
            <div class="testdiv testdivgreen">
                <p class="testp"><?php echo $user_group;?></p>
                <p class="testp newtestone"><?php echo $firstmane." ".$lastname ;?></p>
                <p class="testp"><?php echo $userAL;?></p>
                <p class="testp"><?php echo $email;?></p>
            </div>
        </div>       
      </div>             
  </div>
    <div class='alert well'>
    <form method="post" action="index.php?route=setting/test">
        <div  class="col-lg-3 form-group  well-sm">
            <label for="brandTest">Марка</label>
            <input type="search" class="form-control" name="brandTest" placeholder="Бренд" value="<?php if (isset($filter['brandTest'])){ echo $filter['brandTest'];}?>">
        </div>
         <div class="col-lg-2 form-group  well-sm">
            <label for="minpriceTest">Цена от:</label>
            <input type="number" class="form-control" name="minpriceTest" placeholder="Цена от" value="<?php echo $filter['minpriceTest'];?>">
        </div>
        <div class="col-lg-2 form-group well-sm">
            <label for="maxpriceTest">Цена до:</label>
            <input type="number" class="form-control" name="maxpriceTest" placeholder="Цена до:" value="<?php echo $filter['maxpriceTest'];?>">
        </div>
         <div class="col-lg-2 form-group well-sm">
            <label for="compliteTest">Состав</label>
            <input list="List" type="text"  class="form-control" name="compliteTest" placeholder="Введите " >
        </div>
        <div class="col-lg-1 form-group well-sm"> 
            <label for="colvo">Кол-во товара</label><br>
            <input type="number" class="form-control" name="colvo" placeholder="50" value="<?php echo $filter['maxpriceTest'];?>">
        </div>    
        <div class='col-lg-2 form-group well-sm'>
            <label>&nbsp;</label><br>
            <button type="submit" class="right btn btn-default">Фильтровать</button>
            <datalist id="List">
                <option value="Комплект" />
                <option value="Отдельная деталь" />
            </datalist>
        </div>
    </form>
    </div>    
<table class="table table-striped">
 <tr>
     <th>Порядковый номер</th>
     <th>Название товара</th>
     <th>Внутриний номер</th>
     <th>Цена</th>
     <th>Изображение</th>
 </tr>   
    <?php foreach($products as $key => $prostata){ ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $prostata['nametest'];?></td>
            <td><?php echo $prostata['vintest'];?></td>
            <td><?php echo $prostata['pricetest'];?></td>
            <td><img src="<?php echo $prostata['imagetest'];?>" class="img-circle"></td>
        </tr>
    <?php } ?>
</table>
</div>
<?php echo $footer; ?>
