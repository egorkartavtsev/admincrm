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
    <div class="row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
            <table class="table table-bordered table-striped">
                <tr>
                    <td colspan="6">Total: </td>
                    <td><?php echo count($sales); $i = 1; ?></td>
                </tr>
                <tr>
                    <td class="text-center">№</td>
                    <td class="text-center">Тип</td>
                    <td class="text-center">Цена</td>
                    <td class="text-center">Катагория</td>
                    <td class="text-center">Город</td>
                    <td class="text-center">Менеджер</td>
                    <td class="text-center">Дата</td>
                </tr>
            <?php foreach($sales as $sale){ ?>
                <tr>
                    <td style="background-color: #cac9b6; border-bottom: none;" class="text-center"><?php echo $i; ++$i; ?></td>
                    <td class="text-center"><?php echo $sale['type']=='Р‘/РЈ'?'0':'1';?></td>
                    <td class="text-center"><?php echo $sale['price'];?></td>
                    <td class="text-center"><?php echo $sale['categ'];?></td>
                    <td class="text-center"><?php echo $sale['city']=='РњР°РіРЅРёС‚РѕРіРѕСЂСЃРє'?'0':'1';?></td>
                    <td class="text-center"><?php echo $sale['manager'];?></td>
                    <td class="text-center"><?php echo date("m", strtotime($sale['date']));?></td>
                </tr>
            <?php } ?>
            </table>
            <br><hr><br>
            <?php echo (strtotime(date("Y-m-d H:i:s")) - $start);?> РјСЃРµРє.<br>
        </div>
            <div class="col-lg-4">
            </div>
    </div>
</div>
<?php echo $footer;?>