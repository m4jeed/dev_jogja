<?php defined('BASEPATH') OR exit('No direct script access allowed');

//referens random string generator
//https://stackoverflow.com/questions/4356289/php-random-string-generator
class M_access_token extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	function genReferenceNumber(){
		$t = microtime(true);
		$micro = sprintf("%06d", ($t - floor($t)) * 1000000);
		$d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

		return $d->format("YmdHisu"); 
	}
	
	function create_token($user_id,$expire_time){
		$date = new DateTime();
		$data['token_start']=$date->getTimestamp();
		$data['token_start_time']=date('Y-m-d H:i:s',$data['token_start']);
		$data['token_expired']=$date->getTimestamp()+(int)$expire_time;
		$data['token_expired_time']=date('Y-m-d H:i:s',$data['token_expired']);
		$data['access_token']=bin2hex(random_bytes(10)).$user_id.bin2hex(random_bytes(10)).$this->genReferenceNumber();
		$data['user_id']=$user_id;
		$this->db->insert('access_token',$data);
		return $data['access_token'];
	}
	
	function verify_token($access_token){
		$sql="select 
			t1.access_token,
			t1.token_expired,
			t1.token_start,
			t2.*,
			t3.vacc_number
			from access_token t1
			INNER JOIN ma_users t2
			ON t1.user_id=t2.user_id
			INNER JOIN ma_vacc t3
			ON t1.user_id=t3.user_id
			WHERE t1.access_token=?";
		$q=$this->db->query($sql,array($access_token));
		return $q->row_array();
	}
	
	function update_token($access_token,$expire_time){
		$date = new DateTime();
		$data['token_start']=$date->getTimestamp();
		$data['token_start_time']=date('Y-m-d H:i:s',$data['token_start']);
		$data['token_expired']=$date->getTimestamp()+(int)$expire_time;
		$data['token_expired_time']=date('Y-m-d H:i:s',$data['token_expired']);
		$this->db->where('access_token',$access_token);
		$this->db->update('access_token',$data);
	}
	
	
	
	
	
}

