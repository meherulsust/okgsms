<?php
/*
| -----------------------------------------------------
| PRODUCT NAME        :
-----------------------------------------------------
| MODEL CLASS NAME    : Usermodel
| -----------------------------------------------------
| AUTHOR              : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL               : meherulsust@gmail.com
| -----------------------------------------------------
| WEBSITE             :
| -----------------------------------------------------
 */
class Usermodel extends MT_Model
{
    public function __construct()
    {
        parent::__construct();

        //$this->table='admin';
    }

    public function get_list()
    {
        $this->db->select('ad.id,ad.username, CONCAT(ad.firstname," ",ad.lastname) as full_name,ad.email,ag.title admin_type,t.title as tenant,ad.status', false);
        $this->db->from('admins ad');
        $this->db->join('admin_group ag', 'ag.id = ad.id_admin_group', 'left');
        $this->db->join('tenant t', 't.id = ad.tenant_id', 'left');
        if( $this->tenant_id != 0 )
        $this->db->where('ad.tenant_id', $this->tenant_id);
        if ($this->session->userdata('admin_group_id') !=1)
        $this->db->where('id_admin_group !=',1);
        $rs = $this->db->get();
        $users = $rs->result_array();
        return $users;
    }

    public function count_list()
    {
        $this->db->select('ad.id');
        $this->db->from('admins ad');
        $this->db->join('admin_group ag', 'ag.id = ad.id_admin_group', 'left');
        $this->db->join('tenant t', 't.id = ad.tenant_id', 'left');;
        if( $this->tenant_id != 0 )
        $this->db->where('ad.tenant_id', $this->tenant_id);
        if ($this->session->userdata('admin_group_id') !=1)
        $this->db->where('id_admin_group !=',1);
        $rs = $this->db->get();
        $users = $rs->num_rows();
        return $users;
    }

    public function add($data)
    {
        $this->db->insert('admins', $data);
        return $this->db->insert_id();
    }

    public function edit($id = '', $data)
    {
        return $this->db->update('admins', $data, array('id' => $id));
    }


    public function get_admin_details($id)
    {
        $this->db->select('ad.username,email,mobile,image,address,ad.status,CONCAT(ad.firstname," ",ad.lastname) as full_name,ag.title admin_type', false);
        $this->db->from('admins ad');
        $this->db->join('admin_group ag', 'ag.id = ad.id_admin_group', 'left');
        $this->db->where('ad.id', $id);
        return $this->get_row();
    }

    public function get_record($id)
    {
        $this->db->select('*');
        $this->db->from('admins');
        $this->db->where('id', $id);
        return $this->get_row();
    }

    public function change_status($id, $val)
    {
        $this->db->where('id', $id);
        $this->db->update('admins', array('status' => strtoupper($val)));
    }

    public function del($id)
    {
        $this->db->delete('admins', array('id' => $id));
    }

    public function check_varify_password($id, $password)
    {
        $this->db->select('admins.*');
        $this->db->from('admins');
        $this->db->where('id',$id);
        $user = $this->get_row();
        if (!empty($user))
        {
            return password_verify($password, $user['password']);
            
        }
        return FALSE;
    } 

    function update_pass($id,$data)
	{
		$this->db->update('admins',$data,array('id'=>$id));
	}


    public function get_details_record($id)
    {
        $this->db->select('*');
        $this->db->from('admin_details');
        $this->db->where('admin_id', $id);
        return $this->get_row();
    }
 	

}