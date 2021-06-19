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
class TuitionFeeConfigModel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function get_list()
    {
        $this->db->select('tfc.*,tfh.title,c.title as class,m.title as month');
        $this->db->from('tuition_fee_config tfc');
        $this->db->join('tuition_fee_head tfh', 'tfh.id =tfc.tuition_fee_head_id', 'left');
        $this->db->join('month_list m','m.id = tfc.month_id','left');
		$this->db->join('class c', 'c.id =tfc.class_id', 'left');
        $this->db->order_by('m.id');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list()
    {
        $this->db->select("count(tfc.id) num");
        $this->db->from('tuition_fee_config tfc');
        $this->db->join('tuition_fee_head tfh', 'tfh.id =tfc.tuition_fee_head_id', 'left');
        $this->db->join('month_list m','m.id = tfc.month_id','left');
		$this->db->join('class c', 'c.id =tfc.class_id', 'left');
        return $this->get_one();
    }

    public function add($data)
    {
        $this->db->insert('tuition_fee_config', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->update('tuition_fee_config', $data, array('id' => $id));
    }

    public function get_record($id = '')
    {
        $this->db->select('tfc.*,tfh.title,c.title as class');
        $this->db->from('tuition_fee_config tfc');
        $this->db->join('tuition_fee_head tfh', 'tfh.id =tfc.tuition_fee_head_id', 'left');
		$this->db->join('class c', 'c.id =tfc.class_id', 'left');
        $this->db->where('tfc.id', $id);
        return $this->get_row();
    }

    public function del($id)
    {
        $this->db->delete('tuition_fee_config', array('id' => $id));
    }

    public function change_status($id, $val)
    {

        $this->db->where('id', $id);
        $this->db->update('tuition_fee_config', array('status' => strtoupper($val)));
    }

}