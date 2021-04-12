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
class Designationmodel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list()
    {
        $this->db->select('*');
        $this->db->from('designation');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list()
    {
        $this->db->select("count(id) num");
        $this->db->from('designation');
        return $this->get_one();
    }

    public function add($data)
    {
        $this->db->insert('designation', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->update('designation', $data, array('id' => $id));
    }

    public function get_record($id = '')
    {
        $this->db->select('*');
        $this->db->from('designation');
        $this->db->where('id', $id);
        return $this->get_row();
    }

    public function del($id)
    {
        $this->db->delete('designation', array('id' => $id));
    }

    public function change_status($id, $val)
    {

        $this->db->where('id', $id);
        $this->db->update('designation', array('status' => strtoupper($val)));
    }

}