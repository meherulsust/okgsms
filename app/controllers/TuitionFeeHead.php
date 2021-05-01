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
class TuitionFeeHead extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('TuitionFeeHeadModel'));
		$this->tpl->set_page_title('Tuition Fee Head');
		$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Tuition Fee Head List','link_title'=>'New Tuition Fee Head','link_action'=>'TuitionFeeHead/add');
		$labels = array('title' => 'Title','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->TuitionFeeHeadModel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->TuitionFeeHeadModel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('tuition_fee_head/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Tuition Fee Head','link_title'=>'Tuition Fee Head List','link_action'=>'TuitionFeeHead/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tuition_fee_head/new',$head);	
		}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->TuitionFeeHeadModel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Tuition Fee Head'));
				redirect('TuitionFeeHead'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->TuitionFeeHeadModel->get_record($id);
		$head = array('page_title'=>'Edit Tuition Fee Head','link_title'=>'Tuition Fee Head','link_action'=>'TuitionFeeHead/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('tuition_fee_head/edit',$head);	
			}else{
				$data['title'] 			= $this->input->post('title');
				$data['status']		    = $this->input->post('status');
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->TuitionFeeHeadModel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Tuition Fee Head'));
				redirect('TuitionFeeHead'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('TuitionFeeHead');
        }
		$country = $this->TuitionFeeHeadModel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'Tuition Fee Head information','link_title'=>'Tuition Fee Head List','link_action'=>'TuitionFeeHead/index');
            $this->assign($country);
            $this->load->view('tuition_fee_head/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'TuitionFeeHeadModel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'title','label'=>'Tuition Fee Head Name','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required')		
        );
        return $config;
    }
	
}

