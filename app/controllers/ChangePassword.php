<?php
/*
| -----------------------------------------------------
| PRODUCT NAME          : OKGSMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : ChangePassword
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
class ChangePassword extends MT_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('usermodel');
    }
	
	function index()
	{

		$id = $this->session->userdata('admin_userid');
		$user=$this->usermodel->get_record($id);
		$this->load->library(array('form_validation'));
		$config=array(					
					array('field' => 'old_password','label' => 'Old Password','rules' => 'trim|required'),
					array('field' => 'password','label' => 'Password','rules' => 'trim|required|matches[confirm_password]|min_length[6]|alpha_numeric|callback_password_check'),
					array('field' => 'confirm_password','label' => 'Confirmation Password','rules' => 'trim|required')
				);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if ($this->form_validation->run() == FALSE)
		{
			
			$head = array('page_title'=>'Change Password');
			$this->load->view('change_password/add',$head);
			
		}
		else
		{
			$data['password'] = $this->hash_password($this->input->post('password'));
			if($this->usermodel->check_varify_password($id,$this->input->post('old_password')))
			{
				$this->usermodel->update_pass($id,$data);         // update password		
				$this->session->set_flashdata('message',$this->tpl->set_message('Edit','Password'));
				redirect('ChangePassword');			
			}
			else
			{
				$this->session->set_flashdata('message',$this->tpl->set_message('error','Wrong old Password'));
				redirect('ChangePassword');
			}
		}			
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


}

