<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
		
	}
		
	
	function cek_email($email){
		$sql="SELECT count(*) as jumlah FROM users WHERE email=? and is_confirmed_email='1'";
		$q=$this->db->query($sql,array($email));
		return (int)$q->row()->jumlah;
	}
	
	function cek_no_hp($no_hp){
		$sql="SELECT is_confirmed_hp FROM users WHERE no_hp=?";
		$q=$this->db->query($sql,array($no_hp));
		return $q->row_array();
	}
	
	function cek_email_no_hp($email,$no_hp){
		$sql="SELECT user_id  FROM users WHERE email=? and no_hp=?";
		$q=$this->db->query($sql,array($email,$no_hp));
		if($q->num_rows()>0){
			return $q->row_array();
		}else{
			return array();
		}
	}
	
	
	function register($data){
		$this->db->insert('users',$data);
		return $data;
	}
	
	function login($uname){
		$uname = filter_var($uname, FILTER_SANITIZE_EMAIL);
		if(filter_var($uname, FILTER_VALIDATE_EMAIL)){
			$sql="SELECT *
			FROM users 
			WHERE email=? and is_confirmed_email='1'";
		}else{
			$sql="SELECT *
			FROM users 
			WHERE no_hp=? and is_confirmed_hp='1'";
		}
		
		$q=$this->db->query($sql,array($uname));
		//var_dump($q);die();
		return $q->row_array();
	}
	
	function login_by_email($uname){
		$sql="SELECT *
			FROM users 
			WHERE email=?";
		$q=$this->db->query($sql,array($uname));
		return $q->row_array();
	}
	
	function login_by_no_hp($uname){
		$sql="SELECT *
			FROM users 
			WHERE no_hp=?";
		$q=$this->db->query($sql,array($uname));
		return $q->row_array();
	}
	
	
	
	function update_user($user_id,$data){
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		return $data;
	}
	
	function get_user($user_id){
		$sql="SELECT users.*,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode
			FROM users
			LEFT JOIN base_postalcode
			ON users.postalcode_id=base_postalcode.ids
			WHERE users.user_id=?";
		$q=$this->db->query($sql,array($user_id));
		return $q->row_array();
	}
	
	function get_user_by_user_id($user_id){
		$sql="SELECT *
			FROM users
			WHERE user_id=?";
		$q=$this->db->query($sql,array($user_id));
		return $q->row_array();
	}
	
	function get_user_by_no_hp($no_hp){
		$sql="SELECT *
			FROM users
			WHERE no_hp=?";
		$q=$this->db->query($sql,array($no_hp));
		return $q->row_array();
	}
	
	function get_user_by_no_hp_or_email_or_vacc($q){
		$sql="SELECT * 
			FROM users
			WHERE email=? or no_hp=? or vacc_number=? and is_verified='1'";
		$q=$this->db->query($sql,array($q,$q,$q));
		return $q->row_array();
	}
	
	function get_user_by_vacc($vacc_number){
		$sql="SELECT * 
			FROM users
			WHERE vacc_number=?";
		$q=$this->db->query($sql,array($vacc_number));
		return $q->row_array();
	}
	
	function verify_hp($no_hp,$otp){
		$sql="SELECT * FROM users WHERE no_hp=? and otp=?";
		$q=$this->db->query($sql,array($no_hp,$otp));
		if($q->num_rows()>0){
			$user=$q->row_array();
			if($user['is_confirmed_hp']=='1'){
				return array('is_confirmed_hp'=>'1'
							,'data'=>[]);
			}else{
				//die();
				$this->load->model('M_vacc');
				//$vacc_number=$this->M_vacc->generate_vacc_number($user['user_id']);
				$vacc_number='1'.$this->create_code($user['user_id']);
				$my_referal_code=$user['user_id'];
				//var_dump($vacc_number);die();
				$result=$this->M_vacc->register_vacc($vacc_number,$user['fullname'],$user['email'],$user['no_hp']);
				//var_dump($result['result']);
				//die();
				//$data_insert['response']=json_encode($result);
				//$this->db->insert('log_request',$data_insert);
				//var_dump($result['result']['id_user']);
				//die();
				if(isset($result['result']['id_user'])){
					$user_id_ma=$result['result']['id_user'];
					if($user_id_ma!=''){
						$this->db->where('no_hp',$no_hp);
						$this->db->update('users',array('user_id_ma'=>$user_id_ma,
														'vacc_number'=>$vacc_number,
														'my_referal_code'=>$my_referal_code,
														'is_confirmed_hp'=>'1'));
					}else{
						return array();
					}
				}else{
					return array();
				}
				return array('is_confirmed_hp'=>'0'
							,'data'=>$user);
			}
			
		}else{
			return array();
		}
	}
	
	function get_referal_agent($referal_code){
		$sql="SELECT fullname,email,vacc_number FROM users WHERE my_referal_code=?";
		$q=$this->db->query($sql,array($referal_code));
		return $q->row_array();
	}
	
	function get_referal_downline($my_referal_code){
		$sql="SELECT fullname,email,vacc_number FROM users WHERE referal_code=?";
		$q=$this->db->query($sql,array($my_referal_code));
		return $q->result_array();
	}
	
	function create_code($key){
		if(strlen($key)==1){
			$str='00000'.$key;
		}elseif(strlen($key)==2){
			$str='0000'.$key;
		}elseif(strlen($key)==3){
			$str='000'.$key;
		}elseif(strlen($key)==4){
			$str='00'.$key;
		}elseif(strlen($key)==5){
			$str='0'.$key;
		}else{
			$str=$key;
		}
		return $str;
	}
	
	function insert_gps_tag($data){
		$this->db->insert('users_gps_tag',$data);
		return $data;
	}
	
	function update_fcm_id($user_id,$fcm_id){
		$data['fcm_id']=$fcm_id;
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		return $data;
	}
	
	function update_token($user_id,$expire_time){
		$date = new DateTime();
		$data['access_token']=md5(uniqid().$date->getTimestamp().$user_id.uniqid());
		$data['token_expired']=$date->getTimestamp()+(int)$expire_time;
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		return $data['access_token'];
	}
	
	function update_expire_token($access_token,$expire_time){
		$date = new DateTime();
		$data['token_expired']=$date->getTimestamp()+(int)$expire_time;
		$this->db->where('access_token',$access_token);
		$this->db->update('users',$data);
		return $data['token_expired'];
	}
	
	function verify_token($access_token){
		$sql="SELECT * FROM users WHERE access_token=?";
		$res=$this->db->query($sql,array($access_token));
		return $res->row_array();
	}
	
	
	
	
	
	
}

