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
class SmsTemplate extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('SmsTemplateModel'));
		$this->tpl->set_page_title('SMS Template');
 	 }
	 
	public function index($sort_type = 'asc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'SMS Template List','link_title'=>'New Template','link_action'=>'SmsTemplate/add');
		$labels = array('title' => 'Title','description' =>'Full Message','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->SmsTemplateModel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->SmsTemplateModel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('sms_template/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'SMS Template','link_title'=>'SMS Template List','link_action'=>'SmsTemplate/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->index($sort_type = 'asc', $sort_on = 'id');	
		}else{
				$data['title'] 			= $this->input->post('title');
				$data['description']    = $this->input->post('description');
				$data['status']		    = 'Active';
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->SmsTemplateModel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','SMS Template'));
				redirect('SmsTemplate'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->SmsTemplateModel->get_record($id);
		$head = array('page_title'=>'Edit SMS Template','link_title'=>'SMS Template','link_action'=>'SmsTemplate/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
				$this->assign('status_options', $status_option);
				$this->load->view('sms_template/edit',$head);	
			}else{
				$data['title'] 			= $this->input->post('title');
				$data['description']    = $this->input->post('description');
				$data['status']		    = $this->input->post('status');
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->SmsTemplateModel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','SMS Template'));
				redirect('SmsTemplate'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('SmsTemplate');
        }
		$country = $this->SmsTemplateModel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'SMS Template information','link_title'=>'Tuition Fee Head List','link_action'=>'SmsTemplate/index');
            $this->assign($country);
            $this->load->view('sms_template/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'SmsTemplateModel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}
	
	private function validate(){
        $config = array(
			array('field'=>'title','label'=>'Title','rules'=>'trim|required'),
			array('field'=>'description','label'=>'SMS Description','rules'=>'trim|required|max_length[480]')
		);
        return $config;
    }
	
}

