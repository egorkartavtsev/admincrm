<?php

class ModelToolForms extends Model {
    private $systemFields = array(
        'vin' => 'Внутренний номер', 
        'youtube' => 'YouTube(только код!)',
        'price' => 'Цена',
        'selfprice' => 'Себестоимость', 
        'quantity' => 'Количество'
    );
    private $systems = [
        'vin' => array('text'=>'Внутренний номер', 'default'=>'', 'attrs'=>'required="required" aria-required="true" unique="unique"'), 
        'youtube' => array('text'=>'YouTube(только код!)', 'default'=>'', 'attrs'=>''), 
        'price' => array('text'=>'Цена', 'default'=>'0', 'attrs'=>'required="required" aria-required="true" '), 
        'selfprice' => array('text'=>'Себестоимость', 'default'=>'0', 'attrs'=>''), 
        'quantity' => array('text'=>'Количество', 'default'=>'1', 'attrs'=>'required="required" aria-required="true" ')
       ];
    private $form = array('system' => '', 'library' => '', 'select' => '', 'input' => '', 'compability' => '');
    private $ignoreFields = array('complect', 'heading', 'type_id', 'manager', 'status');

    public function constructAddForm($id) {
        $this->load->model('tool/complect');
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."type_lib WHERE type_id = ".(int)$id." ORDER BY sort_order");
        foreach ($this->systems as $key => $field) {
            $this->form['system'].= '<div class="form-group-sm col-md-4">'
                                . '<label>'.$field['text'].'</label>'
                                . '<input class="form-control" name="input-'.$key.'" field="'.$key.'" value="'.$field['default'].'" '.$field['attrs'].'/>'
                             . '</div>';
        }
        foreach($sup->rows as $option){
            $this->getOptionField($option);
        }
        $result = '<div type="fields">';
        foreach($this->form as $fields){
            $result.=$fields.'<div class="clearfix"></div><hr>';
        }
        $result.= '</div>';
        $result.= '<div type="complect">';
        $result.= $this->model_tool_complect->constrCompField()."<div class='col-lg-12'><hr></div>";
        $result.= '</div>';
        $result.= '<div type="photos">';
        $result.='<div class="form-group-sm col-lg-12" >
                    <label for="photos">Прикрепите фотографии:</label>
                    <input id="photos" class="form-control" type="file" multiple="true">
                  </div>';
        $result.= '</div>';
        $result.='<input type="hidden" name="input-type_id" value="'.$id.'">';
        return $result.'<div class="row"><button class="btn btn-success center-block" btn-type="createProduct"><i class="fa fa-floppy-o"></i> сохранить товар</button></div>';
    }
    
    public function getOptionField($option) {
        $res = '';
        $attrs = '';
        switch ($option['field_type']) {
            case 'input':
                //***Каталожный номер***
                if($option['name']!=='numb' && $option['name']!=='catn'){
                    $this->form[$option['field_type']].= '<div class="form-group-sm col-md-12" link="'.$option['name'].'">';
                        $attrs.= $option['required']==='1'?' required="required" aria-required="true"':'';
                        $attrs.= $option['unique_field']==='1'?' unique="unique" field="'.$option['name'].'"':'';
                        $attrs.= ($option['similar']!=='' && $option['similar']!=='null')?' inp_type="chooseSim" field="'.$option['name'].'" target="'.$option['sim_showlist'].'" opt="'.$option['lib_id'].'"':'';
                        $this->form[$option['field_type']].='<label>'.$option['text'].($option['required']==='1'?'<span style="color: red;">*</span>':'').'</label>'
                            . '<input class="form-control" name="input-'.$option['name'].'" '.$attrs.' value="'.$option['def_val'].'" />';
                        if($option['similar']!=='' && $option['similar']!=='null'){
                            $this->form[$option['field_type']].= '<ul class="dropdown-menu" id="dropD" style="left: 15px; max-height: 170px; overflow-y: scroll; display: none;">'
                                      . '<li class="dropdown-header"><span class="pull-left">Выберите значение</span><span class="pull-right btn btn-default btn-sm" id="closeDd">&times;</span></li>'
                                      . '<li class="devider"><hr></li>'
                                      . '<div id="devList"></div>'
                                    . '</ul>';
                        }
                    $this->form[$option['field_type']].= '</div>';
                } else {
                    $this->form['system'].= '<div class="form-group-sm col-md-4" link="'.$option['name'].'">';
                        $attrs.= $option['required']==='1'?' required="required" aria-required="true"':'';
                        $attrs.= $option['unique_field']==='1'?' unique="unique" field="'.$option['name'].'"':'';
                        $attrs.= ($option['similar']!=='' && $option['similar']!=='null')?' inp_type="chooseSim" field="'.$option['name'].'" target="'.$option['sim_showlist'].'" opt="'.$option['lib_id'].'"':'';
                        $this->form['system'].='<label>'.$option['text'].($option['required']==='1'?'<span style="color: red;">*</span>':'').'</label>'
                            . '<input class="form-control" name="input-'.$option['name'].'" '.$attrs.' value="'.$option['def_val'].'" />';
                        if($option['similar']!=='' && $option['similar']!=='null'){
                            $this->form['system'].= '<ul class="dropdown-menu" id="dropD" style="left: 15px; max-height: 170px; overflow-y: scroll; display: none;">'
                                      . '<li class="dropdown-header"><span class="pull-left">Выберите значение</span><span class="pull-right btn btn-default btn-sm" id="closeDd">&times;</span></li>'
                                      . '<li class="devider"><hr></li>'
                                      . '<div id="devList"></div>'
                                    . '</ul>';
                        }
                    $this->form['system'].= '</div>';
                }
            break;
            case 'select':
                $this->form[$option['field_type']].='<div class="form-group-sm  col-md-4" link="'.$option['name'].'">'
                        . '<label>'.$option['text'].'</label>';
                    $this->form[$option['field_type']].='<select class="form-control" name="input-'.$option['name'].'">';
                    $vals = explode(';', $option['vals']);
                    $this->form[$option['field_type']].='<option value="-">-</option>';
                    foreach ($vals as $value) {
                        $this->form[$option['field_type']].='<option value="'.trim($value).'">'.trim($value).'</option>';
                    }
                    $this->form[$option['field_type']].='</select>';
                $this->form[$option['field_type']].= '</div>';
            break;
            case 'library':
                $sup = $this->db->query("SELECT *, (SELECT name FROM ".DB_PREFIX."lib_struct WHERE parent_id = ".(int)$option['libraries'].") AS child, (SELECT l.smart FROM ".DB_PREFIX."libraries l WHERE l.library_id = ls.library_id) AS smart FROM ".DB_PREFIX."lib_struct ls WHERE ls.item_id = ".(int)$option['libraries']);
                    if((int)$sup->row['smart']){
                        if(!(int)$sup->row['isparent']){
                            $this->form[$option['field_type']].='<div class="form-group-sm col-md-4" link="'.$option['name'].'" id="'.$option['name'].'">'
                                    . '<label>'.$option['text'].'</label>'
                                    . '<input class="form-control" inp_type="smart" type="text" item="'.$option['libraries'].'">'
                                    . '<ul class="dropdown-menu" id="dropD" style="left: 15px; display: none;">'
                                      . '<li class="dropdown-header">Выберите значение</li>'
                                      . '<li class="devider"></li>'
                                      . '<div id="devList"></div>'
                                    . '</ul>'
                                    . '<input type="hidden" name="input-'.$option['name'].'" value=""/>'
                                  . '</div><div class="clearfix"></div>';
                        } else {
                            $this->form[$option['field_type']].='';                            
                        }
                    } else {
                        if($sup->row['parent_id']){
                            $this->form[$option['field_type']].='<div class="form-group-sm col-md-4" link="'.$option['name'].'" id="'.$option['name'].'">'
                                  . '</div>'.($sup->row['isparent']?'':'<div class="clearfix"></div>');
                        }else{
                            $fillsquer = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE item_id = ".(int)$option['libraries']." ORDER BY name ");
                            $this->form[$option['field_type']].='<div class="form-group-sm col-md-4" id="'.$option['name'].'">'
                                    . '<label>'.$option['text'].'</label>'
                                    . '<select class="form-control" name="input-'.$option['name'].'" select_type="librSelect" alert_triger="prompt" child="'.$sup->row['child'].'">'
                                    . '<option value="-">-</option>';
                            foreach ($fillsquer->rows as $fill) {
                                $this->form[$option['field_type']].='<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'">'.trim($fill['name']).'</option>';
                            }
                            $this->form[$option['field_type']].='</select></div>';
                        }
                    }
            break;
            case 'compability':
                $attrs.= $option['required']==='1'?' required="required" aria-required="true"':'';
                $attrs.= $option['unique_field']==='1'?' unique="unique" field="'.$option['name'].'"':'';
                $this->form[$option['field_type']].='<div class="form-group-sm col-md-12" link="'.$option['name'].'"><div class="row"><div class="col-lg-10">'
                        . '<label>'.$option['text'].($option['required']==='1'?'<span style="color: red;">*</span>':'').'</label>'
                        . '<input class="form-control" name="input-'.$option['name'].'" id="'.$option['name'].'" '.$attrs.' value="'.$option['def_val'].'"/>'
                    . '</div><div class="col-lg-1"><label>&nbsp;</label><br><a class="btn btn-success btn-sm rounded" btn_type="showToggle"><i class="fa fa-search"></i></a></div></div>';
                /***********************************************************/
                $this->form[$option['field_type']].= '<div class="alert alert-info" style="display: none;" id="cpbToggle">
                          <div class="" num="compability">';
                $sup = $this->db->query("SELECT *, (SELECT name FROM ".DB_PREFIX."lib_struct ls2 WHERE ls2.parent_id = ls1.item_id) AS child FROM ".DB_PREFIX."lib_struct ls1 WHERE library_id = ".(int)$option['libraries']);
                foreach ($sup->rows as $item) {
                    if($item['parent_id']){
                        $this->form[$option['field_type']].='<div class="col-lg-4" id="'.$item['name'].'"></div>';
                    } else {
                        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE item_id = ".(int)$item['item_id']." ORDER BY name");
                        $this->form[$option['field_type']].='<div class="col-lg-4" id="'.$item['name'].'"><label>'.$item['text'].'</label><select class="form-control" select_type="librSelect" alert_triger="prompt"  child="'.$item['child'].'">';
                        $this->form[$option['field_type']].= '<option value="-">-</option>';
                        foreach ($query->rows as $value) {
                            $this->form[$option['field_type']].= '<option value="'.$value['id'].'" prompt="'.$value['prompt'].'">'.$value['name'].'</option>';
                        }
                        $this->form[$option['field_type']].='</select></div>';
                    }
                }

                $this->form[$option['field_type']].= '</div>
                      <div class="modal-footer">
                        <p id="totalCpb"></p>
                        <button type="button" class="btn btn-primary btn-sm" btn_type="applyCpbAF">Применить</button>
                      </div>
                  </div>
                </div>';
                $this->form[$option['field_type']].= '</div>';
                
            break;
        }
    }
    
    public function getLibrChilds($parent, $fieldName){
        $result = array('js' => '', 'text' => '', 'fills' => array());
        if($parent!=='-'){
            $jsChilds = '';
            $tquery = $this->db->query("SELECT text FROM ".DB_PREFIX."lib_struct WHERE name = '".$fieldName."'");
            $text = $tquery->row['text'];
            $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = ".(int)$parent." ORDER BY name");
            if($sup->num_rows){
                //exit(var_dump($text));
                $cquery = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_struct WHERE parent_id = ".(int)$sup->row['item_id']);
                if($cquery->num_rows){
                    $jsChilds = 'select_type="librSelect" child="'.$cquery->row['name'].'"';
                }
                foreach ($sup->rows as $fill) {
                    $result['fills'][] = $fill;
                }
            }
            $par = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_struct WHERE item_id = (SELECT parent_id FROM ".DB_PREFIX."lib_struct WHERE name = '".$fieldName."') ");
            $result['text'] = isset($text)?$text:'';
            $result['js'] = $jsChilds;
            $result['item'] = isset($sup->row['item_id'])?$sup->row['item_id']:'';
            $result['parent_name'] = $par->row['name'];
        }
        return $result;
    }
    
    public function isUnique($search, $field){
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE ".$field." = '".$search."'");
        return $sup->num_rows;
    }
    
    public function createProduct($product) {
        $this->load->model('tool/complect');
        $this->load->model('tool/image');
        $invoiceItem = '';
        $prodItem = array();
        $prod2Lib = array();
        //"napolnenie" producta
        foreach ($this->systems as $key => $value) {
            $prodItem[$key] = $product[$key];
            $invoiceItem.= '<p class="col-lg-12"><b>'.$value['text'].'</b>: '.$product[$key].'</p>';
        }
        if((int)$product['price']){
            $prodItem['selfprice'] = $product['price']%2;
        }
        $struct = $this->model_tool_product->getProdTypeTemplate($product['type_id']);
        $name = $struct['temp'];
        $description = $struct['desctemp'];
        $tags = '';
        foreach ($struct['options'] as $option) {
            if(isset($product[$option['name']])){
                if($option['field_type']==='library' && $product[$option['name']]!=='-' && $product[$option['name']]!==''){
                    $sup = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_fills WHERE id = ".(int)$product[$option['name']]);
                    $prodItem[$option['name']] = trim($sup->row['name']);
//                    $invoiceItem.= '<p class="col-lg-6"><b>'.$option['text'].'</b>: '.trim($sup->row['name']).'</p>';
                    $prod2Lib[] = $product[$option['name']];
                    $name = str_replace('%'.$option['name'].'%', $sup->row['name'], $name);
                    $description = str_replace('%'.$option['name'].'%', $sup->row['name'], $description);
                    $tags.= $sup->row['name'].', ';
                } else {
                    $prodItem[$option['name']] = trim($product[$option['name']]);
                    if($product[$option['name']]!=='-'){
//                        $invoiceItem.= '<p class="col-lg-6"><b>'.$option['text'].'</b>: '.$product[$option['name']].'</p>';
                        $name = str_replace('%'.$option['name'].'%', $product[$option['name']], $name);
                        $description = str_replace('%'.$option['name'].'%', $product[$option['name']], $description);
                    } else {
                        $name = str_replace('%'.$option['name'].'%', '', $name);
                        $description = str_replace('%'.$option['name'].'%', '', $description);
                    }
                }
            }
        }
        $tags.= $name;
        $invoiceItem = '<h4>'.$name.'</h4>'.$invoiceItem;
        switch ($product['complecting']) {
            case 'set':
                $prodItem['comp'] = $product['heading'];
                break;
            case 'create':
                $prodItem['comp'] = $this->model_tool_complect->createComplect($product['vin'], $name);
                break;
        }
        $prodItem['youtube'] = '';
        if($product['youtube']!==''){
            $sup = strrchr($product['youtube'], "=");
            if($sup){
                $prodItem['youtube'] = str_replace("=", "", $sup);
            } else {
                $sup = explode("/", $product['youtube']);
                if(count($sup)>1){
                    $index = count($sup)-1;
                    $prodItem['youtube'] = $sup[$index];
                } else {
                    $prodItem['youtube'] = $sup[0];
                }                
            }
        }
        //------------------------------
        //add product to db
        $sql = "INSERT INTO ".DB_PREFIX."product SET ";
        foreach ($prodItem as $key => $value) {
            $sql.= $key." = '".htmlspecialchars(trim($value), ENT_QUOTES)."', ";
        }
        $sql.="date_added = NOW(), ";
        $sql.="date_modified = NOW(), ";
        $sql.="date_available = NOW(), ";
        $sql.="last_view = NOW(), ";
        $sql.="manager = '".$this->user->getId()."', ";
        $sql.="structure = '".$product['type_id']."' ";
        $this->db->query($sql);
        $sup = $this->db->query("SELECT MAX(product_id) AS pid FROM ".DB_PREFIX."product ");
        $product_id = $sup->row['pid'];
        //-------------------------------
        //linked product to libraries
        foreach ($prod2Lib as $libitem) {
            $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib SET  product_id = ".(int)$product_id.", fill_id = ".(int)$libitem);
        }
        //------------------------------------------
        //description to product
        $this->db->query("INSERT INTO ".DB_PREFIX."product_description "
                . "(`product_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_h1`, `meta_description`, `meta_keyword`) VALUES "
                . "(".(int)$product_id.", 1, '".$name."', '".$description."', '".$tags."', '".$name."', '".$name."', '".$name."', '".$tags."')");
        //link photos to product
        if(is_dir(DIR_IMAGE . "catalog/demo/production/".$product['vin']."/")){
            $dir = "catalog/demo/production/".$product['vin']."/";
            $photos = scandir(DIR_IMAGE . $dir);
            array_shift($photos);
            array_shift($photos);
            $i = 0;
            foreach ($photos as $key => $image) {
                $image = $dir.$image;
                if($key==0){
                    $invoiceItem = '<div class="col-lg-12"><img class="thumbanil center-block responsive" src="'.$this->model_tool_image->resize($image, 150, 150).'"></div>'.$invoiceItem;
                    $this->db->query("UPDATE ".DB_PREFIX."product SET image = '".$image."' WHERE product_id = ".(int)$product_id);
                }
                $this->db->query("INSERT INTO ".DB_PREFIX."product_image SET product_id = ".(int)$product_id.", image = '".$image."', sort_order = ".(int)$i);
                ++$i;
            }
        }
        //product history
        $this->db->query("INSERT INTO ".DB_PREFIX."product_history SET sku = '".$prodItem['vin']."', manager = '".$this->user->getId()."', date_added = NOW(), type_modify = 'Создание товара' ");            
        //product to store
        $this->db->query("INSERT INTO ".DB_PREFIX."product_to_store (product_id, store_id) VALUES (".(int)$product_id.", 0)");

        //complect settings
        if((int)$product['price'] && $this->model_tool_complect->isCompl($product['vin'])){
            $this->model_tool_complect->compReprice($product['vin']);
        }

        return '<div class="col-md-3" target="'.(int)$product_id.'"><div class="alert alert-success">'.$invoiceItem.'</div></div>';
        
    }
    
    public function createInv($list) {
    }
    
    public function saveProdList($prodlist, $photos) {
        $this->load->model('tool/product');
        $this->load->model('tool/complect');
        $photo = array();
        foreach ($prodlist as $num => $product){
            if(isset($photos['photo']['name'][$num])){
                $i = 0;
                foreach ($photos['photo']['name'][$num] as $name){
                    $photo[$num][$i]['name'] = $name;
                    ++$i;
                }
                $i = 0;
                foreach ($photos['photo']['type'][$num] as $name){
                    $photo[$num][$i]['type'] = $name;
                    ++$i;
                }
                $i = 0;
                foreach ($photos['photo']['error'][$num] as $name){
                    $photo[$num][$i]['error'] = $name;
                    ++$i;
                }
                $i = 0;
                foreach ($photos['photo']['tmp_name'][$num] as $name){
                    $photo[$num][$i]['tmp_name'] = $name;
                    ++$i;
                }
                $i = 0;
                foreach ($photos['photo']['size'][$num] as $name){
                    $photo[$num][$i]['size'] = $name;
                    ++$i;
                }
            }
        }
        foreach ($prodlist as $num => $product){
            $this->load->model('tool/complect');
            //upload photos
            if($photo[$num][0]['size']!='0'){
                $this->uploadPhoto($product['vin'], $photo[$num]);
            }
            $prodItem = array();
            $prod2Lib = array();
            //"napolnenie" producta
            foreach ($this->systemFields as $key => $value) {
                $prodItem[$key] = $product[$key];
            }
            $struct = $this->model_tool_product->getProdTypeTemplate($product['type_id']);
            $name = $struct['temp'];
            $description = $struct['desctemp'];
            $tags = '';
            foreach ($struct['options'] as $option) {
                if(isset($product[$option['name']])){
                    if($option['field_type']==='library' && $product[$option['name']]!=='-' && $product[$option['name']]!==''){
                        $sup = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_fills WHERE id = ".(int)$product[$option['name']]);
                        $prodItem[$option['name']] = trim($sup->row['name']);
                        $prod2Lib[] = $product[$option['name']];
                        $name = str_replace('%'.$option['name'].'%', $sup->row['name'], $name);
                        $description = str_replace('%'.$option['name'].'%', $sup->row['name'], $description);
                        $tags.= $sup->row['name'].', ';
                    } else {
                        $prodItem[$option['name']] = trim($product[$option['name']]);
                        if($product[$option['name']]!=='-'){
                            $name = str_replace('%'.$option['name'].'%', $product[$option['name']], $name);
                            $description = str_replace('%'.$option['name'].'%', $product[$option['name']], $description);
                        } else {
                            $name = str_replace('%'.$option['name'].'%', '', $name);
                            $description = str_replace('%'.$option['name'].'%', '', $description);
                        }
                    }
                }
            }
            $tags.= $name;
            switch ($product['complect']) {
                case 'set':
                    $prodItem['comp'] = $product['heading'];
                    break;
                case 'create':
                    $prodItem['comp'] = $this->model_tool_complect->createComplect($product['vin'], $name);
                    break;
            }
            $prodItem['youtube'] = '';
            if($product['youtube']!==''){
                $sup = strrchr($product['youtube'], "=");
                if($sup){
                    $prodItem['youtube'] = str_replace("=", "", $sup);
                } else {
                    $sup = explode("/", $product['youtube']);
                    if(count($sup)>1){
                        $index = count($sup)-1;
                        $prodItem['youtube'] = $sup[$index];
                    } else {
                        $prodItem['youtube'] = $sup[0];
                    }                
                }
            }
            //------------------------------
            //add product to db
            $sql = "INSERT INTO ".DB_PREFIX."product SET ";
            foreach ($prodItem as $key => $value) {
                $sql.= $key." = '".htmlspecialchars(trim($value), ENT_QUOTES)."', ";
            }
            $sql.="date_added = NOW(), ";
            $sql.="date_modified = NOW(), ";
            $sql.="date_available = NOW(), ";
            $sql.="last_view = NOW(), ";
            $sql.="manager = '".$this->user->getUserName()."', ";
            $sql.="structure = '".$product['type_id']."' ";
            $this->db->query($sql);
            $sup = $this->db->query("SELECT MAX(product_id) AS pid FROM ".DB_PREFIX."product ");
            $product_id = $sup->row['pid'];
            //-------------------------------
            //linked product to libraries
            foreach ($prod2Lib as $libitem) {
                $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib SET  product_id = ".(int)$product_id.", fill_id = ".(int)$libitem);
            }
            //------------------------------------------
            //description to product
            $this->db->query("INSERT INTO ".DB_PREFIX."product_description "
                    . "(`product_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_h1`, `meta_description`, `meta_keyword`) VALUES "
                    . "(".(int)$product_id.", 1, '".$name."', '".$description."', '".$tags."', '".$name."', '".$name."', '".$name."', '".$tags."')");
            //link photos to product
            if(is_dir(DIR_IMAGE . "catalog/demo/production/".$product['vin']."/")){
                $dir = "catalog/demo/production/".$product['vin']."/";
                $photos = scandir(DIR_IMAGE . $dir);
                array_shift($photos);
                array_shift($photos);
                $i = 0;
                foreach ($photos as $key => $image) {
                    $image = $dir.$image;
                    if($key==0){$this->db->query("UPDATE ".DB_PREFIX."product SET image = '".$image."' WHERE product_id = ".(int)$product_id);}
                    $this->db->query("INSERT INTO ".DB_PREFIX."product_image SET product_id = ".(int)$product_id.", image = '".$image."', sort_order = ".(int)$i);
                    ++$i;
                }
            }
            //product history
            $this->db->query("INSERT INTO ".DB_PREFIX."product_history SET sku = '".$prodItem['vin']."', manager = '".$this->user->getId()."', date_added = NOW(), type_modify = 'Создание товара' ");            
            //product to store
            $this->db->query("INSERT INTO ".DB_PREFIX."product_to_store (product_id, store_id) VALUES (".(int)$product_id.", 0)");
            
            //complect settings
            if((int)$product['price'] && $this->model_tool_complect->isCompl($product['vin'])){
                $this->model_tool_complect->compReprice($product['vin']);
            }
        }
        
    }
    
    public function uploadPhoto($vin, $photo) {
        $uploadtmpdir = DIR_IMAGE . "tmp/";
        $uploaddir = DIR_IMAGE . "catalog/demo/production/".$vin."/";
        if(!is_dir($uploaddir)){mkdir($uploaddir);}
        $optw = 1200;
        $name = 0;
        foreach ($photo as $file){
            if($file['size']!=='0'){
                //--------------//
                if ($file['type'] == 'image/jpeg'){
                    $source = imagecreatefromjpeg ($file['tmp_name']);
                } elseif ($file['type'] == 'image/png'){
                    $source = imagecreatefrompng ($file['tmp_name']);
                } elseif ($file['type'] == 'image/gif'){
                    $source = imagecreatefromgif ($file['tmp_name']);
                }
                else{
                    exit ('wtf, dude?!');
                }
               /*****************/

                $w_src = imagesx($source); 
                $h_src = imagesy($source);

                $ratio = $w_src/$optw;
                $w_dest = $optw;
                $h_dest = round($h_src/$ratio);

                $dest = imagecreatetruecolor($optw, $h_dest);

                imagecopyresampled($dest, $source, 0, 0, 0, 0, $optw, $h_dest, $w_src, $h_src);



                imagejpeg($dest, $uploadtmpdir . $file['name'], 90);
                imagedestroy($dest);
                imagedestroy($source);

                copy($uploadtmpdir . $file['name'], $uploaddir .$vin.'-'. $name . '.jpg');

                unlink($uploadtmpdir . $file['name']);

                $name++;
            }
        }
    }
    
    public function constructEditForm($info) {
        $selects = '';
        $libraries = '';
        $inputs = '';
        $compabils = '';
        $systemF = '<div class="col-lg-12"><div class="pull-left" style="margin-bottom: 0px; margin-top: 10px;"><input type="submit" class="btn btn-success" value="сохранить изменения" /></div></div>'
                    . '<div class="clearfix"></div>'
                    .'<hr>';
        $modal = '';
        $hiddens = '<input type="hidden" name="manager" value="'.$info['manager'].'" />'; 
        $lib_links = $this->getLinksArr($this->request->get['product_id']);
//        exit(var_dump($info));
//        exit(var_dump(!array_key_exists('vin', $this->systemFields)));
        $systemF.= '<div class="form-group-sm col-md-6">'
                    . '<label>Внутренний номер:</label>'
                    . '<input class="form-control" name="info[vin]" disabled unique="unique" field="vin" value="'.$info['vin'].'"/>'
                 . '</div>';
        $systemF.= '<div class="form-group-sm col-md-6">'
                    . '<label>YouTube(только код видео!):</label>'
                    . '<input class="form-control" name="info[youtube]" field="youtube" value="'.$info['youtube'].'"/>'
                 . '</div>';
        foreach ($this->systemFields as $key => $field) {
            if($key!=='vin' && $key!=='youtube'){
                $systemF.= '<div class="form-group-sm editForm col-md-3">'
                            . '<div class = "row paddingrow"><label>'.$field.'</label></div>'
                            . '<input class="form-control" name="info['.$key.']" value="'.$info[$key].'"/>'
                         . '</div>';
            }
        }
        $systemF.= '<div class="form-group-sm editForm col-md-3">'
                . '<div class = "row paddingrow"><label>Статус</label></div>'
                . '<select class="form-control" name="info[status]">'
                    . '<option value="1">Включено</option>'
                    . '<option value="2" '.($info['status']=='2'?'selected':'').'>В резерве</option>'
                    . '<option value="0" '.($info['status']=='0'?'selected':'').'>Отключено</option>'
                . '</select></div><div class="col-lg-12"></div>';
        if($info['youtube']!==''){
            $systemF.= '<div class="form-group-sm col-md-9">'
                    . '<label>https://youtu.be/'.$info['youtube'].'</label>'
                 . '</div>';            
        }
        foreach ($info as $key => $option) {
            if(!array_key_exists($key, $this->systemFields) && !in_array($key, $this->ignoreFields)){
                switch ($option['field_type']) {
                    case 'input':
                        $inputs.= '<div class="col-md-12 form-group-sm editForm">'
                                    . '<div class = "row paddingrow"><label>'.$option['text'].'</label></div>'
                                    . '<input class="form-control" name="info['.$key.']" '.($option['required']=='1'?'required="required':'').' value="'.htmlspecialchars_decode($option['value']).'">'
                                . '</div>';
                    break;
                    case 'select':
                        $selects.= '<div class="col-md-4 form-group-sm editForm">'
                                    . '<div class = "row paddingrow"><label>'.$option['text'].'</label></div>'
                                    . '<select class="form-control" name="info['.$key.']">'
                                        . '<option value="-">-</option>';
                            $vals = explode(";", $option['vals']);
                            foreach ($vals as $val) {
                                $selects.= '<option value="'.trim($val).'" '.(trim($val)===$option['value']?'selected':'').'>'.trim($val).'</option>';
                            }
                        $selects.= '</select></div>';
                    break;
                    case 'library':
                        if(isset($lib_links[$option['library']])){
                            $supfills = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = ".(int)$lib_links[$option['library']]['parent']." AND item_id = ".(int)$option['library']." ORDER BY name");
                        } else {
                            $supfills = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE item_id = ".(int)$option['library']." ORDER BY name");
                        }
                        $supitem = $this->db->query("SELECT *, "
                                . "(SELECT name FROM ".DB_PREFIX."lib_struct WHERE parent_id = ".(int)$option['library'].") AS child, "
                                . "(SELECT name FROM ".DB_PREFIX."lib_struct ls1 WHERE ls1.item_id = ls.parent_id) AS parent "
                                . "FROM ".DB_PREFIX."lib_struct ls WHERE item_id = ".(int)$option['library']);
                        if($supitem->row['isparent']==='1'){
                            $dop = 'select_type="librSelect" child="'.$supitem->row['child'].'"';
                            $endrow='';
                        } else{$dop = ''; $endrow = '<div class="col-lg-12"></div>';}
                        $libraries.= '<div class="col-md-4 form-group-sm editForm" id="'.$key.'">'                  
                                    . '<div class = "row paddingrow">' 
                                    . '<label> '.$option['text'].' </label><div class ="floatright"><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#createFillModal" parent="'.($supitem->row['parent']==''?'0':$supitem->row['parent']).'" btn_type="createFill"><i class="fa fa-plus"></i></a><a class="btn btn-info btn-sm" btn_type="changeFillprod" type="button" data-toggle="modal" fill="" data-target="#settingsLevel" btn_type="levelSettings"><i class="fa fa-pencil"></i></a></div>'
                                    . '</div>'
                                    . '<select class="form-control" name="info['.$key.']" '.$dop.'>'
                                        . '<option value="">-</option>';
                        foreach($supfills->rows as $fill){
                            $libraries.= '<option value="'.$fill['id'].'" '.($fill['name']===$option['value']?'selected':'').'>'.$fill['name'].'</option>';
                        }
                        $libraries.= '</select></div>'.$endrow;
                    break;
                    case 'compability':
                        $compabils.= '<div class="col-lg-12 form-group-sm editForm">'
                                        . '<div class="col-md-10">'
                                            . '<div class = "row paddingrow"><label>'.$option['text'].($option['required']=='1'?'<span style="color: red;">*</span>':'').'</label></div>'
                                            . '<input class="form-control" name="info['.$key.']" id="'.$key.'0" '.($option['required']=='1'?'required="required':'').' value="'.$option['value'].'"></div>'
                                        . '<div class="col-md-1">'
                                            . '<label>&nbsp;</label><br><a class="btn btn-success" btn_type="compability" data-toggle="modal" data-target="#'.$key.'"><i class="fa fa-search"></i></a>'
                                        . '</div>'
                                   . '</div>';
                        $modal.= '<div class="modal fade" id="'.$key.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">'.$option['description'].'</h4>
                              </div>
                              <div class="modal-body"><div class="row" num="compability">';
                                $sup = $this->db->query("SELECT *, (SELECT name FROM ".DB_PREFIX."lib_struct ls2 WHERE ls2.parent_id = ls1.item_id) AS child FROM ".DB_PREFIX."lib_struct ls1 WHERE library_id = ".(int)$option['library']);
                                foreach ($sup->rows as $item) {
                                    if($item['parent_id']){
                                        $modal.='<div class="col-lg-4" id="'.$item['name'].'"></div>';
                                    } else {
                                        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE item_id = ".(int)$item['item_id']);
                                        $modal.='<div class="col-lg-4" id="'.$item['name'].'"><label>'.$item['text'].'</label><select class="form-control" select_type="librSelect" child="'.$item['child'].'">';
                                        $modal.= '<option value="-">-</option>';
                                        foreach ($query->rows as $value) {
                                            $modal.= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                        }
                                        $modal.='</select></div>';
                                    }
                                }
                        $modal.= '</div></div>
                              <div class="modal-footer">
                                <p id="totalCpb" cpb></p>
                                <div class="col-lg-12"><hr></div>
                                <button type="button" class="btn btn-primary" cpbfield_id="0" cpbfield_name="'.$key.'" btn_type="applyCpb">Применить</button>
                              </div>
                            </div>
                          </div>
                        </div>';
                    break;
                }
            }
        }
        return '<div class="well well-sm" num="prod-edit">'.$systemF.'<div class="clearfix"></div><hr>'.$libraries.$selects.'<div class="clearfix"></div><hr>'.$inputs.'<div class="clearfix"></div><hr>'.$compabils.$hiddens.'<div class="clearfix"></div><div class="clearfix"></div></div>'.$modal;
    }
    
    public function updateProduct($info, $id) {
        //exit(var_dump($info));
        $this->load->model('tool/product');
        $this->load->model('tool/complect');
        $links = array();
        $vin = $this->db->query("SELECT vin FROM ".DB_PREFIX."product WHERE product_id = ".(int)$id);
        $sup = $this->db->query("SELECT temp, desctemp FROM ".DB_PREFIX."product_type WHERE type_id = (SELECT structure FROM ".DB_PREFIX."product WHERE product_id = ".(int)$id.")");
        $name = $sup->row['temp'];
        $description = $sup->row['desctemp'];
        $sql = "UPDATE ".DB_PREFIX."product SET ";
        foreach ($info['options'] as $key => $value) {
            $val = '';
            if($value['value']=='-' || $value['value']==''){
                $name = str_replace('%'.$key.'%', '', $name);
                $description = str_replace('%'.$key.'%', '', $description);
            }
            if($value['field_type']=='library' && ($value['value']!=='-' || $value['value']!=='')){
                $quer = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_fills WHERE id = ".(int)$value['value']);
                if($quer->num_rows){
                    $links[] = $value['value'];
                    $val = $quer->row['name'];
                }
                $sql.= $key." = '".$val."', ";
                $name = str_replace('%'.$key.'%', $val, $name);
                $description = str_replace('%'.$key.'%', $val, $description);
            } elseif ($value['field_type']!=='library' && ($value['value']!=='-' || $value['value']!=='')) {
                $sql.= $key." = '".$value['value']."', ";
                $name = str_replace('%'.$key.'%', $value['value'], $name);
                $description = str_replace('%'.$key.'%', $value['value'], $description);
            }
        }
        if(isset($info['description'])){
            $description = htmlspecialchars_decode($info['description']);
        }
        $sql.= "date_modified = NOW() "
                . "WHERE product_id = ".(int)$id;
        $this->db->query($sql);
        $this->db->query("UPDATE ".DB_PREFIX."product_description SET name = '".$name."', meta_h1 = '".$name."', meta_title = '".$name."', description = '".$description."' WHERE product_id=".(int)$id);
        $this->db->query("DELETE FROM ".DB_PREFIX."product_image WHERE product_id = ".(int)$id);
        if(is_array($info['image'])){
            foreach($info['image'] as $image){
                $this->db->query("INSERT INTO ".DB_PREFIX."product_image SET product_id = ".(int)$id.", image = '".$image['img']."', sort_order = '".(isset($image['sort_order'])?$image['sort_order']:'0')."'");
            }
        }
        $this->db->query("DELETE FROM ".DB_PREFIX."product_to_lib WHERE product_id = ".(int)$id);
        foreach($links as $link){
            $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib SET product_id = ".(int)$id.", fill_id = ".(int)$link." ");
        }
        $this->db->query("INSERT INTO ".DB_PREFIX."product_history SET sku = '".$vin->row['vin']."', manager = '".$this->user->getId()."', date_modify = NOW(), type_modify = 'Обновление товара' ");
        $this->model_tool_complect->repriceById($id);        
    }
    
    public function createFill($parent, $name) {
        $sql = $this->db->query("SELECT item_id, library_id FROM ".DB_PREFIX."lib_struct WHERE parent_id = (SELECT item_id FROM ".DB_PREFIX."lib_fills WHERE id=".(int)$parent.") GROUP BY item_id");
        $this->db->query("INSERT INTO ".DB_PREFIX."lib_fills SET name = '".$name."', item_id=".(int)$sql->row['item_id'].", parent_id=".(int)$parent.", library_id = ".(int)$sql->row['library_id']." ");
        //exit("INSERT INTO ".DB_PREFIX."lib_fills SET name = '".$name."', item_id=".(int)$sql->row['item_id'].", parent_id=".(int)$parent.", library_id = ".(int)$sql->row['library_id']." ");
    }
    
    public function getLinksArr($id) {
        $result = array();
        $sup = $this->db->query("SELECT *, lf.name AS value, lf.parent_id AS value_parent FROM ".DB_PREFIX."product_to_lib p2l "
                . "LEFT JOIN ".DB_PREFIX."lib_fills lf ON p2l.fill_id = lf.id "
                . "LEFT JOIN ".DB_PREFIX."lib_struct ls ON lf.item_id = ls.item_id "
                . "WHERE p2l.product_id = ".(int)$id);
        foreach($sup->rows as $row){
            $result[$row['item_id']] = array(
                'id'    => $row['id'],
                'name' => $row['value'],
                'parent' => $row['value_parent']
            );
//            foreach ($row as $key => $value) {
//                echo $key.' - '.$value.'<br>';
//            }
//            echo '<hr>';
        }
//        exit(var_dump($result));
        return $result;
    }
}

