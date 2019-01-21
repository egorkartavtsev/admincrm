<?php

class ControllerSettingProdTypes extends Controller {
    
    public function index() {
        $this->load->model('setting/prodtype');
        $this->load->model('tool/product');
        $this->load->model('tool/layout');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['templates'] = $this->model_tool_product->getStructures();
        $data['ckeditor'] = $this->config->get('config_editor_default');
        $data['modal'] = $this->load->view('modals/clear', array(
            'target' => 'options',
            'key' => 'sets_option',
            'header' => 'Настройки свойства'
        ));
//        exit(var_dump($data['ckeditor']));
        $this->response->setOutput($this->load->view('setting/prodtype', $data));
    }
    
    public function showOptions() {
        $this->load->model('tool/product');
        $results = $this->model_tool_product->getOptions($this->request->post['id']);
        $info = $this->model_tool_product->getStructInfo($this->request->post['id']);
        
        $options = '<div>';
        $divInfo = '';
        $divsOpt = '';
        
        $oldlbl1 = 0;
        $oldlbl2 = 0;
        $oldlbl3 = 0;
        
        $lblopt1 = '<option value="-" selected>Выключен</option>';
        $lblopt2 = '<option value="-" selected>Выключен</option>';
        $lblopt3 = '<option value="-" selected>Выключен</option>';
        
        $lblcol1 = '<option value="eanr">Красный</option>'
                 . '<option value="eanb">Синий</option>'
                 . '<option value="eang">Зелёный</option>';
        
        $lblcol2 = '<option value="eanr">Красный</option>'
                 . '<option value="eanb">Синий</option>'
                 . '<option value="eang">Зелёный</option>';
        
        $lblcol3 = '<option value="eanr">Красный</option>'
                 . '<option value="eanb">Синий</option>'
                 . '<option value="eang">Зелёный</option>';
        
        $divExc = '<div role="tabpanel" class="tab-pane" id="excel">'
                . '<h3>Шаблон выгрузки и загрузки товаров типа "'.$info['text'].'"</h3>'
                . '<table class="table table-hover">'
                . '<thead>'
                    . '<tr>'
                        . '<th>Свойство</th>'
                        . '<th>Столбец</th>'
                    . '</tr>'
                . '</thead>'
                . '<tbody>';
        $options.= '<ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Свойства</a></li>
                        <li role="presentation"><a href="#descript" aria-controls="descript" role="tab" data-toggle="tab">Общие</a></li>
                        <li role="presentation"><a href="#excel" aria-controls="excel" role="tab" data-toggle="tab">Excel</a></li>
                        <li role="presentation"><a href="#labels" aria-controls="labels" role="tab" data-toggle="tab">Ярлыки</a></li>
                    </ul>'
                . '<div class="tab-content"><div role="tabpanel" class="tab-pane active" id="home"><h4 type="optHeader"><h4 id="optHeader">Свойства товара: </h4>';
        $divsOpt.= '<div class="clearfix"></div><div class="clearfix"><p></p></div><button id="newOpt" class="btn btn-success" onclick="addOption()"><i class="fa fa-plus-circle"></i> создать нововое свойство товара</button><div class="clearfix"></div><div class="clearfix"><p></p></div>';
        if(!empty($results['options'])){
            foreach ($results['options'] as $result) {
                $options.='<button class="btn btn-success btn-lg col-md-3" btn_type="sets_opt" data-toggle="modal" data-target="#optionsModal" option="'.$result['lib_id'].'">'
                                .'<p>'.$result['text']
                            .'</p></button> ';
                $divExc.= '<tr>'
                        . '<td>'.$result['text'].'</td>'
                        . '<td><input class="form-control" name="excel" target="'.$result['lib_id'].'" value="'.$result['excel'].'"/></td>'
                        . '</tr>';
                switch ($result['label_order']) {
                    case '1':
                        $lblopt1.= '<option value="'.$result['lib_id'].'" selected>'.$result['text'].'</option>';
                        $lblopt2.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblopt3.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblcol1 = '<option value="eanr" '.($result['label_color']=='eanr'?'selected':'').'>Красный</option>'
                                 . '<option value="eanb" '.($result['label_color']=='eanb'?'selected':'').'>Синий</option>'
                                 . '<option value="eang" '.($result['label_color']=='eang'?'selected':'').'>Зелёный</option>';
                        $oldlbl1 = $result['lib_id'];
                    break;
                    case '2':
                        $lblopt1.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblopt2.= '<option value="'.$result['lib_id'].'" selected>'.$result['text'].'</option>';
                        $lblopt3.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblcol2 = '<option value="eanr" '.($result['label_color']=='eanr'?'selected':'').'>Красный</option>'
                                 . '<option value="eanb" '.($result['label_color']=='eanb'?'selected':'').'>Синий</option>'
                                 . '<option value="eang" '.($result['label_color']=='eang'?'selected':'').'>Зелёный</option>';
                        $oldlbl2 = $result['lib_id'];
                    break;
                    case '3':
                        $lblopt1.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblopt2.= '<option value="'.$result['lib_id'].'" disabled>'.$result['text'].'</option>';
                        $lblopt3.= '<option value="'.$result['lib_id'].'" selected>'.$result['text'].'</option>';
                        $lblcol3 = '<option value="eanr" '.($result['label_color']=='eanr'?'selected':'').'>Красный</option>'
                                 . '<option value="eanb" '.($result['label_color']=='eanb'?'selected':'').'>Синий</option>'
                                 . '<option value="eang" '.($result['label_color']=='eang'?'selected':'').'>Зелёный</option>';
                    break;
                    default:
                        $lblopt1.= '<option value="'.$result['lib_id'].'">'.$result['text'].'</option>';
                        $lblopt2.= '<option value="'.$result['lib_id'].'">'.$result['text'].'</option>';
                        $lblopt3.= '<option value="'.$result['lib_id'].'">'.$result['text'].'</option>';
                        $oldlbl3 = $result['lib_id'];
                    break;
                }
            }
        }
        $divsOpt.= '</div>';
        $divInfo.= '<div role="tabpanel" class="tab-pane" id="descript">'
                    . '<div class="col-lg-12 form-group">'
                        . '<div class="col-lg-8"><label for="typeName">Маска наименования продуктов данного типа:</label>'
                        . '<input class="form-control" id="typeName" type="text" type_id="'.$this->request->post['id'].'" value="'.$info['text'].'"/></div>'
                        . '<label>&nbsp;</label><br><button class="btn btn-success" disabled btn_type="typeNameSave"><i class="fa fa-floppy-o"></i></button>'
                    . '</div>'
                    . '<div class="col-lg-12 form-group">'
                        . '<div class="col-lg-8"><label for="templName">Маска наименования продуктов данного типа:</label>'
                        . '<input class="form-control" id="templName" type="text" type_id="'.$this->request->post['id'].'" value="'.$info['temp'].'"/></div>'
                        . '<label>&nbsp;</label><br><button class="btn btn-success" disabled btn_type="tempNameSave"><i class="fa fa-floppy-o"></i></button>'
                    . '</div>'
                    . '<div class="col-lg-12 form-group">'
                        . '<div class="col-lg-8"><label for="showNav">Отображение в верхнем меню витрины:</label>'
                        . '<select class="form-control" id="showNav" type="text" type_id="'.$this->request->post['id'].'">'
                            . '<option value="0" '.($info['top_nav']==='0'?'selected':'').'>Не отображать</option>'
                            . '<option value="1" '.($info['top_nav']==='1'?'selected':'').'>Отображать</option>'
                        . '</select>'
                        . '</div>'
                        . '<label>&nbsp;</label><br><button class="btn btn-success" disabled btn_type="showNavSave"><i class="fa fa-floppy-o"></i></button>'
                    . '</div>';
        $divInfo.= '</div>';
        $divsLabels = '<div role="tabpanel" class="tab-pane" id="labels">'
                    . '<div class="row">'
                        . '<div class="col-md-4">'
                            . '<div class="alert alert-success">'
                                . '<h3>Настройки ярлыка 1</h3>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите свойство:</label>'
                                    . '<select name="field" class="form-control">'.$lblopt1.'</select>'
                                . '</div>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите цвет:</label>'
                                    . '<select name="color" class="form-control">'.$lblcol1.'</select>'
                                . '</div>'
                                . '<button class="btn btn-success btn-sm" btn_type="label_settings" target="1" old_field="'.$oldlbl1.'"><i class="fa fa-floppy-o"></i> сохранить ярлык</button>'
                            . '</div>'
                        . '</div>'
                        . '<div class="col-md-4">'
                            . '<div class="alert alert-success">'
                                . '<h3>Настройки ярлыка 2</h3>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите свойство:</label>'
                                    . '<select name="field" class="form-control">'.$lblopt2.'</select>'
                                . '</div>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите цвет:</label>'
                                    . '<select name="color" class="form-control">'.$lblcol2.'</select>'
                                . '</div>'
                                . '<button class="btn btn-success btn-sm" btn_type="label_settings" target="2" old_field="'.$oldlbl2.'"><i class="fa fa-floppy-o"></i> сохранить ярлык</button>'
                            . '</div>'
                        . '</div>'
                        . '<div class="col-md-4">'
                            . '<div class="alert alert-success">'
                                . '<h3>Настройки ярлыка 3</h3>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите свойство:</label>'
                                    . '<select name="field" class="form-control">'.$lblopt3.'</select>'
                                . '</div>'
                                . '<div class="form-group-sm">'
                                    . '<label>Выберите цвет:</label>'
                                    . '<select name="color" class="form-control">'.$lblcol3.'</select>'
                                . '</div>'
                                . '<button class="btn btn-success btn-sm" btn_type="label_settings" target="3" old_field="'.$oldlbl3.'"><i class="fa fa-floppy-o"></i> сохранить ярлык</button>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                    . '<div class="row">'
                        . '<div class="well well-sm text-center">'
                            . '<h4><i class="fa fa-warning"></i> ярлык с информацией о комплектности товара является системным и редактированию не подлежит!</h4>'
                        . '</div>'
                    . '</div>'
                . '</div>';
        $divExc.= '<tr><td colspan="2" class="text-center"><button btn_type="saveExcelTempl" class="btn btn-success">сохранить шаблон</button></td></tr></tbody></table></div>';
        $options.='</h4>';
        echo $options.$divsOpt.$divInfo.$divExc.$divsLabels;
    }
    
