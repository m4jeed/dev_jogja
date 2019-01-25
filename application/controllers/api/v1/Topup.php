<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topup extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
	}
	
	function manual_post(){
		$this->form_validation->set_rules('bank', 'bank', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('topup', 'topup', 'trim|required|max_length[10]|numeric');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$bank=strip_tags(trim($this->input->post('bank',true)));
			$topup=strip_tags(trim($this->input->post('topup',true)));
			$user_id=$this->user_id;
			
			$random_number=mt_rand(10,200);
			$amount=(int)$random_number+(int)$topup;
			$trx_id=generateCode();
			
			$cek_bank=$this->db->query("SELECT * FROM ma_bank where bank_name='".$bank."'")->row_array();
			if($cek_bank){
				// cek amount apakah sudah pernah di request
				$sql="SELECT count(*) as jumlah FROM ma_topup_history 
					WHERE bank='".$cek_bank['bank_name']."' 
					AND norek='".$cek_bank['norek']."'
					AND amount='".$amount."'
					AND expired_on < '".date('Y-m-d H:i:s')."'";
				$cek=$this->db->query($sql)->row()->jumlah;
				if($cek=='0'){
					$data['user_id']=$user_id;
					$data['uniqid']=$random_number;
					$data['bank']=$cek_bank['bank_name'];
					$data['norek']=$cek_bank['norek'];
					$data['rek_name']=$cek_bank['rek_name'];
					$data['amount']=$amount;
					$data['admin_fee']=0;
					$data['trx_id']=$trx_id;
					$data['trx_status']='pending';
					$data['topup_type']='manual';
					$data['expired_on']=date('Y-m-d H:s:i', strtotime("+2 day"));;
					$data['created_on']=date('Y-m-d H:i:s');
					$data['created_by']=$user_id;
					$cek=$this->db->insert('ma_topup_history',$data);
					if($cek){
						$this->result=array("trx_id"=> ''.$data['trx_id'],
										"bank"=> $data['bank'],
										"norek"=> $data['norek'],
										"rek_name"=> $data['rek_name'],
										"amount"=> ''.$data['amount'],
										"expired_on"=> date('d-M-Y H:i', strtotime($data['expired_on'])).' WIB',
										);
					}else{
						$this->error_code='';
						$this->error_message='General Error (1)';
					}
					
					
				}else{
					$this->error_code='';
					$this->error_message='General Error';
				}
				
				
			}else{
				$this->error_code='';
				$this->error_message='Bank tidak terdaftar';
			}
			
		
		}
		$this->jsonOut();
	}
	
	function history_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->userid;
			$offset=strip_tags(trim($this->input->post('offset',true)));
			
			$history=$this->db->query("SELECT *,'data' as type FROM ma_topup_history ORDER BY topup_id DESC LIMIT 10 OFFSET ?",array((int)$offset))
									->result_array();
			//var_dump($history);die();
			if($history){
				
				$this->result=$history;
			}else{
				$this->error_code='';
				$this->error_message='Data Tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
	function konfirmasi_post(){
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('nama_rek', 'nama_rek', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('norek', 'norek', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('nominal', 'nominal', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
				
			$user_id=$this->user_id;
			
			$allowed =  array('png' ,'jpg','jpeg');
			$cek_file='';
			if(isset($_FILES['konfirmasi_image'])){
				$filename = $_FILES['konfirmasi_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array(strtolower($ext),$allowed) ) {
					$cek_file.='Konfirmasi Image harus jpg/png/jpeg';
				}
				
			}else{
				$cek_file.='Konfirmasi Image harus ada';
			}
			
			
			if($cek_file!=''){
					$this->error_code='';
					$this->error_message=$cek_file;
			}else{
				//upload image
				$this->load->library('Lib_upload');
				$upload_path_konfirmasi_image='./assets/konfirmasi_image/';
				$konfirmasi_image=$this->lib_upload->upload_file($upload_path_konfirmasi_image,'konfirmasi_image','gif|jpg|png|jpeg',NULL);
				
				$data['user_id']=$user_id;
				$data['bank']=strip_tags($this->input->post('bank',true));
				$data['nama_rek']=strip_tags($this->input->post('nama_rek',true));
				$data['norek']=strip_tags($this->input->post('norek',true));
				$data['nominal']=strip_tags($this->input->post('nominal',true));
				$data['upload_image']=$konfirmasi_image;
				$data['created_on']=date('Y-m-d H:i:s');
				$this->db->insert('ma_topup_konfirmasi',$data);
				$update_user=$this->db->affected_rows();
				if($update_user>0){
					$this->result='Konfirmasi berhasil';
				}else{
					$this->error_code='';
					$this->error_message='Konfirmasi gagal';
				}
			
			}
		}
		
		$this->jsonOut();
	}
	
	
	
}

