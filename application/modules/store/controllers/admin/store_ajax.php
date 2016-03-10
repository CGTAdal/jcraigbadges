<?php
class Store_Ajax extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('store_model');
	}

	function checkAccountNumber() {
		$number = $_REQUEST['fieldValue'];
		
		$filter = array('store_number'	=> $number);
		
		$account = $this->store_model->getStoreDetail($filter);

		$arrayToJs = array();
		
		$arrayToJs[0]	= $_REQUEST['fieldId'];
		$arrayToJs[1]	= count($account)>0 ? false : true;
		echo json_encode($arrayToJs);
	}
	
	function checkEmailExists() {
		$email 	= $this->input->post('fieldValue',true);
		$id		= $this->input->post('store_id');
		
		$filter 	= array('store_email' => $email);
		$account 	= $this->store_model->getStoreDetail($filter);
		
		$result = (count($account)>0 && !$id) || (count($account)>0 && $id != $account->store_id) ? false : true;
		
		$arrayToJs = array();
		$arrayToJs[0]	= $_REQUEST['fieldId'];
		$arrayToJs[1]	= $result;
		echo json_encode($arrayToJs);
	}
	
}