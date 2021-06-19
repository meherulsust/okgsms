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
		
 	 	$this->load->model(array('studentmodel','GenerateTuitionFeeModel'));
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
		$this->tpl->set_js(array('select-chain'));
		$this->tpl->set_page_title('Student List');
		$status_options = array('Active'=>'Active','Inactive'=>'Inactive');
		$religion_options = $this->optionmodel->religion_options();	
		$blood_group_options = $this->optionmodel->blood_group_options();
		$gender_options = array('Male'=>'Male','Female'=>'Female','Others'=>'Others'); 		
		$this->assign('gender_options',$gender_options);
		$student_type_options = $this->optionmodel->student_type_options();; 		
		$this->assign('student_type_options',$student_type_options);
		$class_options = $this->optionmodel->class_options();; 		
		$this->assign('class_options',$class_options);
		$class_id = $this->input->post('class_id');
		$section_options = $this->studentmodel->get_section_options_by($class_id); 		
		$this->assign('section_options',$section_options);
		$section_id = $this->input->post('section_id');
	
		$this->assign('religion_options',$religion_options);
		$this->assign('blood_group_options',$blood_group_options);
		$this->assign('status_options',$status_options);

		$sibling_class_id = $this->input->post('sibling_class_id');
		$sibling_section_options = $this->studentmodel->get_section_options_by($sibling_class_id); 		
		$this->assign('sibling_section_options',$sibling_section_options);

		$sibling_section_id = $this->input->post('sibling_section_id');
		$sibling_options = $this->studentmodel->get_student_options_by($sibling_section_id);
		$this->assign('sibling_options',$sibling_options);

    }
	
  	function index($sort_type='desc',$sort_on='id')
  	{
		$data = $this->input->post();
        $this->load->library('search');
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Student List','link_title'=>'New Student','link_action'=>'Student/add');
  	    $labels=array('id_no'=>'Student No','full_name'=>'Full Name','class'=>'Class','section'=>'Form','class_roll'=>'Roll','mobile_no'=>'Mobile','status'=>'Status');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->studentmodel->count_list($data);
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on']=$sort_on;
		$config['sort_type']=$sort_type;
		if($this->session->userdata('admin_userid')==1){
		$this->assign('grid_action',array('payment'=>'payment','view'=>'view','edit'=>'edit'));
		}else{
		$this->assign('grid_action',array('payment'=>'payment','view'=>'view','edit'=>'edit'));	
		}
		$this->set_pagination($config);
  		$teachers=$this->studentmodel->get_list($data);
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
			$data['full_name']			  = $this->input->post('full_name');
			$data['password']      		  = $this->hash_password('123456');
			$data['admission_date']	      = $this->input->post('admission_date');
			$data['class_id']		      = $this->input->post('class_id');
			$data['section_id']			  = $this->input->post('section_id');
			$data['id_no']				  = $this->input->post('id_no');
			$data['admission_roll']		  = $this->input->post('admission_roll');
			$data['class_roll']		  	  = $this->input->post('class_roll');
			$data['dob']				  = $this->input->post('dob');
			$data['birth_certificate_no'] = $this->input->post('birth_certificate_no');
			$data['has_sibling']		  = $this->input->post('has_sibling');
			$data['father_nid']		  	  = $this->input->post('father_nid');
			$data['mother_nid']		      = $this->input->post('mother_nid');
			$data['sibling_class_id']	  = $this->input->post('sibling_class_id');
			$data['sibling_section_id']   = $this->input->post('sibling_section_id');
			$data['sibling_id'] 		  = $this->input->post('sibling_id');
			$data['mobile_no']			  = $this->input->post('mobile_no');
			$data['mobile_no_owner']	  = $this->input->post('mobile_no_owner');
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
		$this->assign($row);  
		
		if ($this->form_validation->run() == FALSE)
		{
			$section_options = $this->studentmodel->get_section_options_by($row['class_id']); 		
			$this->assign('section_options',$section_options);
			
			$sibling_section_options = $this->studentmodel->get_section_options_by($row['sibling_class_id']); 		
			$this->assign('sibling_section_options',$sibling_section_options);
			$sibling_options = $this->studentmodel->get_student_options_by($row['sibling_section_id']);
			$this->assign('sibling_options',$sibling_options);

			$this->load->view('student/edit',$head);
		}
		else
		{
			$data['student_type_id']	  = $this->input->post('student_type_id');
			$data['full_name']			  = $this->input->post('full_name');
			$data['admission_date']	      = $this->input->post('admission_date');
			$data['class_id']		      = $this->input->post('class_id');
			$data['section_id']			  = $this->input->post('section_id');
			$data['id_no']				  = $this->input->post('id_no');
			$data['admission_roll']		  = $this->input->post('admission_roll');
			$data['class_roll']		  	  = $this->input->post('class_roll');
			$data['dob']				  = $this->input->post('dob');
			$data['birth_certificate_no'] = $this->input->post('birth_certificate_no');
			$data['has_sibling']		  = $this->input->post('has_sibling');
			$data['father_nid']		  	  = $this->input->post('father_nid');
			$data['mother_nid']		      = $this->input->post('mother_nid');
			$data['sibling_class_id']	  = $this->input->post('sibling_class_id');
			$data['sibling_section_id']   = $this->input->post('sibling_section_id');
			$data['sibling_id'] 		  = $this->input->post('sibling_id');
			$data['mobile_no']			  = $this->input->post('mobile_no');
			$data['mobile_no_owner']	  = $this->input->post('mobile_no_owner');
			$data['religion_id']		  = $this->input->post('religion_id');
			$data['blood_group_id']		  = $this->input->post('blood_group_id');
			$data['status']				  = $this->input->post('status');
			$data['gender']	  			  = $this->input->post('gender');
			$data['description']		  = $this->input->post('description');
			$data['session']		  	  = $this->input->post('session');
			$data['created_at']  	      = $this->current_date();
			$data['created_by']  		  = $this->session->userdata('admin_userid');

			
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
				
				
				if($this->upload->display_errors()){
					$head = array('page_title'=>'Edit Student','link_title'=>'Student List','link_action'=>'Student/index');
					$this->assign($upload_error);
					$this->load->view('student/edit',$head);	
				}
				else{
					$this->studentmodel->edit($id,$data);
					$this->session->set_flashdata('message', $this->tpl->set_message('edit', 'Student'));
					redirect('Student');	
				}
			
			}else{
				$this->studentmodel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Student'));
				redirect('Student');
				 		
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
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}

	public function payment($id,$sort_type='desc',$sort_on='id'){
		
		$id = decode($id);
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Payment List','link_title'=>'Student List','link_action'=>'Student/index');
		$labels = array('id_no' => 'student ID','full_name' => 'Student Name','class' => 'Class','month'=>'Month','total_amount' => 'Total Amount','total_due' => 'Total Due','payment_status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->studentmodel->count_payment_list($id);
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('view' => 'payment_details'));
		$this->set_pagination($config);
		$list = $this->studentmodel->get_paymenet_list($id); // get data list
		$this->assign('records', $list);
		$this->load->view('student/payment_ist',$head);
	}

	public function payment_details($id)
	{
		$id = decode($id);
        $config = array(array('field' => 'paid_amount','label' => 'paid_amount','rules' => 'trim|required|numeric'));
		$head = array('page_title'=>'Tuition Fee Details','link_title'=>'Student list ','link_action'=>'Student/index');
        $this->form_validation->set_rules($config);
		$this->validation_error_msg(); 
		if($this->form_validation->run()== FALSE) 
		{
			$data['msg'] = '';
		}else{
			$row = $this->GenerateTuitionFeeModel->get_invoice_info($id);
			if($row['total_due'] >= $this->input->post('paid_amount'))
			{
				$history_data['tuition_fee_list_id']  = $id;	
				$history_data['paid_amount']  		  = $this->input->post('paid_amount');	
				$history_data['created_at']  		  = $this->current_date();			
				$history_data['created_by'] 		  = $this->session->userdata('admin_userid');	
				$history_id = $this->GenerateTuitionFeeModel->insert_payment_history($history_data);
				if($history_id)
				{
					$payment_status = ($row['total_due'] == $this->input->post('paid_amount') ? 'Paid' : 'Unpaid');
					$this->GenerateTuitionFeeModel->update_due_payment($id,$payment_status,$this->input->post('paid_amount'));
					$data['msg'] = '<div class="alert alert-success"><b><i class="fa fa-check-circle"></i></b>Tuition Fee Payment has been paid successfully.</div>';
				}else{
					$data['msg'] = '<div class="alert alert-danger"><b><i class="fa fa-info-circle"></i></b> Payment not added.</div>';
				}
			}else{
				$data['msg'] = '<div class="alert alert-danger"><b><i class="fa fa-info-circle"></i></b> Paid amount must be less then or equal to due amount.</div>';
			}
		}
		$invoice_info = $this->GenerateTuitionFeeModel->get_invoice_info($id);
		$this->assign($invoice_info);
		$details = $this->GenerateTuitionFeeModel->get_invoice_details($id);
		$this->assign('details',$details);
		$payment_list = $this->GenerateTuitionFeeModel->get_payment_list($id);
		$this->assign('payment_list',$payment_list);
		$this->assign($data);
		$this->load->view('tuition_fee_list/invoice_details',$head);		
	}

	private function validate($row=''){
        $config1 = array(
			array('field'=>'student_type_id','label'=>'Student type','rules'=>'trim|required'),
			array('field'=>'full_name','label'=>'Full Name','rules'=>'trim|required'),  
			array('field'=>'dob','label'=>'Date of Birth','rules'=>'trim|required'),  
			array('field'=>'gender','label'=>'Gender','rules'=>'trim|required'),  
			array('field'=>'religion_id','label'=>'Religion','rules'=>'trim|required'),  
			array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
			array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
			array('field'=>'section_id','label'=>'Form','rules'=>'trim|required'),
			array('field'=>'admission_date','label'=>'Admission date','rules'=>'trim|required'),
			array('field'=>'session','label'=>'Admission session','rules'=>'trim|required'),
			array('field'=>'has_sibling','label'=>'Siblins','rules'=>'trim|required'),
			array('field'=>'serial','label'=>'Serial','rules'=>'trim'),
			array('field'=>'blood_group_id','label'=>'Blood Group','rules'=>'trim'),
			array('field'=>'description','label'=>'Description','rules'=>'trim'),
			array('field'=>'photo','label'=>'Photo','rules'=>'trim'), 
			array('field'=>'mobile_no_owner','label'=>'Mobile no owner','rules'=>'trim'), 	
        );
		
		if($this->input->post('has_sibling')=='no'){
			if(!empty($row)){
				$config2 = array(
					array('field'=>'father_nid','label'=>'Father NID','rules'=>'trim|callback_duplicate_father_nid['.$row['father_nid'].']'),
					array('field'=>'mother_nid','label'=>'Mother NID','rules'=>'trim|callback_duplicate_mother_nid['.$row['mother_nid'].']'),
					array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required|callback_duplicate_mobile_no['.$row['mobile_no'].']'),
				);
			}else{
				$config2 = array(
					array('field'=>'father_nid','label'=>'Father NID','rules'=>'trim|callback_duplicate_father_nid'),
					array('field'=>'mother_nid','label'=>'Mother NID','rules'=>'trim|callback_duplicate_mother_nid'),
					array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required|callback_duplicate_mobile_no'),
				);	
			}
		}else{
			$config2 = array(
				array('field'=>'sibling_class_id','label'=>'Sibling Class','rules'=>'trim|required'),
				array('field'=>'sibling_section_id','label'=>'Sibling Form','rules'=>'trim|required'),
				array('field'=>'sibling_id','label'=>'Siblins Name','rules'=>'trim|required'),
				array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required'),
			);
		}

		if(!empty($row)){
			$config3 = array(
				array('field'=>'birth_certificate_no','label'=>'Birth certificate','rules'=>'trim|min_length[17]|max_length[17]|callback_duplicate_student_check['.$row['birth_certificate_no'].']'),
				array('field'=>'class_roll','label'=>'Class Roll','rules'=>'trim|required|callback_duplicate_class_roll['.$row['class_roll'].']'),
				array('field'=>'id_no','label'=>'Student ID','rules'=>'trim|required|callback_duplicate_id_no['.$row['id_no'].']'),
				array('field'=>'admission_roll','label'=>'Admission roll','rules'=>'trim|required|callback_duplicate_admission_roll['.$row['admission_roll'].']'),
			);
		}else{
			$config3 = array(
				array('field'=>'birth_certificate_no','label'=>'Birth certificate','rules'=>'trim|min_length[17]|max_length[17]|callback_duplicate_student_check'),
				array('field'=>'class_roll','label'=>'Class roll','rules'=>'trim|required|callback_duplicate_class_roll'),
				array('field'=>'id_no','label'=>'Student ID','rules'=>'trim|required|callback_duplicate_id_no'),
				array('field'=>'admission_roll','label'=>'Admission roll','rules'=>'trim|required|callback_duplicate_admission_roll'),
			);	
		}
		

		$config = array_merge($config1,$config2,$config3);
	
        return $config;
    }

	
 	//check duplicate mobile for validation
	
	function duplicate_mobile_no($str,$param='')
    {
		$query = $this->db->query("SELECT id FROM sms_student_list where mobile_no='$str' AND mobile_no<>'$param'");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_mobile_no', "%s <span style='color:green;'>$str</span> already exists");
		  return false;
       }
       return true;
	}

	//check duplicate Father NID for validation
	
	function duplicate_father_nid($str,$param='')
    {
		$query = $this->db->query("SELECT id FROM sms_student_list where father_nid='$str' AND father_nid<>'$param'");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_father_nid', "%s <span style='color:green;'>$str</span> already exists");
		  return false;
       }
       return true;
	}

	//check duplicate Mother NID for validation
	
	function duplicate_mother_nid($str,$param='')
	{
		$query = $this->db->query("SELECT id FROM sms_student_list where mother_nid='$str' AND mother_nid<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_mother_nid', "%s <span style='color:green;'>$str</span> already exists");
			return false;
		}
		return true;
	}

	//check duplicate Class Roll for validation
	
	function duplicate_class_roll($str,$param='')
	{
		$class_id = $this->input->post('class_id');
		$section_id = $this->input->post('section_id');
		$query = $this->db->query("SELECT id FROM sms_student_list where class_roll='$str' AND class_id='$class_id'AND section_id='$section_id' AND class_roll<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_class_roll', "%s <span style='color:green;'>$str</span> already exists");
			return false;
		}
		return true;
	}

	// validation function for checking student duplicacy 

	function duplicate_student_check($str,$param='')
  	{
		$query = $this->db->query("SELECT id FROM sms_student_list where birth_certificate_no='$str' AND 	birth_certificate_no<>'$param' AND birth_certificate_no<>''");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_student_check', "%s <span style='color:green;'>$str</span> already exists");
		  return false;
       }
       return true;

  	}

	//check duplicate Student ID for validation

	function duplicate_id_no($str,$param='')
	{

		$query = $this->db->query("SELECT id FROM sms_student_list where id_no='$str' AND id_no<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_id_no', "%s <span style='color:green;'>$str</span> already exists");
			return false;
		}
		return true;
	}

	//check duplicate admission Number for validation

	function duplicate_admission_roll($str,$param='')
	{
		$query = $this->db->query("SELECT id FROM sms_student_list where admission_roll='$str' AND admission_roll<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_admission_roll', "%s <span style='color:green;'>$str</span> already exists");
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
	
	function get_student()
	{
		$section_id = $this->input->post('section_id');
		$rs = array(array('id' => '', 'title' => '--- Select Siblings ---'));
		$student = array_merge($rs, $this->studentmodel->get_student_by($section_id));
		$this->output->set_output(json_encode($student));
	}	
	  
	  
	function student_details()
	{
		$class_id = $this->input->post('class_id');
		$details = $this->studentmodel->get_student_details($class_id);
		echo json_encode($details);	
	}

	function student_mobile_no()
	{
		$id = $this->input->post('id');
		$details = $this->studentmodel->get_student_mobile_no($id);
		echo json_encode($details);	
	}

	function class_details()
	{
		$class_id = $this->input->post('class_id');
		$details = $this->studentmodel->get_class_details($class_id);
		echo json_encode($details);	
	}

	
}
