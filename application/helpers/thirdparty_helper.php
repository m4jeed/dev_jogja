<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

if ( ! function_exists('MASendSms'))
{
	function MASendSms($telepon,$message) {
		$url = 'https://reguler.zenziva.net/apps/smsapi.php';
		$userkey='gose74';
		$passkey='q2w3e4r5t6y666';
		
		$curlHandle = curl_init();
		
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
		curl_setopt($curlHandle, CURLOPT_POST, 1);
		
		$result = curl_exec($curlHandle);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($curlHandle));
        }

        // Close connection
        curl_close($curlHandle);
        return $result;
		
		
    }
}


if ( ! function_exists('send_notif'))
{
	function send_notif ($tokens, $message)
	{
		try {
			$url = 'https://fcm.googleapis.com/fcm/send';

			$msg = array
			(
				'body' 	=> "$message",
				'title'		=> "Gerai@ccess",
				'sound'		=> 'default'

				);
				
			$fields = array
			(
				'registration_ids' 	=> $tokens,
				'notification'			=> $msg
				);


			$headers = array(
				'Authorization:key = AIzaSyDM6GPYiskAiNpWHL4fK1K0o-y4RVap5nE',
				'Content-Type: application/json'
				);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			
			$result = curl_exec($ch);           
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			curl_close($ch);

		}catch(\Exception $e) {
            $result =  $e->getMessage();
        }

        return $result;
	}

}



?>
