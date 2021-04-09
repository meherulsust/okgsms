<?php
/*
| -----------------------------------------------------
| PRODUCT NAME             : OKGSMS
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
class Subject extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('subjectmodel'));
		$this->tpl->set_page_title('Subject');
		$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Subject List','link_title'=>'New Subject','link_action'=>'Subject/add');
		$labels = array('title' => 'Title','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->subjectmodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view','del' => 'del'));
		$this->set_pagination($config);
		$list = $this->subjectmodel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('subject/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Subject','link_title'=>'Subject List','link_action'=>'Subject/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('subject/new',$head);	
		}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->subjectmodel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Subject'));
				redirect('Subject'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->subjectmodel->get_record($id);
		$head = array('page_title'=>'Edit Subject','link_title'=>'Subject List','link_action'=>'Subject/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('subject/edit',$head);	
			}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->subjectmodel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Subject'));
				redirect('Subject'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('Subject');
        }
		$country = $this->subjectmodel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'View Subject information','link_title'=>'Subject List','link_action'=>'Subject/index');
            $this->assign($country);
            $this->load->view('subject/view',$head);
        } else {
            $this->view_404();
        }
	}

	function del($id)
	{	
		$id = decode($id);
		$this->subjectmodel->del($id);
		$status = 1;
		$message = $this->tpl->set_message('delete','Subject');
		$array = array('status'=>$status,'message'=>$message);
		echo json_encode($array);
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'subjectmodel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'title','label'=>'Subject Name','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required')		
        );
        return $config;
    }
	
}

