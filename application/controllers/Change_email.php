<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Change_email extends CI_Controller {

	public function email_key($email_key){
		$this->db->where('email_key',$email_key);
		$user=$this->db->get('users')->row_array();
		if($user){
			$data['email']=$user['new_email_change'];
			$this->db->where('email_key',$email_key);
			$this->db->update('users',$data);
			echo 'Email Confirmed';
		}else{
			echo 'Email tidak ada';
		}
		
	}
	
	
	
}
