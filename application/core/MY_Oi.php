<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Oi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('myhash');
		
		$auth_arr=array('oi/auth','oi/auth/login','oi/auth/logout','oi/not_authorized');
		if (in_array(uri_string(), $auth_arr)){
			//do nothing
		}else{
			$is_login=$this->session->userdata('is_login');
			//var_dump($is_login);die();
			if($is_login!='Y'){
				$this->session->sess_destroy();
				redirect('oi/auth');
			}
		}
		
		
		
	
	}
	
	
	
}
