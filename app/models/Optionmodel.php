<?php
/*
| -----------------------------------------------------
| PRODUCT NAME        : 
-----------------------------------------------------
| MODEL CLASS NAME    : Optionmodel
| -----------------------------------------------------
| AUTHOR              : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL               : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT           : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE             :
| -----------------------------------------------------
 */
class Optionmodel extends MT_Model
{

    public function group_option()
    {
        $this->db->select('id,title');
        $this->db->from('admin_group');
        if ($this->session->userdata('admin_group_id') != 1) {
            $this->db->where('id !=', 1);
        }
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'asc');
        return $this->get_assoc();
    }

    public function user_option()
    {
        $this->db->select('id,username title');
        $this->db->from('admins');
        $this->db->where('id_admin_group >', 2);
        $this->db->where('tenant_id', $this->tenant_id);
        $this->db->order_by('username', 'asc');
        return $this->get_assoc();
    }

    public function tenant_option()
    {
        $this->db->select('id, title');
        $this->db->from('tenant');
        $this->db->where('status', 'Active');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();
    }

    function religion_options()
    {
        $this->db->select('id,title');
        $this->db->from('religion');
        //$this->db->where('status=','Active');
        $this->db->order_by('id','asc');
        return $this->get_assoc(); 
    }
   function blood_group_options()
    {
        $this->db->select('id,symbol as title');
        $this->db->from('blood_group');
        //$this->db->where('status=','Active');
        $this->db->order_by('id','asc');
        return $this->get_assoc(); 
    }

    function scale_options()
    {
        $this->db->select('id,title');
        $this->db->from('result_scale');
        $this->db->where('status=','Active');
        $this->db->order_by('id','asc');
        return $this->get_assoc(); 
    }

    function version_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('version_list');
		//$this->db->where('status=','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}

    function class_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('class');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}

    function section_options($class_id='')
 	{
 		$this->db->select('id,title');
 		$this->db->from('section');
		$this->db->where('status','Active');
        //if(isset($class_id) && $class_id !='')
        $this->db->where('class_id',$class_id);
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}
     
    function student_type_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('student_type');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	} 
    
    function subject_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('subject');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}
     
    function designation_options()
 	{
 		$this->db->select('id,title');
 		$this->db->from('designation');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}
    
    function student_options()
 	{
 		$this->db->select('id,full_name title');
 		$this->db->from('student_list');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}
     
    function tutuion_fee_head_options()
 	{
 		$this->db->select('id, title');
 		$this->db->from('tuition_fee_head');
		$this->db->where('status','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}   
     
    function month_option(){
        $this->db->select('id, title');
        $this->db->from('month_list');
        $this->db->order_by('id','asc');
        return $this->get_assoc(); 
    }

    function year_option(){

        $year_list = array(
            '2020'=>'2020',
            '2021'=>'2021',
            '2022'=>'2022',
            '2023'=>'2023',
            '2024'=>'2024',
            '2025'=>'2025',
            '2026'=>'2026',
            );
            return $year_list;
    }

       
        
}