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
		$labels = array('mobile_no'=>'Mobile','class' => 'Class','description'=>'Full SMS','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->StudentSmsModel->count_list($id='',$data);
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('view' => 'view'));
		$this->set_pagination($config);
		$list = $this->StudentSmsModel->get_list($id='',$data); // get data list
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
					$sms['student_id']		= $stu['id'];
					$sms['mobile_no']		= '880'.substr($stu['mobile_no'],-10);
					$sms['class_id']	    = $class_id;
					$sms['full_message']	= $msg;	
					$sms['status']			= 'Send';
					$sms['created_at']	   	= $this->current_date();
					$sms['created_by'] 	 	= $this->session->userdata('admin_userid');
					$sms_data[] = $sms;
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
				$this->session->set_flashdata('message',$this->tpl->set_message('error','No SMS is send for this class'));
				redirect('StudentSms/index');
			} 		
				 			
		}
	
	}

	

	//check duplicate admission Number for validation

	function duplicate_tuition_fee($str,$param='')
	{
		$month    = $this->input->post('month');
		$year     = $this->input->post('year');

		$query = $this->db->query("SELECT id FROM sms_tuition_fee_list where class_id='$str' AND month='$month'AND year='$year' AND class_id<>'$param'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_tuition_fee', "%s <span style='color:green;'>tuition fee for this month $year </span> already exists");
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
				array('field'=>'message_id','label'=>'Message title','rules'=>'trim|required'),
				array('field'=>'full_message','label'=>'Full Message','rules'=>'trim|required')
        );
        return $config;
    }

	public function test_sms(){
		$this->load->helper('send_sms');
		$data['message']     = 'পবিত্র ঈদুল আজহা উপলক্ষে চলমান বিধিনিষেধ ১৪ জুলাই মধ্যরাত থেকে ২৩ জুলাই সকাল ৬টা পর্যন্ত শিথিল করেছে সরকার।';
		$data['mobile']      = '+8801711441623';
		//$data['mobile']    = '8801754954954';
		send_single_sms($data);
	}
	
}

