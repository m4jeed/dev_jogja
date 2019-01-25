<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vacc extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_va');
		
		
	}
	
	function cek_mutasi_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('start_date', 'start_date', 'trim|max_length[50]');
		$this->form_validation->set_rules('end_date', 'end_date', 'trim|max_length[50]');
		$this->form_validation->set_rules('trx_type', 'trx_type', 'trim|max_length[50]');
		//$this->form_validation->set_rules('trx_status', 'trx_status', 'trim|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$offset=strip_tags(trim($this->input->post('offset',true)));
			$start_date=strip_tags(trim($this->input->post('start_date',true)));
			$end_date=strip_tags(trim($this->input->post('end_date',true)));
			$vacc_number=$this->vacc_number;
			$trx_type=strip_tags(trim($this->input->post('trx_type',true)));
			//$trx_status=strip_tags(trim($this->input->post('trx_status',true)));
			
			if($vacc_number==''){
				$this->error_code='';
				$this->error_message='vacc_number not exits';
			}else{
				if($offset==''){
					$offset=0;
				}
				$result=$this->M_va->get_trx_history($vacc_number,$start_date,$end_date,$offset,$trx_type);
				$count=$this->M_va->count_trx_history($vacc_number,$start_date,$end_date,$offset,$trx_type);
				if($result){
					$number=1;
					foreach($result as $row){
						$res[] = [
							'itemno'=>(int)$offset+$number,
							'trx_id'=>$row['trx_id'],
							'vacc_number'=>$row['vacc_number'],
							'dk'=>$row['dk'],
							'trx_date'=>$row['trx_date'],
							'trx_desc'=>$row['trx_desc'],
							'amount'=>formatNomor($row['amount']),
							'saldo'=>formatNomor($row['balance']),
							'trx_status'=>'',
							'trx_type'=>$row['trx_type'],
							'type'=>'data',
						];
						$number++;
					}
					$this->result=array('rows'=>$res
										,"row_per_page"=> 10
										,"total_page"=> 1
										,"total_rows"=> ceil(10/(int)$count)
										);
				}else{
					$this->error_code='';
					$this->error_message='Data tidak ada';
				}
			}
		}
		$this->jsonOut();
	}
	
	function inquiry_name_post(){
		$this->form_validation->set_rules('email_no_hp_vacc_number', 'email_no_hp_vacc_number', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
			
		}else{
			$email_no_hp_vacc_number=strip_tags(trim($this->input->post('email_no_hp_vacc_number',true)));
			$user=$this->M_va->get_user_by_email_phone_vacc_number($email_no_hp_vacc_number);
			if($user){
				if($user['is_verified']=='1'){
					$result['fullname']=$user['fullname'];
					$result['email']=$user['email'];
					$result['no_hp']=$user['phone'];
					$result['vacc_number']=$user['vacc_number'];
					$this->result=$result;
					
				}else{
					$this->error_code='';
					$this->error_message='User belum melakukan verifikasi';
				
				}
				
			}else{
				$this->error_code='';
				$this->error_message='User Tidak Terdaftar, Silahkan Cek Kembali';
				
			}
		}
		$this->jsonOut();
		
		
		
	}
	
	function inquiry_vacc_post(){
		$this->form_validation->set_rules('vacc_number', 'vacc_number', 'trim|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			//$vacc_number=strip_tags(trim($this->input->post('vacc_number',true)));
			$vacc_number=$this->vacc_number;
			$result=$this->M_va->inquiry_vacc($vacc_number);
			
			if($result){
				$this->result=array('fullname'=>$this->fullname
									,'vacc_number'=>$result['vacc_number']
									,'saldo'=>formatNomor($result['balance'])
									,'poin'=>$result['poin']
									,'saldo_numeric'=>$result['balance']
									);
			}else{
				$this->error_code='';
				$this->error_message='Data tidak ada';
			}
		}
		$this->jsonOut();
	}
	
	function transfer_vacc_post(){
		$this->form_validation->set_rules('to_vacc_number', 'to_vacc_number', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('trx_desc', 'trx_desc', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
			
		}else{
			$from_vacc_number=$this->vacc_number;
			$to_vacc_number=strip_tags(trim($this->input->post('to_vacc_number',true)));
			$amount=strip_tags(trim($this->input->post('amount',true)));
			$trx_desc='Transfer dari '.$this->fullname.'('.$this->vacc_number.'), '.strip_tags(trim($this->input->post('trx_desc',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			if($to_vacc_number==$this->vacc_number){
				$this->error_code='';
				$this->error_message='Tidak diperbolehkan melakukan permintaan Transfer dengan nomor virtual account sendiri';
			}else{
				$trx_type='transfer';
				$transfer=$this->M_va->transfer($trx_type,$trx_desc,$amount,$from_vacc_number,$to_vacc_number,$pin);
				
				//var_dump($transfer);die();
				if($transfer['is_error']=='1'){
					$this->error_code='';
					$this->error_message=$transfer['response_msg'];
				}else{
					
					$user_to=$this->M_va->get_user_by_vacc_number($to_vacc_number);
					//send sms notif
					$this->load->helper('thirdparty');
					$fcm_id[] = $user_to['fcm_id'];
					$message = 'Transfer Dari '.$this->fullname.' ('.$from_vacc_number.') Sebesar '.formatNomor($amount);
					send_notif($fcm_id,$message);
					
					$this->result='Transfer berhasil di lakukan';
				}
			}
			
		}
		$this->jsonOut();
		
	}
	
	function req_tarik_tunai_post(){
		$this->form_validation->set_rules('agent_email_no_hp_vacc', 'agent_email_no_hp_vacc', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$agent_email_no_hp_vacc=strip_tags(trim($this->input->post('agent_email_no_hp_vacc',true)));
			$amount=strip_tags(trim($this->input->post('amount',true)));
			
			$user=$this->M_va->get_user_by_email_phone_vacc_number($agent_email_no_hp_vacc);
			if($user['vacc_number']==$this->vacc_number){
				$this->error_code='';
				$this->error_message='Tidak diperbolehkan melakukan permintaan Tarik Tunai ke Akun sendiri';
			}else{
				if($user){
					$config=$this->M_va->get_config();
					if($config){
						$agent_fee=((float)$amount*(float)$config['agent_fee_tariktunai']/100);
						$admin_fee=((float)$amount*(float)$config['ma_fee_tariktunai']/100);
						$this->result=array('agent_name'=>$user['fullname']
											,'amount'=>formatNomor($amount)
											,'biaya_admin'=>formatNomor((float)$agent_fee+(float)$admin_fee)
											,'total_didebet_customer'=>formatNomor((float)$amount+(float)$agent_fee+(float)$admin_fee)
											,'total_diterima_customer'=>formatNomor((float)$amount)
											);
					}else{
						$this->error_code='';
						$this->error_message='Config tidak ada';
					} 
					
				}else{
					$this->error_code='';
					$this->error_message='User tidak ada';
				}
			}
			
			
		}
		$this->jsonOut();
		
	}
	
	function req_tarik_tunai_submit_post(){
		$this->form_validation->set_rules('agent_email_no_hp_vacc', 'agent_email_no_hp_vacc', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_type='tariktunai';
			$cust_vacc_number=$this->vacc_number;
			$agent_email_no_hp_vacc=strip_tags(trim($this->input->post('agent_email_no_hp_vacc',true)));
			$amount=strip_tags(trim($this->input->post('amount',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$user=$this->M_va->get_user_by_email_phone_vacc_number($agent_email_no_hp_vacc);
			
			//var_dump($user);die();
			if($user){
				if($cust_vacc_number==$user['vacc_number']){
					$this->error_code='';
					$this->error_message='Tidak diperbolehkan melakukan permintaan Tarik Tunai ke Akun sendiri';
				}else{
					$config=$this->M_va->get_config();
					$agent_fee=((float)$amount*(float)$config['agent_fee_tariktunai']/100);
					$ma_fee=((float)$amount*(float)$config['ma_fee_tariktunai']/100);
					$total=(float)$amount+(float)$agent_fee+(float)$ma_fee;
					$trx_desc='Tarik Tunai Oleh '.$this->fullname.' ('.$cust_vacc_number.')';
				
					$agent_vacc_number=$user['vacc_number'];
					$cek_pin=$this->M_va->cek_pin($this->user_id,$pin);
					if($cek_pin){
						$result=$this->M_va->request_tariksetor($trx_type,$trx_desc,$amount,$agent_vacc_number,$cust_vacc_number,$ma_fee,$agent_fee);
						if($result['is_error']=='0'){
							$this->load->helper('thirdparty');
							$fcm_id[] = $user['fcm_id'];
							$message = $trx_desc;
							//send_notif($fcm_id,$message);
							
							$this->result='Berhasil tarik tunai';
						}else{
							$this->error_code='';
							$this->error_message=$result['response_msg'];
						}
					}else{
						$this->error_code='';
						$this->error_message='PIN salah';
					}
					
				}
			}else{
				$this->error_code='';
				$this->error_message='User tidak ada';
			}
			
		}
		$this->jsonOut();
		
	}
	
	function req_setor_tunai_post(){
		$this->form_validation->set_rules('agent_email_no_hp_vacc', 'agent_email_no_hp_vacc', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$agent_email_no_hp_vacc=strip_tags(trim($this->input->post('agent_email_no_hp_vacc',true)));
			$amount=strip_tags(trim($this->input->post('amount',true)));
			
			$user=$this->M_va->get_user_by_email_phone_vacc_number($agent_email_no_hp_vacc);
			if($user['vacc_number']==$this->vacc_number){
				$this->error_code='';
				$this->error_message='Tidak diperbolehkan melakukan permintaan Setor Tunai ke Akun sendiri';
			}else{
				if($user){
					$config=$this->M_va->get_config();
					if($config){
						$agent_fee=((float)$amount*(float)$config['agent_fee_setortunai']/100);
						$admin_fee=((float)$amount*(float)$config['ma_fee_setortunai']/100);
						$this->result=array('agent_name'=>$user['fullname']
											,'amount'=>formatNomor($amount)
											,'biaya_admin'=>formatNomor((float)$agent_fee+(float)$admin_fee)
											,'total_cash_disetor_customer'=>formatNomor((float)$amount+(float)$agent_fee+(float)$admin_fee)
											,'total_diterima_customer'=>formatNomor((float)$amount)
											);
					}else{
						$this->error_code='';
						$this->error_message='Config tidak ada';
					} 
					
				}else{
					$this->error_code='';
					$this->error_message='User tidak ada';
				}
			}
			
		}
		$this->jsonOut();
		
	}
	
	function req_setor_tunai_submit_post(){
		$this->form_validation->set_rules('agent_email_no_hp_vacc', 'agent_email_no_hp_vacc', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_type='setortunai';
			$cust_vacc_number=$this->vacc_number;
			$agent_email_no_hp_vacc=strip_tags(trim($this->input->post('agent_email_no_hp_vacc',true)));
			$amount=strip_tags(trim($this->input->post('amount',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$user=$this->M_va->get_user_by_email_phone_vacc_number($agent_email_no_hp_vacc);
			//var_dump($user);die();
			if($user){
				if($cust_vacc_number==$user['vacc_number']){
					$this->error_code='';
					$this->error_message='Tidak diperbolehkan melakukan permintaan Setor Tunai ke Akun sendiri';
				}else{
					$config=$this->M_va->get_config();
					$agent_fee=((float)$amount*(float)$config['agent_fee_tariktunai']/100);
					$ma_fee=((float)$amount*(float)$config['ma_fee_tariktunai']/100);
					$total=(float)$amount+(float)$agent_fee+(float)$ma_fee;
					$trx_desc='Setor Tunai Oleh '.$this->fullname.' ('.$cust_vacc_number.')';
				
					$agent_vacc_number=$user['vacc_number'];
					$cek_pin=$this->M_va->cek_pin($this->user_id,$pin);
					//var_dump($cek_pin);die();
			
					if($cek_pin){
						$result=$this->M_va->request_tariksetor($trx_type,$trx_desc,$amount,$agent_vacc_number,$cust_vacc_number,$ma_fee,$agent_fee);
						//var_dump($result);die();
						if($result['is_error']=='0'){
							$this->load->helper('thirdparty');
							$fcm_id[] = $user['fcm_id'];
							$message = $trx_desc;
							//send_notif($fcm_id,$message);
							
							$this->result='Request setor tunai berhasil';
						}else{
							$this->error_code='';
							$this->error_message=$result['response_msg'];
						}
					}else{
						$this->error_code='';
						$this->error_message='PIN salah';
					}
					
				}
			}else{
				$this->error_code='';
				$this->error_message='User tidak ada';
			}
			
			
		}
		$this->jsonOut();
		
	}
	
	function proses_tarik_setor_tunai_post(){
		$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_id=strip_tags(trim($this->input->post('trx_id',true)));
			$agent_vacc_number=$this->vacc_number;
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$cek_pin=$this->M_va->cek_pin($this->user_id,$pin);
			if($cek_pin){
				$proses=$this->M_va->proses_tariksetor($trx_id);
				if($proses['is_error']=='1'){
					$this->error_code='';
					$this->error_message=$proses['response_msg'];
				}else{
					$this->result=$proses['response_msg'];
				}
				
			}else{
				$this->error_code='';
				$this->error_message='PIN salah';
			}
			
			
		}
		$this->jsonOut();
		
	}
	
	function cancel_tarik_setor_tunai_post(){
		$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_id=strip_tags(trim($this->input->post('trx_id',true)));
			$agent_vacc_number=$this->vacc_number;
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$cek_pin=$this->M_va->cek_pin($this->user_id,$pin);
			if($cek_pin){
				$cancel=$this->M_va->cancel_tariksetor($trx_id);
				if($cancel>0){
					$this->result='Berhasil';
				}else{
					$this->error_code='';
					$this->error_message='Transaksi Gagal';
				}
			}else{
				$this->error_code='';
				$this->error_message='PIN salah';
			}
		}
		$this->jsonOut();
		
	}
	
	function tarik_tunai_list_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('start_date', 'start_date', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('end_date', 'end_date', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$offset=strip_tags(trim($this->input->post('offset',true)));
			$start_date=strip_tags(trim($this->input->post('start_date',true)));
			$end_date=strip_tags(trim($this->input->post('end_date',true)));
			$vacc_number=$this->vacc_number;
			$trx_type='tariktunai';
			$result=$this->M_va->get_tarik_setor_tunai($start_date,$end_date,$offset,$trx_type);
			//var_dump($result);die();
			if($result){
				$number=1;
				foreach($result as $row){
					$res[] = [
						'itemno'=>(int)$offset+$number,
						'trx_id'=>$row['trx_id'],
						'trx_date'=>date('Y-m-d H:i:s',strtotime($row['trx_date'])),
						'trx_desc'=>$row['trx_desc'].' Sebesar Rp.'.formatNomor($row['amount']),
						'agent_fee'=>formatNomor($row['agent_fee']),
						'total'=>formatNomor($row['amount']),
						'trx_status'=>strtoupper($row['trx_status']),
						'type'=>'data',
					];
					$number++;
				}
				$this->result=$res;
			}else{
				$this->error_code='';
				$this->error_message='data tidak ada';
			}
			
		}
		$this->jsonOut();
	}
	
	function setor_tunai_list_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[50]');
		$this->form_validation->set_rules('start_date', 'start_date', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('end_date', 'end_date', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$offset=strip_tags(trim($this->input->post('offset',true)));
			$start_date=strip_tags(trim($this->input->post('start_date',true)));
			$end_date=strip_tags(trim($this->input->post('end_date',true)));
			$vacc_number=$this->vacc_number;
			$trx_type='setortunai';
			$result=$this->M_va->get_tarik_setor_tunai($start_date,$end_date,$offset,$trx_type);
			
			if($result){
				$number=1;
				foreach($result as $row){
					$res[] = [
						'itemno'=>(int)$offset+$number,
						'trx_id'=>$row['trx_id'],
						'trx_date'=>$row['trx_date'],
						'trx_desc'=>$row['trx_desc'].' Sebesar Rp.'.formatNomor($row['amount']),
						'agent_fee'=>formatNomor($row['agent_fee']),
						'total'=>formatNomor($row['amount']),
						'trx_status'=>strtoupper($row['trx_status']),
						'type'=>'data',
					];
					$number++;
				}
				$this->result=$res;
			}else{
				$this->error_code='';
				$this->error_message='data tidak ada';
			}
			
			
		}
		$this->jsonOut();
	}
	
	
	
	
	
	function trx_his_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$offset=strip_tags(trim($this->input->post('offset',true)));
			$vacc_number=$this->vacc_number;
			
			$sql="SELECT *,'data' as type FROM ma_trx WHERE vacc_number=? and trx_type in('topup','cashout','transfer','ppob','refund') ORDER BY trx_id DESC LIMIT 10 OFFSET ? ";
			$trx=$this->db->query($sql,array($vacc_number,(int)$offset))->result_array();
			$this->result=$trx;
		}
		$this->jsonOut();
	}
	
	function trx_detil_post(){
		$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('trx_type', 'trx_type', 'trim|required|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_id=strip_tags(trim($this->input->post('trx_id',true)));
			$trx_type=strip_tags(trim($this->input->post('trx_type',true)));
			$vacc_number=$this->vacc_number;
			
			
			if($trx_type=='ppob'){
				$sql="SELECT ppob_trx.* FROM ma_trx_external_id 
					INNER JOIN ppob_trx 
					ON ppob_trx.trx_id=ma_trx_external_id.external_id
					WHERE ma_trx_external_id.trx_id='".$trx_id."'";
				$trx=$this->db->query($sql)->row_array();
					
				if($trx){
					$result["trx_id"]=$trx['trx_id'];
					$result["user_id"]=$trx['user_id'];
					$result["provider"]=$trx['provider'];
					$result["product_name"]=$trx['product_name'];
					$result["trx_date"]=$trx['trx_date'];
					$result["admin_fee"]=$trx['admin_fee'];
					$result["commision"]=$trx['commision'];
					$result["trx_status"]=$trx['trx_status'];
					$result["trx_desc"]=$trx['trx_desc'];
					$result["trx_amount"]=$trx['trx_amount'];
					$result["reffnum"]=$trx['reffnum'];
					$result["biller_price"]=$trx['biller_price'];
					$result["price_after_discount"]=$trx['price_after_discount'];
					$result["voucher_code"]=$trx['voucher_code'];
					$result["sale_price"]=$trx['sale_price'];
					$result["base_price"]=$trx['base_price'];
					$result["product_code"]=$trx['product_code'];
					$result["admin_bank"]=$trx['admin_bank'];
					$result["cashback"]=$trx['cashback'];
					$result["nominal"]=$trx['nominal'];
					$result["voucher_nominal"]=$trx['voucher_nominal'];
					$result["trx_id2"]=$trx['trx_id2'];
					$result["customer_number"]=$trx['customer_number'];
					$json_result=json_decode($trx['remark1']);
					//var_dump($json_result->RequestMethod);die();
					if(isset($json_result->RequestMethod)){
						if($json_result->RequestMethod=="PaymentService"){
							$sql="SELECT product_type FROM idbiller_price_tagihan WHERE product_code='".$result["product_code"]."'";
							$product=$this->db->query($sql)->row_array();
							if($product['product_type']=='pln_pascabayar'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->SubscribeId;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->SubscriberName;
								$result['detil3_txt']='Tarif/Daya';
								$result['detil3_val']=$json_result->SubscriberSegmentation.'/'.(int)$json_result->PowerConsumingCategory;
								$result['detil4_txt']='Periode 1';
								$result['detil4_val']=$json_result->Blth1;
								$result['detil5_txt']='Periode 2';
								$result['detil5_val']=$json_result->Blth2;
								$result['detil6_txt']='Periode 3';
								$result['detil6_val']=$json_result->Blth3;
								$result['detil7_txt']='Periode 4';
								$result['detil7_val']=$json_result->Blth4;
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
								
							}elseif($product['product_type']=='pln_prabayar'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->CustomerId;
								$result['detil2_txt']='No Meter';
								$result['detil2_val']=$json_result->CustomerMeter;
								$result['detil3_txt']='Nama Pelanggan';
								$result['detil3_val']=$json_result->SubscriberName;
								$result['detil4_txt']='Tarif/Daya';
								$result['detil4_val']=$json_result->SubscriberSegmentation.'/'.(int)$json_result->PowerConsumingCategory;
								$result['detil5_txt']='Token PLN';
								$result['detil5_val']=$json_result->TokenPln;
								$result['detil6_txt']='';
								$result['detil6_val']='';
								$result['detil7_txt']='';
								$result['detil7_val']='';
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
							}elseif($product['product_type']=='multi_finance'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->CustomerId;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->CustomerName;
								$result['detil3_txt']='Leasing';
								$result['detil3_val']=$json_result->PtName;
								$result['detil4_txt']='Merk/Type';
								$result['detil4_val']=$json_result->ItemMerkType;
								$result['detil5_txt']='ChasisNumber';
								$result['detil5_val']=$json_result->ChasisNumber;
								$result['detil6_txt']='CarNumber';
								$result['detil6_val']=$json_result->CarNumber;
								$result['detil7_txt']='Tenor';
								$result['detil7_val']=$json_result->Tenor;
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
							}elseif($product['product_type']=='bpjs_kesehatan'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->CustomerId;;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->CustomerName;
								$result['detil3_txt']='';
								$result['detil3_val']='';
								$result['detil4_txt']='';
								$result['detil4_val']='';
								$result['detil5_txt']='';
								$result['detil5_val']='';
								$result['detil6_txt']='';
								$result['detil6_val']='';
								$result['detil7_txt']='';
								$result['detil7_val']='';
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
							}elseif($product['product_type']=='pulsa_pascabayar'){
								$result['detil1_txt']='Nomor Pelanggan';
								$result['detil1_val']=$json_result->CustomerId;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->CustomerName;
								$result['detil3_txt']='Provider';
								$result['detil3_val']=$json_result->ProviderName;
								$result['detil4_txt']='Periode 1';
								$result['detil4_val']=$json_result->MonthPeriod1.'-'.$json_result->YearPeriod1;
								$result['detil5_txt']='Periode 2';
								$result['detil5_val']=$json_result->MonthPeriod2.'-'.$json_result->YearPeriod2;
								$result['detil6_txt']='Periode 3';
								$result['detil6_val']=$json_result->MonthPeriod3.'-'.$json_result->YearPeriod3;
								$result['detil7_txt']='';
								$result['detil7_val']='';
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
							}elseif($product['product_type']=='telkom'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->AreaCode.$json_result->PhoneNumber;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->CustomerName;
								$result['detil3_txt']='';
								$result['detil3_val']='';
								$result['detil4_txt']='';
								$result['detil4_val']='';
								$result['detil5_txt']='';
								$result['detil5_val']='';
								$result['detil6_txt']='';
								$result['detil6_val']='';
								$result['detil7_txt']='';
								$result['detil7_val']='';
								$result['detil8_txt']='';
								$result['detil8_val']='';
								$result['detil9_txt']='';
								$result['detil9_val']='';
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
								
							}elseif($product['product_type']=='pdam'){
								$result['detil1_txt']='ID Pelanggan';
								$result['detil1_val']=$json_result->CustomerNumber1;;
								$result['detil2_txt']='Nama Pelanggan';
								$result['detil2_val']=$json_result->CustomerName;
								$result['detil3_txt']='PDAM';
								$result['detil3_val']=$json_result->PdamName;
								$result['detil4_txt']='Periode 1';
								$result['detil4_val']=$json_result->MonthPeriod1.'-'.$json_result->YearPeriod1;
								$result['detil5_txt']='Periode 2';
								$result['detil5_val']=$json_result->MonthPeriod2.'-'.$json_result->YearPeriod2;
								$result['detil6_txt']='Periode 3';
								$result['detil6_val']=$json_result->MonthPeriod3.'-'.$json_result->YearPeriod3;
								$result['detil7_txt']='Periode 4';
								$result['detil7_val']=$json_result->MonthPeriod4.'-'.$json_result->YearPeriod4;
								$result['detil8_txt']='Periode 5';
								$result['detil8_val']=$json_result->MonthPeriod5.'-'.$json_result->YearPeriod5;
								$result['detil9_txt']='Periode 6';
								$result['detil9_val']=$json_result->MonthPeriod6.'-'.$json_result->YearPeriod6;
								$result['detil10_txt']='';
								$result['detil10_val']='';
								
							}
							
						}else{
							
						}
						//$result["remark1"]=$json_result;
						$this->result=$result;
					}else{
						$this->error_code='';
						$this->error_message='Data tidak ada';
					}
				}else{
					$this->error_code='';
					$this->error_message='Data tidak ada';
				}
			
			}elseif($trx_type=='transfer'){
				$q1=$this->db->query("SELECT * FROM ma_trx WHERE trx_id='".$trx_id."'")->row_array();
				
				if($q1){
					$result['trx_id']=$q1['trx_id'];
					$result['trx_type']=$q1['trx_type'];
					$result['trx_date']=$q1['trx_date'];
					$result['trx_desc']=$q1['trx_desc'];
					$result['amount']=$q1['amount'];
					$result['dk']=$q1['dk'];
					$result['balance']=$q1['balance'];
					$result['vacc_number']=$q1['vacc_number'];
					$result['vacc_from']=$q1['vacc_from'];
					$result['vacc_to']=$q1['vacc_to'];
					$result['trx_id2']=$q1['trx_id2'];
					
					$vacc_from=$this->db->query("SELECT ma_users.fullname,ma_vacc.vacc_number 
											FROM ma_users INNER JOIN ma_vacc ON ma_users.user_id=ma_vacc.user_id
											WHERE ma_vacc.vacc_number ='".$result['vacc_from']."'")->row_array();
					if($vacc_from){
						$result['vacc_from_fullname']=$vacc_from['fullname'];
					}else{
						$result['vacc_from_fullname']='';
					}
					
					$vacc_to=$this->db->query("SELECT ma_users.fullname,ma_vacc.vacc_number 
											FROM ma_users INNER JOIN ma_vacc ON ma_users.user_id=ma_vacc.user_id
											WHERE ma_vacc.vacc_number ='".$result['vacc_to']."'")->row_array();
					if($vacc_to){
						$result['vacc_to_fullname']=$vacc_to['fullname'];
					}else{
						$result['vacc_to_fullname']='';
					}
					$this->result=$result;
					
				}else{
					$this->error_code='';
					$this->error_message='Trx Id Salah';
				}
			
			}elseif($trx_type=='topup'){
				$q1=$this->db->query("SELECT * FROM ma_trx WHERE trx_id='".$trx_id."'")->row_array();
				
				if($q1){
					$result['trx_id']=$q1['trx_id'];
					$result['trx_type']=$q1['trx_type'];
					$result['trx_date']=$q1['trx_date'];
					$result['trx_desc']=$q1['trx_desc'];
					$result['amount']=$q1['amount'];
					$result['dk']=$q1['dk'];
					$result['balance']=$q1['balance'];
					$result['vacc_number']=$q1['vacc_number'];
					$result['vacc_from']=$q1['vacc_from'];
					$result['vacc_to']=$q1['vacc_to'];
					$result['trx_id2']=$q1['trx_id2'];
					
					$this->result=$result;
					
				}else{
					$this->error_code='';
					$this->error_message='Trx Id Salah';
				}
			
			
			}else{
				$this->error_code='';
				$this->error_message='Trx Type Salah';
			}
			
		}
		$this->jsonOut();
	}
	
	
	
	
	
	
}

