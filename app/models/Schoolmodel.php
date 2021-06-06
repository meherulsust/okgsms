<?php
/*
| -----------------------------------------------------
| PRODUCT NAME     : SMS
-----------------------------------------------------
| MODEL CLASS NAME : Schoolmodel
| -----------------------------------------------------
| AUTHOR		   : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL			   : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT		   : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE		   :			
| -----------------------------------------------------
*/
 class Schoolmodel extends MT_Model
 {
 	function __construct()
 	{
 		parent::__construct();	
 	}
 	 	 	
 	function get_list()
 	{ 		
		$this->db->select('*');		
 	 	$this->db->from('school');
		$rs=$this->db->get(); 	    
		$school=$rs->result_array(); 	    
		return $school;
 	}
 	
 	function count_list()
 	{
 		$this->db->select("count(id) num");
		$this->db->from('school');
 		return $this->get_one();
 	}
 
 	function edit($id='',$data)
 	{
 		return $this->db->update('school',$data,array('id'=>$id));
 	}
		
	function get_details($id)
 	{
 		$this->db->select('*');		
 	 	$this->db->from('school');
		$this->db->where('id',$id);
 		return $this->get_row();
 	}	
 	
 	function get_record($id)
 	{
 		$this->db->select('*');
		$this->db->from('school');
 		$this->db->where('id',$id);
 		return $this->get_row();
 	}

	function get_settings()
 	{
 		$this->db->select('*');
		$this->db->from('school');
 		$this->db->where('id',1);
 	   	return $this->get_row(); 	   	
 	}
 
	
 }
