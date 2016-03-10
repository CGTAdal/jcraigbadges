<?php
class Staff_Model extends General_Model {
	
	function getStaffList() {	
		$this->db->where('admin_role',2);
		$this->db->order_by('admin_id','asc');
		$query	 = $this->db->get('admin');
		$results = $query->result();
		return $results;
	}
	
}