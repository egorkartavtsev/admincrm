<?php

class ControllerToolFormTool extends Controller {
    public function libraryFields() {
        //exit(var_dump($this->request->post));
        $this->load->model('tool/forms');
        $result = '';
        $parent = $this->request->post['parent'];
        $fieldName = $this->request->post['parentName'];
        $num = $this->request->post['num'];
        $child = $this->model_tool_forms->getLibrChilds($parent, $fieldName);
        if($parent!=='-'){
            if($num==='compability'){
                if($child['js']!==''){
                    $result.= '<label>'.$child['text'].'</label>';
                    $result.= '<select class="form-control" '.$child['js'].'>';
                    $result.= '<option value="-">-</option>';
                    foreach ($child['fills'] as $fill) {
                        $result.= '<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'">'.$fill['name'].'</option>';
                    }
                    $result.= '</select>';
                } else {
                    $result.= '<label>'.$child['text'].'</label>';
                    $result.='<br>';
                    foreach ($child['fills'] as $fill) {
                        $result.= '<span class="label label-success cpbItem" span_type="cpbItem">'.$fill['name'].'</span> ';
                    }
                }
            } elseif($num === 'prod-edit') {
                $result.= '<div class = "row paddingrow"><label> '.$child['text'].' </label><div class ="floatright"><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#createFillModal" parent="'.$child['parent_name'].'" btn_type="createFill"><i class="fa fa-plus"></i></a><a class="btn btn-info btn-sm" btn_type="changeFillprod" type="button" data-toggle="modal" fill="" data-target="#settingsLevel" btn_type="levelSettings"><i class="fa fa-pencil"></i></a></div></div>';
                $result.= '<select class="form-control" alert_triger="prompt" name = "info['.$fieldName.']" '.$child['js'].'>';
                $result.= '<option value="-">-</option>';
                foreach ($child['fills'] as $fill) {
                    $result.= '<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'" >'.$fill['name'].'</option>';
                }
                $result.= '</select>';
            } elseif($num === 'createauto') {
                $result.= '<label>'.$child['text'].'</label> ';
                $result.= '<select class="form-control" alert_triger="prompt"  id = "select-'.$fieldName.'" '.$child['js'].'>';
                $result.= '<option value="-">-</option>';
                foreach ($child['fills'] as $fill) {
                    $result.= '<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'">'.$fill['name'].'</option>';
                }
                $result.= '</select>';
            } elseif($num === 'createdonor') {
                $result.= '<label>'.$child['text'].'</label> ';
                $result.= '<select class="form-control"  alert_triger="prompt" name = "'.$fieldName.'_id" '.$child['js'].'>';
                $result.= '<option value="-">-</option>';
                foreach ($child['fills'] as $fill) {
                    $result.= '<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'">'.$fill['name'].'</option>';
                }
                $result.= '</select>';
            } else {
                if($num === 'no-num'){
                    $result.= '<label>'.$child['text'].'</label>';
                    $result.= '<select class="form-control" alert_triger="prompt" name = "info['.$fieldName.']" '.$child['js'].'>';
                } elseif($num==='undefined') {
                    //$result.= '<div class = "row paddingrow"><label> '.$child['text'].' </label><div class ="floatright"><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#createFillModal" parent="'.$child['parent_name'].'" btn_type="createFill"><i class="fa fa-plus"></i></a><a class="btn btn-info btn-sm" btn_type="changeFillprod" type="button" data-toggle="modal" fill="" data-target="#settingsLevel" btn_type="levelSettings"><i class="fa fa-pencil"></i></a></div></div>';
                    $result.= '<label>'.$child['text'].'</label>';
                    $result.= '<select class="form-control" alert_triger="prompt" name = "input-'.$fieldName.'" '.$child['js'].'>';
                } else {
                    $result.= '<div class = "row paddingrow"><label> '.$child['text'].' </label><div class ="floatright"><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#createFillModal" parent="'.$child['parent_name'].'" btn_type="createFill"><i class="fa fa-plus"></i></a><a class="btn btn-info btn-sm" btn_type="changeFillprod" type="button" data-toggle="modal" fill="" data-target="#settingsLevel" btn_type="levelSettings"><i class="fa fa-pencil"></i></a></div></div>';
                    $result.= '<select class="form-control" alert_triger="prompt" name = "info['.$num.']['.$fieldName.']" '.$child['js'].'>';                   
                }
                $result.= '<option value="-">-</option>';
                foreach ($child['fills'] as $fill) {
                    $result.= '<option value="'.$fill['id'].'" prompt="'.$fill['prompt'].'">'.$fill['name'].'</option>';
                }
                $result.= '</select>';
            }    
        }
        echo $result;
    }
    
