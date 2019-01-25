<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_id_biller extends CI_Model {
 
	public function __construct() 
	{
		parent::__construct();
		
		//tes timeout
		//sleep(10);
		
		$env='PRD';
		
		$this->MitraId='VIT62395';
		$this->MitraKey='VIT28835563082061418650225898656268';
		
		$this->BalanceService_dev="http://103.29.214.185:7789/api_json_dev/APIBalanceService.php";
		$this->DataTransactionService_dev="http://103.29.214.185:7789/api_json_dev/APIDataTransactionService.php";
		$this->PriceService_dev="http://103.29.214.185:7789/api_json_dev/APIPriceService.php";
		$this->TopupService_dev="http://103.29.214.185:7789/api_json_dev/APITopupService.php";
		$this->InquiryService_dev="http://103.29.214.185:7789/api_json_dev/APIInquiryService.php";
		$this->PaymentService_dev="http://103.29.214.185:7789/api_json_dev/APIPaymentService.php";
		
		$this->BalanceService_pro="http://103.29.214.185:7789/api_json_pro/APIBalanceService.php";
		$this->DataTransactionService_pro="http://103.29.214.185:7789/api_json_pro/APIDataTransactionService.php";
		$this->PriceService_pro="http://103.29.214.185:7789/api_json_pro/APIPriceService.php";
		$this->TopupService_pro="http://103.29.214.185:7789/api_json_pro/APITopupService.php";
		$this->InquiryService_pro="http://103.29.214.185:7789/api_json_pro/APIInquiryService.php";
		$this->PaymentService_pro="http://103.29.214.185:7789/api_json_pro/APIPaymentService.php";
		
		if($env=='DEV'){
			$this->BalanceService=$this->BalanceService_dev;
			$this->DataTransactionService=$this->DataTransactionService_dev;
			$this->PriceService=$this->PriceService_dev;
			$this->TopupService=$this->TopupService_dev;
			$this->InquiryService=$this->InquiryService_dev;
			$this->PaymentService=$this->PaymentService_dev;
		}elseif($env=='PRD'){
			$this->BalanceService=$this->BalanceService_pro;
			$this->DataTransactionService=$this->DataTransactionService_pro;
			$this->PriceService=$this->PriceService_pro;
			$this->TopupService=$this->TopupService_pro;
			$this->InquiryService=$this->InquiryService_pro;
			$this->PaymentService=$this->PaymentService_pro;
		}else{
			echo '404';
			die();
		}
		
	}
	
	function balance_service(){
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'BalanceService'.$this->MitraKey),
							"RequestMethod" => "BalanceService",
							);
		$url=$this->BalanceService;
		//var_dump($url);die();
		$response = $this->get_content($url, json_encode($request_data));
		
		//create_log
		$this->idbiller_log($request_data,$response);
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['Rc']=='00'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=array('saldo'=>$response_json['Saldo']);
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		//$this->idbiller_log($log_request,$log_response);
		return $response_msg;
		
	}
	
	function data_transaction_service($RefNumber,$StartDate,$EndDate,$Limit){
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'DataTransactionService'.$this->MitraKey),
							"RequestMethod" => "DataTransactionService",
							"RefNumber" => $RefNumber,
							"StartDate"	=> $StartDate,
							"EndDate"	=> $EndDate,
							"Limit" 	=> $Limit
							);
		
		$url=$this->DataTransactionService;
		$response = $this->get_content($url, json_encode($request_data));
		
		//create_log
		$this->idbiller_log($request_data,$response);
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['Rc']=='00'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=$response_json;
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
							
	}
	
	function price_service($Model){ //"PULSA", "DATA", "GAME", "VOUCHER"
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'PriceService'.$this->MitraKey),
							"RequestMethod" => "PriceService",
							"Model" => $Model,
							);
							
		$url=$this->PriceService;
		$response = $this->get_content($url, json_encode($request_data));
		
		//create_log
		$this->idbiller_log($request_data,$response);
		
		//return $response;die();
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['Rc']=='00'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=$response_json['DataProviders'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function TopupService($Model,$ProductCode,$CustomerNumber1,$user_id=''){//model=>"PULSA", "DATA", "GAME", "VOUCHER"
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'TopupService'.$this->MitraKey),
							"RequestMethod" => "TopupService",
							"Model" => $Model,
							"ProductCode" => $ProductCode,
							"CustomerNumber1" => $CustomerNumber1,
							);
							
		$url=$this->TopupService;
		$response = $this->get_content($url, json_encode($request_data));
		
		//var_dump($response);die();
		//create_log
		$this->idbiller_log($request_data,$response,$user_id);
		
		//return $response;die();
		$send_email_error=false;
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			//return $response_json;die();
			if($response_json['Rc']=='00'){
					$response_msg['Rc']=$response_json['Rc'];
					$response_msg['is_error']='0';
					$response_msg['response_msg']=$response_json['Description'];//'Transaksi Berhasil';//
					$response_msg['result']=$response_json;
				
			}elseif($response_json['Rc']=='01'){
					$response_msg['Rc']=$response_json['Rc'];
					$response_msg['is_error']='0';
					$response_msg['response_msg']=$response_json['Description'];//'Transaksi sedang diproses';//
					$response_msg['result']=$response_json;
					//$send_email_error=true;
			}else{
				$response_msg['Rc']=$response_json['Rc'];
				$response_msg['is_error']='1';
				//$response_msg['is_error']='0';
				//$response_msg['response_msg']='-Transaksi sedang diproses';//$response_json['Description'];
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=[];
				$send_email_error=true;
			}
			
		}else{
			$response_msg['Rc']='';
			$response_msg['is_error']='1';
			//$response_msg['is_error']='0';
			//$response_msg['response_msg']='-Transaksi sedang diproses';//$response['data'];
			$response_msg['response_msg']='Koneksi Error';//$response['data'];
			$response_msg['result']=[];
			$send_email_error=true;
		}
		
		if($send_email_error==true){
			
			//send email ----------------------
			$this->load->library('lib_phpmailer');
			$to='fauzipane81@gmail.com';
			$subject='Alert PPOB '.$Model.' '.$ProductCode;
			$msg='<html>
				<head></head>
				<body>
				Request=>'.json_encode($request_data).'</br>
				Response=>'.json_encode($response_msg['result']).'</br>
				
				</body>
				<html>';
			$this->lib_phpmailer->send_email($to,$subject,$msg,false);
			
			//------------------------------------
		 
		}
		
		return $response_msg;
	}
	
	function InquiryService($ProductCode,$CustomerNumber1,$CustomerNumber2,$CustomerNumber3,$Misc){
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'InquiryService'.$this->MitraKey),
							"RequestMethod" => "InquiryService",
							"ProductCode"     => $ProductCode,
							"CustomerNumber1" => $CustomerNumber1,
							"CustomerNumber2" => $CustomerNumber2,
							"CustomerNumber3" => $CustomerNumber3,
							"Misc" 		  => $Misc
							);
							
		$url=$this->InquiryService;
		$response = $this->get_content($url, json_encode($request_data));
		
		//create_log
		$this->idbiller_log($request_data,$response);
		//var_dump($response);die();
		///print_r($response['data']);die();
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['Rc']=='00'||$response_json['Rc']=='01'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=$response_json;
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['Description'];
				$response_msg['result']=[];
				
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
		
	}
	
	function PaymentService($ProductCode,$CustomerNumber1,$CustomerNumber2,$CustomerNumber3,$Nominal,$RefNumber,$Misc,$user_id=''){
		$request_data=array("MitraId"=> $this->MitraId,
							"MitraKey" => md5($this->MitraId.'PaymentService'.$this->MitraKey),
							"RequestMethod" => "PaymentService",
							"ProductCode"     => $ProductCode,
							"CustomerNumber1" => $CustomerNumber1,
							"CustomerNumber2" => $CustomerNumber2,
							"CustomerNumber3" => $CustomerNumber3,
							"Nominal"         => $Nominal,
							"RefNumber"       => $RefNumber,	
							"Misc" 		  => $Misc
							);
							
		$url=$this->PaymentService;
		$response = $this->get_content($url, json_encode($request_data));
		
		//create_log
		$this->idbiller_log($request_data,$response,$user_id);
		
		//return $response;die();
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['Rc']=='00'||$response_json['Rc']=='01'){
					$response_msg['is_error']='0';
					$response_msg['response_msg']='Transaksi Berhasil';//$response_json['Description'];
					$response_msg['result']=$response_json;
				
			}elseif($response_json['Rc']=='01'||$response_json['Rc']=='01'){
					$response_msg['is_error']='0';
					$response_msg['response_msg']='Transaksi sedang diproses';//$response_json['Description'];
					$response_msg['result']=$response_json;
				
			}else{
				$response_msg['is_error']='1';
				//$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['Description'];
				//$response_msg['response_msg']='-Transaksi sedang diproses';//$response_json['Description'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			//$response_msg['is_error']='0';
			//$response_msg['response_msg']='-Transaksi sedang diproses';//$response['data'];
			$response_msg['response_msg']='Koneksi Error';//$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
		
	}
	
	
	function insert_idbiller_bill($data){
		$this->db->insert('idbiller_bill',$data);
		return $this->db->insert_id() ;
	}
	
	function get_idbiller_bill($user_id,$bill_id,$ref_number){
		$sql="select * from idbiller_bill where user_id=? and bill_id=? and ref_number=?";
		$q=$this->db->query($sql,array($user_id,$bill_id,$ref_number));
		return $q->row_array();
	}
	
	function idbiller_log($log_request,$log_response,$user_id=''){
		$data['log_request']=json_encode($log_request);
		$data['log_response']=json_encode($log_response);
		$data['log_time']=date('Y-m-d H:i:s');
		$data['log_by']=$user_id;
		$data['log_ip']=$this->getRealClientIP();
		$this->db->insert('idbiller_log',$data);
	}
	
	
	
	function getRealClientIP() {
		$ipaddress = '';
		if (@$_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = @$_SERVER['HTTP_CLIENT_IP'];
		else if(@$_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(@$_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = @$_SERVER['HTTP_X_FORWARDED'];
		else if(@$_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = @$_SERVER['HTTP_FORWARDED_FOR'];
		else if(@$_SERVER['HTTP_FORWARDED'])
			$ipaddress = @$_SERVER['HTTP_FORWARDED'];
		else if(@$_SERVER['REMOTE_ADDR'])
			$ipaddress = @$_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
	
	function get_content($url, $post = '') {
		//$usecookie = __DIR__ . "/cookie.txt";
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
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

		if ($post)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);

		if(empty($rs)){
			$err=curl_error($ch);
			//var_dump($rs, curl_error($ch));
			curl_close($ch);
			//return false;
			return array('status'=>'error','data'=>'Curl Err.'.$err);
		}
		curl_close($ch);
		return array('status'=>'ok','data'=>$rs);
	}
	
	
	
}
