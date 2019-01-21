<?php

class ControllerDonorEdit extends Controller {
    public function index() {
        $this->load->model("common/donor");
        $this->load->model("tool/layout");
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $data['donor'] = $this->model_common_donor->getDonorInfo($this->request->get['donor_id']);
//        exit(var_dump($data['donor']));
        $this->load->model('tool/image');
        $i = 0;
        $images = $this->model_common_donor->getImages($this->request->get['donor_id']);
//        exit(var_dump($images));
        $data['mainimage'] = $data['donor']['image'];
        $data['images'] = array();
        foreach ($images as $image) {
            if (is_file(DIR_IMAGE.$image['image'])) {
                    $thumb = $this->model_tool_image->resize($image['image'], 100, 100);
            } else {
                    $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
            }
            $data['images'][$i] = array(
                'lid' => $i,
                'image' => $image['image'],
                'sort_order' => $image['sort_order'],
                'thumb' => $thumb,
                'main'  => FALSE
            );
            if($image['image'] === $data['donor']['image']){
                $data['images'][$i] = array(
                'lid' => $i,
                'image' => $image['image'],
                'sort_order' => 0,
                'thumb' => $thumb,
                'main'  => TRUE
                );
            }
            ++$i;
        }
        $data['products'] = array();
        $prods = $this->model_common_donor->getProds($data['donor']['numb']);
        $total_price = 0;
        $quant = 0;
        foreach ($prods as $result){
            $total_price += $result['price']*$result['quantity'];
            $quant+=$result['quantity'];
            
            if (is_file(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 60, 60);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            if($result['product_id']!=NULL){
                $data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'image'      => $image,
                        'manager'    => $result['manager'],
                        'name'       => $result['name'],
                        'vin'        => $result['vin'],
                        'location'   => $result['location'],
                        'stock'      => (isset($result['stock'])) && ($result['stock']!=='') && ($result['stock']!=='-')?$result['stock']:'не указан',
                        'model'      => $result['modR'],
                        'price'      => $result['price'],
                        'date_added' => $result['date_added'],
                        'category'   => $result['category'],
                        'quantity'   => $result['quantity'],
                        'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                        'edit'       => $this->url->link('product/product_edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], true)
                );
            }
        }
        $data['donor']['quant'] = $quant;
        $data['donor']['totalp'] = $total_price;
        //берём марки
        $query = $this->db->query("SELECT id, name FROM ".DB_PREFIX."lib_fills "
                                . "WHERE parent_id = 0 AND library_id = 1 ORDER BY name ");

        $brands = $query->rows;
        $data['brands'] = array();
        foreach ($brands as $res) {
            $data['brands'][] = array(
                'name' => $res['name'],
                'val'  => $res['id']
            );
        }
        $query = $this->db->query("SELECT id, name FROM ".DB_PREFIX."lib_fills "
                                . "WHERE name = '".$data['donor']['brand']."' ORDER BY name ");
        $brand_id = $query->row['id'];
        //берём модели
        $query = $this->db->query("SELECT id, name FROM ".DB_PREFIX."lib_fills "
                                . "WHERE parent_id = '".$brand_id."' ORDER BY name ");

        $models = $query->rows;
        $data['models'] = array();
        foreach ($models as $res) {
            $data['models'][] = array(
                'name' => $res['name'],
                'val'  => $res['id']
            );
        }
        $query = $this->db->query("SELECT id, name FROM ".DB_PREFIX."lib_fills "
                                . "WHERE name = '".$data['donor']['model']."' ORDER BY name ");
        $model_id = $query->row['id'];
        //берём модельные ряды
        $query = $this->db->query("SELECT id, name FROM ".DB_PREFIX."lib_fills "
                                . "WHERE parent_id = '".$model_id."' ORDER BY name ");

        $model_rows = $query->rows;
        $data['model_rows'] = array();
        foreach ($model_rows as $res) {
            $data['model_rows'][] = array(
                'name' => $res['name'],
                'val'  => $res['id']
            );
        }
        
        $data['go_site'] = HTTP_SHOWCASE.'index.php?route=catalog/product&product_id=';
        $data['action'] = $this->url->link('donor/edit/save_form', 'donor_id=' . $this->request->get['donor_id'], true);
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        $data['token_add'] = $this->session->data['token'];
//        $data['utype'] = $this->session->data['uType'];
        $this->response->setOutput($this->load->view('donor/edit', $data));
    }
    
    public function save_form() {
        $this->load->model("common/donor");
        $this->model_common_donor->updateDonor($this->request->post, $this->request->get['donor_id']);
        $this->response->redirect($this->url->link('donor/edit', 'donor_id=' . $this->request->get['donor_id'], true));
    }
}