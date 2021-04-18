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
 class Studentmodel extends MT_Model
 {
 	function __construct()
 	{
 		parent::__construct();
 		
 	}
 	 	 	
 	function get_list($data)
 	{ 		
		$this->db->select('sl.*,c.title as class,se.title as section',false);		
 	 	$this->db->from('student_list sl');
		$this->db->join('admins a', 'a.id =sl.created_by', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
		$this->db->join('section se', 'se.id =sl.section_id', 'left');
		$this->db->join('student_type st', 'st.id =sl.student_type_id', 'left');
		$this->db->join('blood_group bg', 'bg.id =sl.blood_group_id', 'left');
		$this->db->join('religion re', 're.id =sl.religion_id', 'left');
		if($data['id_no'] !='')
			{
				$this->db->where('sl.id_no',$data['id_no']);
			}
		if($data['mobile_no'] !='')
			{
				$this->db->where('sl.mobile_no',$data['mobile_no']);
			}
		$rs=$this->db->get(); 	    
		$teachers=$rs->result_array(); 	    
		return $teachers;
 	}
	
	function count_list($data)
 	{
 		$this->db->select('sl.id');	
		$this->db->from('student_list sl');
		$this->db->join('admins a', 'a.id =sl.created_by', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
		$this->db->join('section se', 'se.id =sl.section_id', 'left');
		$this->db->join('student_type st', 'st.id =sl.student_type_id', 'left');
		$this->db->join('blood_group bg', 'bg.id =sl.blood_group_id', 'left');
		$this->db->join('religion re', 're.id =sl.religion_id', 'left');
		if($data['id_no'] !='')
			{
				$this->db->where('sl.id_no',$data['id_no']);
			}
		if($data['mobile_no'] !='')
			{
				$this->db->where('sl.mobile_no',$data['mobile_no']);
			}
		$rs=$this->db->get();	    
		$teachers=$rs->num_rows();		
 		return $teachers;
 	}
 	
 	
	function add($data)
 	{ 		
		$this->db->insert('student_list',$data);
 		return $this->db->insert_id();
 	}
	 
	
 	function edit($id='',$data)
 	{
 		return $this->db->update('student_list',$data,array('id'=>$id));
 	}

 	function get_record($id)
 	{
		$this->db->select('sl.*,c.title as class,se.title as section',false);		
		$this->db->from('student_list sl');
	  	$this->db->join('admins a', 'a.id =sl.created_by', 'left');
	  	$this->db->join('class c', 'c.id =sl.class_id', 'left');
	 	 $this->db->join('section se', 'se.id =sl.section_id', 'left');
	  	$this->db->join('student_type st', 'st.id =sl.student_type_id', 'left');
	  	$this->db->join('blood_group bg', 'bg.id =sl.blood_group_id', 'left');
	  	$this->db->join('religion re', 're.id =sl.religion_id', 'left');	
 		$this->db->where('sl.id',$id);
 		return $this->get_row();
 	}

	
 	function change_status($id,$val)
 	{
 	   $this->db->where('id',$id);
 	   $this->db->update('student_list',array('status'=>strtoupper($val)));	
 	}
 	
 	function del($id)
 	{
		$this->db->delete('student_list',array('id'=>$id)); 		
 	}

	function get_section_by($class_id)
 	{
 		$this->db->select('id, title');
		$this->db->from('section');
		$this->db->where('class_id',$class_id);
 		$this->db->order_by('id','asc');
 		$rs = $this->db->get(); 				
		return $rs->result_array();
 	} 

	 function get_student_details($id)
	 {
		$this->db->select('c.id,c.code,sl.id_no,sl.admission_roll,sl.created_at,sl.session');
		 $this->db->from('class c');
		 $this->db->join('student_list sl','sl.class_id=c.id','left');
		 $this->db->where('c.id',$id);
		 $this->db->where("sl.session =",current_year());
		 $this->db->order_by('sl.id_no','DESC');
		 return $this->get_row();
	 } 

	 function get_class_details($id)
	 {
		$this->db->select('c.id,c.code');
		$this->db->from('class c');
		$this->db->where('c.id',$id);
		return $this->get_row();
	 }
	 
	 function get_student_by($id)
	 {
		$this->db->select('id,full_name as title');
		$this->db->from('student_list');
		$this->db->where('id',$id);
		$this->db->order_by('id','asc');
 		$rs = $this->db->get(); 				
		return $rs->result_array();
	 } 
			
 	
 }
 
