<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/BniHashing.php';

class Bni extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->client_id = $this->config->item('ecol_client_id');
		$this->secret_key = $this->config->item('ecol_secret_key');
		$this->url = $this->config->item('ecol_url');
		
		$this->load->model('M_bni_ecol');
		$this->load->model('M_va');
		
    }
	
	function topup_request_post(){
		$this->form_validation->set_rules('trx_amount', 'trx_amount', 'trim|required|numeric|greater_than[0]|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_amount=strip_tags(trim($this->input->post('trx_amount',true)));
			$admin_fee=$this->config->item('biaya_admin_topup');
			$trx_total=(float)$trx_amount+(float)$admin_fee;
			
			$user=$this->M_va->get_user_by_vacc_number($this->vacc_number);
			if($user){
				$saldo_after_topup=(float)$user['balance']+(float)$trx_amount;
				$max_saldo_vacc=(float)$this->config->item('max_saldo_vacc');
				if($saldo_after_topup > $max_saldo_vacc){
					$this->error_code='';
					$this->error_message='Request Gagal, Max Saldo Rp.'.formatNomor($this->config->item('max_saldo_vacc'));
				}else{
					$this->result=array('trx_amount'=>formatNomor($trx_amount)
									,'admin_fee'=>formatNomor($admin_fee)
									,'trx_total'=>formatNomor($trx_total)
									);
				}
			}else{
				$this->error_code='';
				$this->error_message='vacc_number Not Found';
			}
		
		}
		$this->jsonOut();
	}
	
	function topup_post(){
		$this->form_validation->set_rules('trx_amount', 'trx_amount', 'trim|required|numeric|greater_than[0]|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->userid;
			$vacc_number=$this->vacc_number;
			$trx_amount=strip_tags(trim($this->input->post('trx_amount',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			
			$admin_fee=$this->config->item('biaya_admin_topup');
			$trx_total=(float)$trx_amount+(float)$admin_fee;
			
			$user=$this->M_va->get_user_by_vacc_number($this->vacc_number);
			if($user){
				if($user['pin']==myhash($pin,$user['salt'])){
					//request ke BNI
					$description='Topup Geraiaccess ID:'.$this->vacc_number;
					$payment_request=$this->M_bni_ecol->payment_request($trx_total,
																		$this->fullname,
																		$this->email,
																		$this->no_hp,
																		$description,
																		$admin_fee,
																		$trx_amount);
					//var_dump($payment_request);die();
					if($payment_request['status']=='ok'){
						$data_response=$payment_request['data'];
						$this->result=array('trx_id'=>$data_response['trx_id']
												,'virtual_account'=>$data_response['virtual_account']
												,'trx_amount'=>formatNomor($trx_amount)
												,'admin_fee'=>formatNomor($admin_fee)
												,'trx_total'=>formatNomor($trx_total)
												);
					}else{
						$this->error_code='';
						$this->error_message=$payment_request['data'];
					}
				}else{
					$this->error_code='';
					$this->error_message='PIN salah';
				}
			}else{
				$this->error_code='';
				$this->error_message='vacc_number Not Found';
			}
		}
		$this->jsonOut();
		
		
			
	}
	
	function topup_history_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$user_id=$this->userid;
			$offset=strip_tags(trim($this->input->post('offset',true)));
			
			$history=$this->M_bni_ecol->get_topup_history($user_id,20,$offset);
			$count_history=$this->M_bni_ecol->count_topup_history($user_id);
			//var_dump($history);die();
			if($count_history){
				$number=1;
				foreach($history as $row){
					$res[] = [
						'itemno'=>$offset+$number,
						'trx_id'=>$row['trx_id'],
						'date'=>$row['createon'],
						'virtual_account'=>pretty_va($row['virtual_account'],'  '),
						'trx_amount'=>'Topup : Rp.'.formatNomor($row['amount']),
						'admin_fee'=>'Biaya Admin : Rp.'.formatNomor($row['admin_fee']),
						'trx_total'=>'Total yang harus di transfer : Rp.'.formatNomor($row['trx_amount']),
						'status'=>strtoupper($row['status']),
						'type'=>'data',
					];
					$number++;
				}
				$this->result=array('rows'=>$res,'total_rows'=>$count_history);
			}else{
				$this->error_code='';
				$this->error_message='Data Tidak ada';
			}
		}
		
		$this->jsonOut();
	}
	
}