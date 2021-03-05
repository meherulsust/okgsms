<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME			: SMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : employee
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
    }
  	function index($sort_type='asc',$sort_on='id')
  	{
  		$this->tpl->set_page_title('Teacher List');
		$data['username'] = $this->input->post('username');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $this->load->library('search');
        $search_data = $this->search->data_search($data);
		$this->tpl->set_js(array('jquery.statusmenu'));
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
  		$this->load->view('employee/list');
  	}
	
	// for staff list
	
	function staff($sort_type='asc',$sort_on='id')
  	{
  		$this->tpl->set_page_title('Staff List');
		$data['username'] = $this->input->post('username');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $this->load->library('search');
        $search_data = $this->search->data_search($data);
		$this->tpl->set_js(array('jquery.statusmenu'));
  	    $labels=array('name'=>'Full Name','username'=>'Username','designation'=>'Designation','gender'=>'Gender','mobile_no'=>'Mobile','status'=>'Status');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->employeemodel->count_staff_list($search_data);
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
  		$staff=$this->employeemodel->get_staff_list($search_data);
  		$this->assign('records',$staff);
  		$this->load->view('employee/list');
  	}
	
	function view($id='')
	{
		if($id=='')
		{
			redirect('employee');
		}
		$this->tpl->set_page_title("Employee information");
		$employee=$this->employeemodel->get_teacher_details($id);							// get record
		//printr($employee);exit;
		$this->assign($employee); 
		$this->load->view('employee/view');
	}
	
  	function add()
  	{
		$this->tpl->set_page_title("Add new employee");
		$this->load->library(array('form_validation'));
		$config = array(
							array('field'=>'name','label'=>'Name','rules'=>'trim|required|min_length[5]|max_length[20]'),
							array('field'=>'category_id','label'=>'Category','rules'=>'trim|required'),
							array('field'=>'username','label'=>'Username','rules'=>'trim|required|min_length[4]|max_length[20]|callback_duplicate_teacher_check'),
							array('field'=>'passwd','label'=>'Password','rules'=>'trim'),
							array('field'=>'designation','label'=>'Designation','rules'=>'trim|required'),  
							array('field'=>'dob','label'=>'Date of Birth','rules'=>'trim|required'),  
							array('field'=>'gender','label'=>'Gender','rules'=>'trim|required'),  
							array('field'=>'blood_group_id','label'=>'Blood Group','rules'=>'trim|required'),  
							array('field'=>'religion_id','label'=>'Religion','rules'=>'trim'),  
							array('field'=>'address','label'=>'Address','rules'=>'trim'),  
							array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required'),  
							array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email|callback_duplicate_email_check'),
							array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
							array('field'=>'photo','label'=>'Photo','rules'=>'trim'),
							array('field'=>'cv_upload','label'=>'Upload CV','rules'=>'trim'),
							array('field'=>'relevant_subject','label'=>'Relevant Subject','rules'=>'trim'),
							array('field'=>'serial','label'=>'Serial','rules'=>'trim'),
							array('field'=>'join_date','label'=>'Join Date','rules'=>'trim'), 
			
						);
		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		$status_options = array('Active'=>'Active','Inactive'=>'Inactive');
		$religion_options = $this->optionmodel->religion_options();	
		$blood_group_options = $this->optionmodel->blood_group_options();
		$gender_options = array('MALE'=>'Male','FEMALE'=>'Female'); 		
		$this->assign('gender_options',$gender_options);
		$category_options = array('1'=>'Teaching Staff','2'=>'Non-Teaching Staff'); 
		$this->assign('category_options',$category_options);
		$this->assign('religion_options',$religion_options);
		$this->assign('blood_group_options',$blood_group_options);
		$this->assign('status_options',$status_options);
		if ($this->form_validation->run() == FALSE)
		{			
			$this->load->view('employee/new');			
		}
		else
		{
			$data['category_id']		= $this->input->post('category_id');
			$data['name']				= $this->input->post('name');
			$data['username']			= $this->input->post('username');
			$data['passwd']				= ($this->input->post('passwd') !='') ? md5($this->input->post('name')) : md5(123456);
			$data['designation']		= $this->input->post('designation');
			$data['dob']				= $this->input->post('dob');
			$data['gender']				= $this->input->post('gender');
			$data['blood_group_id']		= $this->input->post('blood_group_id');
			$data['email']				= $this->input->post('email');
			$data['mobile_no']			= $this->input->post('mobile_no');
			$data['address']			= $this->input->post('address');
			$data['religion_id']		= $this->input->post('religion_id');
			$data['serial']				= $this->input->post('serial');
			$data['status']				= $this->input->post('status');
			$data['relevant_subject']	= $this->input->post('relevant_subject');
			$data['join_date']			= $this->input->post('join_date');
			$data['created_at']  	    = $this->current_date();
			$data['created_by']  		= $this->session->userdata('admin_userid');
			if(trim($_FILES["photo"]["name"])!='' OR  $_FILES["cv_upload"]["name"] !='') 
			{
				$ext_photo = explode(".", $_FILES['photo']['name']);
				$file_ext_photo = end($ext_photo);
				$file_name_photo = rand(100000,999999).'_'.rand(100000,999999).'.'.$file_ext_photo; 
				if ($this->upload_photo('photo',$file_name_photo)) { 
					$data['photo']	   =$file_name_photo;
				}else{
					$sdata['upload_error'] = '<span class="verr">'.$this->upload->display_errors().'</span>';
					$this->load->view('employee/new',$sdata);
				}
				if(trim($_FILES["cv_upload"]["name"])!=''){
					$ext_cv    = explode(".", $_FILES['cv_upload']['name']);
					$file_ext_cv    = end($ext_cv);
					$file_name_cv = rand(100000,999999).'_'.rand(100000,999999).'.'.$file_ext_cv; 
					if($this->upload_cv('cv_upload',$file_name_cv )){
						$data['cv_upload'] =$file_name_cv;	
					}else{
						$sdata['upload_error'] = '<span class="verr">'.$this->upload->display_errors().'</span>';
						$this->load->view('employee/new',$sdata);
					}
				}	
					$this->employeemodel->add($data);
					$this->session->set_flashdata('message',$this->tpl->set_message('add','employee'));
					if($data['category_id']==1){
							redirect('employee');
						}else{
							redirect('employee/staff');	
						}
				}else{
					$this->employeemodel->add($data);
					$this->session->set_flashdata('message',$this->tpl->set_message('add','employee'));
					if($data['category_id']==1){
						redirect('employee');
					}else{
						redirect('employee/staff');	
					}
			}
		}			
  	}
	function edit($id)
	{
		$this->tpl->set_page_title("Edit employee information");
		$this->load->library(array('form_validation'));		
		$employee=$this->employeemodel->get_record($id);							// get record
		$this->assign($employee);  
		$config = array(
							array('field'=>'name','label'=>'Name','rules'=>'trim|required|min_length[5]|max_length[20]'),
							array('field'=>'category_id','label'=>'Category','rules'=>'trim|required'),
							array('field'=>'username','label'=>'Username','rules'=>'trim|required|min_length[4]|max_length[20]|callback_duplicate_teacher_check['.$employee['username'].']'),
							array('field'=>'passwd','label'=>'Password','rules'=>'trim'),
							array('field'=>'designation','label'=>'Designation','rules'=>'trim|required'),  
							array('field'=>'dob','label'=>'Date of Birth','rules'=>'trim|required'),  
							array('field'=>'gender','label'=>'Gender','rules'=>'trim|required'),  
							array('field'=>'blood_group_id','label'=>'Blood Group','rules'=>'trim|required'),  
							array('field'=>'religion_id','label'=>'Religion','rules'=>'trim'),  
							array('field'=>'address','label'=>'Address','rules'=>'trim'),  
							array('field'=>'mobile_no','label'=>'Mobile','rules'=>'trim|required'),  
							array('field'=>'email','label'=>'Email','rules'=> 'trim|required|valid_email|callback_duplicate_email_check['.$employee['email'].']'),
							array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
							array('field'=>'photo','label'=>'Photo','rules'=>'trim'),
							array('field'=>'cv_upload','label'=>'Upload CV','rules'=>'trim'),
							array('field'=>'relevant_subject','label'=>'Relevant Subject','rules'=>'trim'),
							array('field'=>'serial','label'=>'Serial','rules'=>'trim'),
							array('field'=>'join_date','label'=>'Join Date','rules'=>'trim'), 
			
						);
		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		$status_options = array('Active'=>'Active','Inactive'=>'Inactive');
		$gender_options = array('MALE'=>'Male','FEMALE'=>'Female'); 
		$religion_options = $this->optionmodel->religion_options();	
		$blood_group_options = $this->optionmodel->blood_group_options();	
		$this->assign('gender_options',$gender_options);
		$this->assign('religion_options',$religion_options);
		$this->assign('blood_group_options',$blood_group_options);
		$this->assign('status_options',$status_options);
		$gender_options = array('MALE'=>'Male','FEMALE'=>'Female');
		$category_options = array('1'=>'Teaching Staff','2'=>'Non-Teaching Staff'); 	
		$this->assign('category_options',$category_options);
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('employee/edit');
		}
		else
		{
			$data['category_id']		= $this->input->post('category_id');
			$data['name']				= $this->input->post('name');
			$data['username']			= $this->input->post('username');
			if($this->input->post('passwd') !=''){
				$data['passwd']				= md5($this->input->post('passwd'));
			}
			$data['designation']		= $this->input->post('designation');
			$data['dob']				= $this->input->post('dob');
			$data['gender']				= $this->input->post('gender');
			$data['blood_group_id']		= $this->input->post('blood_group_id');
			$data['email']				= $this->input->post('email');
			$data['mobile_no']			= $this->input->post('mobile_no');
			$data['address']			= $this->input->post('address');
			$data['religion_id']		= $this->input->post('religion_id');
			$data['serial']				= $this->input->post('serial');
			$data['status']				= $this->input->post('status');
			$data['relevant_subject']	= $this->input->post('relevant_subject');
			$data['join_date']			= $this->input->post('join_date');
			$data['created_at']  	    = $this->current_date();
			$data['created_by']  		= $this->session->userdata('admin_userid');
			
			if(trim($_FILES["photo"]["name"])!='' OR  $_FILES["cv_upload"]["name"] !='') 
			{
				$ext_photo = explode(".", $_FILES['photo']['name']);
				$file_ext_photo = end($ext_photo);
				$file_name_photo = rand(100000,999999).'_'.rand(100000,999999).'.'.$file_ext_photo; 
				if ($this->upload_photo('photo',$file_name_photo)) { 
					$data['photo']	   =$file_name_photo;
					unlink($this->upload_dir()."teacher_image/".$employee['photo']);
				}else{
					$sdata['upload_error'] = '<span class="verr">'.$this->upload->display_errors().'</span>';
					$this->load->view('employee/edit',$sdata);
				}
				if(trim($_FILES["cv_upload"]["name"])!=''){
					$ext_cv    = explode(".", $_FILES['cv_upload']['name']);
					$file_ext_cv    = end($ext_cv);
					$file_name_cv = rand(100000,999999).'_'.rand(100000,999999).'.'.$file_ext_cv; 
					if($this->upload_cv('cv_upload',$file_name_cv )){
						$data['cv_upload'] =$file_name_cv;
						unlink($this->upload_dir()."teacher_cv/".$employee['cv_upload']);	
					}else{
						$sdata['upload_error'] = '<span class="verr">'.$this->upload->display_errors().'</span>';
						$this->load->view('employee/edit',$sdata);
					}
				}	
				$this->employeemodel->edit($id,$data);   // Update data 
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','employee'));
				if($data['category_id']==1){
						redirect('employee');
					}else{
						redirect('employee/staff');	
					}
		    }else{
				$this->employeemodel->edit($id,$data);   // Update data 
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','employee'));
				if($data['category_id']==1){
						redirect('employee');
					}else{
						redirect('employee/staff');	
					}
			}
		}
	}

	function set_status($id,$val)
	{
		echo $this->status_change($id,$val,'employeemodel','change_status'); //model name 'usermdoel' method name 'change_status'
	}

	function del($id)
	{
		$employee = $this->employeemodel->get_record($id);
		$this->employeemodel->del($id);	
		$status = 1;
		unlink($this->upload_dir()."teacher_image/".$employee['photo']);
		unlink($this->upload_dir()."teacher_cv/".$employee['cv_upload']);
		$message = $this->tpl->set_message('delete','employee');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}
	
 	//check duplicate email for validation
	
	function duplicate_email_check($str,$param='')
    {
		$query = $this->db->query("SELECT id FROM sms_employee where email='$str' AND email<>'$param'");
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
      $query = $this->db->query("SELECT id FROM sms_employee where username='$str' AND username<>'$param'");
       if($query->num_rows()>0)
       {
          $this->form_validation->set_message('duplicate_teacher_check', "%s <span style='color:green;'>$str</span> already exists");
		 	 	 return false;
       }
       return true;

  	}
	
	function upload_photo($photo,$file_name_photo)
	{
		$upconfig['upload_path'] = $this->upload_dir()."teacher_image/"; 
		$file_info = pathinfo($file_name_photo);
		$upconfig['file_name']=basename($file_name_photo,'.'.$file_info['extension']);
		$upconfig['allowed_types'] = 'gif|jpg|png|jpeg';
		$upconfig['max_size'] = '500000';
		//$upconfig['min_width'] = '1590';
		//$upconfig['min_height'] = '670';
		$upconfig['overwrite'] = FALSE;
		$this->load->library('upload');
		$this->upload->initialize($upconfig);
		if (!$this->upload->do_upload($photo))
		{	
			return false;
		}
		else
		{	
			$updata=$this->upload->data();
			if($updata){
				return true;
			}
		}
	}
	
	function upload_cv($cv_upload,$file_name_cv)
	{
		$upconfig['upload_path'] = $this->upload_dir()."teacher_cv/";
		$file_info = pathinfo($file_name_cv);
		$upconfig['file_name']=basename($file_name_cv,'.'.$file_info['extension']);
		$upconfig['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
		$upconfig['max_size'] = '500000';
		$upconfig['overwrite'] = FALSE;
		$this->load->library('upload');
		$this->upload->initialize($upconfig);
		if (!$this->upload->do_upload($cv_upload))
		{	
			return false;
		}
		else
		{	
			$updata=$this->upload->data();
			if($updata){
				return true;
			}
		}
	}
	function download_photo($id)
	{
		$employee = $this->employeemodel->get_record($id);
		$this->load->helper('download');
		$pth = file_get_contents($this->upload_dir()."teacher_image/".$employee['photo']);
		$nme = $employee['photo'];
		force_download($nme,$pth);  
	}
	function download_cv($id)
	{
		$employee = $this->employeemodel->get_record($id);
		$this->load->helper('download');
		$pth = file_get_contents($this->upload_dir()."teacher_cv/".$employee['cv_upload']);
		$nme = $employee['cv_upload'];
		force_download($nme,$pth);  
	}
	
 }
