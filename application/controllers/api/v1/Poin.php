<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Poin extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('M_poin');
		$this->load->model('M_va');
		
	}
	
	function cek_poin_post(){
		$this->form_validation->set_rules('offset', 'offset', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('start_date', 'start_date', 'trim|max_length[50]');
		$this->form_validation->set_rules('end_date', 'end_date', 'trim|max_length[50]');
		$this->form_validation->set_rules('vacc_number', 'vacc_number', 'trim|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$offset=strip_tags(trim($this->input->post('offset',true)));
			$start_date=strip_tags(trim($this->input->post('start_date',true)));
			$end_date=strip_tags(trim($this->input->post('end_date',true)));
			$vacc_number=$this->vacc_number;
			$trx_type='poin';
			$trx_status='';
			$result=$this->M_va->get_trx_history($vacc_number,$start_date,$end_date,$offset,$trx_type);
			//var_dump($vacc_number);
			//var_dump($result);
			//die();
			if($result['is_error']=='0'){
				$this->result=$result['result'];
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
			
		}
		$this->jsonOut();
	}
	
	function claim_poin_post(){
		$this->form_validation->set_rules('reward_poin_id', 'reward_poin_id', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|numeric|max_length[6]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$reward_poin_id=strip_tags(trim($this->input->post('reward_poin_id',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			$user_id=$this->user_id;
			
			$poin=$this->M_poin->get_one_poin($reward_poin_id);
			if($poin){
				
				//debit poin pada moneyaccess
				$trx_type='poin';
				$trx_desc=$poin['poin_reward_desc'];
				$amount=$poin['poin_reward_value'];
				$vacc_from=$this->vacc_number;
				$vacc_to=$this->config->item('gerai_vacc_number');
				//$pin='';
				$referral='';
				$claim_poin=$this->M_va->transfer($trx_type,$trx_desc,$amount,$vacc_from,$vacc_to,$pin='',$referral='');
				if($claim_poin['is_error']=='0'){
					
					//insert ma_trx_external_id
					$data_external_id['trx_id']=$claim_poin['result']['trx_id'];
					$data_external_id['external_id']=$reward_poin_id;
					$data_external_id['external_table']='poin_reward';
					$this->db->insert('ma_trx_external_id',$data_external_id);
					//------------------------------------------
					
					//var_dump($claim_poin);die();
					//create voucher di database voucher
					$data['voucher_code']=randomString(6).$this->user_id;
					$data['voucher_desc']=$poin['poin_reward_desc'];
					$data['voucher_value']=$poin['voucher_value'];
					$data['product']=$poin['product'];
					$data['start_date']=$poin['start_date'];
					$data['end_date']=$poin['end_date'];
					$data['is_percent']=$poin['is_percent'];
					$data['user_id']=$this->user_id;
					$data['is_active']='1';
					$data['create_on']=date('Y-m-d H:i:s');
					$data['create_by']='user_gerai';
					$claim_reward_poin=$this->M_poin->claim_reward_poin($data,$reward_poin_id);
					
					if($claim_reward_poin){
						$this->result='Klaim Reward Poin, Berhasil';
					}else{
						$this->error_code='';
						$this->error_message='Error Klaim Poin';
					}
				}else{
					$this->error_code='';
					$this->error_message=$claim_poin['response_msg'];
				}
				
			}else{
				$this->error_code='';
				$this->error_message='Poin tidak ada';
			}
			
			
			
		}
		$this->jsonOut();
	}
	
	function history_claim_reward_poin_get(){
		$user_id=$this->user_id;
		$res=$this->M_poin->get_poin_reward_claim_by_user_id($user_id);
		//var_dump($res);die();
		if($res){
			foreach($res as $row){
			$result[]=array("ids"=>$row['ids'],
						"reward_poin_id"=>$row['reward_poin_id'],
						"user_id"=>$row['user_id'],
						"id_voucher"=>$row['id_voucher'],
						"create_on"=>$row['create_on'],
						"poin_reward_image"=>site_url('assets/poin_reward_image/').$row['poin_reward_image'],
						"poin_reward_desc"=>$row['poin_reward_desc'],
						"poin_reward_value"=>formatNomor($row['poin_reward_value']),
						"voucher_code"=>strtoupper($row['voucher_code']),
						"start_date"=>date('d-M-Y',strtotime($row['start_date'])),
						"end_date"=>date('d-M-Y',strtotime($row['end_date'])),
						);
			}
			$this->result=$result;
		}else{
			$this->error_code='';
			$this->error_message='data tidak ada';
		}
		$this->jsonOut();
	}
	
	
	
	
	
}
