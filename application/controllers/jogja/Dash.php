<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends MY_Jogja {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		$data['top_title']='Dashboard';
		$data['box_title']='Dashboard';
		$data['content']='jogja/v_dashboard';
		$this->load->view('jogja/template',$data);
	}
	
	
	
	
}
