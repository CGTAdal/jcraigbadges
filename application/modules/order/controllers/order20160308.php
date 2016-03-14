<?php
class Order extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		if(!isset($this->session->userdata['store']) && $this->uri->segment('4')=="") {
			redirect('');
		}
		$this->load->model('order_model');
	}
	
	function add() {
		$order_customer = (string)$this->input->post('order_customer');
		if(!isset($this->session->userdata['cart'])) {
			redirect('order/select');
		}
		
		$cart	= $this->session->userdata['cart'];
		//$total	= (isset($cart['badges'])) ? count($cart['badges']) : 0;
		$total	= $this->session->userdata('cart_total') ? $this->session->userdata('cart_total') : 0;
		$total_tenured = $this->session->userdata('tenured_total') ? $this->session->userdata('tenured_total') : 0;
			
		$store	= $this->session->userdata['store'];
		#set shipping address
		$shipping	= array();
		if($this->input->post('selected_store') && $store->store_role==2) {
			$selected_store_id	= $this->input->post('selected_store');
			$this->load->model('store/store_model');
			$selected_store		= $this->store_model->getStoreDetail(array('store_id'=>$selected_store_id));
			$shipping['attn']	 		= 'Centre Director';
			$shipping['selected_store']	= $selected_store->store_number;
			$shipping['address'] 		= $selected_store->store_address;
			$shipping['city']	 		= $selected_store->store_city;
			$shipping['state']	 		= $selected_store->store_state;
			$shipping['zip']	 		= $selected_store->store_zip;
		} else {
			$shipping['attn']	 		= 'Centre Director';
			$shipping['selected_store']	= $store->store_number;
			$shipping['address'] 		= $store->store_address;
			$shipping['city']	 		= $store->store_city;
			$shipping['state']	 		= $store->store_state;
			$shipping['zip']	 		= $store->store_zip;
		}
		
		#set input data
		$data	= array();		
		$data['store_id']			= $store->store_id;
		$data['order_customer']		= $order_customer;
		$data['order_total']		= $total;
		$data['order_tenured_qty']	= $total_tenured;
		$data['order_items']		= serialize(isset($cart['badges']) ? $cart['badges'] : 0);	 
		$data['order_date']			= time();
		$data['order_shipping']		= serialize($shipping);
		$data['order_mf_qty']		= $total_mf = (isset($cart['order_mf_qty'])) ? $cart['order_mf_qty'] : 0;
		$data['order_pf_qty']		= $total_pf = (isset($cart['order_pf_qty'])) ? $cart['order_pf_qty'] : 0;
		$data['order_cost']			= number_format($total * 4.75 + $total_tenured * 6.25 + $total_mf * 6.25 + $total_pf * 3.5,2);

		$data['order_mf_qty']	= (isset($cart['order_mf_qty'])) ? $cart['order_mf_qty'] : 0;
		$data['order_pf_qty']	= (isset($cart['order_pf_qty'])) ? $cart['order_pf_qty'] : 0;

		# calculate tax
		if($shipping['state']=='FL') {
			$data['order_tax'] = $data['order_cost'] * 0.06;
		}
		
		if($store->store_role==2) 
			$data['order_status'] = 2;
			$data['order_approve_dated'] = time();
		# generate random code
		$this->load->helper('mystring');
		$code = rand_md5(32);

		$data['order_code'] = $code;
		
		# save order into database
		$orderId = $this->order_model->saveItem('orders',array('id'=>0),$data);
		
		if($orderId && $store->store_role==1) {
			#send mail to user
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] 	= 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
	
			#get market director email 
			$this->load->model('store/store_model');
			$market_director = $this->store_model->getStoreDetail(array('store_id'=>$store->store_assigned));
			
			if(count($market_director) > 0 && $market_director->store_email != "") {
				# from
				$this->email->from('support@bestnamebadges.com');
				# to
				$this->email->to($market_director->store_email);
				#set subject
				$subject	= '[Jenny Craig Badges] New Order Needs Your Approval';
				#set content
				$link		= base_url()."order/approvaldetail/{$orderId}/{$code}";
				$message	= "You have 1 new order that needs your immediate attention. Please review this order by clicking on the following link: <br/>{$link}<br/></br/>
				You must \"Approve\" this order before it is processed and shipped.<br/><br/>
				If you require assistance, please reply to this email.<br/><br/>
				Cordially,  <br />
				Best Name Badges <br />";
				$this->email->subject($subject);
				$this->email->message($message);
				#sending email
				$sending	= $this->email->send();
			}
		}
		
		# unset session
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
		$this->session->unset_userdata('new_attn');
		$this->session->unset_userdata('tenured_total');
		
		#load view
		$data['orderId']		= $orderId;
		$data['content']		= 'thanks';
		$this->load->view('front_end/index',$data);
	}
	
	function approvaldetail($orderId,$orderCode="") {
		if($orderCode!="") {
			$filter = array(
				'order_id' 		=> $orderId,
				'order_code'	=> $orderCode
			);
			# get order detail
			$order	= $this->order_model->getOrderDetail($filter);
			
			if(count($order) > 0) {
				$this->load->model('store/store_model');
				$filter = array('store_id' => $order->store_id);
				$store 	= $this->store_model->getStoreDetail($filter);
				
				$filter 	= array('store_id' => $store->store_assigned);
				$director 	= $this->store_model->getStoreDetail($filter);
				
				$current_director_logged_in = $this->session->userdata('store');
				if($current_director_logged_in && $current_director_logged_in->store_id != $director->store_id) {
					redirect('');
				} else {
					$this->session->set_userdata('store',$director);
					##
					if($this->input->post('submit') && $order->order_status!=2) {
						$submit = $this->input->post('submit');
						if($submit=="DENY") {
							$data['order_status'] = 3;
						} else if($submit=="APPROVE") {
							$data['order_status'] = 2;
							$data['order_approve_dated'] = time();
						}
						$this->order_model->saveItem('orders',array('field'=>'order_id','id'=>(int)$orderId),$data);
					}
					$filter = array('order_id' => $orderId);
					$order	= $this->order_model->getOrderDetail($filter);
					##
				}
			} else {
				redirect('');
			}
			
		} else {
			$filter = array('order_id' => $orderId);
	
			$account = $this->session->userdata['store'];
			
			$filter['store_assigned'] = $account->store_id;
			
			# get order detail
			$order	= $this->order_model->getOrderDetail($filter);
			
			if(count($order)<=0)
				redirect();
			if($this->input->post('submit') && $order->order_status!=2) {
				$submit = $this->input->post('submit');
				if($submit=="DENY") {
					$data['order_status'] = 3;
				} else if($submit=="APPROVE") {
					$data['order_status'] = 2;
					$data['order_approve_dated'] = time();
				} 
				$this->order_model->saveItem('orders',array('field'=>'order_id','id'=>(int)$orderId),$data);
			}
			
			$order	= $this->order_model->getOrderDetail($filter);
			
		}
		
		# order's items
		$order_items = unserialize($order->order_items);
		# badges
		$order_badges	= isset($order_items['badges'])?$order_items['badges']:$order_items;
		# total badges
		$total_badges	= $order->order_total;

		$shipping	= (count($order)>0)?unserialize($order->order_shipping):'';

		#load view
		$data['order']	 		= $order;
		$data['total_badges']	= $total_badges;
		$data['total_mf']		= $order->order_mf_qty;
		$data['total_pf']		= $order->order_pf_qty;
		$data['shipping']		= $shipping;
		$data['content'] 		= 'detail_approval';
		$this->load->view('front_end/index',$data);
	}
	
	function detail($orderId) {
		$filter = array('order_id' => $orderId);

		$account = $this->session->userdata['store'];
		
		$filter['store_id'] = $account->store_id;
		
		# get order detail
		$order	= $this->order_model->getOrderDetail($filter);
		if(count($order)<=0)
			redirect();

		$order	= $this->order_model->getOrderDetail($filter);
		# order's items
		$order_items = unserialize($order->order_items);
		# badges
		$order_badges	= isset($order_items['badges'])?$order_items['badges']:$order_items;
		# total badges
		$total_badges	= $order->order_total;
		# total extras magnetic
		$total_magnetic_fasteners = $order->order_mf_qty;
		# total extras pin
		$total_pin_fasteners	  = $order->order_pf_qty;
		# shipping info
		$shipping	= (count($order)>0)?unserialize($order->order_shipping):'';
		# billing info
		$billing	= (count($order)>0)?unserialize($order->order_billing):'';

		#load view
		$data['order']	 		= $order;
		$data['total_badges']	= $total_badges;
		$data['total_tenured']	= $order->order_tenured_qty;
		$data['total_mf']		= $total_magnetic_fasteners;
		$data['total_pf']		= $total_pin_fasteners;
		$data['shipping']		= $shipping;
		$data['billing']		= $billing;
		$data['content'] 		= 'detail';
		$this->load->view('front_end/index',$data);
	}
	
	function listOrders() {
		$account = $this->session->userdata['store'];
		
		$attributes = array();
		$attributes['where']	= "store_id = ".(int)$account->store_id;
		$attributes['order_by']	= array('order_id','DESC');
		$orders	= $this->order_model->getItemList('orders',$attributes);	
		
		$data['orders']		= $orders;
		$data['content']	= 'list';
		$this->load->view('front_end/index',$data);
	}
	
	function listApprovals() {
		$account = $this->session->userdata['store'];
		
		$filter = array('store_assigned'=>(int)$account->store_id);
		$filter['order_by'] = array('field'=>'order_id','sort_type'=>'desc');
		$orders	= $this->order_model->getOrderList($filter);
		
		$data['orders']		= $orders;
		$data['content']	= 'list_approvals';
		$this->load->view('front_end/index',$data);
	}
	
	function select() {
		//echo strlen(md5(trim(addslashes('jcpbadgeS123')));
		$store	= $this->session->userdata['store'];
		$items	= $this->order_model->getItemList('items',array('where'=>'item_status = 1','order_by'=>array('item_order','asc')));
		$cart	= (isset($this->session->userdata['cart']))?$this->session->userdata['cart']:array();
		
		$titles	= array(
			'licensed optician'				=> 'license optician',
			'licensed optician manager'		=> 'licensed optician manager',
			'apprenticed optician'			=> 'apprenticed optician',
			'licensed dispensing optician' 	=> 'licensed dispensing optician',
			'optical lead expert'			=> 'optical lead expert',
			'optical specialist'			=> 'optical specialist'
		);
		
		$new_options = array(
			'jcpenney'		=> 'jcpenney',
			'lead expert'	=> 'lead expert',
			'expert'		=> 'expert',
			'specialist'	=> 'specialist'
		);
		
		$mf_qty = (isset($cart['order_mf_qty']) && $cart['order_mf_qty'] > 0 ) ? $cart['order_mf_qty'] : 0;
		$pf_qty = (isset($cart['order_pf_qty']) && $cart['order_pf_qty'] > 0 ) ? $cart['order_pf_qty'] : 0;
		
		$data['store_number']	= $store->store_number;
		$data['store_minor']	= $store->store_minor;
		$data['store_role']		= $store->store_role;
		$data['store_aor']		= '007900';
		$data['items']			= $items;
		$data['cart']			= $cart;
		$data['mf_qty']			= $mf_qty;
		$data['pf_qty']			= $pf_qty;
		$data['titles']			= $titles;
		$data['new_options']	= $new_options;
		$data['content'] 		= 'default';
		$this->load->view('front_end/index',$data);
	}
	
	function detailOrderBox() {
		$order_uri = (string)$this->uri->segment(2);
		
		if($order_uri == 'shipping')
		{
			if(!isset($this->session->userdata['cart']))
			{
				redirect('order/select');
			}
			else
			{
				$cart	= $this->session->userdata['cart'];
				if(count($cart)<=0)
					redirect('order/select');
			}
			$cart = $this->session->userdata['cart'];
			
			$mf_qty = (isset($cart['order_mf_qty']) && $cart['order_mf_qty'] > 0 ) ? $cart['order_mf_qty'] : 0;
			$pf_qty = (isset($cart['order_pf_qty']) && $cart['order_pf_qty'] > 0 ) ? $cart['order_pf_qty'] : 0;
			
			$badges = (isset($cart['badges']) && count($cart['badges']) > 0 )? $cart['badges'] : 0;
			
			$data['remove_cart'] 	= $order_uri;
			$data['cart'] 			= $cart;
			$data['badges']			= $badges;
			$data['mf_qty']			= $mf_qty;
			$data['pf_qty']			= $pf_qty;
		}
		
		if($order_uri == 'detail' || $order_uri == 'approvaldetail')
		{
			$id =(int)$this->uri->segment(3); 
			$order 			= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$id));
			$items			= (count($order)>0)?unserialize($order->order_items):'';			
			
			$data['cart'] 			= $items;
			$data['badges']			= count($items) > 0 ? $items : 0;
			$data['mf_qty']			= $order->order_mf_qty;
			$data['pf_qty']			= $order->order_pf_qty;
			$data['remove_cart'] 	= $order_uri;
		}		
			
		$this->load->view('order/detailBox',$data);
	}
	function shipping() { 
		if(!isset($this->session->userdata['cart'])) {
			redirect('order/select');
		}		
		// get account logged in 
		$account = $this->session->userdata['store'];
		if($account->store_role==1) { // if store 			
			$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
			// set attn
			$new_attn = '';
			if(!isset($this->session->userdata['new_attn'])|| $this->session->userdata['new_attn'] == ""){
				$new_attn = 'Store Leader';
			} else{
				$new_attn = $this->session->userdata['new_attn'];			
			}
			// get cart info
			$cart 	= $this->session->userdata['cart'];
			$badges	= isset($cart['badges'])?$cart['badges']:null;			
			$extras	= isset($cart['extras'])?$cart['extras']:null;
			$total_magnetic_fasteners = 0;
			$total_pin_fasteners	  = 0;
			if($extras) {
				foreach($extras as $item) {
					if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
					else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
				}
			}			
			$data['new_attn']       = $new_attn;
			$data['store']			= $account;
			$data['total_badges']	= $total_badges;
			$data['badges']			= $badges;
			$data['extras']			= $extras;
			$data['total_mf']		= $total_magnetic_fasteners;
			$data['total_pf']		= $total_pin_fasteners;
			$data['content']		= 'shipping';

			$this->load->view('front_end/index',$data);
		} else if($account->store_role==2) { // if market director
			$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
			
			$this->load->model('store/store_model');
			$filter = array('store_assigned'=>$account->store_id);
			$sub_stores = $this->store_model->getStoreList($filter);			
			// get cart info
			$cart 	= $this->session->userdata['cart'];
			$badges	= isset($cart['badges'])?$cart['badges']:null;			
			$extras	= isset($cart['extras'])?$cart['extras']:null;
			$total_magnetic_fasteners = 0;
			$total_pin_fasteners	  = 0;
			if($extras) {
				foreach($extras as $item) {
					if($item['type']=='magnetic fastener') $total_magnetic_fasteners += $item['qty'];
					else if($item['type']=='pin fastener') $total_pin_fasteners += $item['qty'];
				}
			}			
			$data['store']			= $account;
			$data['sub_stores']		= $sub_stores;
			$data['total_badges']	= $total_badges;
			$data['badges']			= $badges;
			$data['extras']			= $extras;
			$data['total_mf']		= $total_magnetic_fasteners;
			$data['total_pf']		= $total_pin_fasteners;
			$data['content']		= 'shipping_director';		
			$this->load->view('front_end/index',$data);	
		} else {
			// get cart info
			$cart	= $this->session->userdata['cart'];
			// count total amount
			$total		= $this->session->userdata('cart_total') ? $this->session->userdata('cart_total') : 0;
			// total tenured 
			$total_tenured = $this->session->userdata('tenured_total') ? $this->session->userdata('tenured_total') : 0;
			
			$total_mf	= (isset($cart['order_mf_qty']))?$cart['order_mf_qty']:0;
			$total_pf	= (isset($cart['order_pf_qty']))?$cart['order_pf_qty']:0;			
			if($this->input->post('submit')) {
				if(!isset($this->session->userdata['cart'])) { // if cart is empty
					redirect('order/select');
				}
				$amount 	= number_format($total * 4.75 + $total_tenured * 6.25 + $total_mf * 6.25 + $total_pf * 3.5,2);
				// get billing info
				$billing	= array();
				$billing['fname']	= $this->input->post('fname',true);
				$billing['lname']	= $this->input->post('lname',true);
				$billing['phone']	= $this->input->post('phone',true);
				$billing['address']	= $this->input->post('address',true);
				$billing['city']	= $this->input->post('city',true);
				$billing['state']	= $this->input->post('state',true);
				$billing['zip']		= $this->input->post('zip',true);
				
				// do the payment
				/*require_once getcwd().'/application/braintree/lib/Braintree.php';
				#Braintree_Configuration::environment('sandbox');
				#Braintree_Configuration::merchantId('y4b39ygj5tsmsrhm');
				#Braintree_Configuration::publicKey('hc3tx7dpwftgy6yc');
				#Braintree_Configuration::privateKey('ktsvdyd4rmnjfphr');
				Braintree_Configuration::environment('production');
				Braintree_Configuration::merchantId('952ff2n634sv6zdf');
				Braintree_Configuration::publicKey('8qbw39w6nqhjvzwb');
				Braintree_Configuration::privateKey('vgfjkvmx2rndd9qt');
				$result = Braintree_Transaction::sale(array(
				  	'amount' => $amount,
				  	'creditCard' => array(
					    'number' 			=> $this->input->post('credit_card_number',true),
					    'expirationDate' 	=> $this->input->post('expiration_month',true)."/".$this->input->post('expiration_year',true),
					    //'expirationDate' 	=> '01/2014',
						'cardholderName'	=> $this->input->post('credit_card_firstname',true)." ".$this->input->post('credit_card_lastname',true),
						'cvv'				=> $this->input->post('credit_card_cvv2')
					  	),
					'billing' => array(
					    'firstName' 		=> $billing['fname'],
					    'lastName' 			=> $billing['lname'],
					    'streetAddress' 	=> $billing['address'],
					    'locality' 			=> $billing['city'],
					    'postalCode' 		=> $billing['zip']
						),
					'options' => array(
					    'submitForSettlement' => true
					  	)
					)
				);*/
				require_once(getcwd().'/application/payeezy/payeezy_payment.php');
			    $paybilling =  new stdClass();
			    /* get customer email*/
			    $qry1 = "SELECT store_email FROM ci_stores WHERE store_id = ".$this->session->userdata['store']->store_id;   
			    $custemail = mysql_query($qry1) or die('Query failed: ' . mysql_error()); 
			    $custdata = mysql_fetch_assoc($custemail); 
			    $array = array('address'=>$billing['address'],'city'=>$billing['city'],'state'=>$billing['state'],'zip'=>$billing['zip']);
			  
			   foreach ($array as $key => $value)
			    {
			        $paybilling->$key = $value;
			    }	
			    
			    $payment = new Payment();
			    $payment->cc_name = $this->input->post('credit_card_firstname',true)." ".$this->input->post('credit_card_lastname',true);
			    $payment->cc_number = $this->input->post('credit_card_number',true);
			    $payment->cc_cvv = $this->input->post('credit_card_cvv2');
			    $payment->cc_type = $this->input->post('credit_card_type');
			    $payment->cc_month = $this->input->post('expiration_month',true);
			    $payment->merchant_ref = "Badges Order";
			    $payment->amount = $amount;
			    $payment->cc_year = $this->input->post('expiration_year',true);
			    $payment->email = $custdata['store_email'];
			    $result = $payment->charge($paybilling); 

				if ($result['success'] == true) {
					$store	= $this->session->userdata['store'];					
					#set shipping address
					$shipping	= array();
					$shipping['attn']	 		= $store->store_location_name;
					$shipping['selected_store']	= $store->store_number;
					$shipping['address'] 		= $store->store_address;
					$shipping['city']	 		= $store->store_city;
					$shipping['state']	 		= $store->store_state;
					$shipping['zip']	 		= $store->store_zip;
					
					#set input data
					$data	= array();		
					$data['store_id']			= $store->store_id;
					$data['order_customer']		= '';
					$data['order_total']		= $total;
					$data['order_tenured_qty']	= $total_tenured;
					$data['order_items']		= serialize(isset($cart['badges']) ? $cart['badges'] : 0);	 
					$data['order_date']			= time();
					$data['order_shipping']		= serialize($shipping);
					$data['order_billing']		= serialize($billing);
					$data['order_cost']			= $amount;
			
					$data['order_mf_qty']	= (isset($cart['order_mf_qty'])) ? $cart['order_mf_qty'] : 0;
					$data['order_pf_qty']	= (isset($cart['order_pf_qty'])) ? $cart['order_pf_qty'] : 0;
					
					$data['order_status'] = 2;
					$data['order_approve_dated'] = time();
					
					# save order into database
					$orderId = $this->order_model->saveItem('orders',array('id'=>0),$data);
					
					# unset session
					$this->session->unset_userdata('cart');
					$this->session->unset_userdata('cart_total');
					$this->session->unset_userdata('tenured_total');
					$this->session->unset_userdata('new_attn');
					
					#load view
					$data['orderId']		= $orderId;
					$data['total_badges']	= $total;
					$data['total_tenured']	= $total_tenured;
					$data['total_mf']		= $total_mf;
					$data['total_pf']		= $total_pf;
					$data['account_type']	= 3;
					$data['content']		= 'thanks';
					$this->load->view('front_end/index',$data);
					return;
				} else if ($result['error']) {
					//$data['payment_error'] = $result->message;
					$data['payment_error'] = rawurlencode($result['error']);
				}
			}
			
			$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
			$total_tenured = $this->session->userdata('tenured_total') ? $this->session->userdata('tenured_total') : 0;
			
			// get cart info
			$cart 	= $this->session->userdata['cart'];
			$badges	= isset($cart['badges'])?$cart['badges']:null;
			
			$data['store']			= $account;
			$data['badges']			= $badges;
			$data['total_badges']	= $total_badges;
			$data['total_tenured']	= $total_tenured;			
			$data['total_mf']		= $total_mf;
			$data['total_pf']		= $total_pf;
			$data['content']		= 'shipping_franchise';		
			$this->load->view('front_end/index',$data);
		}
	}
}