<?php
class Commond extends MX_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		display('ad');
		exit();
	}
	
	function menu() {
		echo 'acb';
		exit();
		return 'abc';
	}
	
}