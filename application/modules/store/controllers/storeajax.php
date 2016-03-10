<?php
class Storeajax extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('store_model');
		if(!isset($this->session->userdata['store'])) {
			return;
		}
	}
	
	function changeATTN() {
		#change db
		$new_attn = $this->input->post('new_attn',true);
		$store_id = $this->input->post('store_id',true);	
		//$data	  = array('store_attn'=>$new_attn);
		//$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$store_id),$data);

		#change session
		$store = $this->session->userdata['store'];
		$store->store_attn = $new_attn;
		$this->session->set_userdata('store',$store);		
		$this->session->set_userdata('new_attn',$new_attn);		
		 			
		echo $new_attn;
	}
	
	function login() {
		if(isset($this->session->userdata['store'])){
			redirect('order/select');
		}else{
			$store_number 	= $this->input->post('store_number',true);
			if($store_number!="") {
				$this->load->model('store_model');
				$store	= $this->store_model->getStoreDetail(array('store_number' => $store_number));
				
				if(count($store)<=0) {
					echo '0';
					return;
				}
				
				if($store->store_role==1) {
					$this->session->set_userdata('store',$store);
					echo '1';
				} else {
					echo '2';			
				}
			}
		}
	}

	function checkDirectorLogin() {
		$store_number 	= $this->input->post('store_number');
		$password		= $this->input->post('password');
		if($password && $password != "" && $store_number && $store_number != "") {
			$filter = array(
				'store_number' 	=> $store_number,
				'store_password'=> md5(trim($password))
			);
			$account = $this->store_model->getStoreDetail($filter);
			if(count($account) > 0) {
				$this->session->set_userdata('store',$account);
				echo '1';
			} else {
				echo '0';
			}
		}
	}
	
	function showPasswordForm() {
		$store_number = $this->input->post('store_number');
		$data['store_number'] = $store_number;
		$this->load->view('password_form',$data);
	}
	
	function resetPassword() {
		$store_number 	= $this->input->post('store_number',true);
		$store_role 	= (int)$this->input->post('store_role');
		$type = ($store_role==2)?'Market Number':'Franchise Centre Number';		
		
		$account = $this->store_model->getStoreDetail(array('store_number'=>$store_number, 'store_role'=>$store_role));

		if(count($account)<=0) {
			echo "This {$type} does not exist.";
			return false;
		}
		
		if($account->store_email != "") {
			$this->load->helper('mystring');
			$new_pass = rand_md5(12);
			
			#send mail 
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] 	= 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			# from
			$this->email->from('support@bestnamebadges.com');
			# to
			$this->email->to($account->store_email);
			#set subject
			$subject	= '[Jenny Craig Badges] New Password';
			#set content
			$message	= "Your new password is: {$new_pass} <br/><br/>
			Best Name Badges <br />";
			$this->email->subject($subject);
			$this->email->message($message);
			#sending email
			if($this->email->send()) {
				$data = array('store_password' => md5(trim($new_pass)));
				$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$account->store_id),$data);
				echo 'A new password was send to your email. Please check it.';
			} else {
				echo 'This function does not work now. Please try again later.';
			}
		} else {
			echo "This {$type} doesn't have email address. Please contact to the administrator to get your password.";
		}
	}
}