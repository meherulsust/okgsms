<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME			: SMS
| -----------------------------------------------------
| AUTHOR                : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL					: meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT             : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE				:			
| -----------------------------------------------------
*/
 class Employee extends MT_Controller
 {
 	 function __construct()
 	 {
 	 	parent::__construct();
		
 	 	$this->load->model(array('employeemodel','optionmodel'));
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
		$this->tpl->set_page_title('Employee List');
		$status_options = array('Active'=>'Active','Inactive'=>'Inactive');
		$religion_options = $this->optionmodel->religion_options();	
		$blood_group_options = $this->optionmodel->blood_group_options();
		$gender_options = array('MALE'=>'Male','FEMALE'=>'Female'); 		
		$this->assign('gender_options',$gender_options);
		$category_options = array('1'=>'Teaching Stuff','2'=>'Non-Teaching Stuff'); 
		$admin_group_options = $this->optionmodel->group_option(); // get admin group list
        $this->assign('admin_group_options', $admin_group_options);
		$this->assign('category_options',$category_options);
		$this->assign('religion_options',$religion_options);
		$this->assign('blood_group_options',$blood_group_options);
		$this->assign('status_options',$status_options);
    }
  	function index($sort_type='asc',$sort_on='id')
  	{
		$data['username'] = $this->input->post('username');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $this->load->library('search');
        $search_data = $this->search->data_search($data);
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Employee List','link_title'=>'New Employee','link_action'=>'Employee/add');
  	    $labels=array('name'=>'Full Name','username'=>'Username','designation'=>'Designation','gender'=>'Gender','mobile_no'=>'Mobile','status'=>'Status');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->employeemodel->count_list($search_data);
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on']=$sort_on;
		$config['sort_type']=$sort_type;
		if($this->session->userdata('admin_userid')==1){
		$this->assign('grid_action',array('view'=>'view','edit'=>'edit','del'=>'del'));
		}else{
		$this->assign('grid_action',array('view'=>'view','edit'=>'edit'));	
		}
		$this->set_pagination($config);
  		$teachers=$this->employeemodel->get_list($search_data);
  		$this->assign('records',$teachers);
  		$this->load->view('employee/list',$head);
  	}
	
	
	function view($id='')
	{
		$id = decode($id);
		if($id=='')
		{
			redirect('Employee');
		}
		$head = array('page_title'=>'New Employee','link_title'=>'Employee List','link_action'=>'Employee/index');
		$row=$this->employeemodel->get_record($id);							// get record
		$this->assign($row); 
		$this->load->view('employee/view',$head);
	}
	
  	function add()
  	{
		$head = array('page_title'=>'New Employee','link_title'=>'Employee List','link_action'=>'Employee/index');
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg(); 

		if ($this->form_validation->run() == FALSE)
		{			
			$this->load->view('employee/new');			
		}
		else
		{
			$login['username']       	= $this->input->post('username');
            $login['password']      	= $this->hash_password($this->input->post('password') ?$this->input->post('password') : 123456 );
			$login['id_admin_group']	= $this->input->post('id_admin_group');
			$login['full_name']			= $this->input->post('name');
			$login['email']				= $this->input->post('email');
			$login['mobile']		    = $this->input->post('mobile_no');

			$data['name']			    = $this->input->post('name');
			$data['category_id']		= $this->input->post('category_id');
			$data['designation']		= $this->input->post('designation');
			$data['dob']				= $this->input->post('dob');
			$data['gender']				= $this->input->post('gender');
			$data['blood_group_id']		= $this->input->post('blood_group_id');
			$data['mobile_no']			= $this->input->post('mobile_no');
			$data['address']			= $this->input->post('address');
			$data['religion_id']		= $this->input->post('religion_id');
			$data['serial']				= $this->input->post('serial');
			$data['status']				= $this->input->post('status');
			$data['relevant_subject']	= $this->input->post('relevant_subject');
			$data['join_date']			= $this->input->post('join_date');
			$data['created_at']  	    = $this->current_date();
			$data['created_by']  		= $this->session->userdata('admin_userid');

			if(trim($_FILES["photo"]["name"])!='' OR  $_FILES["cv"]["name"] !='') 
			{
				if(trim($_FILES["photo"]["name"]) != '' ){
					$ext = explode(".", $_FILES["photo"]["name"]);
					$file_ext = end($ext);
					$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
					if ($this->upload_images('photo',$image_name,'employee_images')) { // field_name, iamge_name ,folder_name
						$data['photo'] = $image_name;
					}else{
						$upload_error['error_photo'] =  $this->upload->display_errors(); 			
					} 
				}
				
				if(trim($_FILES["cv"]["name"]) != '' ){
					$ext = explode(".", $_FILES["cv"]["name"]);
					$file_ext = end($ext);
					$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
					if ($this->upload_images('cv',$image_name,'employee_cv')) { // field_name, iamge_name ,folder_name
						$data['cv'] = $image_name;
					}else{
						$upload_error['error_cv'] =  $this->upload->display_errors(); 			
					} 
				}
				
				if($this->upload->display_errors()){
					$head = array('page_title'=>'Add Employee','link_title'=>'Employee List','link_action'=>'Employee/index');
					$this->assign($upload_error);
					$this->load->view('employee/add',$head);	
				}
				else{
					if($data['category_id']=='1'){
						$result = $this->employeemodel->add_user($login);
						$data['admin_id'] = $result; 
						$this->employeemodel->add($data);
					}else{
						$this->employeemodel->add($data);
					}
					$this->session->set_flashdata('message', $this->tpl->set_message('add', 'Employee'));
					redirect('Employee');	
				}
			
			}else{
				if($data['category_id']=='1'){
					$result = $this->employeemodel->add_user($login);
					$data['admin_id'] = $result; 
					$this->employeemodel->add($data);
				}else{
					$this->employeemodel->add($data);
				}
				$this->session->set_flashdata('message',$this->tpl->set_message('add','Employee'));
				redirect('Employee');
				 		
			}
			
		}			
  	}

	function edit($id)
	{
		$id = decode($id);
		$head = array('page_title'=>'Edit Employee','link_title'=>'Employee List','link_action'=>'Employee/index');
		$row=$this->employeemodel->get_record($id);							// get record
		$this->form_validation->set_rules($this->validate($row));
		$this->validation_error_msg(); 		
		$admin_id = $row['admin_id'];
		$this->assign($row);  
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('employee/edit');
		}
		else
		{
			$login['username']       	= $this->input->post('username');
			$login['id_admin_group']	= $this->input->post('id_admin_group');
			$login['full_name']			= $this->input->post('name');
			$login['email']				= $this->input->post('email');
			$login['mobile']		    = $this->input->post('mobile_no');
			if($this->input->post('password') !=''){
				$login['password']      	= $this->hash_password($this->input->post('password'));
			}
			$data['name']			    = $this->input->post('name');
			$data['category_id']		= $this->input->post('category_id');
			$data['designation']		= $this->input->post('designation');
			$data['dob']				= $this->input->post('dob');
			$data['gender']				= $this->input->post('gender');
			$data['blood_group_id']		= $this->input->post('blood_group_id');
			$data['mobile_no']			= $this->input->post('mobile_no');
			$data['address']			= $this->input->post('address');
			$data['religion_id']		= $this->input->post('religion_id');
			$data['serial']				= $this->input->post('serial');
			$data['status']				= $this->input->post('status');
			$data['relevant_subject']	= $this->input->post('relevant_subject');
			$data['join_date']			= $this->input->post('join_date');
			$data['created_at']  	    = $this->current_date();
			$data['updated_by']  		= $this->session->userdata('admin_userid');
			
			if(trim($_FILES["photo"]["name"])!='' OR  $_FILES["cv"]["name"] !='') 
			{
				if(trim($_FILES["photo"]["name"]) != '' ){
					$ext = explode(".", $_FILES["photo"]["name"]);
					$file_ext = end($ext);
					$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
					if ($this->upload_images('photo',$image_name,'employee_images')) { // field_name, iamge_name ,folder_name
						$data['photo'] = $image_name;
						if ($row['photo'] != '') {
							unlink($this->upload_dir() . "employee_images/" . $row['photo']);
						}
					}else{
						$upload_error['error_photo'] =  $this->upload->display_errors(); 			
					} 
				}
				
				if(trim($_FILES["cv"]["name"]) != '' ){
					$ext = explode(".", $_FILES["cv"]["name"]);
					$file_ext = end($ext);
					$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
					if ($this->upload_images('cv',$image_name,'employee_cv')) { // field_name, iamge_name ,folder_name
						$data['cv'] = $image_name;
						if ($row['cv'] != '') {
							unlink($this->upload_dir() . "employee_cv/" . $row['cv']);
						}
					}else{
						$upload_error['error_cv'] =  $this->upload->display_errors(); 			
					} 
				}
				
				if($this->upload->display_errors()){
					$head = array('page_title'=>'Edit Employee','link_title'=>'Employee List','link_action'=>'Employee/index');
					$this->assign($upload_error);
					$this->load->view('employee/edit',$head);	
				}
				else{
					if($data['category_id']=='1'){
						$this->employeemodel->edit_user($admin_id,$login);
						$this->employeemodel->edit($id,$data);
					}else{
						$this->employeemodel->edit($id,$data);
					}
					$this->session->set_flashdata('message', $this->tpl->set_message('edit', 'Employee'));
					redirect('Employee');	
				}
			
			}else{
				if($data['category_id']=='1'){
					$this->employeemodel->edit_user($admin_id,$login);
					$this->employeemodel->edit($id,$data);
				}else{
					$this->employeemodel->edit($id,$data);
				}
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Employee'));
				redirect('Employee');
				 		
			}
		}
	}

	function set_status($id,$val)
	{
		echo $this->status_change($id,$val,'employeemodel','change_status'); //model name 'usermdoel' method name 'change_status'
	}

	function del($id)
	{
		$id = decode($id);
		$row = $this->employeemodel->get_record($id);
		$this->employeemodel->del($id);	
		$status = 1;
		unlink($this->upload_dir()."employee_images/".$row['photo']);
		unlink($this->upload_dir()."employee_cv/".$row['cv']);
		$message = $this->tpl->set_message('delete','Employee');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}

	private function validate($row=''){
        $config1 = array(
			array('field'=>'name','label'=>'Name','rules'=>'trim|required|min_length[5]|max_length[20]'),
			array('field'=>'category_id','label'=>'Category','rules'=>'trim|required'),
			array('field'=>'designation','label'=>'Designation','rules'=>'trim|required'),  
			array('field'=>'dob','label'=>'Date of Birth','rules'=>'trim|required'),  
			array('field'=>'gender','label'=>'Gender','rules'=>'trim|required'),  
			array('field'=>'blood_group_id','label'=>'Blood Group','rules'=>'trim|required'),  
			array('field'=>'religion_id','label'=>'Religion','rules'=>'trim'),  
			array('field'=>'address','label'=>'Address','rules'=>'trim'),  
			array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required'),  
			array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
			array('field'=>'photo','label'=>'Photo','rules'=>'trim'),
			array('field'=>'cv_upload','label'=>'Upload CV','rules'=>'trim'),
			array('field'=>'relevant_subject','label'=>'Relevant Subject','rules'=>'trim'),
			array('field'=>'serial','label'=>'Serial','rules'=>'trim'),
			array('field'=>'join_date','label'=>'Join Date','rules'=>'trim'), 		
        );

		if(!empty($row)){
			$config2 = array(
				array('field'=>'username','label'=>'Username','rules'=>'trim|required|min_length[4]|max_length[20]|callback_duplicate_teacher_check[' . $row['username'] . ']'),
				array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email|callback_duplicate_email_check[' . $row['email'] . ']'),
				array('field'=>'password','label'=>'Password','rules'=>'trim'),
				array('field'=>'id_admin_group','label'=>'Group','rules'=>'trim'),
			);
		}else{
			$config2 = array(
				array('field'=>'username','label'=>'Username','rules'=>'trim|required|min_length[4]|max_length[20]|callback_duplicate_teacher_check'),
				array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email|callback_duplicate_email_check'),
				array('field'=>'password','label'=>'Password','rules'=>'trim'),
				array('field'=>'id_admin_group','label'=>'Group','rules'=>'trim'),
			);
	
		}

		if($this->input->post('category_id')==1){
			$config = array_merge($config1,$config2);
		}else{
			$config = $config1;
		}
		
        return $config;
    }

	
 	//check duplicate email for validation
	
	function duplicate_email_check($str,$param='')
    {
		$query = $this->db->query("SELECT id FROM sms_admins where email='$str' AND email<>'$param'");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_email_check', "%s <span style='color:green;'>$str</span> already exists");
		 	 	 return false;
       }
       return true;
	}

	// validation function for checking username duplicacy 

	function duplicate_teacher_check($str,$param='')
  	{
      $query = $this->db->query("SELECT id FROM sms_admins where username='$str' AND username<>'$param'");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_teacher_check', "%s <span style='color:green;'>$str</span> already exists");
		 	 	 return false;
       }
       return true;

  	}

	
 }
