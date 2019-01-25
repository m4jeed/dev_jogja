<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_authorized extends MY_Admin {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		$data['top_title']='404';
		$data['box_title']='NOT AUTHORIZED';
		$data['content']='admin/v_not_authorized';
		$this->load->view('admin/template',$data);
	}
	
	
	
	
}