    public function addOption() {
        $this->load->model('tool/product');
        $result = '<div class="clearfix"></div><div class="clearfix"><p></p></div><div class="alert alert-warning">';
            $result.='<div class="col-md-6">'
                        . '<input type="text" id="textOption" class="form-control" placeholder="Введите название свойства(по-русски)">'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<span type="text" id="nameOption" class="label label-success"></span>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="field_typeOption" class="form-control">'
                            . '<option value="input">Текстовое поле</option>'
                            . '<option value="select">Выбор вариантов</option>'
                            . '<option value="library">Привязать библиотеку</option>'
                            . '<option value="compability">Библиотечная совместимость</option>'
                        . '</select>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="librariesOption" class="form-control" disabled>';
                        $librs = $this->model_tool_product->getLibrs();
                        foreach ($librs as $lib){
                            $result.='<option value="'.$lib['library_id'].'">'.$lib['text'].'</option>';
                        }
                $result.='</select><div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<input type="text" id="def_valOption" class="form-control" placeholder="Введите значение свойства по умолчанию">'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="unique_fieldOption" class="form-control">'
                            . '<option value="0">Неуникальное поле</option>'
                            . '<option value="1">Уникальное поле</option>'
                        . '</select>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<button id="saveOpt" class="btn btn-info"><i class="fa fa-floppy-o"></i> сохранить</button>&nbsp;'
                        . '<button id="delNewOpt" class="btn btn-danger"><i class="fa fa-trash-o"></i> удалить</button>'
                   . '</div>';
            $result.='<div class="col-md-6">'
                        . '<input type="text" id="valsOption" class="form-control" disabled placeholder="Введите значения свойства через ;">'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<input type="text" id="descriptionOption" class="form-control" placeholder="Введите описание свойства ">'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="requiredOption" class="form-control">'
                            . '<option value="0">Необязательное поле</option>'
                            . '<option value="1">Обязательное обязательное</option>'
                        . '</select>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="viewedOption" class="form-control">'
                            . '<option value="1">Отображать на витрине</option>'
                            . '<option value="0">Не отображать на витрине</option>'
                        . '</select>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<select id="searchingOption" class="form-control">'
                            . '<option value="1">Участвует в поиске</option>'
                            . '<option value="0">Не участвует в поиске</option>'
                        . '</select>'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                        . '<input type="text" id="sort_orderOption" class="form-control" placeholder="Порядок сортировки">'
                        . '<input type="hidden" id="oldOption" value="0">'
                        . '<div class="clearfix"></div><div class="clearfix"><p></p></div>'
                   . '</div>'
                    . '<div class="clearfix"></div><div class="clearfix"><p></p></div>';
        $result.= '</div>';
        echo $result;
    }
    
