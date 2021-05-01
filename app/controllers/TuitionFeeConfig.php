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
class TuitionFeeConfig extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('TuitionFeeConfigModel'));
		$this->tpl->set_page_title('Tuition Fee Config');
		$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
		$tuition_fee_head_option = $this->optionmodel->tutuion_fee_head_options(); 
		$this->assign('tuition_fee_head_options', $tuition_fee_head_option);
		$class_options = $this->optionmodel->class_options(); 		
		$this->assign('class_options',$class_options);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Tuition Fee Config List','link_title'=>'New Tuition Fee Config','link_action'=>'TuitionFeeConfig/add');
		$labels = array('title' => 'Title','class' => 'Class','amount' => 'Amount','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->TuitionFeeConfigModel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->TuitionFeeConfigModel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('tuition_fee_config/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Tuition Fee Config','link_title'=>'Tuition Fee Config List','link_action'=>'TuitionFeeConfig/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tuition_fee_config/new',$head);	
		}else{
				$data['tuition_fee_head_id'] 			= $this->input->post('tuition_fee_head_id');
				$data['class_id'] 						= $this->input->post('class_id');
				$data['amount'] 						= $this->input->post('amount');
				$data['status']		   				    = $this->input->post('status');
				$data['created_at']	   				    = $this->current_date();
				$data['created_by'] 	 				= $this->session->userdata('admin_userid');
				$this->TuitionFeeConfigModel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Tuition Fee Config'));
				redirect('TuitionFeeConfig'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->TuitionFeeConfigModel->get_record($id);
		$head = array('page_title'=>'Edit Tuition Fee Config','link_title'=>'Tuition Fee Config','link_action'=>'TuitionFeeConfig/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('tuition_fee_config/edit',$head);	
			}else{
				$data['tuition_fee_head_id'] 			= $this->input->post('tuition_fee_head_id');
				$data['class_id'] 						= $this->input->post('class_id');
				$data['amount'] 						= $this->input->post('amount');
				$data['status']		   				    = $this->input->post('status');
				$data['updated_by'] 					= $this->session->userdata('admin_userid');
				$this->TuitionFeeConfigModel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Tuition Fee Config'));
				redirect('TuitionFeeConfig'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('TuitionFeeConfig');
        }
		$country = $this->TuitionFeeConfigModel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'Tuition Fee config information','link_title'=>'Tuition Fee Config List','link_action'=>'TuitionFeeConfig/index');
            $this->assign($country);
            $this->load->view('tuition_fee_config/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'TuitionFeeConfigModel', 'change_status'); //model name , method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'tuition_fee_head_id','label'=>'Tuition Fee Head','rules'=>'trim|required'),
				array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
				array('field'=>'amount','label'=>'Amount','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required')		
        );
        return $config;
    }
	
}

