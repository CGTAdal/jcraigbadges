<?php
class Instructions extends MX_Controller {
	
	function __construct() {
		parent::__construct();	
	}
	function index(){
		return;
		$data['content'] = 'index';
		$this->load->view('front_end/index',$data);
	}
}	
?>