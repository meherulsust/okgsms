<?php
/*
| -----------------------------------------------------
| PRODUCT NAME         :
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
class Tenantmodel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list()
    {
        $this->db->select('te.*');
        $this->db->from('tenant te');
     
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list()
    {
        $this->db->select("count(id) num");
        $this->db->from('tenant');
        return $this->get_one();
    }

    public function add($data)
    {
        $this->db->insert('tenant', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->update('tenant', $data, array('id' => $id));
    }

    public function get_record($id = '')
    {
        $this->db->select('*');
        $this->db->from('tenant');
        $this->db->where('id', $id);
        return $this->get_row();
    }

    public function del($id)
    {
        $this->db->delete('tenant', array('id' => $id));
    }

    public function change_status($id, $val)
    {

        $this->db->where('id', $id);
        $this->db->update('tenant', array('status' => strtoupper($val)));
    }

     public function get_tenant_info($subdomain)
    {
        $this->db->select('*');
        $this->db->from('tenant');
        $this->db->where(strtolower('subdomain'), $subdomain);
        return $this->get_row();
    }

}