    public function takeAddedFrom(){
        $this->load->model('tool/forms');
        $this->load->model('tool/product');
        $tmp = $this->request->post['data'];
        $form = [];
        foreach ($tmp as $field) {
            $form[str_replace('input-', '', $field['name'])] = $field['value'];
        }
        
        echo $this->model_tool_forms->createProduct($form);
    }
    
    public function createInvoice() {
        $tmp = explode(";", $this->request->post['data']);
        $this->load->model('tool/forms');
        $this->model_tool_forms->createInv($tmp);
    }
    
    public function takePhotos() {
        foreach ($this->request->files as $key => $file) {
            $tmp = explode("::", $key);
            $vin = $tmp[1];
            $name = $tmp[0];
            $uploadtmpdir = DIR_IMAGE . "tmp/";
            $uploaddir = DIR_IMAGE . "catalog/demo/production/".$vin."/";
            if(!is_dir($uploaddir)){mkdir($uploaddir);}
            $optw = 1200;
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
                    exit (false);
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
            }
        }
        echo var_dump($this->request->files);
    }
    
    public function isUnique() {
        $search = $this->request->post['search'];
        $field = $this->request->post['field'];
        $this->load->model('tool/forms');
        $result = $this->model_tool_forms->isUnique($search, $field);
        echo ($result?'false':'true');
    }
    
    public function isComplect() {
        $heading = $this->request->post['heading'];
        $this->load->model('tool/complect');
        echo $this->model_tool_complect->isHeading($heading);
    }
    public function createFill() {
        $parent = $this->request->post['parent'];
        $name = $this->request->post['name'];
        $item_name = $this->request->post['item'];
        $item_id = $this->db->query("SELECT item_id FROM ".DB_PREFIX."lib_struct WHERE name = '".$item_name."'")->row['item_id'];
        $check = $this->db->query("SELECT name FROM ".DB_PREFIX."lib_fills WHERE name = '".$name."' AND item_id = '".$item_id."' AND parent_id = '".$parent."'");
        $check_num = $check->num_rows;
        if ($check_num <= 0){
            $this->load->model('tool/forms');
            $this->model_tool_forms->createFill($parent, $name);
        } else {
            $res = 'exists';
        }
        echo $res;
    }
    
    public function getProdCard() {
        $this->load->model("tool/product");
        $data = $this->model_tool_product->getProdInfo($this->request->post['prod']);
        $photos = $this->model_tool_product->getProdImg($this->request->post['prod']);
        $local_id = 0; 
        $images = array();
        foreach($photos as $img){
            $images[] = array (
                    'thumb'         => $this->model_tool_image->resize($img['image'], 400, 300),
                    'popup'         => $this->model_tool_image->resize($img['image'], 1024, 768),
                    'main'          => $img['image']==$data['image']?TRUE:FALSE,
                    'lid'           => $local_id
            );
        ++$local_id;    
        }
        if(!count($images)){
            $images[] = array (
                    'thumb'         => $this->model_tool_image->resize('no-image.png', 400, 300),
                    'popup'         => $this->model_tool_image->resize('no-image.png', 1024, 768),               
                    'main'          => TRUE,
                    'lid'           => 0
            );
        } elseif (!in_array(TRUE,array_column($images,'main'))) {
                $images[0]['main'] = TRUE;
        }
        $data['images'] = $images;
        echo $this->load->view('modals/prodCard', $data);
    }
    
    
    public function searchingProds() {
        $request = trim($this->request->post['request']);
        $i = 0;
        $output = '<table class="table table-responsive table-bordered table-hover" style="width: 800px;">';
        if($request==''){
            $output.= 'Введите название детали';
        } else {
            $this->load->model('tool/product');
            $this->load->model('tool/image');
            $total = $this->model_tool_product->searchingProds($request);
            if(!empty($total)){
                $output.='<tr>'
                            . '<td>Фото</td>'
                            . '<td>Наимен.</td>'
                            . '<td>Склад</td>'
                            . '<td>К-во</td>'
                            . '<td>Цена</td>'
                            . '<td class="text-center"><i class="fa fa-android"></i></td>'
                        . '</tr>';
                foreach ($total as $prod) {
                    if($i<30){
                        $output.='<tr>'
                                    . '<td><img class="thumbanil center-block responsive" src="'. $this->model_tool_image->resize($prod['image'], 150, 150).'"></td>'
                                    . '<td>'.$prod['name'].'<br><b>Артикул: '.$prod['vin'].'</b></td>'
                                    . '<td>'.$prod['stock'].'</td>'
                                    . '<td>'.$prod['quantity'].'</td>'
                                    . '<td>'.$prod['price'].'</td>'
                                    . '<td><a class="btn btn-warning" btn_type="showProd" target="'.$prod['product_id'].'" title="Информация о товаре" data-toggle="modal" data-target="#productInfoModal"><i class="fa fa-eye"></i></a></td>'
                                . '</tr>';
                        ++$i;
                    }
                }
            }else{
                exit('Ничего не найдено');
            }
        }
        $output.='</tbody></table>';
        echo $output;
    }
    
    public function getSimilarVariants() {
        $req = $this->request->post;
        $request = explode(" ", $req['value']);
        $this->load->model('tool/product');
        $result = $this->model_tool_product->getSimilarVariants($request, $req['target'], $req['field'], $req['opt']);
        if(count($result)){
            $list = '';
            foreach ($result as $res) {
                $list.='<li class="searchItem" li-type="simItem" li-target="'.$res['tmp'].'" item_id="'.$res['id'].'" >'.$res['text'].'</li>';
            }
        } else {
            $list = '<li>В базе нет похожих значениий. Изменение запроса может исправить ситуацию.</li>';            
        }
//        $list = var_dump($result);
        echo $list;
    }
    
    public function getSmartVariants() {
        $req = $this->request->post;
        $request = explode(" ", $req['value']);
        $this->load->model('tool/product');
        $result = $this->model_tool_product->getSmartVariants($request, $req['item']);
        if(count($result)){
            $list = '';
            foreach ($result as $res) {
                $list.='<li class="searchItem" li-type="smartItem" fill="'.$res['id'].'" library="'.$res['library_id'].'">'.trim($res['name']).'</li>';
            }
        } else {
            $list = '<li>В базе нет похожих значениий. Изменение запроса может исправить ситуацию.</li>';            
        }
        echo $list;
    }
    
    public function getSmartVarParents() {
        $req = $this->request->post['fill'];
        $this->load->model('tool/product');
        $result = $this->model_tool_product->getSmartVarParents($req);
        $list = '';
        foreach ($result as $res) {
            $list.='<div class="form-group-sm col-md-4 temp'.$res['library_id'].'" id="">'
                    . '<label>'.$res['text'].'</label>'
                    . '<input class="form-control" disabled type="text" value="'.$res['name'].'">'
                    . '<input type="hidden" name="input-'.$res['itemName'].'" value="'.trim($res['id']).'"/>'
                  . '</div>';
        }
        echo $list;
    }
    
    public function autoload() {
        $req = $this->request->post;
        $this->load->model('tool/product');
        $result = $this->model_tool_product->getItemInfo($req);
        
        echo json_encode($result);
    }
    
    public function fastviewed(){
        $target = $this->request->post['target'];
        $this->load->model('tool/layout');
        $this->model_tool_layout->checkfastviewed($target);
    }

    public function getAxisSettings() {
        echo $this->load->view('form/axis_'.$this->request->post['axis']);
    }
}

