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

    public function country_option()
    {
        $this->db->select('id, country as title');
        $this->db->from('country');
        $this->db->where('status', 'Active');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();
    }

    public function weather_division_options()
    {
        $this->db->select('id, weather_division as title');
        $this->db->from('weather_division');
        $this->db->where('status', 'Active');
        if( $this->tenant_id != 0 )
        $this->db->where('tenant_id', $this->tenant_id);
        $this->db->order_by('title', 'asc');
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
		$this->db->where('status=','Active');
		$this->db->order_by('id','asc');
 		return $this->get_assoc(); 
 	}


}