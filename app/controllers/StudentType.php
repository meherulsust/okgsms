<?php
/*
| -----------------------------------------------------
| PRODUCT NAME             : OKGSMS
|-----------------------------------------------------
| CONTROLLER CLASS NAME    : Country
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
class StudentType extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('studenttypemodel'));
		$this->tpl->set_page_title('Student Type');
		$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Student Type List','link_title'=>'New Student Type','link_action'=>'StudentType/add');
		$labels = array('title' => 'Title','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->studenttypemodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->studenttypemodel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('student_type/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Student Type','link_title'=>'Student Type List','link_action'=>'StudentType/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('student_type/new',$head);	
		}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->studenttypemodel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Student Type'));
				redirect('StudentType'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->studenttypemodel->get_record($id);
		$head = array('page_title'=>'Edit Student Type','link_title'=>'Student Type List','link_action'=>'StudentType/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('student_type/edit',$head);	
			}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->studenttypemodel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Student Type'));
				redirect('StudentType'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('StudentType');
        }
		$country = $this->studenttypemodel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'View Student Type information','link_title'=>'Student Type List','link_action'=>'StudentType/index');
            $this->assign($country);
            $this->load->view('student_type/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'studenttypemodel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'title','label'=>'Student Type Name','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required')		
        );
        return $config;
    }
	
}

