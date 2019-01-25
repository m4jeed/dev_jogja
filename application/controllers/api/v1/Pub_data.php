<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Pub_data extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('M_gerai');
		$this->load->model('M_ppob');
		
		$this->load->model('M_va');
		
	}
	
	function province_get(){
		$this->result=$this->M_gerai->get_province();
		$this->jsonOut();
	}
	
	function city_post(){
		$this->form_validation->set_rules('province', 'province', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$this->result=$this->M_gerai->get_city();
		}
		$this->jsonOut();
	
	}
	
	function districts_post(){
		$this->form_validation->set_rules('province', 'province', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', 'city', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$this->result=$this->M_gerai->get_districts();
		}
		$this->jsonOut();
	
	}

	function village_post(){
		$this->form_validation->set_rules('province', 'province', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', 'city', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('districts', 'districts', 'trim|required|max_length[50]');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$this->result=$this->M_gerai->get_village();
		}
		$this->jsonOut();
	
	}
	
	function postalcode_post(){
		$this->form_validation->set_rules('province', 'province', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', 'city', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('districts', 'districts', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('village', 'village', 'trim|required|max_length[50]');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$this->result=$this->M_gerai->get_postalcode();
		}
		$this->jsonOut();
	
	}
	
	function jobs_get(){
		$this->result=$this->M_gerai->get_jobs();
		$this->jsonOut();
	}
	
	function register_post_old(){
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('pass', 'pass', 'trim|required|min_length[8]|max_length[20]');
		$this->form_validation->set_rules('retype_pass', 'retype_pass', 'trim|required|matches[pass]|max_length[20]');
		$this->form_validation->set_rules('referral_code', 'referral_code', 'trim|max_length[50]');
		$this->form_validation->set_rules('fcm_id', 'fcm_id', 'trim|max_length[500]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
			$data['email']=strip_tags(trim($this->input->post('email',true)));
			$data['phone']=strip_tags(trim($this->input->post('no_hp',true)));
			$data['salt']=bin2hex(random_bytes(10));
			$data['pass']=myhash(strip_tags(trim($this->input->post('pass',true))),$data['salt']);
			$data['is_confirmed_hp']='1';
			$data['is_confirmed_email']='0';
			$data['is_active']='1';
			$data['is_verified']='0';
			$data['referal_code']=strip_tags(trim($this->input->post('referal_code',true)));
			$data['fcm_id']=strip_tags(trim($this->input->post('fcm_id',true)));
			$data['verifikasi_msg']='Segera Verifikasi Akun Anda Untuk Mendapat Akses Sepenuhnya';
			$data['status_verifikasi']='belum';
			$data['email_key']=md5(uniqid().time().$data['phone'].uniqid());
			//$data['otp']=mt_rand(123456,999999);
			$data['my_referal_code']=$this->M_va->gen_referral_code($data['fullname']);
			//die();
			//cek no_hp
			$cek_phone=$this->M_va->cek_phone($data['phone']);
			if($cek_phone){
				$this->error_code='';
				$this->error_message='No Hp sudah terdaftar di Gerai@ccess, Silahkan login dengan no Hp anda';
			}else{
				//cek email
				$cek_email=$this->M_va->cek_email($data['email']);
				if($cek_email){
					$this->error_code='';
					$this->error_message='Akun email sudah terdaftar di Gerai@ccess';
				}else{
					$register=$this->M_va->register_user($data);
					if($register){
						//send email ----------------------
						$this->load->library('lib_phpmailer');
						$to=$data['email'];
						$subject='Selamat Datang di GeraiAccess';
						$this->load->model('M_template_email');
						$message=$this->M_template_email->verify_hp($data['email_key']);
						$send_email=$this->lib_phpmailer->send_email($to,$subject,$message,true);
						//------------------------------------
						$this->result=$register;
						
						if($send_email){
							$this->result=$register;
						}else{
							$this->result=$register;
							//send sms otp
							$this->load->helper('thirdparty');
							$telepon=$data['phone'];
							$message='SEND MAIL ERROR '.$to;
							$res=MASendSms($telepon,$message);
							//--------------
							 
						}
						
						/* 
						//send sms otp
						$this->load->helper('thirdparty');
						$telepon=$data['phone'];
						$message='OTP Gerai Access: '.$data['otp'];
						$res=MASendSms($telepon,$message);
						//--------------
						 */
						//$this->result=$register;
					}else{
						$this->error_code='';
						$this->error_message='Registrasi Error, Silahkan Registrasi Ulang';
					}
				}
			}
			
		}
		$this->jsonOut();
	}
	
	function resend_otp_post(){
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$no_hp=strip_tags(trim($this->input->post('no_hp',true)));
			//$user=$this->M_va->get_user_by_phone($no_hp);
			$user=true;
			if($user){
				//update otp di database
				$data['otp']=mt_rand(123456,999999);
				//$update_user=$this->M_va->update_user($user['user_id'],$data);
				
				//send sms otp
				$this->load->helper('thirdparty');
				$telepon=$no_hp;
				$message='OTP Gerai Access: '.$data['otp'];
				$res=MASendSms($telepon,$message);
				//--------------
				$this->result='Kode Otentifikasi Berhasil diKirim.';
			}else{
				$this->error_code='';
				$this->error_message='No.HP tidak ada.';
			}
		}
		$this->jsonOut();
		
	}
	
	function login_post_old(){
		$this->form_validation->set_rules('uname', 'uname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('pass', 'pass', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('gps_tag', 'gps_tag', 'trim');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$uname=strtolower(strip_tags(trim($this->input->post('uname',true))));
			$pass=strip_tags(trim($this->input->post('pass',true)));
			$gps_tag=strip_tags(trim($this->input->post('gps_tag',true)));

			$uname_cek = filter_var($uname, FILTER_SANITIZE_EMAIL);
			if(filter_var($uname_cek, FILTER_VALIDATE_EMAIL)){
				$user=$this->M_va->get_user_by_email($uname);
				$ket='login_by_email';
			}else{
				$user=$this->M_va->get_user_by_phone($uname);
				$ket='login_by_no_hp';
			}
			if($user){
			//var_dump($user);die();
				if($user['is_active']=='0'){
					$this->error_code='';
					$this->error_message='User Tidak Aktif. Silahkan Hubungi Support Gerai@ccess';
				}else{
					if($ket=='login_by_no_hp'){
						if($user['is_confirmed_hp']=='1'){
							$status='OK';
						}else{
							$status='No.HP Belum di Konfirmasi';
						}
					}elseif($ket=='login_by_email'){
						if($user['is_confirmed_email']=='1'){
							$status='OK';
						}else{
							$status='Email Belum di Konfirmasi';
						}
					}else{
						$status='Users Tidak ada';
					}
					
					if($status=='OK'){
						$this->load->helper('myhash_helper');
						//myhash($pass,$user['salt']);die();
						if (myhash($pass,$user['salt'])==$user['pass']){
							$vacc_number=$user['vacc_number'];
							$data_gps['user_id']=$user['user_id'];
							$data_gps['gps_tag']=$gps_tag;
							$this->db->insert('users_gps_tag',$data_gps);
							
							//generate token
							$this->load->model('M_access_token');
							$access_token=$this->M_access_token->create_token($user['user_id'],$this->config->item('token_expire'));
							$refresh_token=$access_token;
							
							$gerai_name=$user['gerai_name'];
							if($gerai_name==''){
								$gerai_name=$user['fullname'];
							}
							
							$this->result=array('user_id'=>$user['user_id']
												,'vacc_number'=>$user['vacc_number']
												,'fullname'=>$user['fullname']
												,'email'=>$user['email']
												,'no_hp'=>$user['phone']
												,'fcm_id'=>$user['fcm_id']
												,'is_verified'=>$user['is_verified']
												,'is_confirmed_hp'=>$user['is_confirmed_hp']
												,'is_confirmed_email'=>$user['is_confirmed_email']
												,'is_verified'=>$user['is_verified']
												,'referal_code'=>$user['referal_code']
												,'my_referal_code'=>$user['my_referal_code']
												,'status_verifikasi'=>$user['status_verifikasi']
												,'verifikasi_msg'=>$user['verifikasi_msg']
												,'access_token'=>$access_token
												,'refresh_token'=>$refresh_token
												);
						}else{
							$this->error_code='';
							$this->error_message='Password yang Anda Masukan Salah. ';
						} 
					
					}else{
						$this->error_code='';
						$this->error_message=$status;
					}
					
						
				}
			}else{
				$this->error_code='';
				if($ket=='login_by_no_hp'){
					$this->error_message='Nomor Handphone Tidak Terdaftar';
				}else{
					$this->error_message='Email Tidak Terdaftar';
				}
				
			}
			$this->jsonOut();
		
		}
	}
	
	function verify_hp_post(){
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('otp', 'otp', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$no_hp=strip_tags(trim($this->input->post('no_hp',true)));
			$otp=strip_tags(trim($this->input->post('otp',true)));
			$timestamp=date('ymdhis');
			$cek_phone_otp=$this->M_va->cek_phone_otp($no_hp,$otp);
			if($cek_phone_otp){
				if($cek_phone_otp['is_confirmed_hp']=='0'){
					$this->M_va->verify_phone($no_hp,$otp);
					$this->result='Success';
				}else{
					$this->error_code='';
					$this->error_message='No.HP sudah di konfimasi';
				}
			}else{
				$this->error_code='';
				$this->error_message='Salah No.HP/OTP';
			}
		}
		$this->jsonOut();
		
	}
	
	
	function provider_post(){
		$this->form_validation->set_rules('product_type', 'product_type', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$product_type=strip_tags(trim($this->input->post('product_type',true)));
			$this->result=$this->M_ppob->get_all_provider($product_type);
		}
		
		$this->jsonOut();
	}
	
	function product_type_get(){
		$this->result=$this->M_ppob->get_all_product_type();
		$this->jsonOut();
	}
	
	function product_name_post(){
		$this->form_validation->set_rules('product_type', 'product_type', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('provider', 'provider', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$product_type=strip_tags(trim($this->input->post('product_type',true)));
			$provider=strip_tags(trim($this->input->post('provider',true)));
			$get_product_name=$this->M_ppob->get_product_name($provider,$product_type);
			if($get_product_name){
				$this->result=$get_product_name;
			}else{
				$this->error_code='';
				$this->error_message='Product tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
	function nominal_token_get(){
		
		$this->result=array('20.000','50.000','100.000','200.000','500.000','1.000.000','5.000.000','10.000.000','50.000.000');
		$this->jsonOut();
	}
	
	function banner_get(){
		$res=$this->M_gerai->get_banner();
		if($res){
			foreach($res as $row){
				$result[]=site_url('assets/banner/').$row['filename'];
			}
			$this->result=$result;
		}else{
			$this->error_code='';
			$this->error_message='Data tidak ada';
		}
		$this->jsonOut();
	}
	
	function promo_get(){
		$res=$this->M_gerai->get_promo();
		if($res){
			foreach($res as $row){
				$result[]=array('filename'=>site_url('assets/promo/').$row['filename']
								,'description'=>$row['promo_desc']
								);
			}
			$this->result=$result;
		}else{
			$this->error_code='';
			$this->error_message='Data tidak ada';
		}
		$this->jsonOut();
	}
	
	function apk_ver_get(){
		$res=$this->M_gerai->get_ver();
		//var_dump($res);die();
		if($res){
			$this->result=array('ver_apk'=>$res['ver_apk'],
								'ver_display'=>$res['ver_display']);
		}else{
			$this->error_code='';
			$this->error_message='Data tidak ada';
		}
		$this->jsonOut();
	}
	
	function reset_pass_post(){
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[100]');
		//$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$email=strtolower(strip_tags(trim($this->input->post('email',true))));
			//$no_hp=strip_tags(trim($this->input->post('no_hp',true)));
			$user=$this->M_va->get_user_by_email($email);
			if($user){
				$new_pass=mt_rand(10000000,99999999);
				$this->load->helper('myhash');
				$data['pass']=myhash($new_pass,$user['salt']);
				$this->M_va->update_user($user['user_id'],$data);
				//var_dump($new_pass);die();
				//send email ----------------------
				$this->load->library('lib_phpmailer');
				$to=$email;
				$subject='Reset Password Gerai@ccess';
				$this->load->model('M_template_email');
				$message=$this->M_template_email->reset_pass($new_pass);
				$this->lib_phpmailer->send_email_nospam($to,$subject,$message);
				//------------------------------------
				
				$this->result='Password Berhasil di Reset, Mohon Cek Email Anda ';
			}else{
				$this->error_code='';
				$this->error_message='Email/No.HP Tidak Terdaftar';
			}
		}
		
		$this->jsonOut();
	
	}
	
	function poin_reward_list_get(){
		$this->load->model('M_poin');
		$res=$this->M_poin->get_poin_reward();
		if($res){
			foreach($res as $row){
				$result[]=array('poin_reward_id'=>$row['ids']
								,'poin_reward_image'=>site_url('assets/poin_reward_image/').$row['poin_reward_image']
								,'poin_reward_desc'=>$row['poin_reward_desc']
								);
			}
			$this->result=$result;
		}else{
			$this->error_code='';
			$this->error_message='Data tidak ada';
		}
		$this->jsonOut();
	}
	
	function pekerjaan_get(){
		$res=$this->M_gerai->get_job();
		foreach($res as $row){
			$result[]=$row['job_name'];
		}
		$this->result=$result;
		$this->jsonOut();
	}
	
	function customer_service_get(){
		$result=array('cs_email'=>$this->config->item('cs_email')
					,'cs_phone'=>$this->config->item('cs_phone')
					,'cs_whatsapp'=>$this->config->item('cs_whatsapp')
						);
		$this->result=$result;
		$this->jsonOut();
	}
	
	function front_message_get(){
		$res=$this->db->query("SELECT * FROM gerai_front_message")->row_array();
		$result['filename']=base_url().'assets/front_message/'.$res['filename'];
		$result['description']=$res['description'];
		$this->result=$result;
		$this->jsonOut();
	}
	
	
	function register_post(){
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('pass', 'pass', 'trim|required|min_length[8]|max_length[20]');
		$this->form_validation->set_rules('retype_pass', 'retype_pass', 'trim|required|matches[pass]|max_length[20]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|min_length[6]|max_length[7]|numeric');
		$this->form_validation->set_rules('retype_pin', 'retype_pin', 'trim|required|matches[pin]|min_length[6]|max_length[7]|numeric');
		$this->form_validation->set_rules('referral_code', 'referral_code', 'trim|max_length[10]');
		$this->form_validation->set_rules('fcm_id', 'fcm_id', 'trim|max_length[500]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
			$data['email']=strip_tags(trim($this->input->post('email',true)));
			$data['phone']=strip_tags(trim($this->input->post('no_hp',true)));
			$data['salt']=bin2hex(random_bytes(10));
			$data['pass']=myhash(strip_tags(trim($this->input->post('pass',true))),$data['salt']);
			$data['pin']=myhash(strip_tags(trim($this->input->post('pin',true))),$data['salt']);
			$data['is_confirmed_hp']='1';
			$data['is_confirmed_email']='0';
			$data['is_active']='1';
			$data['is_verified']='0';
			$data['referal_code']=strip_tags(trim($this->input->post('referral_code',true)));
			$data['fcm_id']=strip_tags(trim($this->input->post('fcm_id',true)));
			$data['verifikasi_msg']='Segera Verifikasi Akun Anda Untuk Mendapat Akses Sepenuhnya';
			$data['status_verifikasi']='belum';
			$data['email_key']=md5(uniqid().time().$data['phone'].uniqid());
			//$data['otp']=mt_rand(123456,999999);
			$data['my_referal_code']=$this->M_va->gen_referral_code($data['fullname']);
			//die();
			//cek no_hp
			$cek_phone=$this->M_va->cek_phone($data['phone']);
			if($cek_phone){
				$this->error_code='';
				$this->error_message='No Hp sudah terdaftar di Gerai@ccess, Silahkan login dengan no Hp anda';
			}else{
				//cek email
				$cek_email=$this->M_va->cek_email($data['email']);
				if($cek_email){
					$this->error_code='';
					$this->error_message='Akun email sudah terdaftar di Gerai@ccess';
				}else{
					$register=$this->M_va->register_user($data);
					if($register){
						//send email ----------------------
						$this->load->library('lib_phpmailer');
						$to=$data['email'];
						$subject='Selamat Datang di GeraiAccess';
						$this->load->model('M_template_email');
						$message=$this->M_template_email->verify_hp($data['email_key']);
						$send_email=$this->lib_phpmailer->send_email($to,$subject,$message,true);
						//------------------------------------
						$this->result=$register;
						
						if($send_email){
							$this->result=$register;
						}else{
							$this->result=$register;
							//send sms otp
							$this->load->helper('thirdparty');
							$telepon='085779801499';
							$message='SEND MAIL ERROR '.$to;
							$res=MASendSms($telepon,$message);
							//--------------
							 
						}
						
						/* 
						//send sms otp
						$this->load->helper('thirdparty');
						$telepon=$data['phone'];
						$message='OTP Gerai Access: '.$data['otp'];
						$res=MASendSms($telepon,$message);
						//--------------
						 */
						//$this->result=$register;
					}else{
						$this->error_code='';
						$this->error_message='Registrasi Error, Silahkan Registrasi Ulang';
					}
				}
			}
			
		}
		$this->jsonOut();
	}
	
	
	function login_post(){
		$this->form_validation->set_rules('uname', 'uname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('pass', 'pass', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('gps_tag', 'gps_tag', 'trim');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$uname=strtolower(strip_tags(trim($this->input->post('uname',true))));
			$pass=strip_tags(trim($this->input->post('pass',true)));
			$gps_tag=strip_tags(trim($this->input->post('gps_tag',true)));

			$user=$this->M_va->get_user_by_phone($uname);
			
			if($user){
				if($user['is_active']=='0'){
					$this->error_code='';
					$this->error_message='User Tidak Aktif. Silahkan Hubungi Support Gerai@ccess';
				}else{
					if (myhash($pass,$user['salt'])==$user['pass']){
							
						if($user['is_confirmed_hp']=='0'){
							$this->error_code='';
							$this->error_message='No.HP Belum di Konfirmasi';
						}else{
							//var_dump($user['is_confirmed_email']);die();
							if($user['is_confirmed_email']=='0'){
								$this->error_code='';
								$this->error_message='Email Belum di Konfirmasi';
							}else{
								$vacc_number=$user['vacc_number'];
								$data_gps['user_id']=$user['user_id'];
								$data_gps['gps_tag']=$gps_tag;
								$this->db->insert('users_gps_tag',$data_gps);
								
								//generate token
								$this->load->model('M_access_token');
								$access_token=$this->M_access_token->create_token($user['user_id'],$this->config->item('token_expire'));
								$refresh_token=$access_token;
								
								$this->result=array('user_id'=>$user['user_id']
													,'vacc_number'=>$user['vacc_number']
													,'fullname'=>$user['fullname']
													,'email'=>$user['email']
													,'no_hp'=>$user['phone']
													,'fcm_id'=>$user['fcm_id']
													,'is_verified'=>$user['is_verified']
													,'is_confirmed_hp'=>$user['is_confirmed_hp']
													,'is_confirmed_email'=>$user['is_confirmed_email']
													,'is_verified'=>$user['is_verified']
													,'referal_code'=>$user['referal_code']
													,'my_referal_code'=>$user['my_referal_code']
													,'status_verifikasi'=>$user['status_verifikasi']
													,'verifikasi_msg'=>$user['verifikasi_msg']
													,'access_token'=>$access_token
													,'refresh_token'=>$refresh_token
													);
							
							}
						}
						
					}else{
						$this->error_code='';
						$this->error_message=strip_err_msg('Password Salah');
					}
				}
				
			}else{
				$this->error_code='';
				$this->error_message=strip_err_msg('No Handphone tidak ditemukan');
			}
			
			$this->jsonOut();
			
		}
	}
	
	
	function resend_email_confirmation_post(){
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$no_hp=strtolower(strip_tags(trim($this->input->post('no_hp',true))));
			$email=strtolower(strip_tags(trim($this->input->post('email',true))));
			$user=$this->db->query("select user_id,email,email_key,is_confirmed_email from ma_users where phone='".$no_hp."' and is_active='1'")->row_array();
			if($user){
				
				if($user['is_confirmed_email']){
					$this->error_code='';
					$this->error_message='Email Sudah di Konfirmasi';
				}else{
						
					$this->db->where('user_id',$user['user_id']);
					$this->db->update('ma_users',array('email'=>$email));
					
					//send email ----------------------
					$this->load->library('lib_phpmailer');
					$to=$user['email'];
					$subject='Selamat Datang di GeraiAccess';
					$this->load->model('M_template_email');
					$message=$this->M_template_email->verify_hp($user['email_key']);
					$send_email=$this->lib_phpmailer->send_email($to,$subject,$message,true);
					//------------------------------------
					if($send_email){
						$this->result="Resend Email Berhasil, Mohon Cek Email Anda";
					}else{
						$this->error_code='';
						$this->error_message='Resend Email Gagal';
					}
					
				}
				
				
			}else{
				$this->error_code='53';
				$this->error_message='User tidak ditemukan';
			}
			
		}
		
		$this->jsonOut();
	}
	
	

	
	
}
