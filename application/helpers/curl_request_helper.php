<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');


if ( ! function_exists('curl_request'))
{
	function curl_request($url, $postParams = '',$data_type='json') {
		//$usecookie = __DIR__ . "/cookie.txt";
		if($data_type=='json'){
			$header[] = 'Content-Type: application/json';
		}elseif($data_type=='x-www-form-urlencoded'){
			$header[] = 'Content-Type: application/x-www-form-urlencoded';
		}
		//$header[] = 'Content-Type: application/x-www-form-urlencoded';
		//$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";
		$header[] = "apigatekey: webKEY123456789";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		//curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

		if ($postParams)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);
		//$info = curl_getinfo($ch);
		/* print_r($info['request_header']);
		print_r($info);
		curl_close($ch);
		die(); */
		if(empty($rs)){
			$err=curl_error($ch);
			curl_close($ch);
			return array('status'=>'error','data'=>'Curl Err.'.$err);
		}
		curl_close($ch);
		return array('status'=>'ok','data'=>$rs);
	}
}

if ( ! function_exists('curl_request_ma'))
{
	function curl_request_ma($url, $postParams = '') {
		$CI =& get_instance();
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
		//curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $CI->config->item('ma_username') . ":" . $CI->config->item('ma_password'));
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

		if ($postParams)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);
		//$info = curl_getinfo($ch);
		/* print_r($info['request_header']);
		print_r($info);
		curl_close($ch);
		die(); */
		if(empty($rs)){
			$err=curl_error($ch);
			curl_close($ch);
			var_dump($err);
			return array('status'=>'error','data'=>'Curl Err.'.$err);
		}
		curl_close($ch);
		return array('status'=>'ok','data'=>$rs);
	}
}



?>
