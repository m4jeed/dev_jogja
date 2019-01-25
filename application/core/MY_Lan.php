<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class MY_Lan extends REST_Controller
{
	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('jwt');
		$uri_seg3=strtolower($this->uri->segment(3));
		
		$this->error_code='';
		$this->error_message='';
		$this->result=false;
		
		//koneksi local
		if(uri_string()=='api/v1/ppob/data_transaction_service'){
			
		}else{
		//var_dump($uri_seg3);die();
			if($uri_seg3!='pub_data'){
				$access_token=get_token();
				$this->load->model('M_users');
				$verify_token=$this->M_users->verify_token($access_token);
				$token_expire=$this->M_users->update_expire_token($access_token,$this->config->item('token_expire'));
				//var_dump($verify_token);die();
				if($verify_token){
					$date = new DateTime();
					if($date->getTimestamp() > (int)$token_expire){
						$message = [
						'status'=> '0',
						'timestamp'=>date('Y-m-d H:i:s'),
						'error_code'=>'404',
						'error_message'=>'Token Expired'
						];
					$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
					die();
					}
				}else{
					$message = [
						'status'=> '0',
						'timestamp'=>date('Y-m-d H:i:s'),
						'error_code'=>'404',
						'error_message'=>'404 - Unauthorized'
						];
					$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
					die();
				}
				
				/* 
				//var_dump($access_token);die();
				$decode_token=JWT::dec_token($access_token);
				//var_dump($decode_token);die();
				if($decode_token){
					if(time() > (int)$decode_token->expire){
						$message = [
						'status'=> '0',
						'timestamp'=>date('Y-m-d H:i:s'),
						'error_code'=>'',
						'error_message'=>'Token Expired'
						];
					$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
					die();
					}
				}else{
					$message = [
						'status'=> '0',
						'timestamp'=>date('Y-m-d H:i:s'),
						'error_code'=>'',
						'error_message'=>'404 - Unauthorized'
						];
					$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
					die();
				}
				 */
			}
		}
		
		if(isset($verify_token['user_id'])){
			$this->userid=$verify_token['user_id'];
			$this->user_id=$verify_token['user_id'];
		}else{
			$this->userid='';
			$this->user_id='';
		}
		
		if(isset($verify_token['email'])){
			$this->email=$verify_token['email'];
		}else{
			$this->email='';
		}
		
		if(isset($verify_token['no_hp'])){
			$this->no_hp=$verify_token['no_hp'];
		}else{
			$this->no_hp='';
		}
		
		if(isset($verify_token['vacc_number'])){
			$this->vacc_number=$verify_token['vacc_number'];
		}else{
			$this->vacc_number='';
		}
		
		
		if(isset($verify_token['fullname'])){
			$this->fullname=$verify_token['fullname'];
		}else{
			$this->fullname='';
		}
		
		if(isset($verify_token['referal_code'])){
			$this->referal_code=$verify_token['referal_code'];
		}else{
			$this->referal_code='';
		}
		
		if(isset($verify_token['is_verified'])){
			$this->is_verified=$verify_token['is_verified'];
		}else{
			$this->is_verified='';
		}
		
		//cek apakah sudah verifikasi akun
		if(uri_string()=='api/v1/ppob/pulsa_prabayar'
			||uri_string()=='api/v1/ppob/paket_data'
			||uri_string()=='api/v1/ppob/bill_payment'
			||uri_string()=='api/v1/vacc/transfer_vacc'
			||uri_string()=='api/v1/vacc/inquiry_name'
			){
			if($this->is_verified!='1'){
				$message = [
					'status'=> '0',
					'timestamp'=>date('Y-m-d H:i:s'),
					'error_code'=>'',
					'error_message'=>'Mohon Verifikasi Akun Anda Terlebih dahulu'
					];
				$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
				die();
			}
		}
		
		
		
	}
	
	
	public function jsonOut(){
		if($this->result){ #tidak ada error
			$message = [
					'status'=> '1',
					'timestamp'=>date('Y-m-d H:i:s'),
					'result'=>$this->result
					];
				
			$response_status=200;
		}else{
			$message = [
					'status'=> '0',
					'timestamp'=>date('Y-m-d H:i:s'),
					'error_code'=>$this->error_code,
					'error_message'=>$this->error_message
					];
			$response_status=400;
		}
		//insert log
		$data_log['request_get']=json_encode($this->input->get());
		$data_log['request_post']=json_encode($this->input->post());
		$data_log['request_header']=json_encode(getallheaders());
		$data_log['response']=json_encode($message);
		$data_log['url']=uri_string();
		$data_log['ip_address']=getRealClientIP();
		$this->db->insert('log_request',$data_log);
		
		$this->set_response($message, $response_status); 
		//die();
	}
	
	
	
}
