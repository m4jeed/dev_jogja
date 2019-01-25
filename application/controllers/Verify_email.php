<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Verify_email extends CI_Controller {

	public function email_key($email_key){
		$this->db->where('email_key',$email_key);
		$user=$this->db->get('ma_users')->row_array();
		if($user){
			if($user['is_confirmed_email']=='0'){
				$data['is_confirmed_email']='1';
				$this->db->where('email_key',$email_key);
				$this->db->update('ma_users',$data);
				//echo 'Email Confirmed';
			}else{
				//echo 'Email already confirmed';
			}
			redirect('http://geraiaccess.co.id/confirm_email');
		}else{
			echo 'Email tidak ada';
		}
		
	}
	
	
	
}
