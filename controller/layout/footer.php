<?php
class ControllerLayoutFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');
		
		$data['text_footer'] = 'ASMPro - автозачасти &copy; 2017-' . date('Y') . ' Все права защищены.';

		if ($this->user->isLogged() && isset($this->request->cookie['token']) && ($this->request->cookie['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf('Версия программы V %s', VERSION);
		} else {
			$data['text_version'] = '';
		}
                $modal = array(
                    'target' => 'productInfo',
                    'key' => 'prodinfocard',
                    'header' => 'Информация о продукте'
                );
		$data['product_modal'] = $this->load->view('modals/clear', $modal);
		
		        $modal2 = array(
				    'target' => 'expiredOrders',
					'key' => 'expiredorderscard',
					'header' => 'Заказы с просроченным резервированием:'
				);
	    $data['expired_orders'] = $this->load->view('modals/clear', $modal2);
		return $this->load->view('layout/footer', $data);
	}
}
