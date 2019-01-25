<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bni_corppayble extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
		$env='DEV';//DEV -- PRD
		
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
	
	function getbalance($accountNo){
		$token=$this->gettoken();
		if($token){
			$url=$this->url_corppayble."/H2H/getbalance?access_token=$token" ;
			$postParams['clientId']= $this->trx_cleintId.'565';
			$postParams['accountNo']= $accountNo;
			$encript = $this->encrypt_data($postParams['clientId'].$postParams['accountNo']);
			$postParams['signature']= $encript;
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					//var_dump($curl_result);die();
					if(isset($curl_result->getBalanceResponse->parameters)){
						$parameters=$curl_result->getBalanceResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							$result['customerName']=$parameters->customerName;
							$result['accountCurrency']=$parameters->accountCurrency;
							$result['accountBalance']=$parameters->accountBalance;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							$result['accountNo']=$parameters->accountNo;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='getBalanceResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		$this->log_api($postParams,$response_msg,'get_balance');
		return $response_msg;
	}
	
	function getinhouseinquiry($accountNo){
		$token=$this->gettoken();
		if($token){
			$url=$this->url_corppayble."/H2H/getinhouseinquiry?access_token=$token" ;
			$postParams['clientId']= $this->trx_cleintId;
			$postParams['accountNo']= $accountNo;
			$encript = $this->encrypt_data($postParams['clientId'].$postParams['accountNo']);
			$postParams['signature']= $encript;
			
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					//var_dump($curl_result);die();
					if(isset($curl_result->getInHouseInquiryResponse->parameters)){
						$parameters=$curl_result->getInHouseInquiryResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							$result['customerName']=$parameters->customerName;
							$result['accountCurrency']=$parameters->accountCurrency;
							$result['accountNumber']=$parameters->accountNumber;
							$result['accountStatus']=$parameters->accountStatus;
							$result['accountType']=$parameters->accountType;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							$result['accountNo']=$parameters->accountNo;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='getInHouseInquiryResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		$this->log_api($postParams,$response_msg,'get_balance');
		return $response_msg;
	}
	
	function dopayment($creditAccountNo,$valueAmount,$remark,$beneficiaryEmailAddress){
		$token=$this->gettoken();
		if($token){
			$url=$this->url_corppayble."/H2H/dopayment?access_token=$token" ;
				$postParams['clientId']= $this->trx_cleintId;
				$postParams['customerReferenceNumber']= $this->genReferenceNumber();
				$postParams['paymentMethod']= '0';//‘0’ : In-house (antar rekening BNI) ‘1’ : Kliring transfer
				$postParams['debitAccountNo']= $this->accountNum; //valdo account number
				$postParams['creditAccountNo']= $creditAccountNo;
				$postParams['valueDate']= date('YmdHis');
				$postParams['valueCurrency']= 'IDR';
				$postParams['valueAmount']= $valueAmount;
				$postParams['remark']= $remark;
				$postParams['beneficiaryEmailAddress']= $beneficiaryEmailAddress; //(wajib diisi jika paymentmethod =1
				$postParams['destinationBankCode']= ''; //(wajib diisi jika paymentmethod =1
				$postParams['beneficiaryName']= ''; //(wajib diisi jika paymentmethod =1
				$postParams['beneficiaryAddress1']= ''; //(wajib diisi jika paymentmethod =1
				$postParams['beneficiaryAddress2']= ''; //(wajib diisi jika paymentmethod =1
				$postParams['chargingModelId']= ''; //(wajib diisi jika paymentmethod =1
				$encript = $this->encrypt_data($postParams['clientId'].$postParams['customerReferenceNumber']
							.$postParams['paymentMethod'].$postParams['debitAccountNo'].$postParams['creditAccountNo']
							.$postParams['valueAmount'].$postParams['valueCurrency']);
				$postParams['signature']= $encript;
				
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					//var_dump($curl_result);die();
					if(isset($curl_result->doPaymentResponse->parameters)){
						$parameters=$curl_result->doPaymentResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$result['debitAccountNo']=$parameters->debitAccountNo;
							$result['creditAccountNo']=$parameters->creditAccountNo;
							$result['valueAmount']=$parameters->valueAmount;
							$result['valueCurrency']=$parameters->valueCurrency;
							$result['bankReference']=$parameters->bankReference;
							$result['customerReference']=$parameters->customerReference;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
							//insert bni_inhouse_corppayble
							$this->corp_payment($postParams,$result['responseCode'],$result['responseMessage'],$result['responseTimestamp'],$result['bankReference']);
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$result['debitAccountNo']=$parameters->debitAccountNo;
							$result['creditAccountNo']=$parameters->creditAccountNo;
							$result['valueAmount']=$parameters->valueAmount;
							$result['valueCurrency']=$parameters->valueCurrency;
							$result['customerReference']=$parameters->customerReference;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='doPaymentResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		
		//insert Log
		$this->log_api($postParams,$response_msg,'get_balance');
		
		return $response_msg;
	}
	
	function getinterbankinquiry($destinationBankCode,$destinationAccountNum){
		$token=$this->gettoken();
		//var_dump($token);die();
		if($token){
			$url=$this->url_corppayble."/H2H/getinterbankinquiry?access_token=$token" ;
			$postParams['clientId']= $this->trx_cleintId;
			$postParams['customerReferenceNumber']=$this->genReferenceNumber();
			$postParams['accountNum']= $this->accountNum;
			$postParams['destinationBankCode']= $destinationBankCode;
			$postParams['destinationAccountNum']= $destinationAccountNum;
			$encript = $this->encrypt_data($postParams['clientId'].$postParams['destinationBankCode'].
											$postParams['destinationAccountNum'].$postParams['accountNum']);
			$postParams['signature']= $encript;
			//var_dump($postParams);die();
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					//var_dump($curl_result);die();
					if(isset($curl_result->getInterbankInquiryResponse->parameters)){
						$parameters=$curl_result->getInterbankInquiryResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$result['destinationAccountNum']=$parameters->destinationAccountNum;
							$result['destinationAccountName']=$parameters->destinationAccountName;
							$result['destinationBankName']=$parameters->destinationBankName;
							$result['retrievalReffNum']=$parameters->retrievalReffNum;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='getInterbankInquiryResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		//insert LOG
		$this->log_api($postParams,$response_msg,'get_balance');
		return $response_msg;
	}
	
	function getinterbankpayment($amount,$destinationAccountNum,$destinationAccountName,$destinationBankCode,$destinationBankName,$retrievalReffNum){
		$token=$this->gettoken();
		//var_dump($token);die();
		if($token){
			$url=$this->url_corppayble."/H2H/getinterbankpayment?access_token=$token" ;
			$post['clientId']= $this->trx_cleintId;
			$post['customerReferenceNumber']= $this->genReferenceNumber();
			$post['amount']= $amount;
			$post['destinationAccountNum']= $destinationAccountNum;
			$post['destinationAccountName']= $destinationAccountName;
			$post['destinationBankCode']= $destinationBankCode;
			$post['destinationBankName']= $destinationBankName;
			$post['accountNum']= $this->accountNum;
			$post['retrievalReffNum']= $retrievalReffNum;
			
			$encript = $this->encrypt_data($post['clientId'].$post['destinationAccountNum'].$post['destinationBankCode'].$post['accountNum'].$post['amount'].$post['retrievalReffNum']);
			$post['signature']= $encript;
			
			//var_dump($postParams);die();
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					var_dump($curl_result);die();
					if(isset($curl_result->getInterbankPaymentResponse->parameters)){
						$parameters=$curl_result->getInterbankPaymentResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$result['destinationAccountNum']=$parameters->destinationAccountNum;
							$result['destinationAccountName']=$parameters->destinationAccountName;
							$result['customerReffNum']=$parameters->customerReffNum;
							$result['accountName']=$parameters->accountName;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='getInterbankPaymentResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		//insert LOG
		$this->log_api($postParams,$response_msg,'get_balance');
		return $response_msg;
	}
	
	function getpaymentstatus($customerReferenceNumber){
		$token=$this->gettoken();
		//var_dump($token);die();
		if($token){
			$url=$this->url_corppayble."/H2H/getpaymentstatus?access_token=$token" ;
			$postParams['clientId']= $this->trx_cleintId;
			$postParams['customerReferenceNumber']= $customerReferenceNumber;
			$encript = $this->encrypt_data($postParams['clientId'].$postParams['customerReferenceNumber']);
			$postParams['signature']= $encript;
			
			//var_dump($postParams);die();
			$curl_post=$this->curl_post($url,json_encode($postParams));
			if($curl_post['status']=='ok'){
				$curl_result=json_decode($curl_post['result']);
				if($curl_result){
					var_dump($curl_result);die();
					if(isset($curl_result->getInterbankInquiryResponse->parameters)){
						$parameters=$curl_result->getInterbankInquiryResponse->parameters;
						$result['responseCode']=$parameters->responseCode;
						$result['responseMessage']=$parameters->responseMessage;
						if($result['responseCode']=='0001'){
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$result['previousResponse']['transactionStatus']=$parameters->previousResponse->transactionStatus;
							
							
							$result['destinationAccountName']=$parameters->destinationAccountName;
							$result['destinationBankName']=$parameters->destinationBankName;
							$result['retrievalReffNum']=$parameters->retrievalReffNum;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['responseMessage'];
							$response_msg['result']=$result;
							
						}else{
							$result['errorMessage']=$parameters->errorMessage;
							$result['responseTimestamp']=$parameters->responseTimestamp;
							
							$response_msg['is_error']='0';
							$response_msg['response_msg']=$result['errorMessage'];
							$response_msg['result']=$result;
						}
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='getInterbankInquiryResponse->parameters N/A';
						$response_msg['result']=$curl_result;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='json_decode Error';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$curl_post;
				$response_msg['result']=[];
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='gettoken return false';
			$response_msg['result']=[];
		}
		//insert LOG
		$this->log_api($postParams,$response_msg,'get_balance');
		return $response_msg;
	}
	
	function corp_payment($request,$responseCode,$responseMessage,$responseTimestamp,$bankReference){
		$data['customer_reference_number']= $request['customerReferenceNumber'];
		$data['payment_method']= $request['paymentMethod'];
		$data['debit_account_no']= $request['debitAccountNo'];
		$data['credit_account_no']= $request['creditAccountNo'];
		$data['value_date']= $request['valueDate'];
		$data['value_currency']= $request['valueCurrency'];
		$data['value_amount']= $request['valueAmount'];
		$data['remark']= $request['remark'];
		$data['beneficiary_email_address']= $request['beneficiaryEmailAddress'];
		$data['destination_bank_code']= $request['destinationBankCode'];
		$data['beneficiary_name']= $request['beneficiaryName'];
		$data['beneficiary_address1']= $request['beneficiaryAddress1'];
		$data['beneficiary_address2']= $request['beneficiaryAddress2'];
		$data['charging_modelId']= $request['chargingModelId'];
		
		$data['response_code']=$responseCode;
		$data['response_message']=$responseMessage;
		$data['response_timestamp']=$responseTimestamp;
		$data['bank_reference']=$bankReference;
		
		$data['createon']= date('Y-m-d H:i:s');
		
		if($this->db->insert('bni_inhouse_corppayble',$data)){
			return true;
		}
		
		return false;
		
	}
	
	function corp_interbank_payment($request,$response){
		$data['customer_reference_number']= $request['customerReferenceNumber'];
		$data['amount']= $request['amount'];
		$data['destination_account_no']= $request['destinationAccountNum'];
		$data['destination_account_name']= $request['destinationAccountName'];
		$data['destination_bank_code']= $request['destinationBankCode'];
		$data['destination_bank_name']= $request['destinationBankName'];
		$data['account_no']= $request['accountNum'];
		$data['retrieval_reff_num']= $request['retrievalReffNum'];
		
		$data_response = json_decode($response['result']);
		
		if(!isset($data_response->getInterbankPaymentResponse->parameters->responseMessage))
			return false;
		
		$data['status_transaksi']= $data_response->getInterbankPaymentResponse->parameters->responseMessage;
		$data['status_code']= $data_response->getInterbankPaymentResponse->parameters->responseCode;
		$data['createon']= date('Y-m-d H:i:s');
		
		if($this->db->insert('bni_interbank_corppayble',$data)){
			return true;
		}
		
		return false;
		
	}
	
	function log_api($request,$response,$type,$user_id=''){
		$data['api_request']=json_encode($request);
		$data['api_response']=json_encode($response);
		$data['transtype']= $type;
		$data['user_id']= $user_id;
		$data['create_on']= date('Y-m-d H:i:s');
		$this->db->insert('bni_log_corppayble',$data);
		
	}
	
	
	function genReferenceNumber(){
		$t = microtime(true);
		$micro = sprintf("%06d", ($t - floor($t)) * 1000000);
		$d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

		return $d->format("YmdHisu"); 
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
