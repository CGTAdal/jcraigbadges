<?php
class Order_Model extends General_Model {

	function getOrderList($filter=array()) {
		$this->db->select('orders.*, stores.store_id as store_id, stores.store_number as store_number,stores.store_state as store_state, stores.store_role as store_type, stores2.store_id as director_id, stores2.store_number as director_number');
		$this->db->from('orders as orders');
		$this->db->join('stores as stores','stores.store_id = orders.store_id');
		$this->db->join('stores as stores2','stores2.store_id = stores.store_assigned','left');
		if(isset($filter['from_date'])&&$filter['from_date']!="") {
			$this->db->where('orders.order_date >=',$filter['from_date']);
		}
		if(isset($filter['to_date'])&&$filter['to_date']!="") {
			$this->db->where('orders.order_date <',$filter['to_date']+24*60*60);
		}
		if(isset($filter['s_from_date'])&&$filter['s_from_date']!="") {
			$this->db->where('orders.order_shipdate >=',$filter['s_from_date']);
		}
		if(isset($filter['s_to_date'])&&$filter['s_to_date']!="") {
			$this->db->where('orders.order_shipdate <',$filter['s_to_date']+24*60*60);
		}
		if(isset($filter['store_date'])&&$filter['store_date']!="") {
			$this->db->where('orders.order_date >=',$filter['store_date']);
			$this->db->where('orders.order_date <',$filter['store_date']+24*60*60);
		}
		if(isset($filter['store_id'])&&$filter['store_id']!="") {
			$this->db->where('stores.store_id =',$filter['store_id']);
		}
		if(isset($filter['order_id'])&&$filter['order_id']!="") {
			$this->db->like('orders.order_id',(int)$filter['order_id']);			
		}
		if(isset($filter['store_number']) && $filter['store_number']!="") {
			$this->db->like('stores.store_number',$filter['store_number']);			
		}
		if(isset($filter['store_type']) && $filter['store_type']!="") {
			if($filter['store_type']==3) {
				$this->db->where('stores.store_role',3);
			} else {
				$this->db->where('stores.store_role !=',3);
			}
		}
		if(isset($filter['order_total'])&&$filter['order_total']!="") {
			$order_total = ($filter['order_total']);
			$this->db->where("order_total * 4.75 + order_tenured_qty * 6.25 + order_mf_qty * 6.25 + order_pf_qty * 3.5 = {$order_total}");			
		}		
		if(isset($filter['perpage'])&&$filter['perpage']!='all') {
			$perpage	= $filter['perpage'];
			$offset 	= (isset($filter['offset']))?$filter['offset']:0;
			$this->db->limit($perpage,$offset);
		}		
		if(isset($filter['order_by'])&&count($filter['order_by'])>0) {
			$this->db->order_by($filter['order_by']['field'],$filter['order_by']['sort_type']);
		}
		if(isset($filter['order_status'])&&$filter['order_status']!="") {
			$this->db->where('orders.order_status',$filter['order_status']);			
		}
		if(isset($filter['store_assigned'])&&$filter['store_assigned']!="") {
			$this->db->where('stores.store_assigned',$filter['store_assigned']);
		}
		
		$query	 = $this->db->get();
		
		$results = $query->result();
		return $results;
	}
	
