<?php
/*
| -----------------------------------------------------
| PRODUCT NAME         :
-----------------------------------------------------
| CONTROLLER CLASS NAME: Loginmodel
| -----------------------------------------------------
| AUTHOR               : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL                : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT            : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE:
| -----------------------------------------------------
 */
class Loginmodel extends MT_Model
{
    public function __construct()
    {
        
    }

    public function check_login()
    {
        
        $user = $this->input->post('username');
        $pass =  $this->input->post('password');
        $tenant_id = $this->input->post('tenant_id');
    
        if($this->login_access($user,$pass)){
            $this->db->select('a.*');
            $this->db->from('admins a');
            if($tenant_id !='0'){
            $this->db->join('tenant t', 't.id = a.tenant_id', 'left');
            $this->db->where('t.status','Active');
            }
            $this->db->where(array('a.username' => $user,'a.tenant_id'=>$tenant_id,'a.status' => 'ACTIVE'));
            $row = $this->get_row();
        }
        if ($this->db->affected_rows() == 1) {
            $row = $row;
        }

        if ($this->db->affected_rows() > 1) {
            $row = array();
        }

        return $row;
    }

    public function get_logged_user()
    {
        $tenant_id = $this->session->userdata('tenant_id');
        $userid = $this->session->userdata('admin_userid');
        $username = $this->session->userdata('admin_username');
        $admin_group_id = $this->session->userdata('admin_group_id');
        $this->db->select('a.id,id_admin_group, a.username, a.firstname,ag.title admin_type,a.lastname,a.email,a.address, a.mobile,a.status');
        $this->db->from('admins a');
        if($tenant_id !='0'){
            $this->db->join('tenant t', 't.id = a.tenant_id', 'left');
            $this->db->where('t.status','Active');
        }
        $this->db->join('admin_group ag', 'ag.id = id_admin_group', 'left');
        $this->db->where(array('a.id' => $userid, 'a.username' => $username,'a.tenant_id'=>$tenant_id));
        $user = $this->get_row();
        return $user;
    }

    public function update_login_time($user_id, $date_time)
    {
        $data['last_login_time'] = $date_time;
        $this->db->update('admins', $data, array('id' => $user_id));
    }


    private function login_access($username, $password)
    {
        $this->db->select('admins.*');
        $this->db->from('admins');
        $this->db->where('username',$username);
        $user = $this->get_row();
        if (!empty($user))
        {
            return password_verify($password, $user['password']);
            
        }
        return FALSE;
    } 

}