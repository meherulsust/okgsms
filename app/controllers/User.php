<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME          : OKGSMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : User
| -----------------------------------------------------
| AUTHOR                : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL                 : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT             : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE               :
| -----------------------------------------------------
 */
class User extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('usermodel'));
        $this->tpl->set_page_title('User Management');
        $admin_group_options = $this->optionmodel->group_option(); // get admin group list
        $this->assign('admin_group_options', $admin_group_options);
        $tenant_options = $this->optionmodel->tenant_option(); // get tenant list
        $this->assign('tenant_options', $tenant_options);
        $status_option = array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE');
		$this->assign('status_options', $status_option);
    }

    public function index($sort_type = 'desc', $sort_on = 'id')
    {
        $this->tpl->set_js(array('jquery.statusmenu'));
        $head = array('page_title'=>'User list','link_title'=>'New User','link_action'=>'user/add');
        if( $this->tenant_id == 0 ){
            $labels = array('username' => 'Username', 'full_name' => 'Name', 'email' => 'Email', 'admin_type' => 'Group', 'status' => 'Status');
            $this->assign('grid_action', array('view' => 'view', 'edit' => 'edit'));
        }else{
            $labels = array('username' => 'Username', 'full_name' => 'Name', 'email' => 'Email', 'admin_type' => 'Group', 'status' => 'Status');
            $this->assign('grid_action', array('details' => 'details','view' => 'view', 'edit' => 'edit'));
        }
        $this->assign('labels', $labels);
        $config['total_rows'] = $this->usermodel->count_list();
        $config['uri_segment'] = 6;
        $config['select_value'] = $this->input->post('rec_per_page');
        $config['sort_on'] = $sort_on;
        $config['sort_type'] = $sort_type;
        $this->set_pagination($config);
        $users = $this->usermodel->get_list();
        $this->assign('records', $users);
        $this->load->view('user/user_list',$head);
    }

    public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('user');
        }
        $user = $this->usermodel->get_admin_details($id); // get record
        if ($user) {
            $head = array('page_title'=>'View User information','link_title'=>'User List','link_action'=>'user/index');
            $this->assign($user);
            $this->load->view('user/view_user',$head);
        } else {
            $this->view_404();
        }
    }

    public function add()
    {
        $head = array('page_title'=>'New User','link_title'=>'User List','link_action'=>'user/index');
        $this->form_validation->set_rules($this->validate()); // set validation rules
        $this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
        if ($this->form_validation->run() == false) {
            $this->load->view('user/new_user',$head);
        } else {
            $data['username']       = $this->input->post('username');
            $data['password']       = $this->hash_password($this->input->post('password'));
            $data['full_name']      = $this->input->post('full_name');
            $data['email']          = $this->input->post('email');
            $data['mobile']         = $this->input->post('mobile');
            $data['address']        = $this->input->post('address');
            $data['id_admin_group'] = $this->input->post('id_admin_group');
            $data['created_at']     = $this->current_date();
            $data['created_by']     = $this->session->userdata('admin_userid');
            $data['status']         = $this->input->post('status');
            $data['tenant_id']      = $this->input->post('tenant_id')? $this->input->post('tenant_id') :0;

            if (trim($_FILES["image_file"]["name"]) != '') {
                $ext = explode(".", $_FILES['image_file']['name']);
                $file_ext = end($ext);
                $file_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;
                if ($this->upload_images('image_file', $file_name,'user_image')) {

                    $data['image'] = $file_name;
                    $user_id = $this->usermodel->add($data);
                    $this->session->set_flashdata('message', $this->tpl->set_message('add', 'User'));
                    redirect('user/index');

                } else {
                    $head['upload_error'] = $this->upload->display_errors();
                    $this->load->view('user/new_user', $head);
                }
            } else {
                $user_id = $this->usermodel->add($data);
                $this->session->set_flashdata('message', $this->tpl->set_message('add', 'User'));
                redirect('user/index');
            }
        }
    }
    
    public function edit($id = '')
    {
        $id = decode($id);
        $head = array('page_title'=>'Edit user information','link_title'=>'User list','link_action'=>'user/index');
        $user = $this->usermodel->get_record($id); // get record
        $readonly = ($this->session->userdata('admin_userid') == $id) ? 'readonly' : '';
        $this->assign('readonly',$readonly);
        $this->assign($user);
        if (!empty($user)) {
            $config1 = array(
                array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[5]|max_length[20]|callback_duplicate_user_check[' . $user['username'] . ']'),
                array('field' => 'id_admin_group', 'label' => 'Admin Group', 'rules' => 'required'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|callback_duplicate_email_check[' . $user['email'] . ']'),
                array('field' => 'full_name', 'label' => 'Full Name', 'rules' => 'trim|required'),
                array('field' => 'lastname', 'label' => 'Last Name', 'rules' => 'trim'),
                array('field' => 'address', 'label' => 'Address', 'rules' => 'trim'),
                array('field' => 'mobile', 'label' => 'Mobile number', 'rules' => 'trim|required'),
                array('field' => 'status', 'label' => 'status', 'rules' => 'trim|required'),
            );
            $config2 = array(
                array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|matches[confirm_password]|min_length[6]|alpha_numeric|callback_password_check'),
                array('field' => 'confirm_password', 'label' => 'Confirmation', 'rules' => 'trim|required')
            );
            $config3 = array(
                array('field' => 'tenant_id', 'label' => 'Tenant', 'rules' => 'trim|required')
            );
           
            if ($this->input->post('password') !='') {
                $config = array_merge($config1, $config2);
                $this->form_validation->set_rules($config);
                $this->form_validation->set_message('matches', 'Confirm password did not match with password');
            }else if ($this->input->post('tenant_id') !='') {
                $config = array_merge($config1, $config3);
                $this->form_validation->set_rules($config);
            }else {
                $this->form_validation->set_rules($config1);
            }
            $this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');

            if ($this->form_validation->run() == false) {
                $this->load->view('user/edit_user',$head);
            } else {
                $data['username']        = $this->input->post('username');
                $data['full_name']      = $this->input->post('full_name');
                $data['lastname']        = $this->input->post('lastname');
                $data['email']           = $this->input->post('email');
                $data['mobile']          = $this->input->post('mobile');
                $data['address']         = $this->input->post('address');
                $data['updated_by']      = $this->session->userdata('admin_userid');
                $data['id_admin_group']  = $this->input->post('id_admin_group');
                $data['status']          = $this->input->post('status');
                $data['tenant_id']       = $this->input->post('tenant_id')? $this->input->post('tenant_id') :0;
                if (!empty($this->input->post('password'))) {
                    $data['password'] = $this->hash_password($this->input->post('password'));
                }
                if (trim($_FILES["image_file"]["name"]) != '') {
                    $ext = explode(".", $_FILES['image_file']['name']);
                    $file_ext = end($ext);
                    $file_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;
                    if ($this->upload_images('image_file', $file_name,'user_image')) {

                        $data['image'] = $file_name;
                        $this->usermodel->edit($id, $data); // Update data
                        if ($user['image'] != '') {
                            unlink($this->upload_dir() . "user_image/" . $user['image']);
                        }
                        $this->session->set_flashdata('message', $this->tpl->set_message('edit', 'User'));
                        redirect('user/index');

                    } else {
                        $head['upload_error'] = $this->upload->display_errors();
                        $this->load->view('user/edit_user', $head);
                    }
                } else {
                    $this->usermodel->edit($id, $data); // Update data
                    $this->session->set_flashdata('message', $this->tpl->set_message('edit', 'User'));
                    redirect('user/index');
                }
            }
        } else {
            $this->view_404();
        }
    }

    public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'usermodel', 'change_status'); //model name 'usermdoel' method name 'change_status'
    }

    public function del($id = '')
    {
        $id = decode($id);
        $present_user_id = $this->session->userdata('admin_userid');
        $user = $this->usermodel->get_record($id);
        if ($present_user_id == $id) {
            $status = 0;
            $message = $this->tpl->set_message('error', 'You can not delete yourself!.');
        } else {
            $this->usermodel->del($id);
            $status = 1;
            if (isset($user['image']) and $user['image'] != "") {
                unlink($this->upload_dir() . "user_image/" . $user['image']);
            }
            $message = $this->tpl->set_message('delete', 'User');
        }
        $array = array('status' => $status, 'message' => $message);
        echo json_encode($array);
    }

    // Check password for alpha numeric

    public function password_check($str, $param = '')
    {
        if (!empty($str)) {
            if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
                return true;
            } else {
                $this->form_validation->set_message('password_check', 'Password must contain at least uppercase,lowercase and number characters');
                return false;
            }
        }
    }

    //check duplicate email for validation

    public function duplicate_email_check($str, $param = '')
    {
        $query = $this->db->query("SELECT id FROM sms_admins where email='$str' AND email<>'$param'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('duplicate_email_check', "%s <span style='color:green;'>$str</span> already exists");
            return false;
        }
        return true;
    }

    // validation function for checking username duplicacy

    public function duplicate_user_check($str, $param = '')
    {
        $tenant_id = $this->input->post('tenant_id');
        $query = $this->db->query("SELECT id FROM sms_admins where username='$str' AND tenant_id='$tenant_id' AND username<>'$param'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('duplicate_user_check', "%s <span style='color:green;'>$str</span> already exists");
            return false;
        }
        return true;

    }



    private function validate($id=''){
        $config = array(
            array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[5]|max_length[20]|callback_duplicate_user_check'),
            array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|matches[confirm_password]|min_length[6]|alpha_numeric|callback_password_check'),
            array('field' => 'confirm_password', 'label' => 'Confirmation', 'rules' => 'trim|required'),
            array('field' => 'id_admin_group', 'label' => 'Admin Group', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|callback_duplicate_email_check'),
            array('field' => 'full_name', 'label' => 'Full Name', 'rules' => 'trim|required'),
            array('field' => 'lastname', 'label' => 'Last Name', 'rules' => 'trim'),
            array('field' => 'address', 'label' => 'Address', 'rules' => 'trim'),
            array('field' => 'mobile', 'label' => 'Mobile number', 'rules' => 'trim|required'),
            array('field' => 'status', 'label' => 'status', 'rules' => 'trim|required')
        );
        $config1 = array(
            array('field' => 'tenant_id', 'label' => 'tenant', 'rules' => 'trim|required')
        );
        
        if($this->input->post('tenant_id') !=''){
            $config = array_merge($config,$config1);  
        }
        return $config;
    }

    function details($id=""){
        $id = decode($id);
        $head = array('page_title'=>'Detail information','link_title'=>'User list','link_action'=>'user/index');
        $details = $this->usermodel->get_details_record($id); // get record
        printr($details);exit;


    }


}