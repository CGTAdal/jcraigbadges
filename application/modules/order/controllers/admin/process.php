<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Process extends MX_Controller {	
	var $order_table = 'orders';
	
	function __construct() 
	{
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			redirect('admin/login');
		}
		/*if($this->session->userdata('role')==1){
			redirect('admin');
		}*/	
		if($this->session->userdata('role')!=0){
			redirect('admin');
		}
		$this->load->model('order_model');
	}
	
	function exportToText($orderId) {				
		$orders = $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$orderId),'order_items');		
		$item 	= (count($orders)>0)?unserialize($orders->order_items):'';
		$badges	= isset($item['badges'])?$item['badges']:(!isset($item['extras'])?$item:null);
		
		$data['badges']	= $badges;
		$data['role']   = $this->session->userdata['role'];
		$view 			= $this->load->view('order/admin/list_text',$data);		
		
		$file		= "JCP-Output.txt";	 
		$content	= "";
		header("Content-type: application/txt");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Transfer-Encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $view;
	}
	
	function listprocess() {
		if($this->input->post('sort_type')) {
			$sort_type = $this->input->post('sort_type');
			switch($sort_type) {
				case 'order_id':
					if(isset($this->session->userdata['sort_by_order_id'])) {
						$current_type = $this->session->userdata['sort_by_order_id'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_order_id','asc');
						} else {
							$this->session->set_userdata('sort_by_order_id','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_order_id','desc');
					}
					$this->session->set_userdata('sort_by_store_number','');
					$this->session->set_userdata('sort_by_order_shipdate','');
					$order_by = array(
						'field'		=> 'order_id',
						'sort_type'	=> $this->session->userdata['sort_by_order_id']
					);
				break;
				case 'store_number':
					if(isset($this->session->userdata['sort_by_store_number'])) {
						$current_type = $this->session->userdata['sort_by_store_number'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_store_number','asc');
						} else {
							$this->session->set_userdata('sort_by_store_number','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_store_number','desc');
					}
					$this->session->set_userdata('sort_by_order_id','');
					$this->session->set_userdata('sort_by_order_shipdate','');
					$order_by = array(
						'field'		=> 'stores.store_number',
						'sort_type'	=> $this->session->userdata['sort_by_store_number']
					);
				break;
				case 'order_shipdate':
					if(isset($this->session->userdata['sort_by_order_shipdate'])) {
						$current_type = $this->session->userdata['sort_by_order_shipdate'];
						if($current_type=='desc') {
							$this->session->set_userdata('sort_by_order_shipdate','asc');
						} else {
							$this->session->set_userdata('sort_by_order_shipdate','desc');
						}
					} else {
						$this->session->set_userdata('sort_by_order_shipdate','desc');
					}
					$this->session->set_userdata('sort_by_order_id','');
					$this->session->set_userdata('sort_by_store_number','');
					$order_by = array(
						'field'		=> 'order_shipdate',
						'sort_type'	=> $this->session->userdata['sort_by_order_shipdate']
					);
				break;
			}
		} else {
			setSessionVariable(false, 'sort_by_order_id', 'desc');
			setSessionVariable(false, 'sort_by_store_number', '');
			setSessionVariable(false, 'sort_by_order_shipdate', '');
			$order_by = array(
				'field'		=> 'order_id',
				'sort_type'	=> 'desc'
			);
		}
		
		$perpage	= setSessionVariable($this->input->post('perpage'), 'order_on_per_page', 12);
		$offset		= ($this->uri->segment(4)=='')?0:$this->uri->segment(4);
		setSessionVariable($offset, "order_list_offset", 0);
		
		$from_date 	= $this->input->post('from_date');
		$to_date 	= $this->input->post('to_date');
		if($from_date != '') {
			$this->session->unset_userdata('filter_order_from_date');
			$from_date = strtotime($from_date);			
		}
		if($to_date != ''){
			$this->session->unset_userdata('filter_order_to_date');
			$to_date = strtotime($to_date);			
		}		
		$from_date	= setSessionVariable($from_date, 'filter_order_from_date', '');
		$to_date	= setSessionVariable($to_date, 'filter_order_to_date', '');
		
		$s_from_date 	= $this->input->post('s_from_date');
		$s_to_date 		= $this->input->post('s_to_date');
		if($s_from_date != '') {
			$s_from_date = strtotime($s_from_date);			
		}
		if($s_to_date != ''){
			$s_to_date = strtotime($s_to_date);			
		}
		$s_from_date	= setSessionVariable($s_from_date, 'filter_processing_shipped_from_date', '');
		$s_to_date		= setSessionVariable($s_to_date, 'filter_processing_shipped_to_date', '');
		
		$search_order_id 	 = setSessionVariable($this->input->post('search_order_id'), 'search_order_id', '');		
		$search_store_number = setSessionVariable($this->input->post('search_store_number'), 'search_store_number', '');
				
		$filter = array(
			'from_date'		=> $from_date,
			'to_date'		=> $to_date,
			's_from_date' 	=> $s_from_date,
			's_to_date'		=> $s_to_date,
			'offset'    	=> $offset,
			'perpage'   	=> $perpage,
			'order_by'		=> $order_by,
			'order_id'		=> $search_order_id,
			'store_number'	=> $search_store_number,
			'order_status'	=> 2
		);
		
		#Create pagintaion
		$order_total = $this->order_model->getOrderTotal($filter);
		$this->load->library('pagination');
		$config['total_rows'] 		= $order_total;
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
		$config['base_url']			= base_url().'admin/process/listprocess/';
		$config['uri_segment']		= 4;
		$this->pagination->initialize($config); 
		$pagination	= $this->pagination->create_links();		
		#end create pagintation
		
		$orders = $this->order_model->getOrderList($filter);

		$data['orders']				= $orders;
		$data['from_date']			= $from_date;
		$data['to_date']			= $to_date;
		$data['s_from_date']		= $s_from_date;
		$data['s_to_date']			= $s_to_date;
		$data['search_order_id']	= $this->session->userdata['search_order_id'];
		$data['search_store_number']= $this->session->userdata['search_store_number'];		
		$data['sort_order_id']		= $this->session->userdata['sort_by_order_id'];
		$data['sort_unit']			= $this->session->userdata['sort_by_store_number'];		
		$data['order_shipdate']		= $this->session->userdata['sort_by_order_shipdate'];
		$data['pagination'] 		= $pagination;
		$data['role'] 				= $this->session->userdata['role'];		
		$data['select_perpage'] 	= $this->session->userdata['order_on_per_page']; 
		$data['content']			= 'admin/list_proccess';
		$this->load->view('back_end/index',$data);
	}
	
	function detail($order_id)
	{
		$order = $this->order_model->getOrderDetail(array('order_id'=>$order_id));
		if($order->order_status!=2)
			redirect('admin/process/listprocess');
		if($this->input->post('process')) {
			if($order->order_shipdate==0) {
				$data['order_shipdate']		= time();
				$data['order_process']		= $this->session->userdata['username'];
				$this->order_model->saveItem('orders',array('field'=>'order_id','id'=>$order_id),$data);
			}
		}
				
		$item		= (count($order)>0)?unserialize($order->order_items):'';
		$shipping	= (count($order)>0)?unserialize($order->order_shipping):'';
		$billing	= (count($order)>0)?unserialize($order->order_billing):'';
		$badges		= isset($item['badges'])?$item['badges']:(!isset($item['extras'])?$item:null);
		
		$data['order']			= $order;
		$data['badges']			= $badges;
		$data['shipping'] 		= $shipping;
		$data['billing']		= $billing;	
		$data['content']	= 'admin/detail';
		$this->load->view('back_end/index',$data);
	}	
}