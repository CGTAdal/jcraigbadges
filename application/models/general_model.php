<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class General_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * 
	 * Delete item
	 * @param string $table table name
	 * @param array $item array('field','id')
	 */
	function deleteItem($table,$item) {
		$this->db->where($item['field'],$item['id']);
		$this->db->delete($table);
		return true;
	}
	
	/**
	 * 
	 * Get item detail
	 * @param string $table table name
	 * @param array $item array('field','id')
	 * @param string $select fields to select
	 */
	
	function getItemDetail($table,$item=array(),$select="") {
		$this->db->where($item['field'],$item['id']);		
		if($select!="") 
		$this->db->select($select);		
		$query	= $this->db->get($table);
		$result	= $query->row();
		return $result;
	}

	/**
	 * 
	 * Get total number of item
	 * @param string $table		table name
	 * @param string $select	fields to select
	 */
	function getItemTotal($table,$select="") {
		if($select!="") $this->db->select($select);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	/**
	 * 
	 * Get item list
	 * @param string	$table	 table name
	 * @param int 		$perpage limit
	 * @param int		$offset	 offset
	 */
	function getItemList($table,$attributes=array()) {
		if(isset($attributes['where'])&&$attributes['where']!="") $this->db->where($attributes['where']);
		if(isset($attributes['perpage'])&&$attributes['perpage']!='all') $this->db->limit($attributes['perpage'],$attributes['offset']);
		if(isset($attributes['offset'])&&$attributes['select']!='') $this->db->select($attributes['offset']);
		if(isset($attributes['order_by'])) $this->db->order_by($attributes['order_by'][0],$attributes['order_by'][1]);
		$query	 = $this->db->get($table);
		$results = $query->result();
		return $results;
	}
	
	/**
	 * 
	 * Save item
	 * @param string	$table 	table name
	 * @param array		$item  	array('field','id')
	 * @param array		$data	input data
	 */
	function saveItem($table,$item=array(),$data=array()) {
		if($item['id']==0) {
			$this->db->insert($table,$data);
			$item['id']	= $this->db->insert_id();
		} else {
			$this->db->where($item['field'],$item['id']);
			$this->db->update($table,$data);
		}
		return $item['id'];
	}
	
	function saveMultiItems($table,$data,$where_field) {
		if($where_field=='') {
			$this->db->insert_batch($table,$data);
		} else {
			$this->db->update_batch($table,$data,$where_field);
		}
		return;
	}
	
	
}