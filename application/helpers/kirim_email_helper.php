<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

if ( ! function_exists('kirim_email'))
{
	function kirim_email($subject,$msg){
		
		$CI =& get_instance();
	
	      $CI->load->library('email');
	      $config = Array(
		  'protocol' 	=> 'smtp',
		  'smtp_host' 	=> 'ssl://mail.valdoinv.com',
		  'smtp_port' 	=> 465,
		  'smtp_user' 	=> 'fauzi.pane@valdoinv.com', 
		  'smtp_pass' 	=> 'pusing123', 
		  'mailtype' 	=> 'html',
		  'charset' 	=> 'iso-8859-1',
		  'wordwrap' 	=> TRUE
		);
		
		 $CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");
		$CI->email->from('fauzi.pane@valdoinv.com'); 
		$CI->email->to('fauzi.pane@valdoinv.com');
		$CI->email->subject($subject);
		$CI->email->message($msg);
		if($CI->email->send())
		{
			//echo 'Email sent.';
		}else{
			//echo 'email not send';
		}
		//echo $CI->email->print_debugger();	
		 
		
	}
}

?>
