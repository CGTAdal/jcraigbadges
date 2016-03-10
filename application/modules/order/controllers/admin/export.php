<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export extends MX_Controller {
	
	var $order_table = 'orders';
	
	function __construct() 
	{
		parent::__construct();
		if(!isset($this->session->userdata['admin'])) 
		{
			redirect('admin/login');
		}
		$this->load->model('order_model');
	}
	
	function exportToExcel() {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'submit') {
			$query	 = $this->db->get('stores');
			$results = $query->result();
			$date_export = date('d/m/Y',time());
			header("Content-type: application/excel");
			header("Content-Disposition:attachment;filename=StoreData_".$date_export.".csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			print "Store ID, Store Number, Role, Store Assigned  \n";
			foreach ($results as $val) {
				$csv_arr = array($val->store_id,$val->store_number,$val->store_role,$val->store_assigned);
				print '"' . stripslashes(implode('","',$csv_arr)) . "\"\n";
			}
			exit;
		}
		$data['content']		= 'admin/list_export';
		$this->load->view('back_end/index',$data);
// 		$file	 = "Badges-Output.csv";
// 		$content = "";
// 		header("Content-type: application/excel");
// 		header("Content-Disposition: attachment; filename=$file");
// 		header("Pragma: no-cache");
// 		header("Expires: 0");
// 		echo $view;
	}
	
	
	
}