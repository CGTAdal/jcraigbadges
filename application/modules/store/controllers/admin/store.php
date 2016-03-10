<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store extends MX_Controller {
	
	var $order_table 	= 'stores';
	var $error_number 	= "";
	var $error_email 	= "";
	var $error_phone 	= "";
	var $error_full 	= "";
	
	function __construct() 
	{
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			redirect('admin/login');
		}
		$this->load->model('store_model');
		$this->load->model('order/order_model');		
	}
	
	function liststores(){
		$search_store_unit_number	= setSessionVariable($this->input->post('search_store_unit_number'), 'search_store_unit_number', '');		
		$search_store_type			= setSessionVariable($this->input->post('search_store_type'), 'search_store_type', 'all');
		$search_assigned_store		= setSessionVariable($this->input->post('search_assigned_store'), 'search_store_assigned', '');
		$perpage					= setSessionVariable($this->input->post('perpage'), 'store_on_per_page', 12);
		$offset						= ($this->uri->segment(4)=='')?0:$this->uri->segment(4);
		setSessionVariable($offset, "store_list_offset", 0);					
		$filter = array(		
			'offset'    	=> $offset,
			'perpage'   	=> $perpage,
			'store_number' 	=> $search_store_unit_number,
			'store_role'	=> $search_store_type,
			'store_assigned'=> $search_assigned_store
		);

		#Create pagintaion
		$store_total = $this->store_model->getStoreTotal($filter);		
		$this->load->library('pagination');
		$config['total_rows'] 		= $store_total;
		$config['per_page'] 		= $perpage;
		$config['first_link']		= 'First';
		$config['last_link']		= 'Last';
		$config['next_link']		= '';
		$config['prev_link']		= '';
		$config['num_tag_open']		= '<span style="padding:0 5px 0 5px">';
		$config['num_tag_close']	= '</span>';
		$config['num_links']		= 2;
		$config['cur_tag_open']		= '<span style="padding:0 5px 0 5px;color:#ffffff;background-color:#333333;">';
		$config['cur_tag_close']	= '</span>';
		$config['base_url']			= base_url().'admin/store/liststores/';
		$config['uri_segment']		= 4;
		$this->pagination->initialize($config); 
		$pagination	= $this->pagination->create_links();		
		#end create pagintation
		$stores = $this->store_model->getStoreList($filter);

		// get market directors 
		$filter = array('store_role' => 2);
		$market_directors = $this->store_model->getStoreList($filter);
		
		#$filter 	= array('store_role' => 1);
		#$store_list = $this->store_model->getStoreList($filter);
		
		$data['stores'] 					= $stores;
		$data['search_store_unit_number'] 	= $this->session->userdata['search_store_unit_number'];
		$data['search_store_type'] 			= $this->session->userdata['search_store_type'];
		$data['search_store_assigned']		= $this->session->userdata['search_store_assigned']; 
		$data['pagination'] 				= $pagination;
		$data['select_perpage'] 			= $this->session->userdata['store_on_per_page'];
		$data['market_directors']			= $market_directors;
		#$data['store_list']					= $store_list;
		$data['content']					= 'admin/list';
		$this->load->view('back_end/index',$data);
	}
	
	function detail($storeId){
		if($this->input->post('sort_type')) {
			$sort_type = $this->input->post('sort_type');
			switch($sort_type) {
				case 'store_order':
					if(isset($this->session->userdata['sort_store_order'])) {
						$current_type = $this->session->userdata['sort_store_order'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_store_order','asc');
						} else {
							$this->session->set_userdata('sort_store_order','desc');
						}
					} else {
						$this->session->set_userdata('sort_store_order','desc');
					}
					$this->session->set_userdata('sort_store_date','');				
					$order_by = array(
						'field'		=> 'order_id',
						'sort_type'	=> $this->session->userdata['sort_store_order']
					);
				break;
				case 'store_date':
					if(isset($this->session->userdata['sort_store_date'])) {
						$current_type = $this->session->userdata['sort_store_date'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_store_date','asc');
						} else {
							$this->session->set_userdata('sort_store_date','desc');
						}
					} else {
						$this->session->set_userdata('sort_store_date','desc');
					}
					$this->session->set_userdata('sort_store_order','');					
					$order_by = array(
						'field'		=> 'order_date',
						'sort_type'	=> $this->session->userdata['sort_store_date']
					);
				break;				
			}
		} else {
			setSessionVariable(false, 'sort_store_order', 'desc');
			setSessionVariable(false, 'sort_store_date', '');			
			$order_by = array(
				'field'		=> 'order_id',
				'sort_type'	=> 'desc'
			);
		}
		
		$store_date = $this->input->post('store_date');
		if($store_date != ""){
			$this->session->unset_userdata('store_date');
			$store_date = strtotime($store_date);
		}
		$store_date	= setSessionVariable($store_date, 'store_date', '');
		$search_store_order_id = setSessionVariable($this->input->post('search_store_order_id'), 'search_store_order_id', '');
		$search_store_order_total = setSessionVariable($this->input->post('search_store_order_total'), 'search_store_order_total', '');
		if($search_store_order_total != ''){
			$this->session->unset_userdata('search_store_order_total');
			$search_store_order_total = ($search_store_order_total-4.25)/2.75;
			$this->session->set_userdata('search_store_order_total',$search_store_order_total);
		}
		$filter = array(		
				'store_date' =>$store_date,
				'store_id'   => $storeId,
				'order_id'   => $search_store_order_id,					
				'order_total'   => $search_store_order_total,
				'order_by'   => $order_by				
		);	
		
		$orders 				= $this->order_model->getOrderList($filter);		
		$store 					= $this->store_model->getStoreDetail(array('store_id'=>$storeId));				
		$data['orders'] 		= $orders;
		$data['store'] 			= $store; 
		$data['store_date'] 	= $this->session->userdata['store_date'];
		$data['search_store_order_id'] 	= $this->session->userdata['search_store_order_id'];
		$data['search_store_order_total'] 	= $this->session->userdata['search_store_order_total'];
		$data['sort_store_date'] 	= $this->session->userdata['sort_store_date'];
		$data['sort_store_order'] 	= $this->session->userdata['sort_store_order'];
		$data['content']		= 'admin/detail';		
		$this->load->view('back_end/index',$data);
	}
	
	function edit($store_id){
		if($this->input->post('submit')){
			$submit	= $this->input->post('submit');
			$data	= array();		
			$data['store_express'] 		= $this->input->post('store_express');
			$data['store_ground'] 		= $this->input->post('store_ground');
			$data['store_location_name']= $this->input->post('store_location_name');		
			$data['store_address'] 		= $this->input->post('store_address');
			$data['store_address_2'] 	= $this->input->post('store_address_2');
			$data['store_city'] 		= $this->input->post('store_city');
			$data['store_state']		= $this->input->post('store_state');
			$data['store_zip'] 			= $this->input->post('store_zip');
			$data['store_contact'] 		= $this->input->post('store_contact');
			$data['store_phone'] 		= $this->input->post('store_phone');			
			$data['store_email'] 		= $this->input->post('store_email');
			if($this->input->post('store_password')) {
				$data['store_password'] = md5(trim($this->input->post('store_password')));
			}
			
			if($this->input->post('store_role')==1) {
				$data['store_assigned']	= (string)$this->input->post('assigned_to');
			}
			$this->store_model->saveItem('stores',array('field'=>'store_id','id'=>$store_id),$data);
			
			if($submit == "Save"){
				redirect('admin/store/liststores');
			}else{
				redirect('admin/store/edit/'.$store_id);
			}	
		}
		
		$store = $this->store_model->getStoreDetail(array('store_id'=>$store_id));
		
		if($store->store_role==1) {
			$market_directories = $this->store_model->getStoreList(array('store_role' => 2));	
		}		
		
		$data['error_full'] 		= $this->error_full;
		$data['error_phone'] 		= $this->error_phone;
		$data['error_email'] 		= $this->error_email;
		$data['store']				= $store;
		$data['market_directories']	= isset($market_directories)?$market_directories:null;
		$data['content']			= 'admin/edit';
		$this->load->view('back_end/index',$data);
	}
	
	function add(){
		if($this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('store_number', 'Unit #');			
			$this->form_validation->set_rules('store_phone', 'Phone');
			$this->form_validation->set_rules('store_email', 'Email');
			if($this->form_validation->run()) {
				$data = array();		
				$data['store_express'] 		= (int)$this->input->post('store_express');
				$data['store_ground'] 		= (int)$this->input->post('store_ground');
				$data['store_location_name']= $this->input->post('store_location_name');		
				$data['store_address'] 		= $this->input->post('store_address');
				$data['store_address_2'] 	= $this->input->post('store_address_2');
				$data['store_city'] 		= $this->input->post('store_city');
				$data['store_state']		= $this->input->post('store_state');
				$data['store_zip'] 			= $this->input->post('store_zip');
				$data['store_contact'] 		= $this->input->post('store_contact');
				$data['store_phone'] 		= $this->input->post('store_phone');			
				$data['store_email'] 		= $this->input->post('store_email');
				$data['store_number'] 		= $this->input->post('store_number');
				$data['store_role']			= (int)$this->input->post('store_role');
				$data['store_password']		= ($this->input->post('store_password')) ? md5(trim($this->input->post('store_password'))) : '';
				
				$this->store_model->saveItem('stores',array('id'=>0),$data);					
				redirect('admin/store/liststores');
			}
		}
		$data['mode'] 				= 'add';	
		$data['error_full'] 		= $this->error_full;
		$data['error_number'] 		= $this->error_number;
		$data['error_phone'] 		= $this->error_phone;
		$data['error_email'] 		= $this->error_email;	
		$data['content']			= 'admin/add';
		$this->load->view('back_end/index',$data);
	}
	
	function del($id = NULL){
		if($id == NULL){
			$id = (int)$this->uri->segment(4);
		}
		$this->store_model->del($id);
		redirect('admin/store/liststores');		
	}
}