<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -----------------------------------------------------
| PRODUCT NAME          : OKGSMS
-----------------------------------------------------
| CONTROLLER CLASS NAME : Backup
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
class Backup extends MT_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
	
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'mybackup.sql'
        );
        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download('mybackup.zip', $backup);
	}
}