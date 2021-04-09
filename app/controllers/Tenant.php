<?php
/*
| -----------------------------------------------------
| PRODUCT NAME             : AIID
|-----------------------------------------------------
| CONTROLLER CLASS NAME    : Tenant
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
class Tenant extends MT_Controller
{
  	function __construct()
 	{ 	 	
 	 	parent::__construct();
 	 	$this->load->model(array('tenantmodel'));
		$this->tpl->set_page_title('Tenant');
		$status_option = array('Active' => 'Active', 'Pending' => 'Pending','Inactive' => 'Inactive');
		$this->assign('status_options', $status_option);
 	 }
	 
	public function index($sort_type = 'desc', $sort_on = 'id')
	{
		$this->tpl->set_js(array('jquery.statusmenu'));
		$head = array('page_title'=>'Tenant List','link_title'=>'New Tenant','link_action'=>'Tenant/add');
		$labels = array('title' => 'Tenant Name','subdomain'=>'Subdomain','email' => 'Email','contact_number' => 'Contact Number','status' => 'Status');
		$this->assign('labels', $labels);
		$config['total_rows'] = $this->tenantmodel->count_list();
		$config['uri_segment'] = 6;
		$config['select_value'] = $this->input->post('rec_per_page');
		$config['sort_on'] = $sort_on;
		$config['sort_type'] = $sort_type;
		$this->assign('grid_action', array('details' => 'details','edit' => 'edit','view' => 'view'));
		$this->set_pagination($config);
		$list = $this->tenantmodel->get_list(); // get data list
		$this->assign('records', $list);
		$this->load->view('tenant/list',$head);
	}

	public function add()
	{
		$head = array('page_title'=>'New Tenant','link_title'=>'Tenant List','link_action'=>'Tenant/index');
		$this->form_validation->set_rules($this->validate());
		$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->load->view('tenant/new',$head);	
		}else{
				$data['title'] 			= $this->input->post('title');
				$data['subdomain']  	= $this->input->post('subdomain');
				$data['contact_number'] = $this->input->post('contact_number');
				$data['status']		    = $this->input->post('status');
				$data['email'] 	 		= $this->input->post('email');
				$data['created_at']	    = $this->current_date();
				$data['created_by'] 	= $this->session->userdata('admin_userid');
				$this->tenantmodel->add($data);
				$this->session->set_flashdata('message',$this->tpl->set_message('Add','Tenant'));
				redirect('Tenant'); 		
				 			
		}
	}

	public function edit($id='')
	{
		$id = decode($id);
		$row = $this->tenantmodel->get_record($id);
		$head = array('page_title'=>'Edit Tenant','link_title'=>'Tenant List','link_action'=>'Tenant/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->validate());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('tenant/edit',$head);	
			}else{
				$data['title'] 			= $this->input->post('title');
				$data['subdomain']  	= $this->input->post('subdomain');
				$data['contact_number'] = $this->input->post('contact_number');
				$data['status']		    = $this->input->post('status');
				$data['email'] 	 		= $this->input->post('email');
				$data['updated_at']	    = $this->current_date();
				$data['updated_by'] 	= $this->session->userdata('admin_userid');
				$this->tenantmodel->edit($id,$data);
				$this->session->set_flashdata('message',$this->tpl->set_message('edit','Tenant'));
				redirect('Tenant'); 		
				
								
			}
		}else{
			$this->view_404();
		}	
	}

	public function view($id = '')
    {
        $id = decode($id);
        if ($id == '') {
            redirect('Tenant');
        }
		$tenant = $this->tenantmodel->get_record($id); // get record
        if ($tenant) {
			$head = array('page_title'=>'View tenant information','link_title'=>'Tenant List','link_action'=>'Tenant/index');
            $this->assign($tenant);
            $this->load->view('tenant/view',$head);
        } else {
            $this->view_404();
        }
	}
	
	public function set_status($id, $val)
    {
        echo $this->status_change($id, $val, 'tenantmodel', 'change_status'); //model name 'usermdoel' method name 'change_status'
	}

	public function details($id = '')
    {
		$id = decode($id);
		$row = $this->tenantmodel->get_record($id);
		$head = array('page_title'=>'Add Tenant Details','link_title'=>'Tenant List','link_action'=>'Tenant/index');
		$this->assign($row);	
		if (!empty($row)) {
			$this->form_validation->set_rules($this->not_required());
			$this->form_validation->set_error_delimiters('<span class="verr"><i class="fa fa-exclamation-circle"></i> ', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->load->view('tenant/details',$head);	
			}else{
				$data['fax']		 = $this->input->post('fax');
				$data['description'] = $this->input->post('description');
				$data['website'] 	 = $this->input->post('website');
				$data['address'] 	 = $this->input->post('address');
				$data['updated_at']  = $this->current_date();
				$data['updated_by']  = $this->session->userdata('admin_userid');

				if (trim($_FILES["logo"]["name"]) != '' || $_FILES["login_banner"]["name"] != '' || trim($_FILES["favicon"]["name"]) != '')
				{
						if(trim($_FILES["favicon"]["name"]) != '' ){
							$ext = explode(".", $_FILES["favicon"]["name"]);
							$file_ext = end($ext);
							$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
							if ($this->upload_images('favicon',$image_name,'logo')) { // field_name, iamge_name ,folder_name
								$data['favicon'] = $image_name;
								if ($row['favicon'] != '') {
									unlink($this->upload_dir() . "logo/" . $row['favicon']);
								}
							}else{
								$upload_error['error_favicon'] =  $this->upload->display_errors(); 			
							} 
						}
						
						if(trim($_FILES["logo"]["name"]) != '' ){
							$ext = explode(".", $_FILES["logo"]["name"]);
							$file_ext = end($ext);
							$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;			
							if ($this->upload_images('logo',$image_name,'logo')) { // field_name, iamge_name ,folder_name
								$data['logo'] = $image_name;
								if ($row['logo'] != '') {
									unlink($this->upload_dir() . "logo/" . $row['logo']);
								}
							}else{
								$upload_error['error_logo'] =  $this->upload->display_errors(); 			
							} 
						}
						if(trim($_FILES["login_banner"]["name"]) != '' ){
							$ext = explode(".", $_FILES["login_banner"]["name"]);
							$file_ext = end($ext);
							$image_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $file_ext;	
							if ($this->upload_images('login_banner',$image_name,'login_banner')) { // field_name, iamge_name ,folder_name
								$data['login_banner'] = $image_name;
								if ($row['login_banner'] != '') {
									unlink($this->upload_dir() . "login_banner/" . $row['login_banner']);
								}
							}else{
								$upload_error['error_login_banner'] =  $this->upload->display_errors(); 			
							}
		
						}
						
						if($this->upload->display_errors()){
							$head = array('page_title'=>'Add Tenant Details','link_title'=>'Tenant List','link_action'=>'Tenant/index');
							$this->assign($upload_error);
							$this->load->view('tenant/details',$head);	
						}
					else{
						$this->tenantmodel->edit($id,$data); // Update data
						$this->session->set_flashdata('message', $this->tpl->set_message('edit', 'Tenant'));
						redirect('Tenant');	
					}
					
				}else{
					$this->tenantmodel->edit($id,$data);
					$this->session->set_flashdata('message',$this->tpl->set_message('edit','Tenant'));
					redirect('Tenant'); 		
				}
								
			}
		}else{
			$this->view_404();
		}	
	}

	private function validate(){
        $config = array(
				array('field'=>'title','label'=>'Tenant Name','rules'=>'trim|required'),
				array('field'=>'email','label'=>'email','rules'=>'trim|required'),
				array('field'=>'contact_number','label'=>'Contact number','rules'=>'trim|required'),
				array('field'=>'status','label'=>'Status','rules'=>'trim|required'),
				array('field'=>'subdomain','label'=>'Subdomain','rules'=>'trim|required')		
        );
        return $config;
    }

	private function not_required(){
        $config = array(
				array('field'=>'address','label'=>'address','rules'=>'trim'),
				array('field'=>'fax','label'=>'fax','rules'=>'trim'),
				array('field'=>'website','label'=>'website number','rules'=>'trim'),
				array('field'=>'description','label'=>'description','rules'=>'trim')	
        );
        return $config;
    }
	
}

