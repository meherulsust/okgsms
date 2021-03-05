<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME			: SMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : Classes
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
 class Classes extends MT_Controller
 {
 	 function __construct()
 	 {
 	 	parent::__construct();
 	 	$this->load->model(array('classmodel'));
		$this->tpl->set_page_title('Class List');
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
		$result_options=array('1'=>'Publish','2'=>'Unpublish');
		$status_options =array('Active'=>'Active','Inactive'=>'Inactive');	
		$scale_options=$this->optionmodel->scale_options(); 
		$this->assign('status_options',$status_options);
		$this->assign('scale_options',$scale_options);
		$this->assign('result_options',$result_options);
    }

  	function index($sort_type='desc',$sort_on='id')
  	{
  		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Class List','link_title'=>'New Class','link_action'=>'Classes/add');
  	    $labels=array('title'=>'Class Name','code'=>'Class Code','serial'=>'Serial','status'=>'Status');
		$this->assign('labels',$labels);
		$config['total_rows'] = $this->classmodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on']=$sort_on;
		$config['sort_type']=$sort_type;
		if($this->session->userdata('admin_group_id')==1){
		$this->assign('grid_action',array('view'=>'view','edit'=>'edit','del'=>'del'));
		}else{
		$this->assign('grid_action',array('view'=>'view','edit'=>'edit'));	
		}
		$this->set_pagination($config);
  		$users=$this->classmodel->get_list();
  		$this->assign('records',$users);
  		$this->load->view('class/list',$head);
  	}
	
  	function add()
  	{
		$head = array('page_title'=>'New class','link_title'=>'New Class','link_action'=>'Classes/index');
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg();   
		if ($this->form_validation->run() == FALSE)
		{			
			$this->load->view('class/new',$head);			
		}
		else
		{
			$data['title']				= $this->input->post('title');
			$data['code']				= $this->input->post('code');
			$data['serial']				= $this->input->post('serial');
			$data['result_scale_id']	= $this->input->post('result_scale_id');
			$data['is_result_publish']	= $this->input->post('is_result_publish');
			$data['status']				= $this->input->post('status');
			$data['start_date'] 	  	= $this->input->post('start_date');
			$data['end_date']   		= $this->input->post('end_date');
			$data['created_at']  	    = $this->current_date();
			$data['created_by']  		= $this->session->userdata('userid');
			$class_id = $this->classmodel->add($data);
			if($class_id){
				$this->session->set_flashdata('message',$this->tpl->set_message('add','class'));
			}else{
				$this->session->set_flashdata('message',$this->tpl->set_message('error','Class has not saved!.'));
			}
			redirect('Classes');
		}			
	}
		
	function edit($id)
	{
		$id = decode($id);
		$head = array('page_title'=>'Edit class','link_title'=>'Class List','link_action'=>'Classes/index');
		$class=$this->classmodel->get_record($id);							// get record
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg();
		$this->assign($class); 
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('class/edit',$head);
		}
		else
		{
			$data['title']				= $this->input->post('title');
			$data['code']				= $this->input->post('code');
			$data['serial']				= $this->input->post('serial');
			$data['result_scale_id']	= $this->input->post('result_scale_id');
			$data['is_result_publish']	= $this->input->post('is_result_publish');
			$data['status']				= $this->input->post('status');
			$data['start_date'] 	  	= $this->input->post('start_date');
			$data['end_date']   		= $this->input->post('end_date');
			$this->classmodel->edit($id,$data);   // Update data 
			$this->session->set_flashdata('message',$this->tpl->set_message('edit','Class'));
			redirect('classes');			
		}
	}

	function set_status($id,$val)
	{
		echo $this->status_change($id,$val,'classmodel','change_status'); //model name 'usermdoel' method name 'change_status'
	}

	function del($id)
	{
		
		$id = decode($id);
		$this->classmodel->del($id);
		$status = 1;
		$message = $this->tpl->set_message('delete','class');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}
	
	
	function view($id='')
	{
		$id = decode($id);
		if($id=='')
		{
			redirect('class');
		}
		$this->tpl->set_page_title("View class information");
		$class=$this->classmodel->get_class_details($id);// get record
		$this->assign($class); 
		$this->load->view('class/view');
	}

	private function validate(){
		$config = array(
			array('field'=>'title','label'=>'Class Title','rules'=>'trim|required'),
			array('field'=>'code','label'=>'Class Code','rules'=>'trim'),
			array('field'=>'serial','label'=>'Serial','rules'=>'trim|required'),
			array('field'=>'result_scale_id','label'=>'Result Scale','rules'=>'trim|required'),  
			array('field'=>'is_result_publish','label'=>'Result Publish','rules'=>'trim|required'),
			array('field'=>'status','label'=>'Status Publish','rules'=>'trim|required'),
			array('field'=>'start_date','label'=>'Start Working Date','rules'=>'trim|required'),
			array('field'=>'end_date','label'=>'End Working Date','rules'=>'trim|required'),
		);	
		return $config;
	}
		
 }
