<?php
/*
| -----------------------------------------------------
| PRODUCT NAME          : OKGSMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : MenuPermission
| -----------------------------------------------------
| AUTHOR                : Md.Meherul Islam
| -----------------------------------------------------
| EMAIL                 : meherulsust@gmail.com
| -----------------------------------------------------
| COPYRIGHT             : Md.Meherul Islam
| -----------------------------------------------------
| WEBSITE               :
| -----------------------------------------------------
 */

class MenuPermission extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('menumodel'));
    }

    public function index()
    {
        $menu = $this->menumodel->get_home_menulist();
        foreach ($menu as $val) {
            $data_child_array = array();
            $menu_child = $this->menumodel->get_list($val['id']);
            foreach ($menu_child as $val_child) {
                $data_child['id'] = $val_child['id'];
                $data_child['menu_title'] = $val_child['menu_title'];
                $data_child['icon'] = $val_child['icon'];
                $data_child['admin_group_id'] = $val_child['admin_group_id'];
                $data_child_array[] = $data_child;
            }
            $data['id'] = $val['id'];
            $data['menu_title'] = $val['menu_title'];
            $data['icon'] = $val['icon'];
            $data['admin_group_id'] = $val['admin_group_id'];
            $data['child'] = $data_child_array;
            $data_array[] = $data;
        }
        $this->assign('menu_list', $data_array);
        $admin_group_options = $this->optionmodel->group_option(); // get admin group list
        $this->assign('admin_group_options', $admin_group_options);
        $this->load->view('menu_permission/view');
    }

    public function update_permission()
    {
        $menu = $this->menumodel->get_all_menu();
        foreach ($menu as $val) {
            $group_id_array = $this->input->post($val['id']) ? $this->input->post($val['id']) : array();
            $data['id'] = $val['id'];
            $data['admin_group_id'] = '1,'.implode(',', $group_id_array);
            $data_array[] = $data;
        }
        $this->menumodel->update_menu_permission($data_array);
        $this->session->set_flashdata('message', $this->tpl->set_message('edit', 'Menu permission'));
        redirect('MenuPermission');
    }

}