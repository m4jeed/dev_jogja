<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cms extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
			$is_login=$this->session->userdata('is_login');
			if($is_login!='yes'){
				redirect('cms');
			}
		
		$this->load->library('pagination');
		
		$this->load->helper('enkrip');
		$this->load->helper('notify');
	}
}
