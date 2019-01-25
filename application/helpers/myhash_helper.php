<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');


if(!function_exists('myhash'))
{
	function myhash($pass,$salt) 
	{
		$pass=md5($pass);
		$salt=md5($salt);
		
		$result=substr($pass,0,3).substr($salt,0,3).substr($pass,3).substr($salt,3);
		$result=md5($result);
		
		return $result;
	}
}

?>
