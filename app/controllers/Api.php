<?php
/*
| -----------------------------------------------------
| PRODUCT NAME             :
|-----------------------------------------------------
| CONTROLLER CLASS NAME    : Api
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

class Api extends MT_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('html', 'array', 'form'));
        $this->load->model(array('apimodel'));
    }

    /* --------------- check login ------------------ */

    function check_login() {
        $json = $this->input->post();
        //$json = '{"username":"meher","password":"m13456"}';
    
        $data['username'] = $json['username'];
        $data['password'] = md5($json['password']);
	
        $user = $this->apimodel->auth_user($data);
        
        if ($user) {
            $user['user_id'] = $user['id'];
            $user['name'] = $user['full_name'] . '' . $user['full_name'];
        
            $user['status'] = 'success';
            $user['message'] = 'Login Successful.';
            $responses['user'][] = $user;
        } else {
            $user['user_id'] = '';
            $user['username'] = '';
        
            $user['status'] = 'fail';
            $user['message'] = 'Username or password did not match.';
            $responses['user'][] = $user;
        }
        header("content_type: application/json", True);
        echo json_encode($responses);
    }

}