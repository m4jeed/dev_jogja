<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_401 extends CI_Controller {

	public function index()
	{
		$data['header_content']     = '401 - Unauthorized Access';
		$data['content']		= 'v_error_401';
		$this->load->view('template',$data);
	}
	
}
