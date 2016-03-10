<?php
class Store_Model extends General_Model {
	
	function getStoreList($filter=array()) {
		$this->db->from('stores as stores');
		//$this->db->join('stores as `storesabc`','storesabc.store_id = stores.store_assigned','left');
		if(isset($filter['store_number'])&&$filter['store_number']!=''){
			$this->db->like('store_number',$filter['store_number']);
		}
		if(isset($filter['store_role'])&&$filter['store_role']!='all'){
			$this->db->where('store_role',$filter['store_role']);
		}
		if(isset($filter['store_assigned'])&&$filter['store_assigned']!="") {
			$this->db->where('store_assigned',(int)$filter['store_assigned']);
		}
		if(isset($filter['perpage'])&&$filter['perpage']!='all') {
			$perpage	= $filter['perpage'];
			$offset 	= (isset($filter['offset']))?$filter['offset']:0;
			$this->db->limit($perpage,$offset);
		}
		$this->db->order_by('store_id','desc');
		
		
		$query	 = $this->db->get();
		$results = $query->result();
		
		return $results;
	}
	function getStoreTotal($filter=array()){			
		if(isset($filter['store_number'])&&$filter['store_number']!=''){
			$this->db->like('store_number',$filter['store_number']);
		}
		if(isset($filter['store_role'])&&$filter['store_role']!='all'){
			$this->db->where('store_role',$filter['store_role']);
		}
		if(isset($filter['store_assigned'])&&$filter['store_assigned']!="") {
			$this->db->where('store_assigned',(int)$filter['store_assigned']);
		}
		$query	= $this->db->get('stores');
		$total	= $query->num_rows();
		return $total;
	}
	function getStoreDetail($filter=array()) {
		if(isset($filter['store_number'])&&$filter['store_number']!="") {
			$this->db->where('store_number',$filter['store_number']);
		}
		if(isset($filter['store_id'])&&$filter['store_id']!="") {
			$this->db->where('store_id',$filter['store_id']);
		}
		if(isset($filter['store_password']) && $filter['store_password']!= "") {
			$this->db->where('store_password',$filter['store_password']);
		}
		if(isset($filter['store_role']) && $filter['store_role']!="") {
			$this->db->where('store_role',(int)$filter['store_role']);
		}
		if(isset($filter['store_email']) && $filter['store_email']!="") {
			$this->db->where('store_email',$filter['store_email']);
		}
		$query	= $this->db->get('stores');
		$result	= $query->row();
		return $result;	
	}
	
	function edit($data,$id){
		$this->db->where('store_id',$id);
		$rs = $this->db->update('stores',$data);
		if($rs){
            return true;
         } else {
            return false;
         }
	}
   	function del($key_value=0){          
   		$this->db->where('store_id',$key_value);
        $this->db->limit(1,0);
        $this->db->delete('stores');           
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
   	}
		
}