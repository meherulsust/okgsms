<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME			: SMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : Section
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
 Class Section extends MT_Controller
 {
 	 function __construct()
 	 {
 	 	parent::__construct();
 	 	$this->load->model(array('sectionmodel'));
		$this->tpl->set_page_title('Section Management');
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
    }
	
	function index()
	{
		$labels=array('title'=>'Section','version'=>'Version','class'=>'Class','room_number'=>'Room Number','status'=>'Status');
		$this->tpl->set_js(array('jquery.statusmenu'));
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->sectionmodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on']='id';
		$config['sort_type']='desc';
		if($this->session->userdata('admin_userid')==1){
		$this->assign('grid_action',array('edit'=>'edit','del'=>'del'));
		}else{
		$this->assign('grid_action',array('edit'=>'edit'));	
		}
		$this->set_pagination($config);
		$section=$this->sectionmodel->get_list();
		$this->assign('records',$section);		
		$this->load->view('section/list');
	}
	
		function add()
  	{
  		$this->tpl->set_page_title("Add new section");
		$this->load->library('form_validation');
		$config = array(
							array('field'=>'title','label'=>'Section Title','rules'=>'trim|required'),
							array('field'=>'version_id','label'=>'Version','rules'=>'trim|required'),
							array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
							array('field'=>'description','label'=>'Description','rules'=>'trim'),  
							array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
							array('field'=>'room_number','label'=>'Room number','rules'=>'trim'),
						);
		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if ($this->form_validation->run() == FALSE)
		{			
			$class_options=$this->sectionmodel->class_options();
			$version_options=$this->sectionmodel->version_options(); 
			$status_options =array('Active'=>'Active','Inactive'=>'Inactive');	
			$this->assign('status_options',$status_options);
			$this->assign('version_options',$version_options);
			$this->assign('class_options',$class_options);
			$this->load->view('section/new');			
		}
		else
		{
			$data['title']				= $this->input->post('title');
			$data['version_id']			= $this->input->post('version_id');
			$data['class_id']			= $this->input->post('class_id');
			$data['description']		= $this->input->post('description');
			$data['room_number']		= $this->input->post('room_number');
			$data['status']				= $this->input->post('status');
			$data['created_at']  	    = $this->current_date();
			$data['created_by']  		= $this->session->userdata('userid');
			$section_id = $this->sectionmodel->add($data);
			if($section_id){
				$this->session->set_flashdata('message',$this->tpl->set_message('add','section'));
			}else{
				$this->session->set_flashdata('message',$this->tpl->set_message('error','section has not saved!.'));
			}
			redirect('section');
		}
	}		
		
	function edit($id)
	{
		$this->tpl->set_page_title("Edit Section information");
		$this->load->library('form_validation');		
		$class=$this->sectionmodel->get_record($id);							// get record
		$this->assign($class);  
		$config = array(
							array('field'=>'title','label'=>'Section Title','rules'=>'trim|required'),
							array('field'=>'version_id','label'=>'Version','rules'=>'trim|required'),
							array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
							array('field'=>'description','label'=>'Description','rules'=>'trim'),  
							array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
							array('field'=>'room_number','label'=>'Room number','rules'=>'trim'),
						);	
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$status_options =array('Active'=>'Active','Inactive'=>'Inactive');	
			$class_options=$this->sectionmodel->class_options(); 
			$version_options=$this->sectionmodel->version_options(); 
			$this->assign('status_options',$status_options);
			$this->assign('class_options',$class_options);
			$this->assign('version_options',$version_options);
			$this->load->view('section/edit');
		}
		else
		{
			$data['title']				= $this->input->post('title');
			$data['version_id']			= $this->input->post('version_id');
			$data['class_id']			= $this->input->post('class_id');
			$data['description']		= $this->input->post('description');
			$data['room_number']		= $this->input->post('room_number');
			$data['status']				= $this->input->post('status');
			$this->sectionmodel->edit($id,$data);   // Update data 
			$this->session->set_flashdata('message',$this->tpl->set_message('edit','section'));
			redirect('section');			
		}
	}

	public function set_status($id,$val)
	{
		echo $this->status_change($id,$val,'sectionmodel','change_status'); //model name 'usermdoel' method name 'change_status'
	} 
	
	function del($id)
	{
		
		$this->sectionmodel->del($id);
		$status = 1;
		$message = $this->tpl->set_message('delete','section');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}
	
 }	