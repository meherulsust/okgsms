<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	MTCMS
-----------------------------------------------------
| MODEL CLASS NAME: employeemodel
| -----------------------------------------------------
| AUTHOR:			Md.Meherul Islam
| -----------------------------------------------------
| EMAIL:			meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT:		Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE:			
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
		$this->db->select('*',false);		
 	 	$this->db->from('employee');
		$this->db->where('category_id=','1'); //category_id=1 is for teachering staff
		if($data['username'] !='')
		{
			$this->db->where('username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('mobile_no',$data['mobile_no']);
		}
		$rs=$this->db->get(); 	    
		$teachers=$rs->result_array(); 	    
		return $teachers;
 	}
	
	function get_staff_list($data)
 	{ 		
		$this->db->select('*',false);		
 	 	$this->db->from('employee');
		$this->db->where('category_id=','2'); //category_id=2 is for non-teachering staff
		if($data['username'] !='')
		{
			$this->db->where('username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('mobile_no',$data['mobile_no']);
		}
		$rs=$this->db->get(); 	    
		$teachers=$rs->result_array(); 	    
		return $teachers;
 	}
	
	function count_list($data)
 	{
 		$this->db->select('employee.id');	
 	 	$this->db->from('employee');
		$this->db->where('category_id=','1');
		if($data['username'] !='')
		{
			$this->db->where('username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('mobile_no',$data['mobile_no']);
		}
		$rs=$this->db->get();	    
		$teachers=$rs->num_rows();		
 		return $teachers;
 	}
 	
 	function count_staff_list($data)
 	{
 		$this->db->select('employee.id');	
 	 	$this->db->from('employee');
		$this->db->where('category_id=','2');
		if($data['username'] !='')
		{
			$this->db->where('username',$data['username']);
		}
		if($data['mobile_no'] !='')
		{
			$this->db->where('mobile_no',$data['mobile_no']);
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
	
 	function edit($id='',$data)
 	{
 		return $this->db->update('employee',$data,array('id'=>$id));
 	}
	
	function edit_password($id)
 	{
 		$timezone = "Asia/Dhaka";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);			
		$data['passwd']=$this->input->post('new_passwd');
		return $this->db->update('employee',$data,array('id'=>$id));
 	}
		
	function get_teacher_details($id)
 	{
 		$this->db->select('t.*,bg.title');		
 	 	$this->db->from('employee t');
 	 	$this->db->join('blood_group bg','bg.id = t.blood_group_id','left');
		$this->db->where('t.id',$id);
 		return $this->get_row();
 	}	
 	
 	function get_record($id)
 	{
 		$this->db->select('*');
		$this->db->from('employee');
 		$this->db->where('id',$id);
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