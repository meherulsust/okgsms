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
class GenerateTuitionFee extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('GenerateTuitionFeeModel'));
		$this->tpl->set_page_title('Generate Tuition Fee');
		$month_option = $this->optionmodel->month_option(); 
		$this->assign('month_option', $month_option);
		$year_option = $this->optionmodel->year_option(); 
		$this->assign('year_option', $year_option);
		$class_options = $this->optionmodel->class_options(); 		
		$this->assign('class_options',$class_options);
		$this->tpl->set_css(array('datepicker/datepicker'));
        $this->tpl->set_js(array('plugins/datepicker/bootstrap-datepicker'));
 	}
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Tuition Fee List','link_title'=>'Generate Tuition Fee ','link_action'=>'GenerateTuitionFee/add');
		$labels = array('id_no' => 'student ID','full_name' => 'Student Name','class' => 'Class','total_amount' => 'Total Amount','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->GenerateTuitionFeeModel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->GenerateTuitionFeeModel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('tuition_fee_list/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'Generate Tuition Fee','link_title'=>'Tuition Fee List','link_action'=>'GenerateTuitionFee/index');
		$this->form_validation->set_rules($this->validate());
		$this->validation_error_msg(); 

		$class_id						        = $this->input->post('class_id');
		$amount       					    	= $this->GenerateTuitionFeeModel->getTotalTuitionFeeBy($class_id);
		$stuendtList       					    = $this->GenerateTuitionFeeModel->getStudentBy($class_id);
		$tutionFeeConfigList 					= $this->GenerateTuitionFeeModel->getTuitionListBy($class_id);
	
		if($this->form_validation->run() == FALSE){
			$this->load->view('tuition_fee_list/new',$head);	
		}else{	
				foreach($stuendtList as $stu){
					$fee['student_id']		= $stu['id'];
					$fee['class_id']	    = $class_id;
					$fee['total_amount']	= $amount['amount'];
					$fee['total_due']		= $amount['amount'];
					$fee['month']			= $this->input->post('month');
					$fee['year']			= $this->input->post('year');
				    $fee['invoice_no']		= 'INV-'.$fee['month'].$fee['year'].$fee['student_id'];		
					$fee['status']			= 'Unpaid';
					$fee['created_at']	   	= $this->current_date();
					$fee['created_by'] 	 	= $this->session->userdata('admin_userid');
					$tuition_id             = $this->GenerateTuitionFeeModel->addFee($fee);

					foreach($tutionFeeConfigList as $val){
						$fee_detail['tuition_fee_list_id']	   	= $tuition_id;
						$fee_detail['tuition_fee_config_id']    = $val['id'];
						$fee_detail['tuition_fee_head_id']      = $val['tuition_fee_head_id'];
						$fee_detail['amount']	   			    = $val['amount'];;
						$fee_detail['created_at']	   			= $this->current_date();
						$fee_detail['created_by'] 	 			= $this->session->userdata('admin_userid');
						$data[] 						        = $fee_detail;					
					}
				
				}
				$this->GenerateTuitionFeeModel->addDetail($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Tuition Fee Config'));
				redirect('GenerateTuitionFee'); 		
				 			
		}
	
	}

	public function view($id)
	{
		$id = decode($id);
        $config = array(array('field' => 'paid_amount','label' => 'paid_amount','rules' => 'trim|required|numeric'));
        $this->form_validation->set_rules($config);
		$this->validation_error_msg(); 
		if($this->form_validation->run()== FALSE) 
		{
			$data['msg'] = '';
		}else{
			$row = $this->GenerateTuitionFeeModel->get_invoice_info($id);
			if($row['total_due'] >= $this->input->post('paid_amount'))
			{
				$history_data['invoice_id'] = $id;	
				$history_data['paid_amount'] = $this->input->post('paid_amount');	
				$history_data['created_at'] = $this->current_date();			
				$history_data['created_by'] = $this->session->userdata('admin_userid');			
				$history_id = $this->GenerateTuitionFeeModel->insert_payment_history($history_data);
				if($history_id)
				{
					$payment_status = ($row['total_due'] == $this->input->post('paid_amount') ? 'paid' : 'due');
					$this->GenerateTuitionFeeModel->update_due_payment($id,$payment_status,$this->input->post('paid_amount'));
					$data['msg'] = '<div class="alert alert-success"><b><i class="fa fa-check-circle"></i></b> Payment has been added successfully.</div>';
				}else{
					$data['msg'] = '<div class="alert alert-danger"><b><i class="fa fa-info-circle"></i></b> Payment not added.</div>';
				}
			}else{
				$data['msg'] = '<div class="alert alert-danger"><b><i class="fa fa-info-circle"></i></b> Paid amount must be less then or equal to due amount.</div>';
			}
		}
		$invoice_info = $this->GenerateTuitionFeeModel->get_invoice_info($id);
		printr($invoice_info);
		$this->assign($invoice_info);
		$details = $this->GenerateTuitionFeeModel->get_invoice_details($id);
		$this->assign('details',$details);
		//$payment_list = $this->GenerateTuitionFeeModel->get_payment_list($id);
		printr($details);exit;
		$this->assign('payment_list',$payment_list);
		$this->load->view('sales/invoice_details');		
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->GenerateTuitionFeeModel->get_record($id);
		$head = array('page_title'=>'Edit Tuition Fee Config','link_title'=>'Tuition Fee Config','link_action'=>'GenerateTuitionFee/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('generate_tuition_fee/edit',$head);	
			}else{
				$data['tuition_fee_head_id'] 			= $this->input->post('tuition_fee_head_id');
				$data['class_id'] 						= $this->input->post('class_id');
				$data['amount'] 						= $this->input->post('amount');
				$data['status']		   				    = $this->input->post('status');
				$data['updated_at']	   				    = $this->current_date();
				$data['updated_by'] 					= $this->session->userdata('admin_userid');
				$this->GenerateTuitionFeeModel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Tuition Fee Config'));
				redirect('GenerateTuitionFee'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'GenerateTuitionFeeModel', 'change_status'); //model name , method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'class_id','label'=>'Class','rules'=>'trim|required'),
				array('field'=>'year','label'=>'Month','rules'=>'trim|required'),
				array('field'=>'month','label'=>'Month','rules'=>'trim|required')
        );
        return $config;
    }
	
}

