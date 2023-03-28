<?php
class ControllerProductionRelocation extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}
	
	protected function getList(){
				$this->load->model('tool/layout');
				$data = $this->model_tool_layout->getLayout($this->request->get['route']);
				
				$user = $this->user->getUserInfo();
				$data['user'] = array(
					'access' => (int)$user['userAL']
				);
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		if (isset($this->request->get['filter_vin'])) {
			$filter_vin = trim($this->request->get['filter_vin']);
		} else {
			$filter_vin = null;
		}
		
		if (isset($this->request->get['filter_adress'])) {
			$filter_adress = $this->request->get['filter_adress'];
		} else {
			$filter_adress = null;
		}
		if (isset($this->request->get['filter_stock'])) {
			$filter_stock = $this->request->get['filter_stock'];
		} else {
			$filter_stock = null;
		}
		if (isset($this->request->get['filter_stell'])) {
			$filter_stell = $this->request->get['filter_stell'];
		} else {
			$filter_stell = null;
		}
		if (isset($this->request->get['filter_jar'])) {
			$filter_jar = $this->request->get['filter_jar'];
		} else {
			$filter_jar = null;
		}
		if (isset($this->request->get['filter_shelf'])) {
			$filter_shelf = $this->request->get['filter_shelf'];
		} else {
			$filter_shelf = null;
		}
		if (isset($this->request->get['filter_box'])) {
			$filter_box = $this->request->get['filter_box'];
		} else {
			$filter_box = null;
		}
		
		if (isset($this->request->get['page'])) {
			$page = trim($this->request->get['page']);
		} else {
			$page = 1;
		}
		if(isset($this->request->get['isExact'])){
			$isExact = 'yes';
			$data['checked'] = 'checked="checked"';
		} else {
			$isExact = 'no';
			$data['checked'] = '';
		}
		
		$url = $this->getFiltUrl();
		
		$data['relocate'] = $this->url->link('production/relocation/relocate', '1' . $url, true);
		$data['go_site'] = HTTP_SHOWCASE.'index.php?route=catalog/product&product_id=';
		
		$data['products'] = array();
		$filter_data = array(
			'filter_vin'	  => $filter_vin,
			'filter_adress'   => $filter_adress,
			'filter_stock'    => $filter_stock,
			'filter_stell'    => $filter_stell,
			'filter_jar'      => $filter_jar,
			'filter_shelf'    => $filter_shelf,
			'filter_box'      => $filter_box,
			'isExact'         => $isExact,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		$this->load->model('tool/product');        
		$this->load->model('tool/image');
		$this->load->model('product/relocation');
		$this->load->model('tool/forms');
		$product_total = $this->model_product_relocation->getTotalProducts($filter_data);
		$results = $this->model_product_relocation->getProducts($filter_data);
		
		
		foreach ($results as $result) {
			$photos = $this->model_tool_product->getProdImg($result['product_id']);
			$image = array();
			$local_id = 0;
			foreach($photos as $img){
				$image[] = array (
						'thumb'         => $this->model_tool_image->resize($img['image'], 400, 300),
						'popup'         => $this->model_tool_image->resize($img['image'], 1024, 768),
						'main'          => $img['image']==$result['image']?TRUE:FALSE,
						'lid'           => $local_id
				);
			++$local_id;
			}
			$stat ='';
			switch ($result['status']){
				case 0:
					$stat=$this->language->get('text_disabled');
					break;
				case 1:
					$stat=$this->language->get('text_enabled');
					break;
				case 2:
					$stat=$this->language->get('text_reserve');
					break;
			}
			if(!count($image)){
				$image[] = array (
						'thumb'         => $this->model_tool_image->resize('no-image.png', 400, 300),
						'main'          => TRUE,
						'lid'           => 0
				);
			} elseif (!in_array(TRUE,array_column($image,'main'))) {
					$image[0]['main'] = TRUE;
			}
			if($result['product_id']!=NULL){
				$data['products'][] = array(
						'product_id' => $result['product_id'],
						'image'      => $image,
						'manager'    => $result['catn'],
						'name'       => $result['name'],
						'vin'        => $result['vin'],
						'stell'      => (isset($result['stell'])) && ($result['stell']!=='')?$result['stell']:'-',
						'jar'        => (isset($result['jar'])) && ($result['jar']!=='')?$result['jar']:'-',
						'shelf'      => (isset($result['shelf'])) && ($result['shelf']!=='')?$result['shelf']:'-',
						'box'        => (isset($result['box'])) && ($result['box']!=='')?$result['box']:'-',
						'donor'      => $result['numb']!=''?'<a target="_blank" href="'.$this->url->link('donor/show', 'numb=' . $result['numb'] . $url, true).'">'.$result['numb'].'</a>':'-',
						'stock'      => (isset($result['stock'])) && ($result['stock']!=='') && ($result['stock']!=='-')?$result['stock']:'не указан',
						'adress'     => (isset($result['adress'])) && ($result['adress']!=='') && ($result['adress']!=='-')?$result['adress']:'не указан',
						'note'       => $result['note'],
						'price'      => $result['price'],
						'date_added' => $result['date_added'],
						'zаmetki'    => $result['zаmetki'],
						'dop'        => $result['dop'],
						'quantity'   => $result['quantity'],
						'status'     => $stat,
						'edit'       => $this->url->link('production/catalog/edit', 'product_id=' . $result['product_id'] . $url, true)
				);
			}			
		}
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_list'] = $this->language->get('text_list');		
		$data['form'] = $this->model_tool_forms->constructAddressForm();
		$data['filtLocation'] = $this->model_tool_forms->constructFiltLocationForm($filter_data);
		$data['previousAddr'] = $this->model_product_relocation->getPreviousAddr();
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('production/relocation', '1' . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		$data['filter_vin'] = $filter_vin;
		$data['filter_adress'] = $filter_adress;
		$data['filter_stock'] = $filter_stock;
		$data['filter_stell'] = $filter_stell;
		$data['filter_jar'] = $filter_jar;
		$data['filter_shelf'] = $filter_shelf;
		$data['filter_box'] = $filter_box;
		$this->response->setOutput($this->load->view('catalog/relocation', $data));
	}
	
	public function relocate() {
		$this->load->model('product/relocation');
		$all = $this->request->post;
		$names = $this->model_product_relocation->getNames();
		$newAddr = [];
		
		foreach ($names as $name) {
			if(isset($all[$name]) && $all[$name] != "" && $all[$name] != "-"){
				$newAddr += [$name => $all[$name]];
			}
			if(isset($all['info']) && array_key_exists($name, $all['info']) && $all['info'][$name] != "" && $all['info'][$name] != "-"){
				$newAddr += [$name => $all['info'][$name]];
			}
		}
		$this->model_product_relocation->relocate($all['selected'], $newAddr);
		$url = $this->getFiltUrl();
        $this->response->redirect($this->url->link('production/relocation', '1' . $url, true));
    }
	
	public function getFiltUrl() {
		$url = '';
		
		if (isset($this->request->get['filter_vin'])) {
			$url .= '&filter_vin=' . $this->request->get['filter_vin'];
		}
		if (isset($this->request->get['filter_adress']) && $this->request->get['filter_adress'] != "-") {
			$url .= '&filter_adress=' . $this->request->get['filter_adress'];
		}
		if (isset($this->request->get['filter_stock']) && $this->request->get['filter_stock'] != "-") {
			$url .= '&filter_stock=' . $this->request->get['filter_stock'];
		}
		if (isset($this->request->get['filter_stell']) && $this->request->get['filter_stell'] != "-") {
			$url .= '&filter_stell=' . $this->request->get['filter_stell'];
		}
		if (isset($this->request->get['filter_jar']) && $this->request->get['filter_jar'] != "-") {
			$url .= '&filter_jar=' . $this->request->get['filter_jar'];
		}
		if (isset($this->request->get['filter_shelf']) && $this->request->get['filter_shelf'] != "-") {
			$url .= '&filter_shelf=' . $this->request->get['filter_shelf'];
		}
		if (isset($this->request->get['filter_box']) && $this->request->get['filter_box'] != "-") {
			$url .= '&filter_box=' . $this->request->get['filter_box'];
		}
		if (isset($this->request->get['isExact'])) {
			$url .= '&isExact=yes';
		}
		return $url;
	}
	
	public function fillNewAddr(){
		$this->load->model('tool/forms');
		$this->load->model('product/relocation');
		$firstExplode = explode(":", $_POST['selectedAddr']);
		$selected_addr = explode("/", $firstExplode[1]);
		array_unshift($selected_addr, $firstExplode[0]);
		$names = $this->model_product_relocation->getNames();
		$i = 0;
		foreach ($names as $name){
			$selected_addr[$name] = $selected_addr[$i];
			unset($selected_addr[$i]);
			$i++;
		}
		$newForm = $this->model_tool_forms->constructAddressForm($selected_addr);
		echo $newForm;
	}
}
