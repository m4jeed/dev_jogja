<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ppob extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if((int)date("Hi") > (int)"2330" || (int)date("Hi") < (int)"0130"){
			$message = [
				'status'=> '0',
				'timestamp'=>date('Y-m-d H:i:s'),
				'error_code'=>'404',
				'error_message'=>'Mohon Maaf, System Maentenance (23:30 WIB s/d 01:30 WIB)'
			];
			$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
			exit();
		}
		
		
		$this->load->model('M_id_biller');
		$this->load->model('M_va');
	}
	
	function price_service_post(){
		$this->form_validation->set_rules('model', 'model', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('provider', 'provider', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$model=strip_tags(trim($this->input->post('model',true)));
			$provider=strtoupper(strip_tags(trim($this->input->post('provider',true))));
			
			$res=$this->db->query("SELECT 
									provider,
									product_code,
									product_name,
									product_saleprice
									FROM idbiller_price_service 
									WHERE model='".$model."' 
									AND provider='".$provider."'
									AND product_status='open'
									ORDER BY product_price ASC
									")->result_array();
			if($res){
				$this->result=$res;
			}else{
				$this->error_code='';
				$this->error_message='Data Tidak ada';
			}
			
		
		}
		
		$this->jsonOut();
	}
	
	
	function topup_service_post(){
		$this->form_validation->set_rules('model', 'model', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('product_code', 'product_code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('customer_number', 'customer_number', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('voucher_code', 'voucher_code', 'trim|max_length[50]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|max_length[6]|numeric');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$model=strtoupper(strip_tags(trim($this->input->post('model',true))));
			$product_code=strtoupper(strip_tags(trim($this->input->post('product_code',true))));
			$customer_number=strip_tags(trim($this->input->post('customer_number',true)));
			$voucher_code=strip_tags(trim($this->input->post('voucher_code',true)));
			$pin=strip_tags(trim($this->input->post('pin',true)));
			$user_id=$this->user_id;
			
			
				
				$product=$this->db->query("SELECT * FROM idbiller_price_service WHERE product_code='".$product_code."'")->row_array();
				if($product){
					$trx_desc='BUY '.$product['product_name']. ' | '.$customer_number.'';
					$ma_trx=$this->db->query("SELECT trx_date,product_name FROM ppob_trx WHERE product_code='".$product_code."' 
											AND trx_desc='".$trx_desc."'
											AND user_id='".$user_id."' 
											ORDER BY trx_id DESC LIMIT 1 ")->row_array();
					if($ma_trx){
						$last_trx=strtotime($ma_trx['trx_date']);
						$last_trx2=(int)$last_trx+3600;// lebih dari 1 jam;
						$time_now=time();
						if((int)$time_now>(int)$last_trx2){
							$cek_double_trx=false;
						}else{
							$cek_double_trx=true; //transaksi ada yg double
						}
					}else{
						$cek_double_trx=false;
					}
					
					if($cek_double_trx){
						$this->error_code='';
						$this->error_message='Transaksi sudah pernah dilakukan pada '.$ma_trx['trx_date'].'. Transaksi yang sama dapat dilakukan kembali setelah 1 jam';
					}else{
						
						if($voucher_code==''){
							$discount_voucher=0;
							$cek_voucher=true;
						}else{
							$voucher=$this->db->query("SELECT * FROM gerai_voucher_code WHERE voucher_code='".$voucher_code."' AND product='".$product['product_type']."'")->row_array();
							if($voucher){
								if($voucher['is_active']=='Y'){
									if($voucher['end_date']>date('Y-m-d')){
										if($voucher['user_id']=='0'){ //voucer bisa digunakan semua orang
											if($voucher['is_percent']=='Y'){
												$discount_voucher=((float)$product['product_saleprice']*(float)$voucher['voucher_value'])/100;
											}else{
												$discount_voucher=(float)$voucher['voucher_value'];
											}
											$cek_voucher=true;
										}else{
											if($voucher['user_id']==$user_id){
												if($voucher['is_percent']=='Y'){
													$discount_voucher=((float)$product['product_saleprice']*(float)$voucher['voucher_value'])/100;
												}else{
													$discount_voucher=(float)$voucher['voucher_value'];
												}
												$cek_voucher=true;
											}else{
												$cek_voucher=false;
												$cek_voucher_msg="Voucher tidak bisa anda gunakan";
											}
										}
										
									}else{
										$cek_voucher=false;
										$cek_voucher_msg="Voucher expire";
									}
								}else{
									$cek_voucher=false;
									$cek_voucher_msg="Voucher tidak aktif";
								}
							}else{
								$cek_voucher=false;
								$cek_voucher_msg="Voucher Tidak ada";
							}
						}
						
						if($cek_voucher){
							
							$trx_type='ppob';
							//$trx_desc='BUY '.$product['product_name']. ' '.$customer_number.'';
							$amount=(float)$product['product_saleprice']+(float)$discount_voucher;
							$from_vacc_number=$this->vacc_number;
							$to_vacc_number=$this->config->item('gerai_vacc_number');
							$ma_proses=$this->M_va->transfer($trx_type,$trx_desc,$amount,$from_vacc_number,$to_vacc_number,$pin);
							
							
							//var_dump($ma_proses);die();
							if(isset($ma_proses['is_error'])){
								if($ma_proses['is_error']=='0'){
									//disable voucher karna sudah digunakan
									$data_voucher['is_active']='N';
									$this->db->where('is_active','Y');
									$this->db->where('user_id',$user_id);
									$this->db->where('voucher_code',$voucher_code);
									$this->db->update('gerai_voucher_code',$data_voucher);
									
									$TopupService=$this->M_id_biller->TopupService($model,$product['product_code'],$customer_number,$user_id);
									//var_dump($TopupService);die();
									if($TopupService['is_error']=='0'){
										$result_biller=$TopupService['result'];
										//insert ke ppob_trx
										$data_ppob_trx['user_id']=$user_id;
										$data_ppob_trx['provider']=$product['provider'];
										$data_ppob_trx['product_code']=$product['product_code'];
										$data_ppob_trx['product_name']=$product['product_name'];
										$data_ppob_trx['trx_status']=$TopupService['response_msg'];
										$data_ppob_trx['trx_desc']=$trx_desc;
										$data_ppob_trx['trx_amount']=$amount;
										$data_ppob_trx['reffnum']=$result_biller['RefNumber'];
										$data_ppob_trx['voucher_code']=strtoupper($voucher_code);
										$data_ppob_trx['voucher_nominal']=$discount_voucher;
										$data_ppob_trx['sale_price']=$product['product_saleprice'];
										$data_ppob_trx['base_price']=$product['product_price'];
										$data_ppob_trx['nominal']=$product['product_saleprice'];
										$data_ppob_trx['remark1']=json_encode($result_biller);
										$data_ppob_trx['customer_number']=$customer_number;
										$this->db->insert('ppob_trx',$data_ppob_trx);
										$insert_ppob_trx=$this->db->insert_id();
										//-----------------------------------------
										
										//insert ma_trx_external_id
										$data_external_id['trx_id']=$ma_proses['result']['trx_id'];
										$data_external_id['external_id']=$insert_ppob_trx;
										$data_external_id['external_table']='ppob_trx';
										$this->db->insert('ma_trx_external_id',$data_external_id);
										//------------------------------------------
										
										$result['response_msg']=$TopupService['response_msg'];
										//$result['response_msg']='Transaksi Berhasil';
										$this->result=$result;
									}else{
										$this->error_code='';
										$this->error_message=$TopupService['response_msg'];
										//$this->error_message='Transaksi Berhasil';
										
									}
									
								
								}else{
									$this->error_code='';
									$this->error_message=$ma_proses['response_msg'];
								}
							}else{
								$this->error_code='';
								$this->error_message='Err ReqMA transfer_vacc';
							}
							
							
						}else{
							$this->error_code='';
							$this->error_message=$cek_voucher_msg;
						}
							
					}
				}else{
					$this->error_code='';
					$this->error_message='product_code tidak ada';
				}
				
				
				
			
		
		}
		
		$this->jsonOut();
	}
	
	
	function inquiry_service_post(){
		$this->form_validation->set_rules('product_code', 'product_code', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('customer_number1', 'customer_number1', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('customer_number2', 'customer_number2', 'trim|max_length[50]');
		$this->form_validation->set_rules('customer_number3', 'customer_number3', 'trim|max_length[50]');
		$this->form_validation->set_rules('misc', 'misc', 'trim|max_length[50]');
		$this->form_validation->set_rules('voucher_code', 'voucher_code', 'trim|max_length[50]');
		//$this->form_validation->set_rules('pin', 'pin', 'trim|required|max_length[6]|numeric');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$product_code=strip_tags($this->input->post('product_code',true));
			$customer_number1=strip_tags($this->input->post('customer_number1',true));
			$customer_number2=strip_tags($this->input->post('customer_number2',true));
			$customer_number3=strip_tags($this->input->post('customer_number3',true));
			$misc=strip_tags($this->input->post('misc',true));
			$voucher_code=strip_tags($this->input->post('voucher_code',true));
			$user_id=$this->user_id;
			
			//cek product
			$product=$this->db->query("SELECT * FROM idbiller_price_tagihan WHERE product_code='".$product_code."'")->row_array();
			if($product){
				if($voucher_code==''){
						$discount_voucher=0;
						$cek_voucher=true;
					}else{
						$voucher=$this->db->query("SELECT * FROM gerai_voucher_code WHERE voucher_code='".$voucher_code."' AND product='".$product['product_type']."'")->row_array();
						if($voucher){
							if($voucher['is_active']=='Y'){
								if($voucher['end_date']>date('Y-m-d')){
									if($voucher['user_id']=='0'){ //voucer bisa digunakan semua orang
										if($voucher['is_percent']=='Y'){
											$discount_voucher=((float)$product['product_saleprice']*(float)$voucher['voucher_value'])/100;
										}else{
											$discount_voucher=(float)$voucher['voucher_value'];
										}
										$cek_voucher=true;
									}else{
										if($voucher['user_id']==$user_id){
											if($voucher['is_percent']=='Y'){
												$discount_voucher=((float)$product['product_saleprice']*(float)$voucher['voucher_value'])/100;
											}else{
												$discount_voucher=(float)$voucher['voucher_value'];
											}
											$cek_voucher=true;
										}else{
											$cek_voucher=false;
											$cek_voucher_msg="Voucher tidak bisa anda gunakan";
										}
									}
									
								}else{
									$cek_voucher=false;
									$cek_voucher_msg="Voucher expire";
								}
							}else{
								$cek_voucher=false;
								$cek_voucher_msg="Voucher tidak aktif";
							}
						}else{
							$cek_voucher=false;
							$cek_voucher_msg="Voucher Tidak ada";
						}
					}
					
				if($cek_voucher){
					//inquiry to biller
					$InquiryService=$this->M_id_biller->InquiryService($product_code,$customer_number1,$customer_number2,$customer_number3,$misc);
					if(isset($InquiryService['is_error'])){
						if($InquiryService['is_error']=='0'){
							$result['voucher_code']=$voucher_code;
							if($voucher_code==''){
								$voucher_nominal=0;
								$voucher_desc='';
								$voucher_product='';
								$voucher_start_date='';
								$voucher_end_date='';
								$voucher_filename='';
							}else{
								$voucher_nominal=$voucher['voucher_value'];
								$voucher_desc=$voucher['voucher_desc'];
								$voucher_product=$voucher['product'];
								$voucher_start_date=$voucher['start_date'];
								$voucher_end_date=$voucher['end_date'];
								$voucher_filename=$voucher['filename'];
							}
							$result['voucher_nominal']=''.$voucher_nominal;
							$result['voucher_desc']=$voucher_desc;
							$result['voucher_product']=$voucher_product;
							$result['voucher_start_date']=$voucher_start_date;
							$result['voucher_end_date']=$voucher_end_date;
							$result['voucher_filename']=$voucher_filename;
							
							$result['komisi']=$product['komisi'];
							$result['misc']=$misc;
							$result['trx_id']='8'.generateCode();
							$result['product_code']=$product['product_code'];
							$result['product_name']=$product['product_name'];
							if($product['product_type']=='pln_pascabayar'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["SubscribeId"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["SubscriberName"];
								$result['detil3']='Tarif/Daya: '.$InquiryService['result']["SubscriberSegmentation"].'/'.(int)$InquiryService['result']["PowerConsumingCategory"];
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']=$InquiryService['result']["Blth1"];
								$result['periode2']=$InquiryService['result']["Blth2"];
								$result['periode3']=$InquiryService['result']["Blth3"];
								$result['periode4']=$InquiryService['result']["Blth4"];
								$result['periode5']='';
								$result['periode6']='';
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
								
							}elseif($product['product_type']=='pln_prabayar'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerId"];;
								$result['detil2']='No Meter: '.$InquiryService['result']["CustomerMeter"];;
								$result['detil3']='Nama Pelanggan: '.$InquiryService['result']["SubscriberName"];
								$result['detil4']='Tarif/Daya: '.$InquiryService['result']["SubscriberSegmentation"].'/'.(int)$InquiryService['result']["PowerConsumingCategory"];
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']='';
								$result['periode2']='';
								$result['periode3']='';
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
							}elseif($product['product_type']=='multi_finance'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerId"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='Leasing: '.$InquiryService['result']["PtName"];
								$result['detil4']='Merk/Type: '.$InquiryService['result']["ItemMerkType"];
								$result['detil5']='ChasisNumber: '.$InquiryService['result']["ChasisNumber"];
								$result['detil6']='CarNumber: '.$InquiryService['result']["CarNumber"];
								$result['detil7']='Tenor: '.$InquiryService['result']["Tenor"];
								
								$result['periode1']='';
								$result['periode2']='';
								$result['periode3']='';
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
									
								
							}elseif($product['product_type']=='bpjs_kesehatan'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerId"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='';
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']='';
								$result['periode2']='';
								$result['periode3']='';
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
							}elseif($product['product_type']=='pulsa_pascabayar'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerId"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='Provider: '.$InquiryService['result']["ProviderName"];
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']=$InquiryService['result']["MonthPeriod1"].'-'.$InquiryService['result']["YearPeriod1"];
								$result['periode2']=$InquiryService['result']["MonthPeriod2"].'-'.$InquiryService['result']["YearPeriod2"];
								$result['periode3']=$InquiryService['result']["MonthPeriod3"].'-'.$InquiryService['result']["YearPeriod3"];
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
								
							}elseif($product['product_type']=='telkom'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["AreaCode"].$InquiryService['result']["PhoneNumber"];
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='';
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']='';
								$result['periode2']='';
								$result['periode3']='';
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
							}elseif($product['product_type']=='tv_cable'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerId"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='';
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']=$InquiryService['result']["Periode"];
								$result['periode2']='';
								$result['periode3']='';
								$result['periode4']='';
								$result['periode5']='';
								$result['periode6']='';
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
									
							}elseif($product['product_type']=='pdam'){
								$result['detil1']='ID Pelanggan: '.$InquiryService['result']["CustomerNumber1"];;
								$result['detil2']='Nama Pelanggan: '.$InquiryService['result']["CustomerName"];
								$result['detil3']='PDAM: '.$InquiryService['result']["PdamName"];
								$result['detil4']='';
								$result['detil5']='';
								$result['detil6']='';
								$result['detil7']='';
								
								$result['periode1']=$InquiryService['result']["MonthPeriod1"].'-'.$InquiryService['result']["YearPeriod1"];
								$result['periode2']=$InquiryService['result']["MonthPeriod2"].'-'.$InquiryService['result']["YearPeriod2"];
								$result['periode3']=$InquiryService['result']["MonthPeriod3"].'-'.$InquiryService['result']["YearPeriod3"];
								$result['periode4']=$InquiryService['result']["MonthPeriod4"].'-'.$InquiryService['result']["YearPeriod4"];
								$result['periode5']=$InquiryService['result']["MonthPeriod5"].'-'.$InquiryService['result']["YearPeriod5"];
								$result['periode6']=$InquiryService['result']["MonthPeriod6"].'-'.$InquiryService['result']["YearPeriod6"];
								
								$result["customer_number1"]=$InquiryService['result']["CustomerNumber1"];
								$result["customer_number2"]=$InquiryService['result']["CustomerNumber2"];
								$result["customer_number3"]=$InquiryService['result']["CustomerNumber3"];
								$result["ref_number"]=$InquiryService['result']["RefNumber"];
								$result["nominal"]=$InquiryService['result']["Nominal"];
								$result["admin_charge"]=$InquiryService['result']["AdminCharge"];
								$result["cashback"]=$InquiryService['result']["Cashback"];
								
							}else{
								$this->error_code='';
								$this->error_message='General Error Product Type';
								$this->jsonOut();
								die();
								
							}
							$before_discount=((float)$result["nominal"]+(float)$result["admin_charge"])-(float)$product['komisi'];
							$after_discount=(float)$before_discount-(float)$result['voucher_nominal'];
							$result["total"]=''.$after_discount;
							
							
							//insert idbiller_payment
							$data['trx_id']=$result['trx_id'];
							$data['product_code']=$InquiryService['result']["ProductCode"];
							$data['customer_number1']=$InquiryService['result']["CustomerNumber1"];
							$data['customer_number2']=$InquiryService['result']["CustomerNumber2"];
							$data['customer_number3']=$InquiryService['result']["CustomerNumber3"];
							$data['misc']=$misc;
							$data['ref_number']=$InquiryService['result']["RefNumber"];
							$data['nominal']=$InquiryService['result']["Nominal"];
							$data['admin_charge']=$InquiryService['result']["AdminCharge"];
							$data['cashback']=$InquiryService['result']["Cashback"];
							$data['komisi']=$product['komisi'];
							$data['trx_amount']=$result["total"];
							$data['saldo']=$InquiryService['result']["Saldo"];
							$data['voucher_code']=$voucher_code;
							$data['voucher_nominal']=$voucher_nominal;
							$data['product_name']=$product['product_name'];
							$data['inquiry_data']=json_encode($InquiryService['result']);
							//$data['biller_data']='';
							$data['created_on']=date('Y-m-d H:i:s');
							$data['created_by']=$user_id;
							//$data['update_on']=date('Y-m-d H:i:s');
							//$data['update_by']=$user_id;
							$data['paid_flag']='N';
							$this->db->insert('idbiller_payment',$data);
							
							
							$this->result=$result;

							
						}else{
							$this->error_code='';
							$this->error_message=$InquiryService['response_msg'];
						}
					}else{
						$this->error_code='';
						$this->error_message='General Error';
					}
					
				}else{
					$this->error_code='';
					$this->error_message=$cek_voucher_msg;
				}
				
			}else{
				$this->error_code='';
				$this->error_message='Product tidak ada';
			}
			
		
			
		}
		
		$this->jsonOut();
		
	}
	
	
	function payment_service_post(){
		$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('ref_number', 'ref_number', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('pin', 'pin', 'trim|required|max_length[6]|numeric');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_id=strip_tags($this->input->post('trx_id',true));
			$ref_number=strip_tags($this->input->post('ref_number',true));
			$pin=strip_tags($this->input->post('pin',true));
			$user_id=$this->user_id;
			
			$idbiller_payment=$this->db->query("SELECT * 
												FROM idbiller_payment 
												WHERE trx_id='".$trx_id."' 
												AND ref_number='".$ref_number."'
												")
												->row_array();
			if($idbiller_payment){
				if($idbiller_payment['paid_flag']=='N'){
					
					//debet saldo terlebih dahulu
					$trx_type='ppob';
					$trx_desc='PAY '.$idbiller_payment['product_name'].' | '.$idbiller_payment['customer_number1'].$idbiller_payment['customer_number2'];
					$amount=(((float)$idbiller_payment['nominal']+(float)$idbiller_payment['admin_charge'])-(float)$idbiller_payment['komisi'])-(float)$idbiller_payment['voucher_nominal'];
					$from_vacc_number=$this->vacc_number;
					$to_vacc_number=$this->config->item('gerai_vacc_number');
					$ma_proses=$this->M_va->transfer($trx_type,$trx_desc,$amount,$from_vacc_number,$to_vacc_number,$pin);
					
					//var_dump($ma_proses);die();
					if(isset($ma_proses['is_error'])){
						if($ma_proses['is_error']=='0'){								
							
							//disable voucher karna sudah digunakan
							$data_voucher['is_active']='N';
							$this->db->where('is_active','Y');
							$this->db->where('user_id',$user_id);
							$this->db->where('voucher_code',$idbiller_payment['voucher_code']);
							$this->db->update('gerai_voucher_code',$data_voucher);
							
							//payment ke biller
							$PaymentService=$this->M_id_biller->PaymentService($idbiller_payment['product_code'],
																				$idbiller_payment['customer_number1'],
																				$idbiller_payment['customer_number2'],
																				$idbiller_payment['customer_number3'],
																				$idbiller_payment['nominal'],
																				$idbiller_payment['ref_number'],
																				$idbiller_payment['misc'],$user_id);
							if(isset($PaymentService['is_error'])){
								if($PaymentService['is_error']=='0'){
									//var_dump($PaymentService);die();
									$result_biller=$PaymentService['result'];
									//update idbiller_payment
									$data_ppob['payment_data']=json_encode($PaymentService['result']);
									$data_ppob['paid_flag']='Y';
									$data_ppob['update_on']=date('Y-m-d H:i:s');
									$data_ppob['update_by']=$user_id;
									$data_ppob['paid_flag']='Y';
									$this->db->where('ids',$idbiller_payment['ids']);
									$this->db->update('idbiller_payment',$data_ppob);
									
									//insert ke ppob_trx
									$data_ppob_trx['user_id']=$user_id;
									$data_ppob_trx['provider']=$idbiller_payment['product_name'];
									$data_ppob_trx['product_code']=$idbiller_payment['product_code'];
									$data_ppob_trx['product_name']=$idbiller_payment['product_name'];
									$data_ppob_trx['trx_status']=$PaymentService['response_msg'];
									$data_ppob_trx['trx_desc']=$trx_desc;
									$data_ppob_trx['trx_amount']=$amount;
									$data_ppob_trx['reffnum']=$result_biller['RefNumber'];
									$data_ppob_trx['voucher_code']=$idbiller_payment['voucher_code'];
									$data_ppob_trx['voucher_nominal']=$idbiller_payment['voucher_nominal'];
									$data_ppob_trx['cashback']=$result_biller['Cashback'];
									$data_ppob_trx['admin_bank']=$idbiller_payment['admin_charge'];
									$data_ppob_trx['nominal']=$idbiller_payment['nominal'];
									$data_ppob_trx['commision']=$idbiller_payment['komisi'];
									$data_ppob_trx['remark1']=json_encode($result_biller);
									$data_ppob_trx['trx_id2']=$trx_id;
									$data_ppob_trx['customer_number']=$idbiller_payment['customer_number1'].$idbiller_payment['customer_number2'];
									$this->db->insert('ppob_trx',$data_ppob_trx);
									$insert_ppob_trx=$this->db->insert_id();;
									//-----------------------------------------
									
									//insert ma_trx_external_id
									$data_external_id['trx_id']=$ma_proses['result']['trx_id'];
									$data_external_id['external_id']=$insert_ppob_trx;
									$data_external_id['external_table']='ppob_trx';
									$this->db->insert('ma_trx_external_id',$data_external_id);
									//------------------------------------------
									if($idbiller_payment['product_code']=='PPLNPRAY'){
										$this->result="Token PLN: ".$result_biller['TokenPln'];
									
									}else{
										$this->result=$PaymentService['response_msg'];
									}
									
									
								}else{
									$this->error_code='';
									$this->error_message=$PaymentService['response_msg'];
								}
							}else{
								$this->error_code='';
								$this->error_message='General Error';
							}
					
						}else{
							$this->error_code='';
							$this->error_message=$ma_proses['response_msg'];
						}
					}else{
						$this->error_code='';
						$this->error_message='Err ReqMA transfer_vacc';
					}
					
					
				}else{
					$this->error_code='';
					$this->error_message='Tagihan sudah dibayar (Paid Has Been Flag)';
				}
				
			}else{
				$this->error_code='';
				$this->error_message='Tagihan tidak ditemukan';
			}	
						
		}
		
		$this->jsonOut();
		
	}
	
	
	function price_tagihan_post(){
		$this->form_validation->set_rules('product_type', 'product_type', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$product_type=strip_tags($this->input->post('product_type',true));
			
			$sql="SELECT * FROM idbiller_price_tagihan WHERE product_type='".$product_type."' AND lower(status)='open' ORDER BY product_name ASC";
			$product=$this->db->query($sql)->result_array();
			if($product){
				$this->result=$product;
			}else{
				$this->error_code='';
				$this->error_message='Product type tidak ditemukan';
			}	
		}
		
		$this->jsonOut();
		
	}
	
	function ppob_trx_detil_post(){
		$this->form_validation->set_rules('trx_id2', 'trx_id2', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('ref_number', 'ref_number', 'trim|required|max_length[50]');
		
		if ($this->form_validation->run() == FALSE){
			$this->error_code='53';
			$this->error_message=strip_err_msg(validation_errors());
		}else{
			$trx_id2=strip_tags($this->input->post('trx_id2',true));
			$ref_number=strip_tags($this->input->post('ref_number',true));
			$user_id=$this->user_id;
			
			$this->db->where('trx_id2',$trx_id2);
			$this->db->where('reffnum',$ref_number);
			$this->db->where('user_id',$user_id);
			$q=$this->db->get('ppob_trx');
			$res=$q->row_array();
			if($res){
				$this->result=$res;
			}else{
				$this->error_code='';
				$this->error_message='Data tidak ditemukan';
			}
						
		}
		
		$this->jsonOut();
		
	}
	
	
	
}

