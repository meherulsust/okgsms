<?php
/*
| -----------------------------------------------------
| PRODUCT NAME         : OKGSMS
-----------------------------------------------------
| AUTHOR               : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL                : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT            : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE              :
| -----------------------------------------------------
 */
class StudentSmsModel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list($data)
    {
        $this->db->select('smi.*,smi.full_message as description,c.title as class');
        $this->db->from('send_msg_info smi');
		$this->db->join('class c', 'c.id =smi.class_id', 'left');
      
		if(isset($data['class_id']) &&  $data['class_id']!='')
		{
			$this->db->where('smi.class_id',$data['class_id']);
		}
		if(isset($data['student_id']) && $data['student_id'] !='')
		{
			$this->db->where('smi.student_id',$data['student_id']);
		}
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list($data)
    {
        $this->db->select("count(smi.id) num");
        $this->db->from('send_msg_info smi');
		$this->db->join('class c', 'c.id =smi.class_id', 'left');
      
		if(isset($data['class_id']) &&  $data['class_id']!='')
		{
			$this->db->where('smi.class_id',$data['class_id']);
		}
		if(isset($data['student_id']) && $data['student_id'] !='')
		{
			$this->db->where('smi.student_id',$data['student_id']);
		}
        return $this->get_one();
    }

    public function add($data)
    {
        $this->db->insert('send_msg_info', $data);
        return $this->db->insert_id();
    }

    // get full message
	function get_full_message($id)
	{
		$this->db->select('description');		
 	 	$this->db->from('msg_template');
		$this->db->where('id',$id);
		return $this->get_row();
	}

    public function getStudentBy($class_id){
        $this->db->select('id,mobile_no');
        $this->db->from('student_list');
        $this->db->where('class_id',$class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function add_sms_history($data)
    {
        $this->db->insert_batch('send_msg_info', $data);  
    }


}