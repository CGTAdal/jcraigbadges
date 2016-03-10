<?php
class Ajax extends MX_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('order_model');
	}
	
	function addBadgesToCart() {
		if(isset($this->session->userdata['cart'])) {
			$cart 	= $this->session->userdata['cart'];
			$badges	= (isset($cart['badges']))?$cart['badges']:array();
		} else {
			$cart 	= array();
			$badges	= array();
		}
		
		$styles			= $this->input->post('styles');
		$names			= $this->input->post('names');
		$titles			= $this->input->post('titles');
		$licenses		= $this->input->post('licenses');
		$fasteners		= $this->input->post('fasteners');
		$spk_spanish	= $this->input->post('spk_spanish');
		$service_year	= $this->input->post('service_year');
		
		$total 			= 0;
		$total_tenured	= 0;
		$items = array();
		foreach($styles as $key=>$style) {
			$temp_item = array();
			$temp_item['style']			= $style;
			$temp_item['name']			= $names[$key];
			$temp_item['fastener']		= $fasteners[$key];
			if($titles) {
				$temp_item['title']		= $titles[$key];
			}
			if($licenses) {
				$temp_item['license']	= $licenses[$key];
			}
			if($spk_spanish) {
				$temp_item['spk_spanish']	= $spk_spanish[$key];
			}
			if($service_year) {
				$temp_item['service_year']	= $service_year[$key];
			}
			$items[] = $badges[] 	= $temp_item;
			if($style != 'tenured name badge') {
				$total++;
			} else {
				$total_tenured++;
			}
		}
		
		$cart['badges']	= $badges;
		$this->session->set_userdata('cart',$cart);
				
		if(!isset($this->session->userdata['cart_total'])) {
			$cart_total = $total;
		} else {
			$cart_total = $this->session->userdata['cart_total'];
			$cart_total += $total;
		}
		$this->session->set_userdata('cart_total',$cart_total);
		
		if(!isset($this->session->userdata['tenured_total'])) {
			$this->session->set_userdata('tenured_total',$total_tenured);
		} else {
			$cart_tenured_total = $this->session->userdata['tenured_total'];
			$this->session->set_userdata('tenured_total',$cart_tenured_total + $total_tenured);
		}
		
		$data['badges']	= $items;
		$this->load->view('order/list_badges',$data);
		return;
	}
	
	function addExtrasToCart() {
		$magnet_qty = (int)$this->input->post('magnet_qty');
		$pin_qty	= (int)$this->input->post('pin_qty');
		
		if($magnet_qty + $pin_qty > 0) {
			if(isset($this->session->userdata['cart'])) {
				$cart 	= $this->session->userdata['cart'];
			} else {
				$cart = array();
			}
			
			$cart['order_mf_qty'] = $data['mf_qty'] = $magnet_qty;
			$cart['order_pf_qty'] = $data['pf_qty'] = $pin_qty;
			
			$this->session->set_userdata('cart',$cart);
			
			$this->load->view('order/list_extras',$data);
			return;
		}
	}
	
	function addInputBox() {				
		$current_input_boxes_number = $this->input->post('current_input_boxes_number');
		$type = $this->input->post('type');		
		switch($type) {
			case '1':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = "silver name badge";
				#$data['title']	 = "no title included";
				#$data['license'] = 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '2':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "lead expert";
				$data['title']	= "lead expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '3':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "expert";
				$data['title']	= "expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '4':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "specialist";
				$data['title']	= "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '5':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "optical";
				$data['title_options'] = array(
					'licensed optician'				=> 'licensed optician',
					'licensed optician manager'		=> 'licensed optician manager',
					'apprenticed optician'			=> 'apprenticed optician',
					'licensed dispensing optician' 	=> 'licensed dispensing optician',
					'optical lead expert'			=> 'optical lead expert',
					'optical specialist'			=> 'optical specialist'
				);
				$this->load->view('order/form/additional_input_name_form_optical',$data);
				return;				
			break;
			case '7':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "minor specialist";
				$data['title']	= "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '9':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "custom decorating";
				$data['title_options'] = array(
					'in-home decorator'	=> 'in-home decorator',
					'installer'			=> 'installer'
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;				
			break;
			case '10':
				$data['number']		= $current_input_boxes_number + 1;
				$data['style']		= "salon";
				$data['title']		= "no title included";
				$data['license']	= 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '11':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = "tenured name badge";
				$data['service_year']	= array(
					'5'		=> '5 years (Amethyst)',
					'10'	=> '10 years (Ruby)',
					'15'	=> '15 years (Sapphire)',
					'20' 	=> '20 years (Diamond)',
					'25' 	=> '25 years (Peridot)',
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
		}
	}
	
	function showNamesField() {
		$type	= $this->input->post('type');		
		switch ($type) {
			case '1':
				$data	= array();
				$data['description']	= "";
				$data['style']			= "silver name badge";
				#$data['title']			= "no title included";
				$data['type']			= 1;
				//$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '2':
				$data	= array();
				$data['description']	= "Title: lead expert";
				$data['style']			= "lead expert";
				$data['title']			= "lead expert";
				$data['type']			= 2;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '3':
				$data	= array();
				$data['description']	= "Title: expert";
				$data['style']			= "expert";
				$data['title']			= "expert";
				$data['type']			= 3;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '4':
				$data	= array();
				$data['description']	= "Title: specialist";
				$data['style']			= "specialist";
				$data['title']			= "specialist";
				$data['type']			= 4;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '5':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "optical";
				$data['type']			= 5;
				$data['title_options'] 	= array(
					'licensed optician'				=> 'licensed optician',
					'licensed optician manager'		=> 'licensed optician manager',
					'apprenticed optician'			=> 'apprenticed optician',
					'licensed dispensing optician' 	=> 'licensed dispensing optician',
					'optical lead expert'			=> 'optical lead expert',
					'optical specialist'			=> 'optical specialist'
				);
				
				$this->load->view('order/form/input_names_form_optical',$data);
				break;
			case '6':
				$data = array();
				$this->load->view('order/form/input_names_form_generic',$data);
				break;
			case '7':
				$data	= array();
				$data['description']	= "Enter Name For Minor Badge";
				$data['style']			= "minor specialist";
				$data['title']			= "specialist";
				$data['type']			= 7;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '8':
				$data	= array();
				$this->load->view('order/form/input_names_form_minor',$data);
				break;
			case '9':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "custom decorating";
				$data['type']			= 9;
				$data['title_options'] 	= array(
					'in-home decorator'	=> 'in-home decorator',
					'installer'			=> 'installer'
				);
				
				$this->load->view('order/form/input_names_form',$data);
				break;
				break;
			case '10':
				$data	= array();
				$data['description']	= "No Titles On Salon Badges";
				$data['style']			= "salon";
				//$data['title']			= "salon";
				$data['title']		= "no title included";
				$data['type']			= 10;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '11':
				$data	= array();
				$data['description']	= "";
				$data['style']			= "tenured name badge";
				$data['type']			= 11;
				$data['service_year']	= array(
					'5'		=> '5 years (Amethyst)',
					'10'	=> '10 years (Ruby)',
					'15'	=> '15 years (Sapphire)',
					'20' 	=> '20 years (Diamond)',
					'25' 	=> '25 years (Peridot)',
				);
				$this->load->view('order/form/input_names_form',$data);
				break;
		}
	}
	
	function deleteApprovalBadge() {
		$item_id 	= $this->input->post('item_id');
		$order_id	= $this->input->post('order_id');
		$order 		= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$order_id));
		$items		= (count($order)>0)?unserialize($order->order_items):'';			

		$badges	= $items;
		unset($badges[$item_id]);
		
		$new_badges	= array();
		foreach($badges as $badge) {
			$new_badges[] = $badge;
		}
		if(count($new_badges)>0) {
			$items = $new_badges;
		} else {
			$items = '';
		}
		
		$data = array('order_items'=>serialize($items));
		$data['order_total'] = $order->order_total - 1;
		
		# save order into database
		$this->order_model->saveItem('orders',array('id'=>$order_id,'field'=>'order_id'),$data);
		
		echo json_encode($data);
	}
	
	function deleteApprovalExtras() {
		$type 		= $this->input->post('type');
		$order_id	= $this->input->post('order_id');
		
		$order 		= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$order_id));
		
		$data = array();
		switch ($type) {
			case '1': 
				$order->order_mf_qty = $data['order_mf_qty'] = 0;
			break;
			case '2':
				$order->order_pf_qty = $data['order_pf_qty'] = 0;
			break;
		}
		
		# save order into database
		$this->order_model->saveItem('orders',array('id'=>$order_id,'field'=>'order_id'),$data);
		$total_extras = $order->order_mf_qty + $order->order_pf_qty;
		
		$data = array(
			'removed_item'		=> $type,
			'total_extras'		=> "$total_extras"
		);
		echo json_encode($data);
	}
	
	function deleteBadge() {		
		$id 	= (int)$this->input->post('item_id');				
		$cart 	= $this->session->userdata['cart'];
		$badges	= $cart['badges'];
		unset($badges[$id]);
		$new_badges	= array();
		foreach($badges as $badge) {
			$new_badges[] = $badge;
		}
		if(count($new_badges)>0) {
			$cart['badges']	= $new_badges;
		} else {
			unset($cart['badges']);
		}
		$this->session->set_userdata('cart',$cart);
		$cart_total	= $this->session->userdata['cart_total'];
		$this->session->set_userdata('cart_total',$cart_total-1);
		
		$total_mf	= (isset($cart['order_mf_qty']))?$cart['order_mf_qty']:0;
		$total_pf	= (isset($cart['order_pf_qty']))?$cart['order_pf_qty']:0;
		
		$total_order_price = number_format(($cart_total-1)*4.75 + $total_mf * 6.25 + $total_pf * 3.5,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		if($last > 0){
			$last = trim($last,'0');
		}
		$total_price = $first.'.'.$last;
		
		$data = array(
			'total_badges'		=> $cart_total-1,
			'total_order_price' => $total_price
		);
		
		echo json_encode($data);
		
	}
	
	function deleteExtras() {
		$type 	= $this->input->post('type');
		$cart	= $this->session->userdata['cart'];
		
		$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
		$badges_cost	= $total_badges*4.75;
		$extras_cost	= 0;
		switch ($type) {
			
			case '1':
				unset($cart['order_mf_qty']);
				$extras_cost = isset($cart['order_pf_qty']) ? $cart['order_pf_qty'] * 3.5: 0; 
			break;
			case '2':
				unset($cart['order_pf_qty']);
				$extras_cost = isset($cart['order_mf_qty']) ? $cart['order_mf_qty'] * 6.25: 0;
			break;
		}
		
		$this->session->set_userdata('cart',$cart);
		$data = array(
			'removed_item'		=> $type,
			'total_extras'		=> (!isset($cart['order_mf_qty'])&&!isset($cart['order_pf_qty'])) ? 0 : 1,
			'total_cost'		=> number_format($badges_cost + $extras_cost,2)
		);
		echo json_encode($data);
	}
	
	function deleteCart(){
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
	}
	
	function abcxyz() {
		$this->load->view('order/list_extras');
	}
	
	function changeStoreShippingAddress() {
		$store_id = $this->input->post('store_id');
		if($store_id!="") {
			$this->load->model('store/store_model');
			$store	= $this->store_model->getStoreDetail(array('store_id'=>$store_id));
			
			$data['store']	= $store;
			$this->load->view('shipping_address',$data);
		} else {
			echo "";
		}
	}
}