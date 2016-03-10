<?php
class OrderAjax extends MX_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('order_model');
	}
	
	function addItems() {
		$itemId = $this->input->post('itemId');		
		if(isset($this->session->userdata['cart'])) {
			$cart = $this->session->userdata['cart'];
		} else {
			$cart = array();
		}
		
		// get item detail
		// $item = $this->order_model->getItemDetail(...);
		// $type = $item->item_type;
		$type = $itemId;
		switch($type) {
			case 1:
				$names		= $this->input->post('names');
				$fasteners	= $this->input->post('fasteners');
				$spk_spanish= $this->input->post('spk_spanish');
				
				$total = 0;
				$items = array();
				foreach($names as $key=>$name) {
					$temp_item = array();
					$temp_item['style']			= "name only";
					$temp_item['itemId']		= $itemId;
					$temp_item['name']			= $name;
					$temp_item['fastener']		= $fasteners[$key];
					$temp_item['spk_spanish']	= $spk_spanish[$key];
					
					$items[] = $cart[] = $temp_item;
					$total	+= 1;
				}
			break;
			case 2:
				$names		= $this->input->post('names');
				$titles		= $this->input->post('titles');
				$fasteners	= $this->input->post('fasteners');
				$spk_spanish= $this->input->post('spk_spanish');
				
				$total = 0;
				$items = array();
				foreach($names as $key=>$name) {
					$temp_item = array();
					$temp_item['style']			= "name w/ title";
					$temp_item['itemId']		= $itemId;
					$temp_item['name']			= $name;
					$temp_item['title']			= $titles[$key];
					$temp_item['fastener']		= $fasteners[$key];
					$temp_item['spk_spanish']	= $spk_spanish[$key];
					
					$items[] = $cart[] = $temp_item;
					$total	+= 1;
				}
			break;
			case 3:
				$fasteners	= $this->input->post('fasteners');
				$spk_spanish= $this->input->post('spk_spanish');
				
				$total = 0;
				$items = array();
				foreach($fasteners as $key=>$fastener) {
					$temp_item = array();
					$temp_item['style']			= "generic (no name)";
					$temp_item['itemId']		= $itemId;
					$temp_item['fastener']		= $fastener;
					
					$items[] = $cart[] = $temp_item;
					$total	+= 1;
				}
			break;
			case 6:
				
				$style  	= $this->input->post('style');
				$names		= $this->input->post('names');
				$fasteners	= $this->input->post('fasteners');
				//$spk_spanish= $this->input->post('spk_spanish');
				
				$total = 0;
				$items = array();
				foreach($names as $key=>$name) {
					$temp_item = array();
					$temp_item['style']			= $style;
					$temp_item['itemId']		= $itemId;
					$temp_item['name']			= $name;
					$temp_item['fastener']		= $fasteners[$key];		
					$items[] = $cart[] = $temp_item;
					$total	+= 1;
				}
			break;			
			
		}
		
		$this->session->set_userdata('cart',$cart);
				
		if(!isset($this->session->userdata['cart_total'])) {
			$cart_total = $total;
		} else {
			$cart_total = $this->session->userdata['cart_total'];
			$cart_total += $total;
		}
		$this->session->set_userdata('cart_total',$cart_total);
		
		$data	= array(
			'total'	=> $cart_total,
			'items'	=> $items
		);
		$data	= json_encode($data);
		echo $data;
		return;		
	}
	
	function addInputBox() {
		$current_input_boxes_number = $this->input->post('current_input_boxes_number');
		$type = $this->input->post('type');
		if($type==5) {
			$titles	= array(
				'licensed optician'				=> 'license optician',
				'licensed optician manager'		=> 'licensed optician manager',
				'apprenticed optician'			=> 'apprenticed optician',
				'licensed dispensing optician' 	=> 'licensed dispensing optician',
				'optical lead expert'			=> 'optical lead expert',
				'optical specialist'			=> 'optical specialist'
			);
			$data['titles']	= $titles;
		}
		$data['number']	= $current_input_boxes_number + 1;
		$data['type']	= $type;
		$this->load->view('order/input_box',$data);
	}
	function deleteCartItem(){
		
	}
}