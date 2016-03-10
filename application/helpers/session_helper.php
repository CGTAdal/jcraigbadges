<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function setSessionVariable($input_field,$variable_name,$default) {
	$ci =& get_instance();
	if($input_field!==false) {
		$value	= $input_field;
		$ci->session->set_userdata($variable_name,$value);
	} else {
		if($ci->session->userdata($variable_name)) {
			$value = $ci->session->userdata($variable_name);
		} else {
			$value = $default;
			$ci->session->set_userdata($variable_name,$value);
		}
	}
	return $value;
}