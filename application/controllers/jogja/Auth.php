<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Jogja{
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		
	}
	
	
	public function index(){
		$is_login=$this->session->userdata('is_login');
		if($is_login=='yes'){
			redirect('jogja/notifikasi');
		}else{
			redirect('jogja/auth/login');
		}
	}
	
	public function login(){
		if($this->input->post()){
			$this->form_validation->set_rules('uname', 'Username', 'trim|required');
			$this->form_validation->set_rules('pass', 'Password', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
			}else{
				$uname=trim(strip_tags($this->input->post('uname',true)));
				$pass=trim(strip_tags($this->input->post('pass',true)));
				$login=$this->db->query("select * from users_adm where uname='".$uname."'")->row_array();
				if($login){
					//if($login['pass']==myhash($pass,$login['salt'])){
						$this->session->set_userdata('uname',$login['uname']);
						$this->session->set_userdata('fullname',$login['fullname']);
						$this->session->set_userdata('lvl',$login['lvl']);
						$this->session->set_userdata('is_login','Y');
						$data=array('status'=>'sukses','data'=>"");
					 //}
					 //else{
					// 	$data=array('status'=>'error','data'=>'Password salah');
					// }
				}else{
					$data=array('status'=>'error','data'=>'Username tidak ada');
				}
			}
			
			echo json_encode($data);
			
		}else{
			$this->load->view('jogja/v_login');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('jogja/auth');
	}
	
	
	
}
