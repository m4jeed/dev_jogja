<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_gerai');
		$this->load->model('M_va');
		
	}
	
	function update_user_post(){
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('gender', 'gender', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('dob', 'dob', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('pob', 'pob', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('job', 'job', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('address', 'address', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('province', 'province', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', 'city', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('districts', 'districts', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('village', 'village', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('postalcode', 'postalcode', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('id_card_number', 'id_card_number', 'trim|required|numeric|max_length[50]');
		$this->form_validation->set_rules('mom', 'mom', 'trim|max_length[100]');
		$this->form_validation->set_rules('gerai_name', 'gerai_name', 'trim|max_length[100]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|numeric|max_length[6]');
		$this->form_validation->set_rules('retype_pin', 'retype_pin', 'trim|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$user=$this->M_va->get_user_by_user_id($user_id);
			//var_dump($user);die();
			$allowed =  array('png' ,'jpg','jpeg');
			$cek_file='';
			if(isset($_FILES['id_card_number_photo']) && isset($_FILES['id_card_number_selfi'])){
				$filename = $_FILES['id_card_number_photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array(strtolower($ext),$allowed) ) {
					$cek_file.='Foto KTP harus jpg/png/jpeg';
				}
				
				$filename = $_FILES['id_card_number_selfi']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array(strtolower($ext),$allowed) ) {
					$cek_file.='Foto Selfi KTP harus jpg/png/jpeg';
				}
			}else{
				$cek_file.='Foto KTP & Selfi harus ada';
			}
			
			if($cek_file!=''){
				$this->error_code='';
				$this->error_message=$cek_file;
			}else{				
				if($user){
					$province=strip_tags(trim($this->input->post('province',true)));
					$city=strip_tags(trim($this->input->post('city',true)));
					$districts=strip_tags(trim($this->input->post('districts',true)));
					$village=strip_tags(trim($this->input->post('village',true)));
					$postalcode=strip_tags(trim($this->input->post('postalcode',true)));
					
					$postalcode_data=$this->M_gerai->get_postalcode_data($province,$city,$districts,$village);
					//var_dump($postalcode_data);die();
					if($postalcode_data){
						$data_gerai['postalcode_id']=$postalcode_data['ids'];
					}else{
						$data_gerai['postalcode_id']='0';
					}
					
					//upload image
					$this->load->library('Lib_upload');
					$upload_path_id_card_number_photo='./assets/users_image/';
					$id_card_number_photo=$this->lib_upload->upload_file($upload_path_id_card_number_photo,'id_card_number_photo','gif|jpg|png|jpeg',NULL);
					
					$upload_path_id_card_number_selfi='./assets/users_image/';
					$id_card_number_selfi=$this->lib_upload->upload_file($upload_path_id_card_number_selfi,'id_card_number_selfi','gif|jpg|png|jpeg',NULL);
					
					if($id_card_number_photo){
						$data_gerai['id_card_number_photo']=$id_card_number_photo;
					}
					if($id_card_number_selfi){
						$data_gerai['id_card_number_selfi']=$id_card_number_selfi;
					}
					
					$data_gerai['fullname']=strip_tags(trim($this->input->post('fullname',true)));
					$data_gerai['gender']=strip_tags(trim($this->input->post('gender',true)));
					$data_gerai['dob']=strip_tags(trim($this->input->post('dob',true)));
					$data_gerai['pob']=strip_tags(trim($this->input->post('pob',true)));
					$data_gerai['job']=strip_tags(trim($this->input->post('job',true)));
					$data_gerai['address']=strip_tags(trim($this->input->post('address',true)));
					$data_gerai['id_card_number']=strip_tags(trim($this->input->post('id_card_number',true)));
					$data_gerai['id_card_type']='KTP';
					$data_gerai['mom']=strip_tags(trim($this->input->post('mom',true)));
					$data_gerai['gerai_name']=strip_tags(trim($this->input->post('gerai_name',true)));
					$data_gerai['pin']=myhash(strip_tags(trim($this->input->post('pin',true))),$this->salt);
					
					$data_gerai['status_verifikasi']='proses';
					$data_gerai['verifikasi_msg']='Akun sedang dalam proses verifikasi';
					
					$update_user=$this->M_va->update_user($user_id,$data_gerai);
					if($update_user>0){
						$this->result='Update profile berhasil';
					}else{
						$this->error_code='';
						$this->error_message='Update profile gagal';
					}
				}else{
					$this->error_code='';
					$this->error_message='User tidak ada';
				}
				
			}
		}
		
		$this->jsonOut();
	}
	
	function getuser_post(){
		$this->form_validation->set_rules('user_id', 'user_id', 'trim|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$user=$this->M_va->get_user_by_user_id($user_id);
			if($user){
				$postalcode_id=$user['postalcode_id'];
				if($postalcode_id==''){
					$postalcode_id=0;
				}
				$postalcode=$this->M_va->get_postalcode_by_id($postalcode_id);				
				$this->result= array('user_id'=>$user['user_id'],
							'fullname'=>$user['fullname'],
							"email"=>$user['email'],
							"no_hp"=>$user['phone'],
							"gerai_name"=>$user['gerai_name'],
							"is_verified"=>$user['is_verified'],
							"is_active"=>$user['is_active'],
							"fcm_id"=>$user['fcm_id'],
							"referal_code"=>$user['referal_code'],
							"my_referal_code"=>$user['my_referal_code'],
							"id_card_number"=>$user['id_card_number'],
							"id_card_number_photo"=>site_url('assets/users_image/').$user['id_card_number_photo'],
							"id_card_number_selfi"=>site_url('assets/users_image/').$user['id_card_number_selfi'],
							"is_confirmed_hp"=>$user['is_confirmed_hp'],
							"is_confirmed_email"=>$user['is_confirmed_email'],
							"village"=>$postalcode['village'],
							"districts"=>$postalcode['districts'],
							"city"=>$postalcode['city'],
							"province"=>$postalcode['province'],
							"postalcode"=>$postalcode['postalcode'],
							"address"=>$user['address'],
							"dob"=>$user['dob'],
							"pob"=>$user['pob'],
							"job"=>$user['job'],
							"mom"=>$user['mom'],
							"gender"=>$user['gender'],
							);
			}else{
				$this->error_code='';
				$this->error_message='User tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
	function change_pass_post(){
		$this->form_validation->set_rules('old_pass', 'old_pass', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('new_pass', 'new_pass', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('retype_new_pass', 'retype_new_pass', 'trim|required|matches[new_pass]|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$old_pass=strip_tags(trim($this->input->post('old_pass',true)));
			$new_pass=strip_tags(trim($this->input->post('new_pass',true)));
			
			$change_pass=$this->M_va->change_pass($user_id,$old_pass,$new_pass);
			if($change_pass>0){
				$this->result='Perubahan Password Gerai@ccess Anda Telah Berhasil';
			}else{
				$this->error_code='';
				$this->error_message='Old Password Salah';
			}
		}
		$this->jsonOut();
	}
	
	function change_pin_post(){
		$this->form_validation->set_rules('old_pin', 'old_pin', 'trim|required|numeric|max_length[6]');
		$this->form_validation->set_rules('new_pin', 'new_pin', 'trim|required|numeric|max_length[6]');
		$this->form_validation->set_rules('retype_new_pin', 'retype_new_pin', 'trim|required|matches[new_pin]|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$old_pin=strip_tags(trim($this->input->post('old_pin',true)));
			$new_pin=strip_tags(trim($this->input->post('new_pin',true)));
			
			$user=$this->M_va->get_user_by_user_id($user_id);
			$change_pin=$this->M_va->change_pin($user_id,$old_pin,$new_pin);
			if($change_pin==1){
				$this->result='Success Change PIN';
			}else{
				$this->error_code='';
				$this->error_message='Error Change PIN';
			}
		}
		
		$this->jsonOut();
	}
	
	function reset_pin_post(){
		$this->form_validation->set_rules('user_id', 'user_id', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			//$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$user_id=$this->user_id;
			$new_pin=mt_rand(100000,999999);
			$reset_pin=$this->M_va->reset_pin($user_id,$new_pin);
			if($reset_pin==1){
				$this->result=$new_pin;
			}else{
				$this->error_code='';
				$this->error_message='Error Reset PIN';
			}
		}
		$this->jsonOut();
	}
	
	function verifikasi_msg_post(){
		$this->form_validation->set_rules('user_id', 'user_id', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$user=$this->M_va->get_user_by_user_id($user_id);
			if($user){
				$this->result=array('status_verifikasi'=>$user['status_verifikasi']
									,'verifikasi_msg'=>$user['verifikasi_msg']
									);
			}else{
				$this->error_code='';
				$this->error_message='user tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
	function referal_agent_post(){
		$this->form_validation->set_rules('my_referal_code', 'my_referal_code', 'trim|required|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$my_referal_code=strip_tags(trim($this->input->post('my_referal_code',true)));
			
			$user=$this->M_va->get_referal_downline($my_referal_code);
			if($user){
				$this->result=$user;
			}else{
				$this->error_code='';
				$this->error_message='Data tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
	function change_email_post(){
		$this->form_validation->set_rules('new_email', 'new_email', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$new_email=strip_tags(trim($this->input->post('new_email',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$cek_email=$this->M_va->cek_email($email);
			if($cek_email){
				$this->error_code='';
				$this->error_message='Email sudah ada';
			}else{
				$user=$this->M_va->get_user_by_user_id($user_id);
				if($user){
					if($user['pin']==myhash($pin,$this->salt)){
						$data['new_email_change']=$new_email;
						$data['email_key']=uniqid().time().uniqid().uniqid().uniqid();
						$this->M_va->update_user($user_id,$data);
						
						//send email ----------------------
						$this->load->library('lib_phpmailer');
						$to=$new_email;
						$subject='GeraiAccess - Verifikasi Email';
						
						$this->load->model('M_template_email');
						$message=$this->M_template_email->verify_change_email($email_key);
						
						$this->lib_phpmailer->send_email($to,$subject,$message);
						//------------------------------------
						$this->result='Mohon Cek Email Untuk Verifikasi';
					}else{
						$this->error_code='';
						$this->error_message='PIN salah';
					}
				}else{
					$this->error_code='';
					$this->error_message='User sudah ada';
				}
			}
			
			
		}
		
		$this->jsonOut();
	}
	
	function change_no_hp_post(){
		$this->form_validation->set_rules('new_no_hp', 'new_no_hp', 'trim|required|numeric|max_length[50]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$new_no_hp=strip_tags(trim($this->input->post('new_no_hp',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			$user=$this->M_va->get_user_by_user_id($user_id);
			if($user){
				$cek_phone=$this->M_va->cek_phone($new_no_hp);
				if($cek_phone){
					$this->error_code='';
					$this->error_message='No.HP sudah ada';
				}else{
					$data['otp']=mt_rand(100000,999999);
					$data['new_hp_change']=$new_no_hp;
					$this->M_va->update_user($user_id,$data);
					
					//send sms otp
					$this->load->helper('thirdparty');
					$telepon=$new_no_hp;
					$message='OTP Gerai Access: '.$data['otp'];
					$res=MASendSms($telepon,$message);
					//--------------
					
					$this->result='OTP Send';
				}
			}else{
				$this->error_code='';
				$this->error_message='User tidak ada';
			}
			
			
		}
		
		$this->jsonOut();
	}
	
	function verify_new_hp_post(){
		$this->form_validation->set_rules('otp', 'otp', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$otp=strip_tags(trim($this->input->post('otp',true)));
			$user=$this->M_va->get_user_by_user_id($user_id);
			if($user){
				if($otp==$user['otp']){
					$new_hp_change=$user['new_hp_change'];
					if($new_hp_change==''){
						$data['no_hp']=$new_hp_change;
						$data['new_hp_change']='';
						$this->M_va->update_user($user_id,$data);
						$this->result='Ubah No.HP Berhasil';
					}else{
						$this->error_code='';
						$this->error_message='New No.HP tidak ada';
					}
				}else{
					$this->error_code='';
					$this->error_message='OTP salah';
				}
			}else{
				$this->error_code='';
				$this->error_message='User Tidak ada';
			}
			
		}
		$this->jsonOut();
		
	}
	
	function update_fcmid_post(){
		$this->form_validation->set_rules('fcm_id', 'fcm_id', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->user_id;
			$fcm_id=strip_tags(trim($this->input->post('fcm_id',true)));
			$data['fcm_id']=$fcm_id;
			$this->M_va->update_user($user_id,$data);
			$this->result=$fcm_id;
		}
		$this->jsonOut();
	}
	
	
	
	
	
	
}
