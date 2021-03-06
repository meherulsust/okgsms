<?php
/*
| -----------------------------------------------------
| PRODUCT NAME		: SMS
-----------------------------------------------------
| MODEL CLASS NAME	: Sectionmodel
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
 class Sectionmodel extends MT_Model
 {
 	function __construct()
 	{
 		parent::__construct();
 		
 	}
 	 	 	
 	function get_list()
 	{ 		
		$this->db->select('se.*,vl.title as version,cl.title as class, se.status as custom_set_status');		
 	 	$this->db->from('section se');
		$this->db->join('version_list vl','vl.id = se.version_id','left');
		$this->db->join('class cl','cl.id = se.class_id','left');
		$rs=$this->db->get(); 	    
		$section=$rs->result_array(); 	    
		return $section;
 	}
 	
 	function count_list()
 	{
 		$this->db->select("count(id) num");
		$this->db->from('section');
 		return $this->get_one();
 	}
 	
	function add($data)
 	{ 		
		$this->db->insert('section',$data);
 		return $this->db->insert_id();
 	}
	
 	function edit($id='',$data)
 	{
 		return $this->db->update('section',$data,array('id'=>$id));
 	}	
 	function get_record($id)
 	{
 		$this->db->select('*');
		$this->db->from('section');
 		$this->db->where('id',$id);
 		return $this->get_row();
 	}
	
 	function change_status($id,$val)
 	{
 	   $this->db->where('id',$id);
 	   $this->db->update('section',array('status'=>strtoupper($val)));	
 	}
 	
 	function del($id)
 	{
 		$this->db->delete('section',array('id'=>$id)); 		
 	}
	function version_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('version_list');
		$this->db->where('status=','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}
	
	function class_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('class');
		$this->db->where('status=','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}	
		
 }
 
?>