	function getOrderTotal($filter = array()){
		$this->db->select('orders.order_id');
		$this->db->from('orders as orders');
		$this->db->join('stores as stores','stores.store_id = orders.store_id');
		$this->db->join('stores as stores2','stores2.store_id = stores.store_assigned','left');
		if(isset($filter['from_date'])&&$filter['from_date']!="") {
			$this->db->where('orders.order_date >=',$filter['from_date']);
		}
		if(isset($filter['to_date'])&&$filter['to_date']!="") {
			$this->db->where('orders.order_date <',$filter['to_date']+24*60*60);
		}
		if(isset($filter['s_from_date'])&&$filter['s_from_date']!="") {
			$this->db->where('orders.order_shipdate >=',$filter['s_from_date']);
		}
		if(isset($filter['s_to_date'])&&$filter['s_to_date']!="") {
			$this->db->where('orders.order_shipdate <',$filter['s_to_date']+24*60*60);
		}
		if(isset($filter['store_date'])&&$filter['store_date']!="") {
			$this->db->where('orders.order_date >=',$filter['store_date']);
			$this->db->where('orders.order_date <',$filter['store_date']+24*60*60);
		}
		if(isset($filter['store_id'])&&$filter['store_id']!="") {
			$this->db->where('stores.store_id =',$filter['store_id']);
		}
		if(isset($filter['order_id'])&&$filter['order_id']!="") {
			$this->db->like('orders.order_id',(int)$filter['order_id']);			
		}
		if(isset($filter['store_number']) && $filter['store_number']!="") {
			$this->db->like('stores.store_number',$filter['store_number']);			
		}
		if(isset($filter['store_type']) && $filter['store_type']!="") {
			if($filter['store_type']==3) {
				$this->db->where('stores.store_role',3);
			} else {
				$this->db->where('stores.store_role !=',3);
			}
		}
		if(isset($filter['order_total'])&&$filter['order_total']!="") {
			$order_total = ($filter['order_total']);
			$this->db->where("order_total * 4.75 + order_tenured_qty * 6.25 + order_mf_qty * 6.25 + order_pf_qty * 3.5 = {$order_total}");			
		}		
		if(isset($filter['order_by'])&&count($filter['order_by'])>0) {
			$this->db->order_by($filter['order_by']['field'],$filter['order_by']['sort_type']);
		}
		if(isset($filter['order_status'])&&$filter['order_status']!="") {
			$this->db->where('orders.order_status',$filter['order_status']);			
		}
		if(isset($filter['store_assigned'])&&$filter['store_assigned']!="") {
			$this->db->where('stores.store_assigned',$filter['store_assigned']);
		}
		
		$query	 = $this->db->get();
		$total	= $query->num_rows();
		return $total;
		/*
		$results = $query->result();
		return $results;
	
		if(isset($filter['from_date'])&&$filter['from_date']!="") {
			$this->db->where('order_date >=',$filter['from_date']);
		}
		if(isset($filter['to_date'])&&$filter['to_date']!="") {
			$this->db->where('order_date <',$filter['to_date']+24*60*60);
		}
		if(isset($filter['s_from_date'])&&$filter['s_from_date']!="") {
			$this->db->where('order_shipdate >=',$filter['s_from_date']);
		}
		if(isset($filter['s_to_date'])&&$filter['s_to_date']!="") {
			$this->db->where('order_shipdate <',$filter['s_to_date']+24*60*60);
		}
		if(isset($filter['store_date'])&&$filter['store_date']!="") {
			$this->db->where('order_date >=',$filter['store_date']);
			$this->db->where('order_date <',$filter['store_date']+24*60*60);
		}
		if(isset($filter['store_id'])&&$filter['store_id']!="") {
			$this->db->where('orders.store_id =',$filter['store_id']);
		}
		if(isset($filter['order_id'])&&$filter['order_id']!="") {
			$this->db->like('order_id',(int)$filter['order_id']);			
		}		
		if(isset($filter['store_number'])&&$filter['store_number']!="") {
			$this->db->like('store_number',$filter['store_number']);			
		}
		if(isset($filter['store_type']) && $filter['store_type']!="") {
			if($filter['store_type']==3) {
				$this->db->where('stores.store_role',3);
			} else {
				$this->db->where('stores.store_role !=',3);
			}
		}
		if(isset($filter['order_total'])&&$filter['order_total']!="") {
			$order_total = ($filter['order_total']);
			$this->db->where("order_total * 2.75 + order_mf_qty * 7.5 + order_pf_qty * 5 + 4.25 = {$order_total}");			
		}
		$this->db->join('stores','stores.store_id = orders.store_id');
		if(isset($filter['order_by'])&&count($filter['order_by'])>0) {
			$this->db->order_by($filter['order_by']['field'],$filter['order_by']['sort_type']);
		}
		if(isset($filter['store_status'])&&$filter['store_status']!="") {
			$this->db->where('orders.store_status',$filter['store_status']);			
		}
		$this->db->order_by('order_id','desc' );
		
		$query	= $this->db->get('orders');
		$total	= $query->num_rows();
		return $total;
		*/
	}
	
	function getOrderDetail($filter=array()) {
		$this->db->join('stores','stores.store_id = orders.store_id');
		$this->db->where('order_id',(int)$filter['order_id']);
		if(isset($filter['store_id'])) {
			$this->db->where('orders.store_id',(int)$filter['store_id']);
		}
		if(isset($filter['store_assigned'])) {
			$this->db->where('stores.store_assigned',(int)$filter['store_assigned']);
		}
		if(isset($filter['order_code']) && $filter['order_code'] != "") {
			$this->db->where('orders.order_code',$filter['order_code']);
		}
		$query	= $this->db->get('orders');
		$order	= $query->row();
		return $order;
	}
	
	function get_by_id($key_value){
         if($key_value != NULL){
             $sql = "SELECT * FROM ci_orders JOIN ci_stores ON ci_stores.store_id=ci_orders.store_id WHERE order_id = '".$key_value."' LIMIT 0,1";
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
    
}