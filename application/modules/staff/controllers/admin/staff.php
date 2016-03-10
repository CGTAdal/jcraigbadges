<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Staff extends MX_Controller {
	
	var $staff_table 			= "admin";
	var $error_login 			= "";	
	var $error_confirm_password = "";
	var $error_full				= "";
	var $error_old				= "";
	function __construct() 
	{
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			redirect('admin/login');
		}
		if($this->session->userdata('role')!=0){
			redirect('admin');
		}		
		$this->load->model('staff_model');		
	}
	function listviews(){
		$data['staffs']		= $this->staff_model->getStaffList();	
		$data['content'] 	= 'admin/list';		
		$this->load->view('back_end/index',$data);	
	}
	function add(){		
		
		if($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('admin_login', 'Login');			
			$this->form_validation->set_rules('admin_password', 'PassWord');
			$this->form_validation->set_rules('confirm_password', 'Confirm PassWord');
			if($this->form_validation->run()) {
				$login 				= $this->input->post('admin_login');
				$password 			= $this->input->post('admin_password');
				$confirm_password 	= $this->input->post('confirm_password');
				if($login==''||$password==''||$confirm_password==''){
					$this->error_full = "<span style='float:left; margin-left:200px'><font color='red'>Please enter full information!</font></span>";								
				}else if($password != $confirm_password){
					$this->error_confirm_password = "<span style='float:left; margin-left:200px'><font color='red'>Confirm password Wrong! Pleased enter again!</font></span>";
				}else{				
					$user = $this->staff_model->getItemDetail('admin',array('field'=>'admin_login','id'=>$login),'');
					if(count($user)>0){
						$this->error_login = "<span style='float:left; margin-left:200px'><font color='red'>User login exist! Please enter user login again!</font></span>";
					}else{
						$mode 					= $this->input->post('mode');
						$button 				= $this->input->post('button_edit');		
						$id 					= (int)$this->input->post('admin_id');
						$data 					= array();
						$data['admin_login'] 	= $this->input->post('admin_login');		
						$data['admin_role']   	= 2;	
						$data['admin_password'] = md5(trim(addslashes($this->input->post('admin_password'))));					
						if($button == "Save"){
							$this->staff_model->saveItem('admin',array('id'=>0),$data);	
							redirect('admin/staff/listviews');
						}
					}		
				}		
			}			
		}
		$data['mode'] = 'add';
		$data['error_login'] 				= $this->error_login;
		$data['error_full'] 				= $this->error_full;
		$data['error_confirm_password'] 	= $this->error_confirm_password;
		$data['content'] 					= 'admin/add';	
		$this->load->view('back_end/index',$data);
	}
	function edit($id){		
		if($this->input->post()) {		
			$this->load->library('form_validation');			
			$this->form_validation->set_rules('admin_password_old', 'PassWord old');
			$this->form_validation->set_rules('new_password', 'PassWord new');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new PassWord');						
			if($this->form_validation->run()) {
				$login 						= $this->input->post('admin_login');
				$password_old 				= $this->input->post('admin_password_old');
				$password_new 				= $this->input->post('new_password');
				$confirm_new_password 		= $this->input->post('confirm_new_password');
				$password = md5(trim(addslashes($this->input->post('admin_password_old'))));				
				$user = $this->staff_model->getItemDetail('admin',array('field'=>'admin_password','id'=>$password),'');
				if($login==""||$password_old==""||$password_new==""||$password_new==""||$confirm_new_password==""){
					$this->error_full = "<span style='float:left; margin-left:200px'><font color='red'>Please enter full information!</font></span>";
				}else if($password_new != $confirm_new_password){
					$this->error_confirm_password = "<span style='float:left; margin-left:200px'><font color='red'>Confirm password Wrong! Pleased enter again!</font></span>";
				}else if(count($user)>0){					
					$button 				= $this->input->post('button_edit');		
					$id 					= (int)$this->input->post('admin_id');
					$data 					= array();
					$data['admin_login'] 	= $this->input->post('admin_login');		
					$data['admin_role']   	= 2;	
					$data['admin_password'] = md5(trim(addslashes($this->input->post('new_password'))));					
					if($button == "Save"){
						$this->staff_model->saveItem('admin',array('field'=>'admin_id','id'=>$id),$data);
						redirect('admin/staff/listviews');
					}else{
						$this->staff_model->saveItem('admin',array('field'=>'admin_id','id'=>$id),$data);
						redirect('admin/staff/edit/'.$id);
					}	
				}else{
					$this->error_old = "<span style='float:left; margin-left:200px'><font color='red'>Password old Wrong! Pleased enter again!</font></span>";
				}				
			}
		}
		$data['staff'] 						= $this->staff_model->getItemDetail('admin',array('field'=>'admin_id','id'=>$id));
		$data['error_full'] 				= $this->error_full;
		$data['error_old'] 					= $this->error_old;
		$data['error_confirm_password'] 	= $this->error_confirm_password; 
		$data['content'] 					= 'admin/edit';				
		$this->load->view('back_end/index',$data);
	}	
	function del($id=NULL){
		if($id == NULL){
			$id = (int)$this->uri->segment(4);
		}		
		$this->staff_model->deleteItem('admin',array('field'=>'admin_id','id'=>$id));
		redirect('admin/staff/listviews');	
	}
	
}