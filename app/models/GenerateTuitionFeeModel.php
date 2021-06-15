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

   
    public function get_list($id='',$data=[])
    {
        $this->db->select('tfl.*,sl.full_name,sl.id_no,sl.mobile_no,c.title as class,m.title as month,tfl.status as payment_status');
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('student_list sl', 'sl.id =tfl.student_id', 'left');
        $this->db->join('month_list m', 'm.id =tfl.month', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
        if(isset($id) && $id!=""){
            $this->db->where('tfl.student_id',$id);
        }
        if(isset($data['id_no']) &&  $data['id_no']!='')
		{
			$this->db->where('sl.id_no',$data['id_no']);
		}
		if(isset($data['mobile_no']) &&  $data['mobile_no']!='')
		{
			$this->db->where('sl.mobile_no',$data['mobile_no']);
		}
		if(isset($data['class_id']) &&  $data['class_id']!='')
		{
			$this->db->where('sl.class_id',$data['class_id']);
		}
		if(isset($data['section_id']) && $data['section_id'] !='')
		{
			$this->db->where('sl.section_id',$data['section_id']);
		}
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function count_list($id='',$data=[])
    {
        $this->db->select("count(tfl.id) num");
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('student_list sl', 'sl.id =tfl.student_id', 'left');
        $this->db->join('month_list m', 'm.id =tfl.month', 'left');
		$this->db->join('class c', 'c.id =sl.class_id', 'left');
        if(isset($id) && $id!=""){
            $this->db->where('tfl.student_id',$id);
        }
        if(isset($data['id_no']) &&  $data['id_no']!='')
		{
			$this->db->where('sl.id_no',$data['id_no']);
		}
		if(isset($data['mobile_no']) &&  $data['mobile_no']!='')
		{
			$this->db->where('sl.mobile_no',$data['mobile_no']);
		}
		if(isset($data['class_id']) &&  $data['class_id']!='')
		{
			$this->db->where('sl.class_id',$data['class_id']);
		}
		if(isset($data['section_id']) && $data['section_id'] !='')
		{
			$this->db->where('sl.section_id',$data['section_id']);
		}
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
        $this->db->select('tfl.*,tfh.title,c.title as class');
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('tuition_fee_head tfh', 'tfh.id =tfl.tuition_fee_head_id', 'left');
		$this->db->join('class c', 'c.id =tfl.class_id', 'left');
        $this->db->where('tfl.id', $id);
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

    function get_invoice_info($id)
	{
		$this->db->select('tfl.*,sl.*,a.username,tfl.status,tfl.id,m.title as month');
        $this->db->from('tuition_fee_list tfl');
        $this->db->join('student_list sl','sl.id = tfl.student_id','left');
        $this->db->join('month_list m','m.id = tfl.month','left');
        $this->db->join('admins a','a.id = tfl.created_by','left');
		$this->db->where('tfl.id',$id);
        $rs = $this->get_row();
        return $rs;
	}

    function get_invoice_details($id)
	{
		$this->db->select('tfd.id,tfd.amount,tfh.id as head_id,tfh.title as head');
        $this->db->from('tuition_fee_details tfd');
        $this->db->join('tuition_fee_config tfc','tfc.id = tfd.tuition_fee_config_id','left');	
		$this->db->join('tuition_fee_head tfh','tfh.id = tfd.tuition_fee_head_id','left');	
 	 	$this->db->where('tfd.tuition_fee_list_id',$id);
        $rs = $this->db->get();
		$result = $rs->result_array();
        return $result;
	}

    public function getStudentBy($class_id){
        $this->db->select('id,full_name');
        $this->db->from('student_list');
        $this->db->where('class_id',$class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getTutionFeeConfigListBy($class_id,$month_id){
        $this->db->select('*');
        $this->db->from('tuition_fee_config');
        $this->db->where('class_id',$class_id);
        $this->db->where('month_id',$month_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getTotalTuitionFeeBy($class_id,$month_id){
        $this->db->select_sum('amount');
        $this->db->from('tuition_fee_config');
        $this->db->where('class_id',$class_id);
        $this->db->where('month_id',$month_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }

    function check_due_history($id){
        $this->db->select('id');
        $this->db->from('payment_history_list');
        $this->db->where('tuition_fee_list_id',$id);
        $query = $this->db->get();
        $rs = $query->row_array();
        return $rs;
    }

    function get_payment_list($id)
	{
		$this->db->select('paid_amount,created_at');
        $this->db->from('payment_history_list');
		$this->db->where('tuition_fee_list_id',$id);
		$this->db->order_by('created_at','asc');
		$rs = $this->db->get();
		$result = $rs->result_array();
        return $result;
	}

    function update_due_payment($id,$payment_status,$paid_amount)
	{
        if($payment_status=='Paid')
        $this->db->set('status','Paid');
        $this->db->set('total_due','total_due - '.$paid_amount,FALSE);	
		$this->db->where('id',$id);
		$this->db->update('tuition_fee_list');
	}

    function update_invoice($id,$data)
    {
        $this->db->update('tuition_fee_list',$data,array('id'=>$id));
    }

    function insert_payment_history($data)
    {
        $this->db->insert('payment_history_list',$data);
		return $this->db->insert_id();
    }

}