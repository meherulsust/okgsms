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
class Country extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('countrymodel'));
		$this->tpl->set_page_title('Country');
		$status_option = array('Active' => 'Active','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Country List','link_title'=>'New Country','link_action'=>'country/add');
		$labels = array('country' => 'Country Name','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->countrymodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->countrymodel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('country/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Country','link_title'=>'Country List','link_action'=>'Country/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('Country/new',$head);	
		}else{
				$data['country'] 		= $this->input->post('country');
				$data['status']		    = $this->input->post('status');
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->countrymodel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Country'));
				redirect('country'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->countrymodel->get_record($id);
		$head = array('page_title'=>'Edit Country','link_title'=>'Country List','link_action'=>'Country/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('Country/edit',$head);	
			}else{
				$data['country'] 		= $this->input->post('country');
				$data['status']		    = $this->input->post('status');
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->countrymodel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Country'));
				redirect('country'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('country');
        }
		$country = $this->countrymodel->get_record($id); // get record
        if ($country) {
			$head = array('page_title'=>'View Country information','link_title'=>'Country List','link_action'=>'Country/index');
            $this->assign($country);
            $this->load->view('country/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'countrymodel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}

	
	private function validate(){
        $config = array(
				array('field'=>'country','label'=>'Country Name','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required')		
        );
        return $config;
    }
	
}

