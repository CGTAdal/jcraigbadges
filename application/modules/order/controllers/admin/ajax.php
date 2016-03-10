<?php
class Ajax extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			echo "You don't have permission";
		}
		$this->load->model('order_model');
	}
	
	function updateOrderStatus(){
		$order_id 		= $this->input->post('order_id');
		$status			= $this->input->post('status');
		if($status == 2) {
			$date_approve 	= time();
		} else {
			$date_approve 	= '';
		}
		$data = array('order_status'=>(int)$status,'order_approve_dated'=>$date_approve);
		if($this->order_model->saveItem('orders',array('field'=>'order_id','id'=>$order_id),$data)) {
			if($status == 1) {
				echo 1;
			} else if($status ==2) {
				echo 2;
			} else if($status ==3) {
				echo 3;
			}
		} else {
			echo 0;
		}
	}
	
	function resend_approval() {
		$order_id 	= $this->input->post('order_id');
		$orders		= $this->order_model->getOrderList(array('order_id'=>$order_id));
		$order		= $orders[0];
		if($order->director_id!="") {
			$this->load->model('store/store_model');
			$market_director	= $this->store_model->getStoreDetail(array('store_id'=>$order->director_id));
			
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] 	= 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
	
			if($market_director->store_email != "") {
				# from
				$this->email->from('support@bestnamebadges.com');
				# to
				$this->email->to($market_director->store_email);
				#set subject
				$subject	= '[Jenny Craig Badges] New Order Needs Your Approval';
				#set content
				$link		= base_url()."order/approvaldetail/{$order->order_id}/{$order->order_code}";
				$message	= "You have 1 new order that needs your immediate attention. Please review this order by clicking on the following link: <br/>{$link}<br/></br/>
				You must \"Approve\" this order before it is processed and shipped.<br/><br/>
				If you require assistance, please reply to this email.<br/><br/>
				Cordially,  <br />
				Best Name Badges <br />";
				$this->email->subject($subject);
				$this->email->message($message);
				#sending email
				$sending	= $this->email->send();
				echo 1;
				return;
			}
		}
		echo 0;
		return;
	}
}