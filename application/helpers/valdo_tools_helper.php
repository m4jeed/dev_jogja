<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');


if(!function_exists('strip_validation_msg'))
{
    function strip_validation_msg($string){
		$string=str_replace('<p>','',validation_errors());
		$string=str_replace('</p>','',$string);
		return $string;
	}
}

if ( ! function_exists('strip_err_msg'))
{
	function strip_err_msg($error_message) {
		$error_message  = str_replace('<p>','', $error_message);
		$error_message  = str_replace('</p>','', $error_message); 
		return $error_message;
    }
}

if(!function_exists('formatNomor'))
{
    function formatNomor($number) 
    {
		return number_format($number,0);
    }
}

if ( ! function_exists('getRealClientIP'))
{
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
}

if ( ! function_exists('get_token'))
{
	function get_token(){
		$headers=array();
		//$ret='';
		foreach (getallheaders() as $name => $value) {
			if(strtolower($name)=='authorization'){
				$ret=$value;
			} 
		}
		
		if(isset($ret)){
			$arr_ret=explode(' ',$ret);
			if(isset($arr_ret[1])){
				$token=$arr_ret[1];
			}else{
				$token='';
			}
		}else{
			$token='';
		}
		
		return $token;
	}
}
if ( ! function_exists('pretty_va'))
{
	
	function pretty_va($va,$format='-')
	{
		$n = strlen($va);
		if($n==5)
			return $va;
		
		$arr = array();
		if(!is_float($n/4)){
			$dev = $n/4;
			$t = $n;
			for($i=1;$i<=$dev;$i++){
				$arr[$i] = $t-4;
				$t = $arr[$i];
			}
		}else{
			$dev = $n/3;
			$t = $n;
			for($i=1;$i<=$dev;$i++){
				$arr[$i] = $t-3;
				$t = $arr[$i];
			}
		}
		
		for($i=1;$i<=$dev;$i++){
			if($arr[$i]>3){
				$va = substr_replace($va,$format,$arr[$i],0);
			}
		}
		
		return $va;
	}
	
}

if ( ! function_exists('randomString'))
{
	
	function randomString($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));

		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return strtoupper($key);
	}
	
}



if(!function_exists('tglPhpToDB'))
{
    function tglPhpToDB($tgl) 
    {
		if($tgl==''){
			$res='1900-01-01';
		}else{
			$arr=explode('-',$tgl);
			$res=$arr[2].'-'.$arr[1].'-'.$arr[0];
        }
		
		$res=str_replace(" ","",$res);
		
		return $res;
    }
}

if(!function_exists('tglDBToPhp'))
{
    function tglDBToPhp($tgl) 
    {
		if($tgl=='1900-01-01'){
			$res='';
		}elseif($tgl==''){
			$res='';
		}else{
			$arr=explode('-',$tgl);
			$res=$arr[2].'-'.$arr[1].'-'.$arr[0];
        }
		
		$res=str_replace(" ","",$res);
		
		return $res;
    }
}

if(!function_exists('generateCode'))
{
    function generateCode() 
    {
		$microtime=microtime(true);
		return round($microtime*10000);
    }
}


?>
