<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bni_corppayble extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_bni_corppayble');
	}
	
	function getbalance_post(){
		$this->form_validation->set_rules('account_no', 'account_no', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$account_no=strip_tags($this->input->post('account_no'));
			$result=$this->M_bni_corppayble->getbalance($account_no);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	function getinhouseinquiry_post(){
		$this->form_validation->set_rules('account_no', 'account_no', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$account_no=strip_tags($this->input->post('account_no'));
			$result=$this->M_bni_corppayble->getinhouseinquiry($account_no);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	
	function inhousedopayment_post(){
		$this->form_validation->set_rules('credit_account_no', 'credit_account_no', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('value_amount', 'value_amount', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('remark', 'remark', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('beneficiary_email_address', 'beneficiary_email_address', 'trim|max_length[100]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$creditAccountNo=strip_tags($this->input->post('credit_account_no',true));
			$valueAmount=strip_tags($this->input->post('value_amount',true));
			$remark=strip_tags($this->input->post('remark',true));
			$beneficiaryEmailAddress=strip_tags($this->input->post('beneficiary_email_address',true));
			
			$result=$this->M_bni_corppayble->dopayment($creditAccountNo,$valueAmount,$remark,$beneficiaryEmailAddress);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	
	function getinterbankinquiry_post(){
		$this->form_validation->set_rules('destination_bank_code', 'destination_bank_code', 'trim|required|max_length[5]');
		$this->form_validation->set_rules('destination_account_num', 'destination_account_num', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$destinationBankCode=strip_tags($this->input->post('destination_bank_code',true));
			$destinationAccountNum=strip_tags($this->input->post('destination_account_num',true));
			$result=$this->M_bni_corppayble->getinterbankinquiry($destinationBankCode,$destinationAccountNum);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	function interbankpayment_post(){
		$this->form_validation->set_rules('destination_account_num', 'destination_account_num', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('destination_account_name', 'destination_account_name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('destination_bank_code', 'destination_bank_code', 'trim|required|max_length[5]');
		$this->form_validation->set_rules('destination_bank_name', 'destination_bank_name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('retrieval_reff_num', 'retrieval_reff_num', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$amount=strip_tags($this->input->post('amount',true));
			$destinationAccountNum=strip_tags($this->input->post('destination_account_num',true));
			$destinationAccountName=strip_tags($this->input->post('destination_account_name',true));
			$destinationBankCode=strip_tags($this->input->post('destination_bank_code',true));
			$destinationBankName=strip_tags($this->input->post('destination_bank_name',true));
			$retrievalReffNum=strip_tags($this->input->post('retrieval_reff_num',true));
			
			$result=$this->M_bni_corppayble->getinterbankpayment($amount,$destinationAccountNum,$destinationAccountName,
																$destinationBankCode,$destinationBankName,$retrievalReffNum);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	
	function getpaymentstatus_post(){
		$this->form_validation->set_rules('customer_reference_number', 'customer_reference_number', 'trim|required|numeric|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$customerReferenceNumber=strip_tags($this->input->post('customer_reference_number',true));
			
			$result=$this->M_bni_corppayble->getpaymentstatus($customerReferenceNumber);
			if($result['is_error']=='0'){
				if($result['result']['responseCode']=='0001'){
					$this->result=$result['result'];
				}else{
					$this->error_code='';
					$this->error_message=$result['result']['errorMessage'];
				}
			}else{
				$this->error_code='';
				$this->error_message=$result['response_msg'];
			}
		}
		$this->jsonOut();
	}
	
	
	
}
