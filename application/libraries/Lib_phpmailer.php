<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;

require APPPATH . 'libraries/phpmailer/vendor/autoload.php';
class Lib_phpmailer {

  function send_email($to,$subject,$body_message)
  {
    
		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		//Tell PHPMailer to use SMTP
		//$mail->isSMTP();
		
		$mail->isMail();
		
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		//$mail->Username = "it.supp.valdo@gmail.com";
		$mail->Username = "service@geraiaccess.co.id";

		//Password to use for SMTP authentication
		//$mail->Password = "bedon123";
		$mail->Password = "geraijarimu1127";

		//Set who the message is to be sent from
		$mail->setFrom('service@geraiaccess.co.id', 'Service GeraiAccess');

		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		//$mail->addAddress('fauzipane81@gmail.com', 'Fauzi Pane');
		$mail->addAddress($to);

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		/*
		$body_message='<html>
						<head></head>
						<body>
							<a href="http://google.com">google</a>
						</body>
						</html>
						';
		*/
		$mail->msgHTML($body_message);

		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		//$mail->send();
		
		if (!$mail->send()) {
			return false;
			//return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return true;
			//return "Message sent!";
			//Section 2: IMAP
			//Uncomment these to save your message in the 'Sent Mail' folder.
			#if (save_mail($mail)) {
			#    echo "Message saved!";
			#}
		}
		
		
	}
  
	function send_email_nospam($to,$subject,$body_message)
	{
		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		//$mail->Username = "it.supp.valdo@gmail.com";
		$mail->Username = "service@geraiaccess.co.id";

		//Password to use for SMTP authentication
		//$mail->Password = "bedon123";
		$mail->Password = "geraijarimu1127";

		//Set who the message is to be sent from
		$mail->setFrom('service@geraiaccess.co.id', 'Service GeraiAccess');

		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		//$mail->addAddress('fauzipane81@gmail.com', 'Fauzi Pane');
		$mail->addAddress($to);

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		/*
		$body_message='<html>
						<head></head>
						<body>
							<a href="http://google.com">google</a>
						</body>
						</html>
						';
		*/
		$mail->msgHTML($body_message);

		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		//$mail->send();
		
		if (!$mail->send()) {
			return false;
			//return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return true;
			//return "Message sent!";
			//Section 2: IMAP
			//Uncomment these to save your message in the 'Sent Mail' folder.
			#if (save_mail($mail)) {
			#    echo "Message saved!";
			#}
		}
		
		
	}
  
  
}