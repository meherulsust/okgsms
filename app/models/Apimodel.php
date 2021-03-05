<?php

/*
 * 
 */

class Apimodel extends MT_Model {

    function auth_user($data) {
        $this->db->select('admin.id,id_admin_group, username, firstname,ag.title admin_type,lastname,' .
        ' email, address, mobile,admin.status');
        $this->db->from('admin');
        $this->db->join('admin_group ag', 'ag.id = id_admin_group', 'left');
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['password']);
        $this->db->where('admin.status', 'ACTIVE');
        $query = $this->db->get();
        return $query->row_array();
    }
}    

