<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME         : SMS
-----------------------------------------------------
| CONTROLLER CLASS NAME: School
| -----------------------------------------------------
| AUTHOR 			   : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL				   : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT			   : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE			   :			
| -----------------------------------------------------
*/
 class School extends MT_Controller
 {
 	 function __construct()
 	 {
 	 	parent::__construct();
		$this->tpl->set_page_title('School Settings');
		$this->load->model('schoolmodel');
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
    }
	
  	function index($sort_type='desc',$sort_on='id')
	
  	{
  	    $labels=array('name'=>'School Name','address1'=>'Address','description'=>'Description','establish_date'=>'Establish Date');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->schoolmodel->count_list(); 
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on']=$sort_on;
		$config['sort_type']=$sort_type;
		$this->assign('grid_action',array('view'=>'view','edit'=>'edit'));
		$this->set_pagination($config);
  		$info=$this->schoolmodel->get_list();
  		$this->assign('records',$info);
  		$this->load->view('school/list');
  	}
 
	function edit($id)
	{
		$id = decode($id);
		$this->tpl->set_page_title("Edit school information");	
		$row=$this->schoolmodel->get_record($id);							// get record
		$this->assign($row);  
		$config = array(
							array('field'=>'name','label'=>'School Name','rules'=>'trim|required'),
							array('field'=>'establish_date','label'=>'Establish Date','rules'=>'trim'),  
							array('field'=>'address1','label'=>'Address','rules'=>'trim|required'),
							array('field'=>'address2','label'=>'Address','rules'=>'trim'),
							array('field'=>'description','label'=>'Description','rules'=>'trim')
						);
		$this->form_validation->set_rules($config);
		$this->validation_error_msg();
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('school/edit');
		}
		else
		{
			$data['name']=$this->input->post('name');
			$data['establish_date']=$this->input->post('establish_date');
			$data['address1']=$this->input->post('address1');
			$data['address2']=$this->input->post('address2');
			$data['description']=$this->input->post('description');
			$data['created_by'] = $this->session->userdata('admin_userid');

			if(trim($_FILES["logo"]["name"])!='') 
			{
			
				$ext = explode(".", $_FILES["logo"]["name"]);
				$file_ext = end($ext);
				$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
				if ($this->upload_images('logo',$image_name,'logo')) { // field_name, iamge_name ,folder_name
					$data['logo'] = $image_name;
					if (isset($row['logo']) AND $row['logo'] != '') {
						unlink($this->upload_dir() . "logo/" . $row['logo']);
					}
				}else{
					$upload_error['error_logo'] =  $this->upload->display_errors(); 
					$this->assign($upload_error);
					$this->load->view('school/edit');				
				} 
				$this->schoolmodel->edit($id,$data);   // Update data 
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','School'));
				redirect('school');
  			}
			else
			{
				$this->schoolmodel->edit($id,$data);   // Update data 
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','School'));
				redirect('school');
			}				
		}
	}
	function view($id='')
	{
		$id = decode($id);
		if($id=='')
		{
			redirect('school');
		}
		$this->tpl->set_page_title("View school information");
		$school=$this->schoolmodel->get_details($id);							// get record
		$this->assign($school); 
		$this->load->view('school/view');
	}

 }
