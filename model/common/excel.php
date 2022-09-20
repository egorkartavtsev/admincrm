<?php
    class ModelCommonExcel extends Model {
        
        public function getTypes() {
            $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."product_type ");
            return $sup->rows;
        }
        
        public function getProductTemplate() {
            $query = $this->db->query("SELECT * FROM ".DB_PREFIX."type_lib WHERE type_id = 1 and excel != 0 ORDER BY excel");
            $template = array();
            $template[1] = array(
                'name' => 'vin',
                'text' => 'Внутренний номер',
                'important' => 1,
                'system' => 1
            );
            $template[2] = array(
                'name' => 'price',
                'text' => 'Цена',
                'important' => 1,
                'system' => 1
            );
            $template[3] = array(
                'name' => 'quantity',
                'text' => 'Кол-во',
                'important' => 1,
                'system' => 1
            );
            $i = 3;
            foreach ($query->rows as $row) {
                $template[$row['excel']+3] = array(
                    'name' => trim($row['name']),
                    'text' => trim($row['text']),
                    'important' => trim($row['required']),
                    'system' => trim($row['required'])
                );
                ++$i;
            }
            ++$i;
            $template[$i] = array(
                'name' => 'comp',
                'text' => 'Комплект',
                'important' => 0,
                'system' => 0
            );
            $template[$i+1] = array(
                'name' => 'comp_price',
                'text' => 'Цена комплекта',
                'important' => 0,
                'system' => 0
            );
            $template[$i+2] = array(
                'name' => 'comp_whole',
                'text' => 'Способ продажи',
                'important' => 0,
                'system' => 0
            );
            $template[$i+3] = array(
                'name' => 'date_added',
                'text' => 'Дата создания',
                'important' => 1,
                'system' => 1
            );
            
            return $template;
        }
        
        public function getdescripttemplate(){
            $query = $this->db->query("SELECT desctemp FROM ".DB_PREFIX."product_type WHERE type_id = 1 ");
            return $query->row['desctemp'];
        }
        
        public function constructDescription($template, $product){
            
            $this->load->controller('common/desctemp');
            $descT = new ControllerCommonDescTemp($this->registry);
            $regex = $descT->regex;
            foreach ($regex as $key => $ex) {
                $template = str_replace($ex, $product[$key], $template);
            }
            return $template;
        }
        
        public function getListProds($quer=0) {
            $cell = $quer===0?'vin':$quer;
            $query = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE vin != '' ");
            $results = array();
            foreach ($query->rows as $row) {
                $results[] = $row[$cell];
            }
            return $results;
        }
        
        public function getbrands() {
            $query = $this->db->query("SELECT name FROM ".DB_PREFIX."brand WHERE 1 ");
            $brands = array();
            foreach ($query->rows as $row) {
                $brands[] = mb_convert_case(trim($row['name']), MB_CASE_UPPER);
            }
            return $brands;
        }
        
        public function getcategories() {
            $query = $this->db->query("SELECT name FROM ".DB_PREFIX."category_description WHERE 1 ");
            $cats = array();
            foreach ($query->rows as $row) {
                $cats[] = mb_convert_case(trim($row['name']), MB_CASE_UPPER);
            }
            return $cats;
        }
        
        public function setToDB($data, $vin, $description, $images, $comp, $manager) {
//            exit(var_dump(strtoupper($data['brand'])));
            $quer = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE vin = '".$vin."' ");
            if(empty($quer->rows)){
            /* в этом блоке объединяем некоторые разрозненные данные по товару в переменные */
                $name = $data['podcateg'] . " ". $data['brand'] ." ". $data['modR'];
                $tag = $data['brand'].', '.$data['model'].', '.$data['modR'].', '.$data['podcateg'].', '.$name.', '.$data['catn'];
                foreach ($data as $key => $value) {
                    $description = str_replace('%'.$key.'%', $value, $description);
                }
                $brand = strtoupper($data['brand']);
                $price = $data['price']!==NULL?$data['price']:0;
                $quantity = $data['quantity']!=NULL?$data['quantity']:0;
                $date = $data['date_added']!=''?"'".$data['date_added']."'":"NOW()";
                $query = $this->db->query("SELECT id FROM ".DB_PREFIX."lib_fills WHERE name = '".$brand."' ");
                $brand_id = $query->row['id'];
                
                $query = $this->db->query("SELECT id FROM ".DB_PREFIX."lib_fills WHERE name = '".$data['model']."' ");
                $mod_id = $query->row['id'];
                
                $query = $this->db->query("SELECT id FROM ".DB_PREFIX."lib_fills WHERE name = '".$data['modR']."' ");
                $modr_id = $query->row['id'];
                
                $query = $this->db->query("SELECT id FROM ".DB_PREFIX."lib_fills WHERE name = '".$data['category']."' ");
                $cat_id = $query->row['id'];
                
                $query = $this->db->query("SELECT id FROM ".DB_PREFIX."lib_fills WHERE name = '".$data['podcateg']."' ");
                $podcat_id = $query->row['id'];
                
                $image = ((is_array($images)) && (!empty($images)))?'catalog/demo/production/'.$vin.'/'.$images[0]:' ';
                $comp_price = $data['comp_price']!=NULL?$data['comp_price']:'';
                $complect = '';
                $comp_whole = $data['comp_whole']!=NULL?1:'';
                $donor = $data['numb']!=NULL?$data['numb']:'';
            /*******************************************************************************/
            /******************** блок работы с комплектами ********************************/
                if($data['comp_price']!==''){
                    $whole = $data['comp_whole']!==''?1:0;
                    $heading = $vin;
                    $c_price = $data['comp_price'];
                    $this->load->model('complect/complect');
                    $this->model_complect_complect->create($name, $c_price, $heading, 0, $whole);
                    $query = $this->db->query("SELECT id FROM ".DB_PREFIX."complects WHERE heading = '".$heading."' ");
                    $comp_id = $query->row['id'];
                    $complect = "`comp` = '".$comp_id."', ";
                } elseif ($data['comp']!=='') {
                    $complect = ", `comp` = '".$data['comp']."', ";
                } else {
                    $complect = "";
                }
                $status = $quantity!=0?1:0;
            /******************************************************************************/
            /******* окончательно сформированный товар укладываем в базу потаблично *******/
                $query = "INSERT INTO ".DB_PREFIX."product "
                        . "SET "
                            . "`structure` = 1, "
                            . "`brand` = '". $data['brand'] ."', "
                            . "`model` = '". $data['model'] ."', "
                            . "`category` = '". $data['category'] ."', "
                            . "`podcateg` = '". $data['podcateg'] ."', "
                            . "`note` = '". $data['note'] ."', "
                            . "`vin` = '". $vin ."', "
                            . "`cond` = '". $data['cond'] ."', "
                            . "`numb` = '". $donor ."', "
                            . "`type` = '". $data['type'] ."', "
                            //. "`location` = '".$data['stell']."/".$data['jar']."/".$data['shelf']."/".$data['box']."', "
                            . "`adress` = '". $data['adress'] ."', "
                            . "`stock` = '". $data['stock'] ."', "
                            . "`stell` = '".$data['stell']."', "
                            . "`jar` = '".$data['jar']."', "
                            . "`shelf` = '".$data['shelf']."', "
                            . "`box` = '".$data['box']."', "
                            . "`catn` = '". $data['catn'] ."', "
                            . "`price` = ". $price .", "
                            . "`image` = '". $image ."', "
                            . "`quantity` = ".$quantity.", "
                            . "`comp_price` = '".$comp_price."', "
                            . "`comp_whole` = '".$comp_whole."', "
                            . "`manager` = '".$manager."', "
                            . "`modR` = '".$data['modR']."', "
                            ."`status` = ".(int)$status.", "
                            ."`date_added` = ".$date.", "
                            ."`date_available` = NOW(), "
                            ."`date_modified` = NOW(), "
                            . "avito = '".$data['avito']."', "
                            . "drom = '".$data['drom']."' "
                            .$complect. " ";
//                    exit($query);
                $this->db->query($query);
                $product_id = $this->db->getLastId();
                
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_description "
                            . "SET "
                            . "product_id = '" . (int)$product_id . "', "
                            . "language_id = 1, "
                            . "name = '" . $name ."', "
                            . "description = '".$description."', "
                            . "tag =  '".$tag."', "
                            . "meta_title = '" . $name . "', "
                            . "meta_h1 = '" . $name . "', "
                            . "meta_description = '" . $description . "', "
                            . "meta_keyword = '" . $tag . "'");
                
                $this->db->query("INSERT INTO ". DB_PREFIX ."product_to_store "
                    . "SET "
                    . "product_id = '".(int)$product_id."',"
                    . "store_id = 0");
                
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_lib "
                                . "SET "
                                . "product_id = '" . (int)$product_id . "', "
                                . "fill_id = '" . (int)$cat_id . "' ");

                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_lib "
                                . "SET "
                                . "product_id = '" . (int)$product_id . "', "
                                . "fill_id = '" . (int)$podcat_id . "'");

                $this->db->query("INSERT INTO ". DB_PREFIX ."url_alias "
                                . "SET "
                                . "query = 'product_id=".(int)$product_id."'");
                
                $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib "
                                . "SET "
                                . "product_id = ". $product_id .", "
                                . "fill_id = ".$brand_id);
                
                $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib "
                                . "SET "
                                . "product_id = ". $product_id .", "
                                . "fill_id = ".$mod_id);
                
                $this->db->query("INSERT INTO ".DB_PREFIX."product_to_lib "
                                . "SET "
                                . "product_id = ". $product_id .", "
                                . "fill_id = ".$modr_id);
                
                if((!empty($images))){
                    foreach ($images as $file){
                        if($file!=' '){
                            $this->db->query("INSERT INTO ". DB_PREFIX ."product_image "
                                . "SET "
                                . "product_id = ". $product_id .", "
                                . "image = 'catalog/demo/production/".$vin."/".$file."' ");
                        }
                    }
                }
                
                if(!empty($comp)){
                    foreach ($comp as $modR){
                        $this->db->query("INSERT INTO ".DB_PREFIX."product_to_brand "
                            . "SET "
                            . "product_id = ". $product_id .", "
                            . "brand_id = ".$modR['id']."; ");
                    }
                }
            /******************************************************************************/ 
            }   
        }
        
        public function synchToDB($data) {
            $this->db->query("UPDATE ".DB_PREFIX."product "
                . "SET quantity = ".$data['quant'].", "
                    . "status = 0, "
					. "price = ".$data['price'].", "
					. "image = '' "
                . "WHERE vin = '".$data['vnutn']."';");
            $dir = DIR_IMAGE."catalog/demo/production/".$data['vnutn']."/";
            $this->removeDirectory($dir);
            
            $prod = $this->db->query("SELECT product_id FROM ".DB_PREFIX."product WHERE vin = '".$data['vnutn']."'");
            $prod_id = $prod->row['product_id'];

            $this->db->query("DELETE FROM ".DB_PREFIX."product_image "
                    . "WHERE product_id = '".$prod_id."'");
        }
        
        public function removeDirectory($dir) {
            if(is_dir($dir)){
                $objs = scandir($dir);
                array_shift($objs);
                array_shift($objs);

                foreach($objs as $obj) {
                    $objct = $dir;
                    $objct.= $obj;
					unlink($objct);
                }
                rmdir($dir);
            }
        }
        
        public function updateToDB($data) {
            $status = $data['quant']!=0?1:0;
            $this->db->query("UPDATE ".DB_PREFIX."product "
                . "SET "
                    . "cond = '".$data['condit']."', "
                    . "type = '".$data['type']."', "
                    . "quantity = '".$data['quant']."', "
                    . "note = '".$data['note']."', "
                    . "catn = '".$data['catn']."', "
                    . "stock = '".$data['stock']."', "
                    . "location = '".$data['still']."/".$data['jar']."/".$data['shelf']."/".$data['box']."', "
                    . "`stell` = '".$data['still']."', "
                    . "`jar` = '".$data['jar']."', "
                    . "`shelf` = '".$data['shelf']."', "
                    . "`box` = '".$data['box']."', "
                    . "price = '".$data['price']."', "
                    . "status = '".$status."', "
                    . "comp = '".$data['complect']."', "
                    . "drom = '".$data['drom']."', "
                    . "avito = '".$data['avito']."' "
                . "WHERE vin = '".$data['vnutn']."';");
        }
        
        public function haveImg($id) {
            $query = $this->db->query("SELECT * FROM ".DB_PREFIX."product_image WHERE product_id = ".(int)$id);
            $result = !empty($query->row)?TRUE:FALSE;
            return $result;
        }
        
        public function setImg($id, $dir) {
            $files = scandir(DIR_IMAGE.$dir);
            array_shift($files);
            array_shift($files);
            
            foreach($files as $image){
                if($image!='Thumbs.db'){
                    $this->db->query("INSERT INTO ".DB_PREFIX."product_image "
                            . "SET "
                            . "product_id = ".(int)$id.", "
                            . "image = '".$dir.$image."' ");
                    $this->db->query("UPDATE ".DB_PREFIX."product "
                            . "SET "
                            . "image = '".$dir.$files[0]."' "
                            . "WHERE product_id = ".(int)$id);
                }
            }
        }
        
        public function getParam($param, $id){
            $table = $param; 
            $field = 'id';
            if($param == 'category'){
                $table = $param.'_description';
                $field = $param.'_id';
            }
            $query = $this->db->query("SELECT name FROM ".DB_PREFIX.$table." WHERE ".$field." = ".(int)$id);
            return $query->row['name'];
        }
        
        public function searchingProds($request) {
            $reqwords = explode(" ", $request);
            
            $query = "SELECT pd.name AS name, p.vin AS vin FROM ".DB_PREFIX."product_description pd "
                        . "LEFT JOIN ".DB_PREFIX."product p "
                            . "ON pd.product_id = p.product_id "
                        . "WHERE 1 ";
            foreach ($reqwords as $word){
                $query.="AND LOCATE ('" . $this->db->escape($word) . "', pd.name) ";
            }
            $result = $this->db->query($query);
            return $result->rows;
        }
        
        public function constructQuery($filter) {
            $this->load->model('tool/product');
            $template = $this->model_tool_product->getExcelTempl($filter['type']);
//            exit(var_dump($filter));
//            exit(var_dump($template));
            
            $query = "SELECT ";
            foreach ($template as $key => $value) {
                $query.="p.".$key." AS ".$key.", ";
            }
            $query.= "pd.name AS name "
                    . "FROM ".DB_PREFIX."product p "
                    . "LEFT JOIN ".DB_PREFIX."product_description pd ON p.product_id = pd.product_id "
                    . "WHERE !LOCATE('complect', p.vin) ";
            $query.=$filter['manager'];
            if($filter){
                if($filter['prod_on']){
                    if(!$filter['prod_off']){
                        $query.="AND p.quantity >= 1 ";
                    } else {
                        $query.="AND p.quantity >= 0 ";
                    }
                } else {
                    if($filter['prod_off']){
                        $query.="AND p.quantity = '0' ";
                    }
                }
                if($filter['stock']){
                    $query.="AND (0 ";
                    foreach ($filter['stock'] as $stock => $value) {
                        $query.="OR p.stock = '".$stock."' ";
                    }
                    $query.=") ";
                }
                if($filter['date_start']){
                    $query.="AND p.date_added >= '".$filter['date_start']."' ";
                }
                if($filter['date_end']){
                    $query.="AND p.date_added <= '".$filter['date_end']."' ";
                }
            }
            $query.="AND structure = ".(int)$filter['type']." ORDER BY p.date_added DESC";
            //exit($query);
            return $query;
        }


        public function getInfoProducts($filter) {
            $query = $this->constructQuery($filter);
            $products = $this->db->query($query);
            return $products->rows;
        }
    }