<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_bni_ecol extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
		$env='PRD';
		
		if($env=='DEV'){
			$this->client_id = $this->config->item('dev_ecol_client_id');
			$this->secret_key = $this->config->item('dev_ecol_secret_key');
			$this->url = $this->config->item('dev_ecol_url');
		}elseif($env=='PRD'){
			$this->client_id = $this->config->item('prd_ecol_client_id');
			$this->secret_key = $this->config->item('prd_ecol_secret_key');
			$this->url = $this->config->item('prd_ecol_url');
		}else{
			echo '404';
			die();
		}
		
	}
	
	
	function get_topup_history($user_id,$limit,$offset){
		$sql="SELECT * FROM bni_payment_request where user_id=? order by ids DESC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($user_id,(int)$limit,(int)$offset));
		return $q->result_array(); 
	}
	
	function count_topup_history($user_id){
		$sql="SELECT count(*) as jumlah FROM bni_payment_request where user_id=?";
		$q=$this->db->query($sql,array($user_id));
		return $q->row()->jumlah; 
	}
	
	public function payment_request($trx_total,$customer_name,$customer_email,$customer_phone,$description,$admin_fee,$trx_amount){
		// FROM BNI
		$client_id = $this->client_id; 
		$secret_key =$this->secret_key; 
		$url = $this->url; 
		$trx_id=date('ymdhis').mt_rand(20000,99999);
		
		$request_data = array(
							'client_id' => $client_id,
							'trx_id' => $trx_id, // fill with Billing ID
							'trx_amount' => $trx_total,
							'billing_type' => 'c',
							'datetime_expired' => date('c', time() + (3600*24)), // billing will be expired in 24 hours
							'virtual_account' => '',
							'customer_name' => $customer_name,
							'customer_email' => $customer_email,
							'customer_phone' => $customer_phone,
							'type' => 'createBilling',
							'description' => $description
						);
		//var_dump($request_data);
		//var_dump($client_id);
		//var_dump($secret_key);
		//die();
		$hashed_string = BniHashing::hashData(
											$request_data,
											$client_id,
											$secret_key
										);
		//var_dump($hashed_string);die();
		$data = array(
					'client_id' => $client_id,
					'data' => $hashed_string,
				);
		$response = $this->get_content($url, json_encode($data));
		
		//insert log e-coll request
		$data_log['transtype']='payment_request';
		$data_log['api_request']=json_encode(array('url'=>$url,'request_data'=>$request_data));
		$data_log['api_response']=json_encode($response);
		$data_log['create_on']=date('Y-m-d H:i:s');
		$this->db->insert('bni_log_ecol',$data_log);
		
		//var_dump($response);die();
		if($response['status']=='ok'){
			$response_json = json_decode($response['data'], true);
			if ($response_json['status'] !== '000') {
				// handling jika gagal
				return array('status'=>'error',
							'data'=>$response_json['status'].' - '.$response_json['message']);
			}else {
				$data_response = BniHashing::parseData($response_json['data'], $client_id, $secret_key);
				$this->insert_payment_request($request_data,$data_response,$admin_fee,$trx_amount);
				
				$data_topup_history['user_id']=$this->user_id;
				$data_topup_history['uniqid']=0;
				$data_topup_history['bank']='BNI';
				$data_topup_history['norek']=$data_response['virtual_account'];
				$data_topup_history['amount']=$request_data['trx_amount'];
				$data_topup_history['admin_fee']=$admin_fee;
				$data_topup_history['trx_id']=$request_data['trx_id'];
				$data_topup_history['trx_status']='pending';
				$data_topup_history['topup_type']='va';
				$data_topup_history['expired_on']=date('Y-m-d H:i:s', strtotime($request_data['datetime_expired']));
				$data_topup_history['created_on']=date('Y-m-d H:i:s');
				$data['created_by']=$this->user_id;
				//var_dump($data_topup_history);die();
				$cek=$this->db->insert('ma_topup_history',$data_topup_history);
				
				return array('status'=>'ok',
							'data'=>array('trx_id'=>$data_response['trx_id']
											,'virtual_account'=>$data_response['virtual_account'])
								);
			}
		}else{
			return array('status'=>'error',
							'data'=>'Req BNI Gagal');
		}
	}
	
	function insert_payment_request($request_data,$data_response,$admin_fee='0',$amount='0'){
		$data=array('type'=>$request_data['type']
					,'client_id'=>$request_data['client_id']
					,'trx_id'=>$request_data['trx_id']
					,'trx_amount'=>$request_data['trx_amount']
					,'billing_type'=>$request_data['billing_type']
					,'customer_name'=>$request_data['customer_name']
					,'customer_email'=>$request_data['customer_email']
					,'customer_phone'=>$request_data['customer_phone']
					,'virtual_account'=>$data_response['virtual_account']
					,'datetime_expired'=>date('Y-m-d H:i:s', strtotime($request_data['datetime_expired']))
					,'datetime_expired_iso8601'=>$request_data['datetime_expired']
					,'description'=>$request_data['description']
					,'createon'=>date('Y-m-d H:i:s')
					,'createby'=>getRealClientIP()
					,'flag_paid'=>'N'
					,'status'=>'pending'
					,'user_id'=>$this->userid
					,'admin_fee'=>$admin_fee
					,'amount'=>$amount
					);
		$this->db->insert('bni_payment_request',$data);
	}
	
	
	public function get_content($url, $post = '') {
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
	// URL utk simulasi pembayaran: http://dev.bni-ecollection.com/
	
	
}
