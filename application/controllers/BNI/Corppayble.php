<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corppayble extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		
		$env='DEV';
		
		if($env=='DEV'){
			$this->url_corppayble = $this->config->item('dev_corppayble_url');
			$this->client_id = $this->config->item('dev_corppayble_client_id');
			$this->secret_key = $this->config->item('dev_corppayble_secret_key');
			$this->trx_cleintId= $this->config->item('dev_corppayble_trx_cleintId');
			$this->accountNum= $this->config->item('dev_norek');
			$this->valdo_key= $this->config->item('dev_valdo_key');
		}elseif($env=='PRD'){
			$this->url_corppayble = $this->config->item('prd_corppayble_url');
			$this->client_id = $this->config->item('prd_corppayble_client_id');
			$this->secret_key = $this->config->item('prd_corppayble_secret_key');
			$this->trx_cleintId= $this->config->item('prd_corppayble_trx_cleintId');
			$this->accountNum= $this->config->item('prd_norek');
			$this->valdo_key= $this->config->item('prd_valdo_key');
		}else{
			echo 'error env';
			die();
		}
		
		$this->load->model('M_bni_corppayble');
	}
	
	function gettoken(){
		$username=$this->client_id;
		$password=$this->secret_key;
		$URL=$this->url_corppayble.'/api/oauth/token';
		
		$header[]='Connection: Keep-Alive';
		$header[]='Accept-Encoding: gzip,deflate';
		$header[]='Content-Type: application/x-www-form-urlencoded';
		$header[]='Connection: Keep-Alive';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$result=curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		
		$req_token=json_decode($result);

		if(isset($req_token->access_token)){
			return  $req_token->access_token;
		}
		
		return false;
	}
	
	
	function get_balance_post(){
		$this->form_validation->set_rules('account_no','account no','trim|required|numeric|max_length[50]');
		if($this->form_validation->run()==true){
			$token=$this->gettoken();
			//var_dump($token);die();
			if($token){
				$url=$this->url_corppayble."/H2H/getbalance?access_token=$token" ;
				$post['clientId']= $this->trx_cleintId;
				$post['accountNo']= strip_tags($this->input->post('account_no',true));
				$encript = $this->encrypt_data($post['clientId'].$post['accountNo']);
				$post['signature']= $encript;
				$curl_post=$this->curl_post($url,json_encode($post));
				if($curl_post['status']=='error'){
					$response_msg['error_code'] = '';
					$response_msg['error_message'] = $curl_post['result'];
				}else{
					$response_msg= $curl_post;
				}
				
				$this->M_bni_corppayble->log_api($post,$curl_post,'get_balance');
			}else{
				$response_msg['error_code'] = '401';
				$response_msg['error_message'] = 'Authorization Required';
			}
		}else{
			$response_msg['error_code'] = '53';
			$response_msg['error_message'] = strip_err_msg(validation_errors());
		}
		$this->set_response($response_msg, REST_Controller::HTTP_OK); 
	
	}
	
	//inquiry bank bni	
	function inhouse_inquiry_post(){
		$this->form_validation->set_rules('account_no','account no','trim|required|numeric|max_length[50]');
		if($this->form_validation->run()==true){
			$token=$this->gettoken();
			if($token){
				$url=$this->url_corppayble."/H2H/getinhouseinquiry?access_token=$token" ;
				$post['clientId']= $this->trx_cleintId;
				$post['accountNo']= strip_tags($this->input->post('account_no',true));
				$encript = $this->encrypt_data($post['clientId'].$post['accountNo']);
				$post['signature']= $encript;
				$curl_post=$this->curl_post($url,json_encode($post));
				if($curl_post['status']=='error'){
					$response_msg['error_code'] = '';
					$response_msg['error_message'] = $curl_post['result'];
				}else{
					$response_msg= $curl_post;
				}
				
				$this->M_bni_corppayble->log_api($post,$curl_post,'inhouse_inquiry');
			}else{
				$response_msg['error_code'] = '401';
				$response_msg['error_message'] = 'Authorization Required';
			}
		}else{
			$response_msg['error_code'] = '53';
			$response_msg['error_message'] = strip_err_msg(validation_errors());
		}
		
		$this->set_response($response_msg, REST_Controller::HTTP_OK); 
	}
	
	function do_payment_post(){
		$this->form_validation->set_rules('customer_reference_number','customer reference number','trim|required|max_length[20]');
		$this->form_validation->set_rules('payment_method','payment method','trim|required|numeric');
		$this->form_validation->set_rules('debit_account_no','debit account no','trim|required');
		$this->form_validation->set_rules('credit_account_no','credit account no','trim|required');
		$this->form_validation->set_rules('value_date','value date','trim|required');
		$this->form_validation->set_rules('value_currency','value currency','trim|required');
		$this->form_validation->set_rules('value_amount','value amount','trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules('remark','remark','trim|required');
		$this->form_validation->set_rules('beneficiary_email_address','beneficiary email address','trim|valid_email');
		$this->form_validation->set_rules('destination_bank_code','destination bank code','trim|required');
		$this->form_validation->set_rules('beneficiary_name','beneficiary name','trim|required');
		$this->form_validation->set_rules('beneficiary_address1','beneficiary address1','trim|required');
		$this->form_validation->set_rules('beneficiary_address2','beneficiary address2','trim');
		$this->form_validation->set_rules('charging_modelId','charging model id','trim|required');
		
		if($this->form_validation->run()==true){
			$token=$this->gettoken();
			if($token){
				$url=$this->url_corppayble."/H2H/dopayment?access_token=$token" ;
				$post['clientId']= $this->trx_cleintId;
				$post['customerReferenceNumber']= $this->input->post('customer_reference_number');
				$post['paymentMethod']= $this->input->post('payment_method');
				$post['debitAccountNo']= $this->input->post('debit_account_no');
				$post['creditAccountNo']= $this->input->post('credit_account_no');
				$post['valueDate']= $this->input->post('value_date');
				$post['valueCurrency']= $this->input->post('value_currency');
				$post['valueAmount']= $this->input->post('value_amount');
				$post['remark']= $this->input->post('remark');
				$post['beneficiaryEmailAddress']= $this->input->post('beneficiary_email_address');
				$post['destinationBankCode']= $this->input->post('destination_bank_code');
				$post['beneficiaryName']= $this->input->post('beneficiary_name');
				$post['beneficiaryAddress1']= $this->input->post('beneficiary_address1');
				$post['beneficiaryAddress2']= $this->input->post('beneficiary_address2');
				$post['chargingModelId']= $this->input->post('charging_modelId');
				$encript = $this->encrypt_data($post['clientId'].$post['customerReferenceNumber'].$post['paymentMethod'].$post['debitAccountNo'].$post['creditAccountNo'].$post['valueAmount'].$post['valueCurrency']);
				
				$post['signature']= $encript;
				
				$curl_post=$this->curl_post($url,json_encode($post));
				//print_r($curl_post['result']);die();
				//var_dump($curl_post['result']);die();
				$this->set_response(json_encode($curl_post), REST_Controller::HTTP_OK); 
				if($curl_post['status']=='error'){
					$response_msg['error_code'] = '';
					$response_msg['error_message'] = $curl_post['result'];
				}else{
					$response_msg= $curl_post;
					$this->M_bni_corppayble->corp_payment($post,$response_msg);
				}
				//var_dump($curl_post);die();
				$this->M_bni_corppayble->log_api($post,$curl_post,'inhouse_payment');
			}else{
				$response_msg['error_code'] = '401';
				$response_msg['error_message'] = 'Authorization Required';
			}
		}else{
			$response_msg['error_code'] = '53';
			$response_msg['error_message'] = strip_err_msg(validation_errors());
		}
	
		$this->set_response($response_msg, REST_Controller::HTTP_OK); 
	}
	
	//cash out antar bank
	function interbank_inquiry_post(){
		$this->form_validation->set_rules('customer_reference_number','customer reference number','trim|required|required|max_length[20]');
		$this->form_validation->set_rules('destination_bank_code','destination bank code','trim|required');
		$this->form_validation->set_rules('destination_account_num','destination account num','trim|required');
		
		if($this->form_validation->run()==true){
			$token=$this->gettoken();
			if($token){
				$url=$this->url_corppayble."/H2H/getinterbankinquiry?access_token=$token" ;
				$post['clientId']= $this->trx_cleintId;
				$post['customerReferenceNumber']= $this->input->post('customer_reference_number');
				$post['accountNum']= $this->accountNum;
				$post['destinationBankCode']= $this->input->post('destination_bank_code');
				$post['destinationAccountNum']= $this->input->post('destination_account_num');
				
				$encript = $this->encrypt_data($post['clientId'].$post['destinationBankCode'].$post['destinationAccountNum'].$post['accountNum']);
				
				$post['signature']= $encript;
				
				$curl_post=$this->curl_post($url,json_encode($post));
				
				if($curl_post['status']=='error'){
					$response_msg['error_code'] = '';
					$response_msg['error_message'] = $curl_post['result'];
				}else{
					$response_msg= $curl_post;
				}
				
				$this->bni->log_api($post,$curl_post,'interbank_inquiry');
			}else{
				$response_msg['error_code'] = '401';
				$response_msg['error_message'] = 'Authorization Required';
			}
		}else{
			$response_msg['error_code'] = '53';
			$response_msg['error_message'] = strip_err_msg(validation_errors());
		}
		
		$this->set_response($response_msg, REST_Controller::HTTP_OK);
	}
	
	function interbank_payment_post(){
		// $vacc_number = $this->vacc_number;
		// $userid = $this->user->get_id_user($vacc_number);
		// if(empty($userid)){
			// $this->is_error=1;
			// $error_code='10';
			// $error_message=error_code_msg('10');
			// $this->set_response($response_msg, REST_Controller::HTTP_UNAUTHORIZED); 
		// }else{
			$this->form_validation->set_rules('customer_reference_number','customer reference number','trim|required|max_length[20]');
			$this->form_validation->set_rules('amount','amount','trim|required|numeric|greater_than[0]');
			$this->form_validation->set_rules('destination_account_no','destination account no','trim|required');
			$this->form_validation->set_rules('destination_account_name','destination account name','trim|required');
			$this->form_validation->set_rules('destination_bank_code','destination bank code','trim|required');
			$this->form_validation->set_rules('destination_bank_name','destination bank name','trim|required');
			$this->form_validation->set_rules('retrieval_reff_num','retrieval reff num','trim|required');
			
			if($this->form_validation->run()==true){
				$token=$this->gettoken();
				if($token){
					$url=$this->url_corppayble."/H2H/getinterbankpayment?access_token=$token" ;
					$post['clientId']= $this->trx_cleintId;
					$post['customerReferenceNumber']= $this->input->post('customer_reference_number');
					$post['amount']= $this->input->post('amount');
					$post['destinationAccountNum']= $this->input->post('destination_account_no');
					$post['destinationAccountName']= $this->input->post('destination_account_name');
					$post['destinationBankCode']= $this->input->post('destination_bank_code');
					$post['destinationBankName']= $this->input->post('destination_bank_name');
					$post['accountNum']= $this->accountNum;
					$post['retrievalReffNum']= $this->input->post('retrieval_reff_num');
					
					$encript = $this->encrypt_data($post['clientId'].$post['destinationAccountNum'].$post['destinationBankCode'].$post['accountNum'].$post['amount'].$post['retrievalReffNum']);
					$post['signature']= $encript;
					
					$curl_post=$this->curl_post($url,json_encode($post));
					// var_dump($curl_post);
					// die();
					
					if($curl_post['status']=='error'){
						$response_msg['error_code'] = '';
						$response_msg['error_message'] = $curl_post['result'];
					}else{
						$response_msg= $curl_post;
						
						$this->bni->corp_interbank_payment($post,$response_msg);
					}
					
					$this->bni->log_api($post,$curl_post,'interbank_payment');
				}else{
					$response_msg['error_code'] = '401';
					$response_msg['error_message'] = 'Authorization Required';
				}
			}else{
				$response_msg['error_code'] = '53';
				$response_msg['error_message'] = strip_err_msg(validation_errors());
			}
			
			$this->set_response($response_msg, REST_Controller::HTTP_OK); 
		// }
	}
	
	//check payment status
	function payment_status_post(){
		$this->form_validation->set_rules('customer_reference_number','customer reference number','trim|required|max_length[20]');
		
		if($this->form_validation->run()==true){
			$token=$this->gettoken();
			if($token){
				$url=$this->url_corppayble."/H2H/getpaymentstatus?access_token=$token" ;
				$post['clientId']= $this->trx_cleintId;
				$post['customerReferenceNumber']= $this->input->post('customer_reference_number');
				
				$encript = $this->encrypt_data($post['clientId'].$post['customerReferenceNumber']);
				$post['signature']= $encript;
				
				$curl_post=$this->curl_post($url,json_encode($post));
				
				if($curl_post['status']=='error'){
					$response_msg['error_code'] = '';
					$response_msg['error_message'] = $curl_post['result'];
				}else{
					$response_msg= $curl_post;
					$this->bni->log_api($post,$curl_post,'payment_status');
				}
			}else{
				$response_msg['error_code'] = '401';
				$response_msg['error_message'] = 'Authorization Required';
			}
		}else{
			$response_msg['error_code'] = '53';
			$response_msg['error_message'] = strip_err_msg(validation_errors());
		}
		
		$this->set_response($response_msg, REST_Controller::HTTP_OK);
	}
	
	function update_balance(){
		$vacc_number = $this->vacc_number;
		$userid = $this->user->get_id_user($vacc_number);
		if(empty($userid)){
			$this->is_error=1;
			$error_code='10';
			$error_message=error_code_msg('10');
			$this->set_response($response_msg, REST_Controller::HTTP_UNAUTHORIZED); 
		}else{
			$this->form_validation->set_rules('amount','amount','trim|required|numeric');
		
			if($this->form_validation->run()==true){
				$this->load->model('M_user','profile');
				
				$data['balance'] = $this->input->post('amount');
				$update_balance = $this->profile->update_profile($vacc_number,$data);
				if($update_balance){
					$response_msg['status'] = 'berhasil';
					$response_msg['status_code'] = '1';
				}else{
					$response_msg['status'] = 'gagal';
					$response_msg['status_code'] = '0';
					$response_msg['error_code'] = '92';
					$response_msg['error_message'] = 'query failed';
				}
			}
			
			$this->set_response($response_msg, REST_Controller::HTTP_OK); 
		}
	}

	function curl_post($url, $post = '',$auth='',$pwd='') {
			$header[] = 'Content-Type: application/json';
			$header[] = "Accept-Encoding: gzip, deflate";
			$header[] = "Cache-Control: max-age=0";
			$header[] = "Connection: Keep-Alive";
			$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, false);
			// curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_ENCODING, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
			
			//jika auth basic
			if($auth=='basic'){
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD,$pwd);
			}
			
			if ($post)
			{
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$rs = curl_exec($ch);

			if(empty($rs)){
				$err = curl_error($ch);
				curl_close($ch);
				return array('status'=>'error',
							'result'=>"cURL Error #:" . $err);
			}
			
			curl_close($ch);
			return array('status'=>'ok',
							'result'=>$rs);
	}
		
	function encrypt_data($source)
	{
		$fp=fopen($this->valdo_key,"r");
		$pub_key_string='';
		while(! feof($fp))
		{
			$pub_key_string .= fgets($fp);
		}
		fclose($fp);
		
		$binary_signature = "";
		$algo = "SHA256";
		openssl_sign($source, $binary_signature, $pub_key_string, $algo);
		
		$crypttext = base64_encode($binary_signature) ."\n";
		
		return $crypttext; 
		
	} 
	
}
