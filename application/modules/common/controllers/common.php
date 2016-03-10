<?php
class Common extends MX_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function showMenu(){
		$store	= $this->session->userdata['store'];
		
		$this->db->join('stores','stores.store_id = orders.store_id');
		$this->db->where('stores.store_assigned',(int)$store->store_id);
		$this->db->where('orders.order_status',1);
		$query	= $this->db->get('orders');
		$orders	= $query->result();
		
		$data['store']		= $store;
		$data['pending']	= count($orders);
		$this->load->view('common/menu',$data);
	}
	
	function showPopup() {
		$this->load->view('common/popup');
	}
}