    public function saveOption() {
        $res = [];
        foreach($this->request->post['data'] as $field){
            $index = str_replace('Option', '', $field['field']);
            $res[trim($index)] = $field['val'];
        }
        $res['type_id'] = $this->request->post['type_id'];
        $this->load->model('tool/product');
        $result = $this->model_tool_product->saveOption($res);
        if($res['field_type']==='libraries'){
            $divsOpt.= '<div class="alert alert-success">';
            $divsOpt.= '<h4>Библиотека: '.$result[0]['library_name'].'</h4>';
            foreach ($result as $item) {
                $divsOpt.= '<span class="label label-success">'.$item['text'].'</span>';
            }
            $divsOpt.= '</div><div class="clearfix"></div><div class="clearfix"><p></p></div>';
            exit($divsOpt);
        }
    }
    
    public function translateOption() {
        $this->load->model('tool/translate');
        echo $this->model_tool_translate->translate($this->request->post['text']);
    }
    
    public function saveNewType() {
        $name = $this->request->post['data'];
        $this->load->model('tool/product');
        $result = $this->model_tool_product->saveType($name);
        echo $result;
    }
    
    public function deleteOption() {
        $name = $this->request->post['name'];
        $type_id = $this->request->post['type_id'];
        $this->load->model('tool/product');
        $this->model_tool_product->deleteOption($name, $type_id);
    }
    
