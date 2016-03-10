<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('admin_model');
	}
	
	function index() {
		if(!isset($this->session->userdata['admin'])){
			redirect('admin/login');
		}
		$data['username'] = $this->session->userdata('username');			
		redirect('admin/order/listorders');		
	}
	
	function login() {
		if(isset($this->session->userdata['admin'])){
			redirect('admin/index');
		}else{
			if($this->input->post()) {
				$this->load->library('form_validation');			
				$this->form_validation->set_rules('username', 'Admin', 'required');
				$this->form_validation->set_rules('password', 'password', 'required');					
				if($this->form_validation->run()!=false) {			
					$username	= $this->input->post('username');
					$password	= $this->input->post('password');
					$password	= md5(trim(addslashes($password)));
					$admin = $this->admin_model->getAdminDetail($username,$password);
					if(count($admin)>0) {
						$this->session->set_userdata('admin', $admin);
						$this->session->set_userdata('username',$admin->admin_login);
						$this->session->set_userdata('role',$admin->admin_role);					
						redirect('admin/index');										
					} else {
						echo '<script>alert("PassWord wrong!");window.location="'.base_url().'admin/login";</script>';
					}
				}
			}
			
			$data['content'] = 'login';
			$this->load->view('back_end/index',$data);
		}
	}	
	function logout() {
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('username');		
		$this->session->unset_userdata('admin');
		redirect('admin/login');
	}
}