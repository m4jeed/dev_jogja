<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_voucher');
		$this->load->model('M_ppob');
		
		
	}
	
	function cek_post(){
		$this->form_validation->set_rules('voucher_code', 'voucher_code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric|max_length[10]');
		$this->form_validation->set_rules('product', 'product', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$voucher_code=trim(strip_tags($this->input->post('voucher_code',true)));
			$amount=trim(strip_tags($this->input->post('amount',true)));
			$product=trim(strip_tags($this->input->post('product',true)));
			
			$voucher=$this->M_voucher->get_one($voucher_code);
			if($voucher){
				$cek_product=$this->M_ppob->get_product($product);
				if($cek_product){
					if($cek_product['product_type']==$voucher['product']){
						if($voucher['end_date']>date('Y-m-d')){
							if($voucher['is_percent']=='1'){
								$discount_value=$voucher['voucher_value'].'%';
								$discount_amount=ceil(((float)$amount*(float)$voucher['voucher_value'])/100);
							}else{
								$discount_value=formatNomor($voucher['voucher_value']);
								$discount_amount=(float)$voucher['voucher_value'];
							}
							$amount_after_discount=(float)$amount-$discount_amount;
							$this->result=array('amount'=>formatNomor($amount)
												,'discount_value'=>$discount_value
												,'discount_amount'=>formatNomor($discount_amount)
												,'amount_after_discount'=>formatNomor($amount_after_discount)
												);
						}else{
							$this->error_code='';
							$this->error_message='Voucher Expire ';
						}
					}else{
						$this->error_code='';
						$this->error_message='Voucher ini bukan untuk '.$product ;
					}
				}else{
					$this->error_code='';
					$this->error_message='Product Tidak ada ';
				
				}
				
			}else{
				$this->error_code='';
				$this->error_message='Voucher Tidak Ada';
			}
		}
		$this->jsonOut();
	}
	
	
	
	
}
