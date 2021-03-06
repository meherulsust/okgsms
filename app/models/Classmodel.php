<?php
/*
| -----------------------------------------------------
| PRODUCT NAME		: SMS
-----------------------------------------------------
| MODEL CLASS NAME	: Classmodel
| -----------------------------------------------------
| AUTHOR			: Md.Meherul Islam
| -----------------------------------------------------
| EMAIL				: meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT			: Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE:			
| -----------------------------------------------------
*/
 class Classmodel extends MT_Model
 {
 	function __construct()
 	{
 		parent::__construct();
 		
 	}
 	 	 	
 	function get_list()
 	{ 		
		$this->db->select('*');		
 	 	$this->db->from('class');
		$rs=$this->db->get(); 
		$this->db->order_by('id');	    
		$class=$rs->result_array(); 	    
		return $class;
 	}
 	
 	function count_list()
 	{
 		$this->db->select("count(id) num");
		$this->db->from('class');
 		return $this->get_one();
 	}
 	
	function add($data)
 	{ 		
		$this->db->insert('class',$data);
 		return $this->db->insert_id();
 	}
	
 	function edit($id='',$data)
 	{
 		return $this->db->update('class',$data,array('id'=>$id));
 	}	
 	function get_record($id)
 	{
 		$this->db->select('*');
		$this->db->from('class');
 		$this->db->where('id',$id);
 		return $this->get_row();
 	}
	
 	function change_status($id,$val)
 	{
 	   $this->db->where('id',$id);
 	   $this->db->update('class',array('status'=>strtoupper($val)));	
 	}
 	
 	function del($id)
 	{
 		$this->db->delete('class',array('id'=>$id)); 		
 	}
	 	
	function get_class_details($id)
 	{
 		$this->db->select('*');		
 	 	$this->db->from('class');
 	 	$this->db->where('id',$id);
 		return $this->get_row();
 	}	
 }
 
