<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_model extends CI_Model {
	
	function getAdminDetail($username,$password) {
		$this->db->where('admin_login',$username);
		$this->db->where('admin_password',$password);
		$query	= $this->db->get('ci_admin');
		$result	= $query->row();
		return $result;
	}
	/*function getRole()
	{
		$this->db->where('admin_name',$username);		
		$query	= $this->db->get('ci_admin');
		$result	= $query->row();
		return $result;
	}*/
	/*
	function get_by_id($key_value){
         if($key_value != NULL){
             $sql = "SELECT * FROM ci_stores WHERE id = '".$key_value."' LIMIT 0,1";
             $q = $this->db->query($sql);			 
             if($q->num_rows()==1){
                 return $q->row();
             } else {
                 return false;
             }
         } else {
             return false;
         }
    }
	function edit($key_value, $data){
         $this->db->where('id', $key_value);
         $rs = $this->db->update('Stores', $data);
         if($rs){
            return $key_value;
         } else {
            return false;
         }
     }     
	*/	
}