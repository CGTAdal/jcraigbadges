<?php
class Store extends MX_Controller {
	
	var $error_messages = "";
	var $markets = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('store_model');
	}
		
	function login() {
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			if($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('store_number', 'Store number', 'required');
				if($this->form_validation->run()) {
					$number	= $this->input->post('store_number',true);
					$store 	= $this->store_model->getStoreDetail(array('store_number'=>$number,'store_role'=>1));
					if(count($store)>0) {
						$this->session->set_userdata('store', $store);
						redirect('order/select');
					} else {
						$this->error_messages = "Centre Number Does Not Exist.";
					}
				}
				
			}
			$data['content'] 		= 'login';
			$data['error_messages']	= $this->error_messages;
			$this->load->view('front_end/index',$data);
		}
	}
	
	function edit_account() {
		$store = $this->session->userdata('store');
		if($store->store_role!=3) {
			redirect('order/select');
		}

		if($this->input->post('submit')) {
			$data = array();		
			$data['store_location_name']= $this->input->post('name');		
			$data['store_address'] 		= $this->input->post('mailing_address');
			$data['store_address_2'] 	= $this->input->post('line2');
			$data['store_city'] 		= $this->input->post('city');
			$data['store_state']		= $this->input->post('state');
			$data['store_zip'] 			= $this->input->post('zip');
			$data['store_phone'] 		= $this->input->post('phone');			
			
			$store_id = $this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$store->store_id),$data);
			
			$store 	= $this->store_model->getStoreDetail(array('store_id'=>$store_id));
			$this->session->set_userdata('store',$store);
		}
		
		$data['store']		= $store;
		$data['content']	= 'franchise_edit';
		$this->load->view('front_end/index',$data);
	}
	
	function market_login(){
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			if($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('market_number', 'Market Number', 'required');
				if($this->form_validation->run()) {
					$number	= $this->input->post('market_number',true);
					$store 	= $this->store_model->getStoreDetail(array('store_number'=>$number,'store_role'=>2));
					
					if(count($store)>0) {
						$pw 	= $this->input->post('password',true);
						$md5_pw	= md5($pw);
						if(($pw=="" && $store->store_password=="") || ($pw!="" && $store->store_password!="" && $md5_pw==$store->store_password)) {
							$this->session->set_userdata('store', $store);
							redirect('order/select');
						} else {
							$this->error_messages = "Password is not correct. Please enter it again.";
						}
					} else {
						$this->error_messages = "Market Number does not exist.";
					}
				}
				
			}
			
			$data['error_messages']	= $this->error_messages;
			$data['content'] = 'market_login';
			$this->load->view('front_end/index',$data);
		}
		
	}
	
	function franchise_login(){
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			if($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('franchise_number', 'Franchise Centre Number', 'required');
				if($this->form_validation->run()) {
					$number	= $this->input->post('franchise_number',true);
					$store 	= $this->store_model->getStoreDetail(array('store_number'=>$number,'store_role'=>3));
					
					if(count($store)>0) {
						$pw 	= $this->input->post('password',true);
						$md5_pw	= md5($pw);
						if(($pw=="" && $store->store_password=="") || ($pw!="" && $store->store_password!="" && $md5_pw==$store->store_password)) {
							$this->session->set_userdata('store', $store);
							redirect('order/select');
						} else {
							$this->error_messages = "Password is not correct. Please enter it again.";
						}
					} else {
						$this->error_messages = "Franchise Number does not exist.";
					}
				}
				
			}
			
			$data['error_messages']	= $this->error_messages;
			$data['content'] = 'franchise_login';
			$this->load->view('front_end/index',$data);
		}
	}
	
	function franchise_signup() {
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			if($this->input->post('submit')) {
				$data = array();		
				$data['store_location_name']= $this->input->post('name');		
				$data['store_address'] 		= $this->input->post('mailing_address');
				$data['store_address_2'] 	= $this->input->post('line2');
				$data['store_city'] 		= $this->input->post('city');
				$data['store_state']		= $this->input->post('state');
				$data['store_zip'] 			= $this->input->post('zip');
				$data['store_phone'] 		= $this->input->post('phone');			
				$data['store_email'] 		= $this->input->post('email');
				$data['store_number'] 		= $this->input->post('number');
				$data['store_role']			= 3;
				$data['store_password']		= ($this->input->post('password')) ? md5(trim($this->input->post('password'))) : '';
				
				$store_id = $this->store_model->saveItem('stores',array('id'=>0),$data);
				
				$store 	= $this->store_model->getStoreDetail(array('store_id'=>$store_id));
				
				$this->session->set_userdata('store', $store);
				redirect('order/select');
				
			}
		}
		$data['content']	= 'franchise_signup';
		$this->load->view('front_end/index',$data);
	}
	
	function market_change_password() {
		if($this->input->post('submit')) {
			$store_number = $this->input->post('mk_number',true);
			
			$account = $this->store_model->getStoreDetail(array('store_number'=>$store_number));
	
			if(count($account) > 0) {
				$old_pw			= $this->input->post('old_password');
				if($account->store_password!="" && $account->store_password != md5($old_pw)) {
					$this->error_messages = "Password doesn't match. Please check it again";
					$data['mk_number'] = $store_number;					
				} else {
					$new_pw = $this->input->post('new_password',true);
					$data = array('store_password' => md5(trim($new_pw)));
					$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$account->store_id),$data);
					$this->error_messages = "Your password has been updated successfully. Please click <a href='".base_url()."store/market_login'>here</a> to login";
				}
			} else {
				$data['mk_number'] = $store_number;
				$this->error_messages = "Market Number Does Not Exist.";
			}
		}
		
		$data['error_messages'] = $this->error_messages;
		$data['content'] = 'market_change_password';
		$this->load->view('front_end/index',$data);
	}
	
	function franchise_change_password() {
		if($this->input->post('submit')) {
			$store_number = $this->input->post('fc_number',true);
			
			$account = $this->store_model->getStoreDetail(array('store_number'=>$store_number));
	
			if(count($account) > 0) {
				$old_pw	= $this->input->post('old_password');
				if($account->store_password!="" && $account->store_password != md5($old_pw)) {
					$this->error_messages = "Password doesn't match. Please check it again";
					$data['fc_number'] = $store_number;					
				} else {
					$new_pw = $this->input->post('new_password',true);
					$data = array('store_password' => md5(trim($new_pw)));
					$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$account->store_id),$data);
					$this->error_messages = "Your password has been updated successfully. Please click <a href='".base_url()."store/franchise_login'>here</a> to login";
				}
			} else {
				$data['fc_number'] = $store_number;
				$this->error_messages = "Franchise Centre Number does not exist.";
			}
		}
		
		$data['error_messages'] = $this->error_messages;
		$data['content'] = 'franchise_change_password';
		$this->load->view('front_end/index',$data);
	}
	
	function logout() {
		$this->session->unset_userdata('new_attn');
		$this->session->unset_userdata('store');
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('cart_total');
		$this->session->unset_userdata('tenured_total');
		redirect('store/login');
	}

	function update_excel_data() {
		// echo BASEPATH.'../'; exit;
		require_once 'excel_reader2.php';
		// $filename = BASEPATH."../application/modules/store/controllers/newdata.xls";
		$filename = BASEPATH."../_newdata.xls";
		$data = new Spreadsheet_Excel_Reader($filename);

		$sheet_index = 0;
		$totalrow = $data->rowcount($sheet_index);
		$totalcol = $data->colcount($sheet_index);
		$error_log = array();

		for ($row=2; $row <= $totalrow; $row++) { 
			$storedata = array();
			$marketId = 0;

			for ($col=1; $col <= $totalcol; $col++) { 
				echo $data->val($row,$col,$sheet_index).' || ';

				$value = $data->val($row,$col,$sheet_index);
				switch($col){
					case 1:
						// $storedata['store_ground'] = $value;
					break;
					case 2:
						$value = explode(" ", $value);
						$value = $value[0];
						$marketId = $this->isMarketExists($value);
						if(!$marketId){
							$marketId = $this->createMarket($value);
						}
						if($marketId>0)
						$storedata['store_assigned'] = $marketId;
					break;
					case 3:
						$storedata['store_number'] = $value;
					break;
					case 4:
						$storedata['store_location_name'] = $value;
					break;
					case 5:
						$storedata['store_address'] = $value;
					break;
					case 6:
						$storedata['store_city'] = $value;
					break;
					case 7:
						$storedata['store_state'] = $value;
					break;
					case 8:
						$storedata['store_zip'] = $value;
					break;
					case 9:
						$storedata['store_phone'] = $value;
					break;
					
				}
				$storedata['store_role'] = 1;
			}
			echo ' </br>';
			if($marketId>0){
				$storedata['store_password'] = '';
				$this->store_model->saveItem('stores',array('id'=>0),$storedata);	
			}else{
				$error_log[] = $storedata;
			}
			// if($row>30)
			// break;
		}
		echo '<br/> ERRORS: </br>';
		print_r($error_log);
		$data['data'] = 'demo';
		$data['content'] = 'update_excel_data';
		$this->load->view('front_end/index',$data);
	}

	protected function isMarketExists($matchkey){
		foreach ($this->markets as $key => $values) {
			if($values['value'] == $matchkey){
				return $values['id'];
			}
		}
		return false;
	}
	protected function createMarket($value){
		$storedata = array();
		$storedata['store_role'] = 2;
		$storedata['store_number'] = $value;
		$storedata['store_password'] = md5(trim('supplies'));
		$id = $this->store_model->saveItem('stores',array('id'=>0),$storedata);
		$this->markets[] = array('id'=>$id,'value'=>$value);
		return $id;
	}
	
}