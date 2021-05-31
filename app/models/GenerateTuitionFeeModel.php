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
class GenerateTuitionFeeModel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list()
    {
        $this->db->select('tfl.*,sl.full_name,sl.id_no,c.title as class');
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('student_list sl', 'sl.id =tfl.student_id', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list()
    {
        $this->db->select("count(tfl.id) num");
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('student_list sl', 'sl.id =tfl.student_id', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
        return $this->get_one();
    }

    public function addFee($data)
    {
        $this->db->insert('tuition_fee_list', $data);
        return $this->db->insert_id();
    }

    public function addDetail($data)
    {
        $this->db->insert_batch('tuition_fee_details', $data);  
    }

    public function edit($id, $data)
    {
        $this->db->update('tuition_fee_list', $data, array('id' => $id));
    }

    public function get_record($id = '')
    {
        $this->db->select('tfc.*,tfh.title,c.title as class');
        $this->db->from('tuition_fee_list tfc');
        $this->db->join('tuition_fee_head tfh', 'tfh.id =tfc.tuition_fee_head_id', 'left');
		$this->db->join('class c', 'c.id =tfc.class_id', 'left');
        $this->db->where('tfc.id', $id);
        return $this->get_row();
    }

    public function del($id)
    {
        $this->db->delete('tuition_fee_list', array('id' => $id));
    }

    public function change_status($id, $val)
    {

        $this->db->where('id', $id);
        $this->db->update('tuition_fee_list', array('status' => strtoupper($val)));
    }

    public function getStudentBy($class_id){
        $this->db->select('id,full_name');
        $this->db->from('student_list');
        $this->db->where('class_id',$class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getTuitionListBy($class_id){
        $this->db->select('*');
        $this->db->from('tuition_fee_config');
        $this->db->where('class_id',$class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getTotalTuitionFeeBy($class_id){
        $this->db->select_sum('amount');
        $this->db->from('tuition_fee_config');
        $this->db->where('class_id',$class_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }

}