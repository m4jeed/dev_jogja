<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_vacc extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
		$this->pageSize=10;
		$this->ma_server=$this->config->item('ma_server');
		$this->url_mutasi_vacc=$this->ma_server.'api/trans/mutasi';
		$this->url_inquiry_vacc=$this->ma_server.'api/account/inquiry';
		$this->url_register_vacc=$this->ma_server.'api/account/register';
		$this->url_change_profile=$this->ma_server.'api/account/change_profile';
		$this->url_user_detail=$this->ma_server.'api/account/user_detail';
		$this->url_transfer_vacc=$this->ma_server.'api/trans/transfer';
		$this->url_change_pin=$this->ma_server.'api/account/change_pin';
		$this->url_cek_pin=$this->ma_server.'api/account/cek_pin';
		$this->url_reset_pin=$this->ma_server.'api/account/reset_pin';
		$this->url_tarik_setor_tunai=$this->ma_server.'api/trans/history_request';
		$this->url_request_agent=$this->ma_server.'api/trans/request_agent';
		$this->url_agent_proccess=$this->ma_server.'api/trans/agent_proccess';
		$this->url_agent_proccess_cancel=$this->ma_server.'api/trans/agent_proccess_cancel';
		$this->url_biaya_transaksi=$this->ma_server.'api/trans/biaya_transaksi';
		$this->url_trans_detail=$this->ma_server.'api/trans/trans_detail';
		$this->url_refund=$this->ma_server.'api/trans/refund';
		$this->url_cek_pin=$this->ma_server.'api/account/cek_pin';
		$this->url_limit_fee=$this->ma_server.'api/trans/limit_fee';
		$this->url_klaim_poin=$this->ma_server.'api/trans/klaim_poin';
		
	}
	
	function get_mutasi_vacc($offset_post=0,$startDate='',$endDate='',$vaccNumber='',$trxType='',$trxStatus=''){
		/* if($offset_post==''){
			$offset=0;
		} */
		//$offset_post=0;
		$offset=(int)$offset_post/(int)$this->pageSize;
		$pageNumber=(int)$offset+1;
		$postParams=array(
						"pageNumber"=>$pageNumber,
						"pageSize"=>$this->pageSize,
						"startDate"=>$startDate,
						"endDate"=>$endDate,
						"vaccNumber"=>$vaccNumber,
						"trxType"=>$trxType,
						"trxStatus"=>$trxStatus,
						
					);

		$url=$this->url_mutasi_vacc;
		$response=curl_request_ma($url, json_encode($postParams));
		
		//var_dump($pageNumber);
		//var_dump($postParams);
		//var_dump($response);die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				
				$rows=$response_json['result']['rows'];
				//var_dump($rows);die();
				if($rows){
					$number=1;
					foreach($rows as $row){
						$res[] = [
							'itemno'=>(int)$offset_post+$number,
							'trx_id'=>$row['trx_id'],
							'vacc_number'=>$row['vacc_number'],
							'dk'=>$row['dk'],
							'trx_date'=>$row['trx_date'],
							'trx_desc'=>$row['trx_desc'],
							'amount'=>formatNomor($row['amount']),
							'saldo'=>formatNomor($row['saldo']),
							'trx_status'=>$row['trx_status'],
							'trx_type'=>$row['trx_type'],
							'type'=>'data',
							
						];
						$number++;
					}
				}else{
					$res=array();
				}
				
				//$response_msg['result']=$response_json['result'];
				
				$response_msg['result']=array('rows'=>$res
											,'row_per_page'=>$this->pageSize
											,'total_page'=>ceil((float)$response_json['result']['total_rows']/(float)$this->pageSize)
											,'total_rows'=>$response_json['result']['total_rows']
											);
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
		
	}
	
	function ma_trans_detil($trxId){
		$postParams=array(
						"trxId"=>$trxId
					);

		$url=$this->url_trans_detail;
		$response=curl_request_ma($url, json_encode($postParams));
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function ma_trans_refund($trxId){
		$postParams=array(
						"trxId"=>$trxId
					);

		$url=$this->url_refund;
		$response=curl_request_ma($url, json_encode($postParams));
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	
	function inquiry_vacc($vacc_number){
		$postParams=array(
						"vaccNumber"=>$vacc_number
					);

		$url=$this->url_inquiry_vacc;
		$response=curl_request_ma($url, json_encode($postParams));
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			
			$data_log['url']=$url;
			$data_log['request_post']=json_encode($postParams);
			$data_log['response']=$response['data'];
			$this->db->insert('log_request',$data_log);
			
			if($response_json['response_code']=='0'){
				if(isset($response_json['result']['fullname'])){
					$response_msg['is_error']='0';
					$response_msg['response_msg']=$response_json['response_message'];
					//var_dump($response_json['result']);die();
					if(isset($response_json['result']['vaccNumber'])){
						if(isset($response_json['result']['poin'])){
							if(isset($response_json['result']['balance'])){
								$response_msg['result']=array('fullname'=>$response_json['result']['fullname']
														,'vacc_number'=>$response_json['result']['vaccNumber']
														,'saldo'=>formatNomor($response_json['result']['balance'])
														,'poin'=>$response_json['result']['poin']
														,'saldo_numeric'=>$response_json['result']['balance']
														);
							}else{
								$response_msg['is_error']='1';
								$response_msg['response_msg']='Error Response MA balance';
								$response_msg['result']=[];
							}
							
						}else{
							$response_msg['is_error']='1';
							$response_msg['response_msg']='Error Response MA poin';
							$response_msg['result']=[];
						}
						
					}else{
						$response_msg['is_error']='1';
						$response_msg['response_msg']='Error Response MA vaccNumber';
						$response_msg['result']=[];
					}
					
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='Error Response MA Fullname';
					$response_msg['result']=[];
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function register_vacc($vaccNumber,$fullname,$email,$phone){
		$postParams=array(
						"vaccNumber"=>$vaccNumber,
						"fullname"=>$fullname,
						"email"=>$email,
						"phone"=>$phone
					);
		//var_dump($postParams);die();
		$url=$this->url_register_vacc;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($url);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function ma_user_detil($ma_user_id){
		$postParams=array(
						"usersDetailId"=>$ma_user_id
					);

		$url=$this->url_user_detail;
		$response=curl_request_ma($url, json_encode($postParams));
		
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				//var_dump($response_json['result']);die();
				$response_msg['result']=$response_json['result'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function change_profile($vaccNumber,$fullname,$email,$pob,$dob,$phone,$job,$address,$gender,$idCard,$locationId,$pin='',$mom=''){
		$postParams["vaccNumber"]=$vaccNumber;
		$postParams["fullname"]=$fullname;
		$postParams["email"]=$email;
		$postParams["pob"]=$pob;
		$postParams["dob"]=$dob;
		$postParams["mom"]=$mom;
		$postParams["phone"]=$phone;
		$postParams["job"]=$job;
		$postParams["address"]=$address;
		$postParams["gender"]=$gender;
		$postParams["idCard"]=$idCard;
		$postParams["idCardType"]="KTP";
		$postParams["locationID"]=$locationId;
		if($pin!=''){
			$postParams["pin"]=$pin;
		}
		//var_dump($postParams);die();
		$url=$this->url_change_profile;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($url);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}

	function transfer_vacc($transDesc,$fromVacc,$toVacc,$amount,$transType,$pin,$externalId,$adminFee,$bankFee,$agentFee,$poinReward,$trxAmount,$vaccReferal='',$voucherCode=''){
		$postParams=array(
						"transDesc"=>$transDesc,
						"fromVacc"=>$fromVacc,
						"toVacc"=>$toVacc,
						"amount"=>$amount,
						"transType"=>$transType,
						"pin"=>$pin,
						"externalId"=>$externalId,
						"adminFee"=>$adminFee,
						"bankFee"=>$bankFee,
						"agentFee"=>$agentFee,
						"poinReward"=>$poinReward,
						"trxAmount"=>$trxAmount,
						"vaccReferal"=>$vaccReferal,
						"voucherCode"=>$voucherCode,
					);

		$url=$this->url_transfer_vacc;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		
		/*
		array(2) {
		  ["status"]=>
		  string(2) "ok"
		  ["data"]=>
		  string(399) "{"result":true,"response_timestamp":"2017/12/18 12:29:25",
						"request":{"trxAmount":3090.0,"amount":3090.0,"bankFee":0.0,"fromVacc":"1000229","externalId":"","idTrx":32283,"adminFee":0.0,"vaccReferal":"","toVacc":"0","agentFee":0.0,"transType":"ppob","transDesc":"Pembelian THREE REGULER 3RB -- Rp.3,090, No.HP:08124656111","poinReward":0.0},
						"response_code":"0","response_message":"Transaksi berhasil"}"
		}
		*/
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function change_pin($vaccNumber,$oldPin,$newPin){
		$postParams=array(
						"vaccNumber"=>$vaccNumber,
						"oldPin"=>$oldPin,
						"newPin"=>$newPin,
						);

		$url=$this->url_change_pin;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function reset_pin($vaccNumber,$pin){
		$postParams=array(
						"vaccNumber"=>$vaccNumber,
						"pin"=>$pin
						);

		$url=$this->url_reset_pin;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function cek_pin($vaccNumber,$pin){
		$postParams=array(
						"vaccNumber"=>$vaccNumber,
						"pin"=>$pin
						);

		$url=$this->url_cek_pin;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function get_biaya_transaksi($settingName){
		$postParams=array(
						"settingName"=>$settingName
						);

		$url=$this->url_biaya_transaksi;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'][0]['val'];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function request_tarik_setor_tunai($trxType,$trxDesc,$custVaccNumber,$agentVaccNumber,$amount,$pin){
		$postParams=array(
						"trxType"=>$trxType,
						"trxDesc"=>$trxDesc,
						"custVaccNumber"=>$custVaccNumber,
						"agentVaccNumber"=>$agentVaccNumber,
						"amount"=>$amount,
						"note"=>'',
						"pin"=>$pin,
						);
		//var_dump($postParams);die();
		$url=$this->url_request_agent;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function proses_tarik_setor_tunai($trxId,$agentVaccNumber,$pin){
		$postParams=array(
						"trxId"=>$trxId,
						"agentVaccNumber"=>$agentVaccNumber,
						"pin"=>$pin
						);

		$url=$this->url_agent_proccess;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function cancel_tarik_setor_tunai($trxId,$agentVaccNumber,$pin){
		$postParams=array(
						"trxId"=>$trxId,
						"agentVaccNumber"=>$agentVaccNumber,
						"pin"=>$pin
						);

		$url=$this->url_agent_proccess_cancel;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	function get_tarik_setor_tunai($offset_post=0,$startDate='',$endDate='',$vaccNumber='',$trxType='',$trxStatus=''){
		if($offset_post==''){
			$offset=0;
		}
		$offset=(int)$offset_post/(int)$this->pageSize;
		$pageNumber=(int)$offset+1;
		//var_dump($pageNumber);die();
		$postParams=array(
						"pageNumber"=>$pageNumber,
						"pageSize"=>$this->pageSize,
						"startDate"=>$startDate,
						"endDate"=>$endDate,
						//"custVaccNumber"=>"",
						"agentVaccNumber"=>$vaccNumber,
						"trxType"=>$trxType,
						"trxStatus"=>$trxStatus
					);

		$url=$this->url_tarik_setor_tunai;
		$response=curl_request_ma($url, json_encode($postParams));
		
		//var_dump($pageNumber);
		//var_dump($response);die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				
				$rows=$response_json['result']['rows'];
				//var_dump($rows);die();
				if($rows){
					$number=1;
					foreach($rows as $row){
						$res[] = [
							'itemno'=>(int)$offset_post+$number,
							'trx_id'=>$row['trx_id'],
							//'vacc_number'=>$row['vacc_number'],
							//'to_vacc'=>$row['to_vacc'],
							'trx_date'=>$row['trx_date'],
							'trx_desc'=>$row['trx_desc'].' Sebesar Rp.'.formatNomor($row['amount']),
							//'agent_fee'=>formatNomor('0'),
							'agent_fee'=>formatNomor($row['agent_fee']),
							'total'=>formatNomor($row['amount']),
							//'trx_type'=>$row['trx_type'],
							'trx_status'=>strtoupper($row['trx_status']),
							'type'=>'data',
							
						];
						$number++;
					}
				}else{
					$res=array();
				}
				
				//$response_msg['result']=$response_json['result'];
				
				$response_msg['result']=array('rows'=>$res
											,'row_per_page'=>$this->pageSize
											,'total_rows'=>$response_json['result']['total_rows']
											);
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
		
	}
	
	function get_limit_fee(){
		$url=$this->url_limit_fee;
		$response=curl_request_ma($url);
		//var_dump($response);die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=$response_json['result'];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
		
	}
	
	function claim_poin($transDesc,$toVacc,$amount,$externalId,$pin){
		$postParams=array(
						"transDesc"=>$transDesc,
						"toVacc"=>$toVacc,
						"amount"=>$amount,
						"transType"=>'klaim_poin',
						"externalId"=>$externalId,
						"pin"=>$pin,
						);
						

		$url=$this->url_klaim_poin;
		$response=curl_request_ma($url, json_encode($postParams));
		//var_dump($postParams);
		//var_dump($response);
		//die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if($response_json['response_code']=='0'){
				$response_msg['is_error']='0';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
				
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']=$response_json['response_message'];
				$response_msg['result']=[];
			}
			
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']=$response['data'];
			$response_msg['result']=[];
		}
		
		return $response_msg;
	}
	
	
	
	
	
}

