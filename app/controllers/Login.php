<?php
/*
| -----------------------------------------------------
| PRODUCT NAME             : OKGSMS
|-----------------------------------------------------
| CONTROLLER CLASS NAME    : Login
| -----------------------------------------------------
| AUTHOR                   : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL                    : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT                : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE                  :
| -----------------------------------------------------
 */
class Login extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->set_layout('login_layout');
        $this->load->helper(array('html', 'array', 'form'));
        $this->load->model(array('menumodel')); // Load Model
        $this->assign('tenant_info',$this->tenant_info());
    }

    public function index()
    {
        $this->tpl->set_css('login_style');
        $this->load->library(array('form_validation'));
        $config = array(
            array('field' => 'username', 'label' => 'Username', 'rules' => 'trim'),
            array('field' => 'password', 'label' => 'password', 'rules' => 'trim'),
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        if ($this->form_validation->run() == false) {
            $status = 0;
            $this->load->view('login/login_page');
        } else {
            $user = $this->loginmodel->check_login();
            $id = !empty($user) ? $user['id_admin_group'] : '0';
            if ($id != 0) {
                $menu_list[1] = [];
                $menu_list = $this->menumodel->get_home_menulist($id);
                $home = !empty($menu_list[1]) ? $menu_list[1] : [];
            }
            if (!empty($user)) {
                if (!empty($home)) {
                    echo $this->subdomain;exit;
                    if($this->subdomain !='' AND $user['id_admin_group']!=1){
                        $status = 1; // tenant admin
                        $this->session_set();
                    }else if(in_array($this->subdomain,array('139.59.15.182','localhost')) AND $user['id_admin_group']==1){
                        $status = 3; //tenant superadmin
                        $this->session_set();
                    }else{
                        $status =5; // not superadmin
                    }
                    
                } else {
                    $status = 2;
                }
            } else {
                $status = 0;
            }
            echo $status;exit;
        }
    }

    private function session_set(){
        $user = $this->loginmodel->check_login();
        $date_time = $this->current_date();
        $this->loginmodel->update_login_time($user['id'], $date_time); // update last login time
        $sdata['tenant_id']         = $user['tenant_id'];
        $sdata['admin_username']    = $user['username'];
        $sdata['admin_email']       = $user['email'];
        $sdata['admin_userid']      = $user['id'];
        $sdata['admin_group_id']    = $user['id_admin_group'];
        $sdata['image']             = $user['image'];
        $this->session->set_userdata($sdata);
    }

    public function logout()
    {
        $sdata['admin_username'] = '';
        $sdata['admin_email'] = '';
        $sdata['admin_userid'] = '';
        $sdata['admin_group_id'] = '';
        $sdata['image'] = '';
        $sdata['tenant_id'] = '';
        $this->session->sess_destroy($sdata);
        redirect('login');
    }
}