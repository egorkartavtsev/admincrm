<?php

class ControllerDonorList extends Controller {
    public function index(){
        $this->load->model("common/donor");
        $this->load->model("tool/layout");
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $filter = array();
        $donors = $this->model_common_donor->getDonors($filter);
        $this->load->model('tool/image');
        foreach ($donors as $donor) {
            $prods = $this->model_common_donor->getProds($donor['numb']);
            $total_price = 0;
            $quant = 0;
            foreach ($prods as $prod) {
                $total_price += $prod['price']*$prod['quantity'];
                $quant+=$prod['quantity'];
            }
            if (is_file(DIR_IMAGE.$donor['image'])) {
                    $image = $this->model_tool_image->resize($donor['image'], 40, 40);
            } else {
                    $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }
            $data['donors'][] = array(
                'numb' => $donor['numb'],
                'image' => $image,
                'totalp' => $total_price,
                'quant' => $quant,
                'vin' => $donor['vin'],
                'dvs' => $donor['dvs'],
                'price' => $donor['price'],
                'color' => $donor['color'],
                'ctype' => $donor['ctype'],
                'year' => $donor['year'],
                'mod_row' => $donor['modR'],
                'kmeters' => $donor['kmeters'],
                'trmiss' => $donor['trmiss'],
                'priv' => $donor['priv'],
                'name' => $donor['name'],
                'delete' => $this->url->link('donor/list/delete', 'donor_id='.$donor['id'], true),
                'edit' => $this->url->link('donor/edit', 'donor_id='.$donor['id'], true),
                'show' => $this->url->link('donor/show', 'numb='.$donor['numb'], true)
            );
        }
        $data['token_add'] = $this->session->data['token'];
        $user = $this->user->getUserInfo();
        $data['utype'] = ($user['userAL']==19 || $user['userAL']==99999)?1:0;
        $this->response->setOutput($this->load->view('donor/list', $data));
    }
    
    public function delete() {
        $id = $this->request->get['donor_id'];
        $this->load->model("common/donor");
        $this->model_common_donor->deleteDonor($id);
        $this->response->redirect($this->url->link('donor/list', 'token=' . $this->session->data['token'], true));
    }
    
    public function filter() {
        $this->load->model("common/donor");
        $filter = array();
        $request = $this->request->post['param'];
        if($request==''){
            $donors = $this->model_common_donor->getDonors($filter);
        } else {
            $donors = $this->model_common_donor->filterList($request);
        }
        $this->load->model('tool/image');
        $table = '';
        foreach ($donors as $donor) {
            $prods = $this->model_common_donor->getProds($donor['numb']);
            $total_price = 0;
            $quant = 0;
            foreach ($prods as $prod) {
                $total_price += $prod['price']*$prod['quantity'];
                $quant+=$prod['quantity'];
            }
            if (is_file(DIR_IMAGE.$donor['image'])) {
                    $image = $this->model_tool_image->resize($donor['image'], 40, 40);
            } else {
                    $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }
            
            $table.='<tr>';
            $table.='<td>'
                    . '<a href="'.$this->url->link('donor/edit', 'donor_id='.$donor['id'], true).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>'
                    . '<a href="'.$this->url->link('donor/list/delete', 'donor_id='.$donor['id'], true).'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>'
                    . '</td>';
            $table.='<td class="text-center"><img src="'.$image.'"></td>';
            $table.='<td>'.$donor['name'].'</td>';
            $table.='<td>'.$donor['numb'].'</td>';
            $table.='<td>'.$donor['modR'].'</td>';
            $table.='<td>'.$donor['ctype'].'</td>';
            $table.='<td>'.$donor['year'].'</td>';
            $table.='<td>'.$donor['kmeters'].'</td>';
            $table.='<td>'.$donor['vin'].'</td>';
            $table.='<td>'.$donor['dvs'].'</td>';
            $table.='<td>'.$donor['trmiss'].'</td>';
            $table.='<td>'.$donor['priv'].'</td>';
            $table.='<td>'.$donor['color'].'</td>';
            $table.='<td>'.$donor['price'].'</td>';
            $table.='<td>'.$quant.'</td>';
            $table.='<td>'.$total_price.'</td>';
            $table.='</tr>';
        }
        
        echo $table;
    }
}

