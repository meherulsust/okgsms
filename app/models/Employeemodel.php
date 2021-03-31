<?php
/*
| -----------------------------------------------------
| AUTHOR	:Md.Meherul Islam
| -----------------------------------------------------
| EMAIL		:meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT :aimictacademy
| -----------------------------------------------------
| WEBSITE	:http://aimictacademy.com/			
| -----------------------------------------------------
*/
 class Employeemodel extends MT_Model
 {
 	function __construct()
 	{
 		parent::__construct();
 		
 	}
 	 	 	
 	function get_list($data)
 	{ 		
		$this->db->select('em.*,a.username,password,id_admin_group',false);		
 	 	$this->db->from('employee em');
		$this->db->join('admins a', 'a.id =em.admin_id', 'left');
		if($data['username'] !='')
		{
			$this->db->where('a.username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('em.mobile_no',$data['mobile_no']);
		}
		$rs=$this->db->get(); 	    
		$teachers=$rs->result_array(); 	    
		return $teachers;
 	}
	
	function count_list($data)
 	{
 		$this->db->select('em.id');	
 	 	$this->db->from('employee em');
		$this->db->join('admins a', 'a.id =em.admin_id', 'left');
		if($data['username'] !='')
		{
			$this->db->where('a.username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('em.mobile_no',$data['mobile_no']);
		}
		$rs=$this->db->get();	    
		$teachers=$rs->num_rows();		
 		return $teachers;
 	}
 	
 	
	function add($data)
 	{ 		
		$this->db->insert('employee',$data);
 		return $this->db->insert_id();
 	}
	 
	function add_user($data)
 	{ 		
		$this->db->insert('admins',$data);
 		return $this->db->insert_id();
 	} 
	
 	function edit($id='',$data)
 	{
 		return $this->db->update('employee',$data,array('id'=>$id));
 	}

	function edit_user($id='',$data)
 	{
 		return $this->db->update('admins',$data,array('id'=>$id));
 	} 
	
	

 	function get_record($id)
 	{
		$this->db->select('em.*,a.username,a.id_admin_group,a.email',false);	
		$this->db->from('employee em');
		$this->db->join('admins a', 'a.id =em.admin_id', 'left');	
 		$this->db->where('em.id',$id);
 		return $this->get_row();
 	}
	
 	function change_status($id,$val)
 	{
 	   $this->db->where('id',$id);
 	   $this->db->update('employee',array('status'=>strtoupper($val)));	
 	}
 	
 	function del($id)
 	{
		$this->db->delete('employee',array('id'=>$id)); 		
 	}
		
 	
 }
 
?>