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
class Studenttypemodel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list()
    {
        $this->db->select('*');
        $this->db->from('student_type');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list()
    {
        $this->db->select("count(id) num");
        $this->db->from('student_type');
        return $this->get_one();
    }

    public function add($data)
    {
        $this->db->insert('student_type', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->update('student_type', $data, array('id' => $id));
    }

    public function get_record($id = '')
    {
        $this->db->select('*');
        $this->db->from('student_type');
        $this->db->where('id', $id);
        return $this->get_row();
    }

    public function del($id)
    {
        $this->db->delete('student_type', array('id' => $id));
    }

    public function change_status($id, $val)
    {

        $this->db->where('id', $id);
        $this->db->update('student_type', array('status' => strtoupper($val)));
    }

}