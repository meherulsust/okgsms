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
| WEBSITE				:http://aimictacademy.com/		
| -----------------------------------------------------
*/
 class Student extends MT_Controller
 {
 	 function __construct()
 	 {
 	 	parent::__construct();
		
 	 	$this->load->model(array('studentmodel'));
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
		$this->tpl->set_page_title('Student List');
		$status_options = array('Active'=>'Active','Inactive'=>'Inactive');
		$religion_options = $this->optionmodel->religion_options();	
		$blood_group_options = $this->optionmodel->blood_group_options();
		$gender_options = array('Male'=>'Male','Female'=>'Female','Others'=>'Others'); 		
		$this->assign('gender_options',$gender_options);
		$class_options = $this->optionmodel->class_options();; 		
		$this->assign('class_options',$class_options);
		$section_options = $this->optionmodel->section_options();; 		
		$this->assign('section_options',$section_options);
		$student_type_options = $this->optionmodel->student_type_options();; 		
		$this->assign('student_type_options',$student_type_options);
		$this->assign('religion_options',$religion_options);
		$this->assign('blood_group_options',$blood_group_options);
		$this->assign('status_options',$status_options);
		$this->tpl->set_js(array('select-chain'));
    }
  	function index($sort_type='asc',$sort_on='id')
  	{
		$data['id_no'] = $this->input->post('id_no');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $this->load->library('search');
        $search_data = $this->search->data_search($data);
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Student List','link_title'=>'New Student','link_action'=>'Student/add');
  	    $labels=array('id_no'=>'Student No','name'=>'Full Name','class'=>'Class','section'=>'Section','mobile_no'=>'Mobile','status'=>'Status');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->studentmodel->count_list($search_data);
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
  		$teachers=$this->studentmodel->get_list($search_data);
  		$this->assign('records',$teachers);
  		$this->load->view('student/list',$head);
  	}
	
	
	function view($id='')
	{
		$id = decode($id);
		if($id=='')
		{
			redirect('Student');
		}
		$head = array('page_title'=>'New Student','link_title'=>'Student List','link_action'=>'Student/index');
		$row=$this->studentmodel->get_record($id);							// get record
		$this->assign($row); 
		$this->load->view('student/view',$head);
	}
	
  	function add()
  	{
		$head = array('page_title'=>'New Student','link_title'=>'Student List','link_action'=>'Student/index');
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg(); 

		if ($this->form_validation->run() == FALSE)
		{			
			$this->load->view('student/new',$head);			
		}
		else
		{
			
			$data['student_type_id']	  = $this->input->post('student_type_id');
			$data['full_name']			  = $this->input->post('name');
			$data['password']      		  = $this->hash_password('123456');
			$data['admission_date']	      = $this->input->post('admission_date');
			$data['class_id']		      = $this->input->post('class_id');
			$data['section_id']			  = $this->input->post('section_id');
			$data['id_no']				  = $this->input->post('id_no');
			$data['dob']				  = $this->input->post('dob');
			$data['birth_certificate_no'] = $this->input->post('birth_certificate_no');
			$data['is_siblings']		  = $this->input->post('is_siblings');
			$data['father_nid']		  	  = $this->input->post('father_nid');
			$data['mother_nid']		      = $this->input->post('mother_nid');
			$data['siblings_class_id']	  = $this->input->post('siblings_class_id');
			$data['siblings_section_id']  = $this->input->post('siblings_section_id');
			$data['siblings_id'] 		  = $this->input->post('siblings_id');
			$data['mobile_no']			  = $this->input->post('mobile_no');
			$data['religion_id']		  = $this->input->post('religion_id');
			$data['blood_group_id']		  = $this->input->post('blood_group_id');
			$data['status']				  = $this->input->post('status');
			$data['gender']	  			  = $this->input->post('gender');
			$data['description']		  = $this->input->post('description');
			$data['session']		  	  = $this->input->post('session');
			$data['created_at']  	      = $this->current_date();
			$data['created_by']  		  = $this->session->userdata('admin_userid');

			if(trim($_FILES["photo"]["name"])!='') 
			{
				if(trim($_FILES["photo"]["name"]) != '' ){
					$ext = explode(".", $_FILES["photo"]["name"]);
					$file_ext = end($ext);
					$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
					if ($this->upload_images('photo',$image_name,'student_images')) { // field_name, iamge_name ,folder_name
						$data['photo'] = $image_name;
					}else{
						$upload_error['error_photo'] =  $this->upload->display_errors(); 			
					} 
				}
				
				if($this->upload->display_errors()){
					$head = array('page_title'=>'Add Student','link_title'=>'Student List','link_action'=>'Student/index');
					$this->assign($upload_error);
					$this->load->view('student/add',$head);	
				}
				else{
					$this->studentmodel->add($data);
					$this->session->set_flashdata('message', $this->tpl->set_message('add', 'Student'));
					redirect('Student');	
				}
			
			}else{
				$this->studentmodel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('add','Student'));
				redirect('Student');
				 		
			}
			
		}			
  	}

	function edit($id)
	{
		$id = decode($id);
		$head = array('page_title'=>'Edit Student','link_title'=>'Student List','link_action'=>'Student/index');
		$row=$this->studentmodel->get_record($id);							// get record
		$this->form_validation->set_rules($this->validate($row));
		$this->validation_error_msg(); 		
		$admin_id = $row['admin_id'];
		$this->assign($row);  
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('student/edit',$head);
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
					if ($this->upload_images('photo',$image_name,'student_images')) { // field_name, iamge_name ,folder_name
						$data['photo'] = $image_name;
						if ($row['photo'] != '') {
							unlink($this->upload_dir() . "student_images/" . $row['photo']);
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
					$head = array('page_title'=>'Edit Student','link_title'=>'Student List','link_action'=>'Student/index');
					$this->assign($upload_error);
					$this->load->view('student/edit',$head);	
				}
				else{
					if($data['category_id']=='1'){
						$this->studentmodel->edit_user($admin_id,$login);
						$this->studentmodel->edit($id,$data);
					}else{
						$this->studentmodel->edit($id,$data);
					}
					$this->session->set_flashdata('message', $this->tpl->set_message('edit', 'Student'));
					redirect('Student');	
				}
			
			}else{
				if($data['category_id']=='1'){
					$this->studentmodel->edit_user($admin_id,$login);
					$this->studentmodel->edit($id,$data);
				}else{
					$this->studentmodel->edit($id,$data);
				}
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Student'));
				redirect('Employee');
				 		
			}
		}
	}

	function set_status($id,$val)
	{
		echo $this->status_change($id,$val,'studentmodel','change_status'); //model name 'usermdoel' method name 'change_status'
	}

	function del($id)
	{
		$id = decode($id);
		$row = $this->studentmodel->get_record($id);
		$this->studentmodel->del($id);	
		$status = 1;
		unlink($this->upload_dir()."student_images/".$row['photo']);
		unlink($this->upload_dir()."employee_cv/".$row['cv']);
		$message = $this->tpl->set_message('delete','Employee');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}

	private function validate($row=''){
        $config1 = array(
			array('field'=>'student_type_id','label'=>'Student type','rules'=>'trim|required'),
			array('field'=>'full_name','label'=>'Full Name','rules'=>'trim|required'),  
			array('field'=>'dob','label'=>'Date of Birth','rules'=>'trim|required'),  
			array('field'=>'gender','label'=>'Gender','rules'=>'trim|required'),  
			array('field'=>'religion_id','label'=>'Religion','rules'=>'trim|required'),  
			array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required'),  
			array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
			array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
			array('field'=>'id_no','label'=>'Student No','rules'=>'trim|required'),
			array('field'=>'section_id','label'=>'Form','rules'=>'trim|required'),
			array('field'=>'birth_certificate_no','label'=>'Birth certificate','rules'=>'trim|required'),
			array('field'=>'admission_roll','label'=>'Admission roll','rules'=>'trim|required'),
			array('field'=>'admission_date','label'=>'Admission date','rules'=>'trim|required'),
			array('field'=>'session','label'=>'Admission session','rules'=>'trim|required'),
			array('field'=>'is_siblins','label'=>'Siblins','rules'=>'trim|required'),



			array('field'=>'serial','label'=>'Serial','rules'=>'trim'),
			array('field'=>'blood_group_id','label'=>'Blood Group','rules'=>'trim'),
			array('field'=>'description','label'=>'Description','rules'=>'trim'),
			array('field'=>'photo','label'=>'Photo','rules'=>'trim'),    		
        );
		
		$config2 = array(
			array('field'=>'father_nid','label'=>'Father NID','rules'=>'trim|required'),
			array('field'=>'mother_nid','label'=>'Mother NID','rules'=>'trim|required'),
		);

		$config3 = array(
			array('field'=>'siblings_class_id','label'=>'Siblings Class','rules'=>'trim|required'),
			array('field'=>'siblings_section_id','label'=>'Siblings Form','rules'=>'trim|required'),
			array('field'=>'siblings_id','label'=>'Siblins Name','rules'=>'trim|required'),
		);
	
        return $config1;
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

	function get_section()
	  {
		  $class_id = $this->input->post('class_id');
		  $rs = array(array('id' => '', 'title' => '--- Select Form ---'));
		  $section = array_merge($rs, $this->studentmodel->get_section_by($class_id));
		  $this->output->set_output(json_encode($section));
	  }	
	  
	function student_details()
	{
		$class_id = $this->input->post('class_id');
		$details = $this->studentmodel->get_student_details($class_id);
		echo json_encode($details);	
	}

	function class_details()
	{
		$class_id = $this->input->post('class_id');
		$details = $this->studentmodel->get_class_details($class_id);
		echo json_encode($details);	
	}

	
 }
