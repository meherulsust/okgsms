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
class StudentSms extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('StudentSmsModel'));
		$this->tpl->set_page_title('Student SMS');

		$class_options = $this->optionmodel->class_options();; 		
		$this->assign('class_options',$class_options);
		$class_id = $this->input->post('class_id');
		$message_options = $this->optionmodel->message_options(); 		
		$this->assign('message_options',$message_options);
 	}
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$data = $this->input->post();
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Student SMS','link_title'=>'Send Student SMS','link_action'=>'StudentSms/add');
		$labels = array('mobile_no'=>'Mobile','class' => 'Class','full_message'=>'Full Message');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->StudentSmsModel->count_list($data);
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array());
		$this->set_pagination($config);
		$list = $this->StudentSmsModel->get_list($data); // get data list
		$this->assign('records', $list);
		$this->load->view('student_sms/list',$head);
	}

	public function add()
	{
		$this->load->helper('send_sms');
		$head = array('page_title'=>'Student SMS','link_title'=>'Send Student SMS List','link_action'=>'StudentSms/index');
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg(); 

		if($this->form_validation->run() == FALSE){
			$this->load->view('student_sms/new',$head);	
		}else{
			$class_id						        = $this->input->post('class_id');
			$msg						            = $this->input->post('full_message');
			$stuendtList       					    = $this->StudentSmsModel->getStudentBy($class_id);
			
			if(!empty($stuendtList))	{

				foreach($stuendtList as $stu){
					$sms_history['student_id']		= $stu['id'];
					$sms_history['mobile_no']		= '880'.substr($stu['mobile_no'],-10);
					$sms_history['class_id']	    = $class_id;
					$sms_history['message_id']	    = $this->input->post('message_id');
					$sms_history['full_message']	= $msg;	
					$sms_history['status']			= 'Send';
					$sms_history['created_at']	   	= $this->current_date();
					$sms_history['created_by'] 	 	= $this->session->userdata('admin_userid');
					$sms_data[] = $sms_history;
				}

				foreach($stuendtList as $val)
				{
					$mobile_number[]='+880'.substr($val['mobile_no'],-10);
				}

				$data['recipient'] 			   = implode(",",$mobile_number);
				$data['message'] 	           = $this->input->post('full_message');
				$title_array                   = explode(' ',trim($data['message']));
				$data['message_title'] 		   = $title_array[0].' '.$title_array[1];
				//sending sms
				bulk_sms($data);

				$this->StudentSmsModel->add_sms_history($sms_data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','SMS History'));
				redirect('StudentSms/index');
				
			}else{
				$this->session->set_flashdata('message',$this->tpl->set_message('error','No SMS has send to this class !'));
				redirect('StudentSms/index');
			} 		
				 			
		}
	
	}

	

	//check duplicate admission Number for validation

	function duplicate_sms($str,$param='')
	{
		$class_id    = $this->input->post('class_id');

		$query = $this->db->query("SELECT id FROM sms_send_msg_info where message_id='$str' AND class_id='$class_id' AND message_id<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_sms', "%s <span style='color:green;'>This SMS has already send to this class</span>");
			return false;
		}
		return true;
	}

	// get full message	
	function get_full_message()
	{
		$id = $this->input->post('message_id');		
		if($id!='' OR $id!=Null)
		{
			$data=$this->StudentSmsModel->get_full_message($id);         // get full message
			echo $data['description'];
		}
	}

	private function validate(){
        $config = array(
				array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
				array('field'=>'message_id','label'=>'Message title','rules'=>'trim|required|callback_duplicate_sms'),
				array('field'=>'full_message','label'=>'Full Message','rules'=>'trim|required')
        );
        return $config;
    }

	
}

