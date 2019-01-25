<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Pub_data extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->library('phpass');
		$this->load->model('M_gerai');
		$this->load->model('M_users');
		$this->load->model('M_ppob');
		$this->load->model('M_misc');
		$this->load->model('M_vacc');
		
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
	
	function register_post(){
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('pass', 'pass', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('retype_pass', 'retype_pass', 'trim|required|matches[pass]|max_length[20]');
		$this->form_validation->set_rules('referral_code', 'referral_code', 'trim|numeric|max_length[10]');
		$this->form_validation->set_rules('fcm_id', 'fcm_id', 'trim|max_length[500]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
			$data['no_hp']=strip_tags(trim($this->input->post('no_hp',true)));
			$data['email']=strtolower(strip_tags(trim($this->input->post('email',true))));
			$data['referal_code']=strip_tags(trim($this->input->post('referral_code',true)));
			$data['fcm_id']=strip_tags(trim($this->input->post('fcm_id',true)));
			$data['pass']=$this->phpass->hash(strip_tags(trim($this->input->post('pass',true))));
			$data['otp']=mt_rand(100000,999999);
			$data['is_confirmed_hp']='0';
			$data['is_confirmed_email']='0';
			$data['is_verified']='0';
			$data['is_active']='1';
			$data['create_on']=date('Y-m-d H:i:s');
			$data['email_key']=uniqid().time().uniqid().$data['no_hp'].uniqid();
			$data['status_verifikasi']='belum';
			$data['verifikasi_msg']='Segera Verifikasi Akun Anda Untuk Mendapat Akses Sepenuhnya';
			//var_dump($data);die();
			$cek_no_hp=$this->M_users->cek_no_hp($data['no_hp']);
			if($cek_no_hp){
				$this->error_code='';
				$this->error_message='No Hp sudah terdaftar di Gerai@ccess, Silahkan login dengan no Hp anda';
			}else{
				$cek_email=$this->M_users->cek_email($data['email']);
				if($cek_email>0){ //jikas email sudah ada
					$this->error_code='';
					$this->error_message='Akun email sudah terdaftar di Gerai@ccess';
				}else{
					//send email ----------------------
					$this->load->library('lib_phpmailer');
					$to=$data['email'];
					$subject='Selamat Datang di GeraiAccess';
					$this->load->model('M_template_email');
					$message=$this->M_template_email->verify_hp($data['email_key']);
					
					$this->lib_phpmailer->send_email($to,$subject,$message,false);
					
					//------------------------------------
					
					//if no error
					$this->result=$this->M_users->register($data);
					
					//send sms otp
					$this->load->helper('thirdparty');
					$telepon=$data['no_hp'];
					$message='OTP Gerai Access: '.$data['otp'];
					$res=MASendSms($telepon,$message);
					//--------------
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
			$user=$this->M_users->get_user_by_no_hp($no_hp);
			if($user){
				//update otp di database
				$data['otp']=mt_rand(100000,999999);
				$update_user=$this->M_users->update_user($user['user_id'],$data);
				
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

			$uname_cek = filter_var($uname, FILTER_SANITIZE_EMAIL);
			if(filter_var($uname_cek, FILTER_VALIDATE_EMAIL)){
				$user=$this->M_users->login_by_email($uname);
				$ket='login_by_email';
			}else{
				$user=$this->M_users->login_by_no_hp($uname);
				$ket='login_by_no_hp';
			}
			//$user=$this->M_users->login($uname);
			if($user){
			//var_dump($user);die();
				if($user['is_active']=='0'){
					$this->error_code='';
					$this->error_message='User Tidak Aktif. Silahkan Hubungi Silahkan Hubungi Support Gerai@ccess';
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
						if ($this->phpass->check($pass, $user['pass'])){
							$vacc_number=$user['vacc_number'];
							$data_gps['user_id']=$user['user_id'];
							$data_gps['gps_tag']=$gps_tag;
							$this->M_users->insert_gps_tag($data_gps);
							
							//generate token
							//$this->load->helper('jwt');
							//$access_token=JWT::gen_token($user['user_id'],$user['email'],$user['no_hp'],$user['vacc_number'],$user['fullname'],$user['referal_code'],$user['is_verified']);
							//$refresh_token=JWT::gen_refresh_token($user['user_id'],$user['email'],$user['no_hp'],$user['vacc_number'],$user['fullname'],$user['referal_code'],$user['is_verified']);
							
							//generate token
							//$access_token=$this->M_users->update_token($user['user_id'],$this->config->item('token_expire'));
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
												,'no_hp'=>$user['no_hp']
												//,'gender'=>''
												//,'dob'=>''
												//,'pob'=>''
												//,'address'=>''
												//,'province'=>$user['village']
												//,'city'=>$user['city']
												//,'districts'=>$user['districts']
												//,'village'=>$user['village']
												//,'postalcode'=>$user['village']
												//,'job'=>''
												//,'id_card_number'=>''
												//,'gerai_name'=>$gerai_name
												,'id_card_number'=>$user['id_card_number']
												,'id_card_number_photo'=>$user['id_card_number_photo']
												,'id_card_number_selfi'=>$user['id_card_number_selfi']
												,'is_verified'=>$user['is_verified']
												,'referal_code'=>$user['referal_code']
												,'my_referal_code'=>$user['my_referal_code']
												//,'avatar'=>$user['avatar']
												,'fcm_id'=>$user['fcm_id']
												,'is_verified'=>$user['is_verified']
												,'is_confirmed_hp'=>$user['is_confirmed_hp']
												,'is_confirmed_email'=>$user['is_confirmed_email']
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
				$this->error_message='Nomor Telpon/Email Tidak Terdaftar';
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
			/* 
			$q_cek=$this->db->query('select timestamp from log_request_cek where request_post=? and url=? '
							,array(json_encode($this->input->post()),uri_string()))->row_array();
			if($q_cek){
				$cek_timestamp=(float)$timestamp-(float)$q_cek['timestamp'];
				if($cek_timestamp<20){
					$message = [
					'status'=> '0',
					'timestamp'=>date('Y-m-d H:i:s'),
					'error_code'=>'',
					'error_message'=>'404 - Unauthorized'
					];
				$data_log_2['request_get']=json_encode($this->input->get());
				//$data_log_2['request_post']=json_encode($post_input);
				$data_log['request_post']=json_encode($this->input->post());
				$data_log_2['request_header']=json_encode(getallheaders());
				$data_log_2['response']=json_encode($message);
				$data_log_2['url']=uri_string();
				$data_log_2['ip_address']=getRealClientIP();
				$this->db->insert('log_request',$data_log_2);
				
				$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
				die();
				}
			}
			 
			//---------------------------------------------
			$data_log_1['request_post']=json_encode($this->input->post());
			$data_log_1['url']=uri_string();
			$data_log_1['timestamp']=$timestamp;
			$this->db->insert('log_request_cek',$data_log_1);
			//--------------------------------
			*/
			//die();
			$verify_hp=$this->M_users->verify_hp($no_hp,$otp);
			//var_dump($verify_hp);die();
			if($verify_hp){//ok
				if($verify_hp['is_confirmed_hp']=='0'){
					/* 
					//send email ----------------------
					$this->load->library('lib_phpmailer');
					$to=$verify_hp['data']['email'];
					$subject='Selamat Datang di GeraiAccess';
					$this->load->model('M_template_email');
					$message=$this->M_template_email->verify_hp($verify_hp['data']['email_key']);
					
					$this->lib_phpmailer->send_email($to,$subject,$message);
					//------------------------------------
					 */
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
		$res=$this->M_misc->get_banner();
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
		$res=$this->M_misc->get_promo();
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
		$res=$this->M_misc->get_ver();
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
		$this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$email=strtolower(strip_tags(trim($this->input->post('email',true))));
			$no_hp=strip_tags(trim($this->input->post('no_hp',true)));
			$user=$this->M_users->cek_email_no_hp($email,$no_hp);
			//var_dump($user);die();
			if($user){
				$new_pass=mt_rand(100000,999999);
				$data['pass']=$this->phpass->hash($new_pass);
				$this->M_users->update_user($user['user_id'],$data);
				
				//send email ----------------------
				$this->load->library('lib_phpmailer');
				$to=$email;
				$subject='Reset Password GeraiAccess';
				$this->load->model('M_template_email');
				$message=$this->M_template_email->reset_pass($new_pass);
				/* 
				$message='
						<html>
						<head></head>
						<body>
							Your New Password:'.$new_pass.'
						</body>
						</html>
						';
				 */
				$this->lib_phpmailer->send_email($to,$subject,$message,false);
				//------------------------------------
				
				$this->result='Password Berhasil di Reset, Mohon Cek Email Anda';
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
		$res=$this->M_misc->get_job();
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
		$res=$this->db->query("SELECT * FROM front_message")->row_array();
		$result['filename']=base_url().'assets/front_message/'.$res['filename'];
		$result['description']=$res['description'];
		$this->result=$result;
		$this->jsonOut();
	}
	

	
	
}
