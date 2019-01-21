<div class="container-fluid">
<div class="row">
    <div class="form-group-sm col-md-6">
        <label>Название поля:</label>
        <input type="text" class="form-control" id="textOption" value="<?php echo $text;?>"/>
        <input type="hidden" class="form-control" id="field_typeOption" value="<?php echo $field_type;?>"/>
        <input type="hidden" class="form-control" id="nameOption" value="<?php echo $name;?>"/>
        <input type="hidden" class="form-control" id="oldOption" value="1"/>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Значение по умолчанию:</label>
        <input type="text" class="form-control" id="def_valOption" value="<?php echo $def_val;?>"/>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Описание свойства:</label>
        <input type="text" class="form-control" id="descriptionOption" value="<?php echo $description;?>"/>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Порядок сортировки:</label>
        <input type="text" class="form-control" id="sort_orderOption" value="<?php echo $sort_order;?>"/>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Обязательность:</label>
        <select class="form-control" id="requiredOption">
            <option value="0">Необязательное поле</option>
            <option value="1" <?php echo $required=='1'?'selected':'';?>>Обязательное поле</option>
        </select>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Видимость:</label>
        <select class="form-control" id="viewedOption">
            <option value="1">Отображать веезде на витрине</option>
            <option value="2" <?php echo $viewed=='2'?'selected':'';?>>Отображать только в списке товаров</option>
            <option value="3" <?php echo $viewed=='3'?'selected':'';?>>Отображать тоьлко на странице товара</option>
            <option value="0" <?php echo $viewed=='0'?'selected':'';?>>Не отображать на витрине</option>
        </select>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Участие в поиске:</label>
        <select class="form-control" id="searchingOption">
            <option value="0">Не учавствует в поиске</option>
            <option value="1" <?php echo $searching=='1'?'selected':'';?>>Учавствует в поиске</option>
        </select>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Уникальность:</label>
        <select class="form-control" id="unique_fieldOption">
            <option value="0">Неуникальное поле</option>
            <option value="1" <?php echo $unique_field=='1'?'selected':'';?>>Уникальное поле</option>
        </select>
    </div>
    <div class="form-group-sm col-md-6">
        <label>Участие в фильтрах:</label>
        <select class="form-control" id="filterOption">
            <option value="0">Не отображать в фильтрах</option>
            <option value="1" <?php echo $filter=='1'?'selected':'';?>>Отображать в фильтрах</option>
        </select>
    </div>
    <div class="form-group-sm col-md-12">
        <label>Автозаполнение:</label>
        <select class="form-control" id="chooseWay" target="<?php echo $type_id;?>">
            <option value="0">Обычный ввод текста</option>
            <option value="1" <?php echo ($similar!='' && $similar!='null')?'selected':'';?>>Автозаполнение свойств товара при вводе</option>
        </select>
    </div>
    <?php if($similar!=='' && $similar!=='null'){ ?>
        <?php $similar = '_'.$similar;?>
        <div class="form-group-sm col-md-12">
            <label>Способ заполнения:</label>
            <select class="form-control" id="sim_showlistOption">
                <option value="product">По подобным товарам</option>
                <option value="donor" <?php echo $sim_showlist=='donor'?'selected':'';?>>По донорам</option>
            </select>
        </div>
        <div class="form-group-sm col-md-12">
            <label>Поля для заполнения:</label>
            <select class="form-control" style="min-height: 100px;" multiple id="similarOption">
                <?php foreach($opts['options'] as $opt){ ?>
                    <option value="<?php echo $opt['name'];?>" <?php echo stripos($similar, $opt['name'])?'selected':'';?>><?php echo $opt['text'];?></option>
                <?php }?>
            </select>
        </div>
    <?php }?>
    <div class="clearfix"></div>
    <div class="clearfix"><p></p></div>
    <div class="col-lg-12">
        <button id="saveOpt" class="btn btn-info"><i class="fa fa-floppy-o"></i> сохранить</button>
    </div>
</div>
</div>