    public function saveTempName() {
        $this->load->model('tool/product');
        $this->model_tool_product->saveTempName($this->request->post['tempName'], $this->request->post['type_id']);
        echo 'ok';
    }
    
    public function saveTypeName() {
        $this->load->model('tool/product');
        $this->model_tool_product->saveTypeName($this->request->post['typeName'], $this->request->post['type_id']);
        echo 'ok';
    }
    
    public function saveShowNav() {
        $this->load->model('tool/product');
        $this->model_tool_product->saveShowNav($this->request->post['show'], $this->request->post['type_id']);
        echo 'ok';
    }
    
    public function saveDT() {
        $this->load->model('tool/product');
        
        echo $this->model_tool_product->saveDT($this->request->post['temp'], $this->request->post['temp_id']);
    }
    
    public function getSetsOpt() {
        $opt = $this->request->post['opt'];
        $this->load->model('tool/product');
        $result = $this->model_tool_product->getOptionInfo($opt);
        $output = '';
        switch ($result['field_type']) {
            case 'input':
                $result['opts'] = $this->model_tool_product->getOptions($result['type_id']);
                $output = $this->load->view('form/sets_input', $result);
            break;
            case 'select':
                $output = $this->load->view('form/sets_select', $result);
            break;
            case 'library':
                $output = $this->load->view('form/sets_libr', $result);
            break;
            case 'compability':
                $output = $this->load->view('form/sets_cpb', $result);
            break;
        }
        echo $output;
    }
    
    public function saveTypeLabel(){
        $this->load->model('tool/product');
        echo $this->model_tool_product->saveTypeLabel($this->request->post['label'], $this->request->post['field'], $this->request->post['old'], $this->request->post['color']);
    }
    
    public function saveExcelTempl(){
        $this->load->model('tool/product');
        $templ = array();
        $sup = explode(',', $this->request->post['templ']);
        foreach ($sup as $value) {
            $subsup = explode(":", $value);
            if(isset($subsup[1])){
                $templ[$subsup[0]] = $subsup[1];
            }
        }
        $this->model_tool_product->saveExcelTemplate($templ);
        echo 'COXPAHEHO';
    }
    
    public function getFields() {
        $this->load->model('tool/product');
        $sup = $this->model_tool_product->getOptions($this->request->post['target']);
        $output = '<div class="form-group-sm col-md-12">
                        <label>Способ заполнения:</label>
                        <select class="form-control" id="sim_showlistOption">
                            <option value="product">По подобным товарам</option>
                            <option value="donor">По донорам</option>
                        </select>
                    </div>
                    <div class="form-group-sm col-md-12">
                        <label>Поля для заполнения:</label>
                        <select class="form-control" multiple id="similarOption">';
        foreach ($sup['options'] as $value) {
            $output.= '<option value="'.$value['name'].'">'.$value['text'].'</option>';
        }
        $output.= '</select></div>';
        echo $output;
    }
}
