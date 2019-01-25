<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller {
	
	function index(){
		echo 'asdsad';
	}
	public function kebijakan_privasi()
	{
		$this->load->view('web_view/v_kebijakan_privasi');
	}
	
	public function ketentuan_pengguna()
	{
		$this->load->view('web_view/v_ketentuan_pengguna');
	}
	
	public function tanya_jawab()
	{
		$this->load->view('web_view/v_tanya_jawab');
	}
}
