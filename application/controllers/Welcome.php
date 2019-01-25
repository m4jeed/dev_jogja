<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		echo 'app=> '.date('Y-m-d H:i:s').'<br/>';
		$q=$this->db->query("select now() as tgl");
		echo 'db=> '.$q->row()->tgl.'<br/>';
		echo '<br/>';
		
		
		$salt='q2w3e4r5t6y';
		//echo $salt;
		echo '<br/>';
		$this->load->helper('myhash');
		$str=myhash('password',$salt);
		
		$this->load->helper('valdo_tools');
		
		echo '</br>';
		echo generateCode();
		//echo $str;
		
		//$this->load->view('welcome_message');
	}
	
	
	
	function tes_sms(){
		$this->load->helper('thirdparty');
		$telepon='085779801499';
		$message='Selamat Bro.. Anda Berhasil Terdaftar : ';
		$res=MASendSms($telepon,$message);
		var_dump($res);
	
	}
	
	function tes_fcm($message=''){
		//236
		$res=$this->db->query("select * from ma_users where user_id='295'")->row_array();
		
		$this->load->helper('thirdparty');
		//$gcmid[] = 'eknnW8rl8s4:APA91bGQ5U_Pc2PQyGWxghTSDFloyw8L1rXgYo8BnY62n501a1rSNEEAhdpVfnQScbSSN3m-r8cshi70tRw5uND94uPi5Bu9iuRe5_oITqVCfIFelfuWA7tWxxw9UnnYeZ59BUQ9K_yh';
		//$gcmid[] = 'cbxmcnRem1w:APA91bGxPri_4kpa8RGy8nO9L2SLFFJonz62ZDqI4oVfMwk9w6U93SSMF2c9MNcX0NUoYzWj3_A4UAJh-Eura69A-rPhVVeQJU05t9JZTAIH5CFtQEe1GUEnp1rWrKwRqG81TDY-1aQC';
		//$gcmid[] ="feoCdbc9mQc:APA91bGi6m57DTTiCvT2hE-UE5_D53XNofDJn3FvqgGqd_cYBi5pO-tkYL-IticUUyvIu8c3YzqIdqCK4KCnYkff0HvWnsJMgsRTGYDK2UmaLkAxVf037F1kWlXizhfIAUDswXkVntDb";
		$gcmid[] =$res['fcm_id'];
		if($message==''){
		$message = 'tes fcm dari server gerai';
		}
		var_dump(send_notif($gcmid,$message));
	}
	
	function tes_ma_auth(){
		$url='http://192.168.12.172:8080/com.valdo.maccess/api/account/auth';
		//$postParams=array('fullname'=>'tess');
		//$postParams=array();
		//var_dump(json_encode($postParams));die();
		$response=curl_request_ma($url);
		//$response=curl_request_ma($url,json_encode($postParams));
		var_dump($response);
		die();
		
	}
	
	function tes_mail2(){
		//send email ----------------------
		$this->load->library('lib_phpmailer');
		$to='fauzipane81@gmail.com';
		$subject='Selamat Datang di GeraiAccess';
		$this->load->model('M_template_email');
		$message=$this->M_template_email->verify_hp('GASJDGJAHSG76876872324');
		
		$this->lib_phpmailer->send_email($to,$subject,$message);
		//------------------------------------
	}
	
	function tes_inq(){
		$this->load->model('M_vacc');
		for ($x = 0; $x <= 100; $x++) {
			$ma_user_detil=$this->M_vacc->ma_user_detil('20295');
			var_dump($ma_user_detil);
			echo '<br/>';
			echo '<br/>';
			$inquiry_vacc=$this->M_vacc->inquiry_vacc('1000231');
			var_dump($inquiry_vacc);
			echo '<br/>';
			echo '<br/>';
			
		} 
	}
	
	function RandomString($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));

		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return $key;
	}

	function random_string(){
		echo strtoupper($this->RandomString(8));
	}
	
	function tes_email_gmail(){
		/* // the message
		$msg = "First line of text\nSecond line of text";

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

		// send email
		$mail=mail("fauzipane81@gmail.com","My subject",$msg);
		var_dump($mail);
		die(); */
		//send email ----------------------
		$this->load->library('lib_phpmailer');
		$to='fauzipane81@gmail.com';
		$subject='bukti pembayaran tes';
		//$this->load->model('M_template_email');
		$message='bukti pembayaran tes';
		
		//$lib_phpmailer=$this->lib_phpmailer->send_email($to,$subject,$message);
		$lib_phpmailer=$this->lib_phpmailer->send_email_nospam($to,$subject,$message);
		var_dump($lib_phpmailer);
		//------------------------------------
		
	}
	
	function tes_bnihash(){
		require APPPATH . 'libraries/BniHashing.php';
		$request_data=array(
							'billing_type' => 'c',
							'datetime_expired' => date('c', time() + (3600*24)), // billing will be expired in 24 hours
						);
		$client_id='123123123';
		$secret_key='123123';
		$hashed_string = BniHashing::hashData(
											$request_data,
											$client_id,
											$secret_key
										);
		var_dump($hashed_string);
		die();
	}
	
	function resetpin($user_id){
		$this->load->model('M_va');
		$reset_pin=$this->M_va->reset_pin($user_id);
		var_dump($reset_pin);
	}
	
	function backup_db(){
				
		// Load the DB utility class
		$this->load->dbutil();

		$prefs = array(
				//'tables'     => array('ma_users', 'users'),
				// Array table yang akan dibackup
				//'ignore'     => array(),
				// Daftar table yang tidak akan dibackup
				'format'     => 'txt',
				// gzip, zip, txt format filenya
				'filename'   => 'mybackup.sql',
				// Nama file
				'add_drop'   => TRUE, 
				// Untuk menambahkan drop table di backup
				'add_insert' => TRUE,
				// Untuk menambahkan data insert di file backup
				'newline'    => "\n"
				// Baris baru yang digunakan dalam file backup
		);

		$backup = $this->dbutil->backup($prefs);
		// Backup database dan dijadikan variable
		//$backup = $this->dbutil->backup();

		// Load file helper dan menulis ke server untuk keperluan restore
		//$this->load->helper('file');
		//write_file('/backup/database/mybackup.gz', $backup);

		// Load the download helper dan melalukan download ke komputer
		$this->load->helper('download');
		force_download('mybackup.sql', $backup);
	}
	
	function tes_idbiller(){
		$this->load->model('M_id_biller');
		$balance_service=$this->M_id_biller->balance_service();
		var_dump($balance_service);
	}
	
	
	function harga_ppob(){
		//$this->db->query("truncate table idbiller_price_service");
		$this->load->model('M_id_biller');
		$Model='pulsa';
		$res=$this->M_id_biller->price_service($Model);
		if($res['is_error']=='0'){
			//var_dump($res['result']);
			foreach($res['result'] as $row){
				//var_dump($row['Provider']);
				$res2['provider']=$row['Provider'];
				foreach($row['DataProducts'] as $row1){
					$res2['code']=$row1['code'];
					$res2['name']=$row1['name'];
					$res2['price']=$row1['price'];
					$res2['status']=$row1['status'];
					
					$data['model']=$Model;
					$data['provider']=$res2['provider'];
					$data['product_code']=$res2['code'];
					$data['product_name']=$res2['name'];
					$data['product_price']=$res2['price'];
					$data['product_status']=$res2['status'];
					$data['product_saleprice']=(int)$res2['price']+1000;
					$data['product_type']='pulsa_prabayar';
					$data['updated_on']=date('Y-m-d H:i:s');
					//$this->db->insert('idbiller_price_service',$data);
					
					
				}
				$res3[]=$res2;
				
			}
			var_dump($res3);
		}
		
		$Model='data';
		$res=$this->M_id_biller->price_service($Model);
		if($res['is_error']=='0'){
			//var_dump($res['result']);
			foreach($res['result'] as $row){
				//var_dump($row['Provider']);
				$res2['provider']=$row['Provider'];
				foreach($row['DataProducts'] as $row1){
					$res2['code']=$row1['code'];
					$res2['name']=$row1['name'];
					$res2['price']=$row1['price'];
					$res2['status']=$row1['status'];
					
					$data['model']=$Model;
					$data['provider']=$res2['provider'];
					$data['product_code']=$res2['code'];
					$data['product_name']=$res2['name'];
					$data['product_price']=$res2['price'];
					$data['product_status']=$res2['status'];
					$data['product_saleprice']=(int)$res2['price']+1000;
					$data['product_type']='paket_data';
					$data['updated_on']=date('Y-m-d H:i:s');
					//$this->db->insert('idbiller_price_service',$data);
					
					
				}
				$res3[]=$res2;
				
			}
			var_dump($res3);
		}
		
		$Model='game';
		$res=$this->M_id_biller->price_service($Model);
		if($res['is_error']=='0'){
			//var_dump($res['result']);
			foreach($res['result'] as $row){
				//var_dump($row['Provider']);
				$res2['provider']=$row['Provider'];
				foreach($row['DataProducts'] as $row1){
					$res2['code']=$row1['code'];
					$res2['name']=$row1['name'];
					$res2['price']=$row1['price'];
					$res2['status']=$row1['status'];
					
					$data['model']=$Model;
					$data['provider']=$res2['provider'];
					$data['product_code']=$res2['code'];
					$data['product_name']=$res2['name'];
					$data['product_price']=$res2['price'];
					$data['product_status']=$res2['status'];
					$data['product_saleprice']=(int)$res2['price']+1000;
					$data['product_type']='game';
					
					$data['updated_on']=date('Y-m-d H:i:s');
					//$this->db->insert('idbiller_price_service',$data);
					
					
				}
				$res3[]=$res2;
				
			}
			var_dump($res3);
		}
		
		$Model='voucher';
		$res=$this->M_id_biller->price_service($Model);
		if($res['is_error']=='0'){
			//var_dump($res['result']);
			foreach($res['result'] as $row){
				//var_dump($row['Provider']);
				$res2['provider']=$row['Provider'];
				foreach($row['DataProducts'] as $row1){
					$res2['code']=$row1['code'];
					$res2['name']=$row1['name'];
					$res2['price']=$row1['price'];
					$res2['status']=$row1['status'];
					
					$data['model']=$Model;
					$data['provider']=$res2['provider'];
					$data['product_code']=$res2['code'];
					$data['product_name']=$res2['name'];
					$data['product_price']=$res2['price'];
					$data['product_status']=$res2['status'];
					$data['product_saleprice']=(int)$res2['price']+1000;
					$data['product_type']='voucher';
					
					$data['updated_on']=date('Y-m-d H:i:s');
					//$this->db->insert('idbiller_price_service',$data);
					
					
				}
				$res3[]=$res2;
				
			}
			var_dump($res3);
		}
		
		$Model='emoney';
		$res=$this->M_id_biller->price_service($Model);
		if($res['is_error']=='0'){
			//var_dump($res['result']);
			foreach($res['result'] as $row){
				//var_dump($row['Provider']);
				$res2['provider']=$row['Provider'];
				foreach($row['DataProducts'] as $row1){
					$res2['code']=$row1['code'];
					$res2['name']=$row1['name'];
					$res2['price']=$row1['price'];
					$res2['status']=$row1['status'];
					
					$data['model']=$Model;
					$data['provider']=$res2['provider'];
					$data['product_code']=$res2['code'];
					$data['product_name']=$res2['name'];
					$data['product_price']=$res2['price'];
					$data['product_status']=$res2['status'];
					$data['product_saleprice']=(int)$res2['price']+1000;
					$data['updated_on']=date('Y-m-d H:i:s');
					$data['product_type']='emoney';
					
					//$this->db->insert('idbiller_price_service',$data);
					
					
				}
				$res3[]=$res2;
				
			}
			var_dump($res3);
		}
	
	}
	
	function tes_json1(){
		$data='{"status":"ok","data":"{\"Time\":\"20180416181534\",\"RequestMethod\":\"PaymentService\",\"Rc\":\"00\",\"Description\":\"Berhasil\",\"ProductCode\":\"PPLNPRAY\",\"CustomerNumber1\":\"01117357176\",\"CustomerNumber2\":\"\",\"CustomerNumber3\":\"081370589405\",\"RefNumber\":\"3545581503\",\"Nominal\":\"100000\",\"AdminCharge\":\"2500\",\"Cashback\":\"2200\",\"Saldo\":\"7549795\",\"SwitcherId\":\"506CA01\",\"CustomerMeter\":\"01117357176\",\"CustomerId\":\"541102801690\",\"Flag\":\"0\",\"NoRef1\":\"00000000000000000000000000000000\",\"NoRef2\":\"0SMB2135115218D88DAA410D5B99E46F\",\"VendingReceiptNumber\":\"00000000\",\"SubscriberName\":\"H. ROHANAH (A)\",\"SubscriberSegmentation\":\"R1\",\"PowerConsumingCategory\":\"000001300\",\"MinorUnitAdminCharge\":\"2\",\"BillerAdminCharge\":\"0000300000\",\"BuyingOption\":\"0\",\"DistributionCode\":\"54\",\"ServiceUnit\":\"54110\",\"ServiceUnitPhone\":\"123\",\"MaxKwhLimit\":\"00936\",\"TotalRepeatUnsoldToken\":\"0\",\"Unsold1\":\"\",\"Unsold2\":\"\",\"TokenPln\":\"61233235742356986977\",\"MinorUnitStampDuty\":\"2\",\"StampDuty\":\"0000000000\",\"MinorUnitPpn\":\"2\",\"Ppn\":\"0000000000\",\"MinorUnitPpj\":\"2\",\"Ppj\":\"0000234400\",\"MinorUnitCustomerPayablesInstallment\":\"2\",\"CustomerPayablesInstallment\":\"0000000000\",\"MinorUnitOfPowerPurchase\":\"2\",\"PowerPurchase\":\"000009765600\",\"MinorUnitOfPurchasedKwhUnit\":\"2\",\"PurchasedKwhUnit\":\"0000006660\",\"InfoText\":\"Informasi Hubungi Call Center 123 Atau hubungi PLN Terdekat \"}"}';
		$data2=json_decode($data, true);
		$data3=json_decode($data2['data'], true);
		print_r($data3);
	}
	
	function ci_mail(){
		$ci = get_instance();
		$ci->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "fauzipane81@gmail.com"; 
		$config['smtp_pass'] = "kantorkantor123";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$ci->email->initialize($config);

		$ci->email->from('blablabla@gmail.com', 'Blabla');
		$list = array('fauzipane81@gmail.com');
		$ci->email->to($list);
		$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		$ci->email->subject('This is an email test');
		$ci->email->message('It is working. Great!');
		if ($this->email->send()) {
				echo 'Your email was sent, thanks chamil.';
			} else {
				show_error($this->email->print_debugger());
			}
	}
	
	public function cek_reffnum(){
		$reffnum='3544311519';
		$this->load->model('M_id_biller');
		$data=$this->M_id_biller->data_transaction_service('','2018-01-01','2018-04-01','');
		$res=$data['result'];
		// echo $res['Time'];
		// echo '<br/>';
		// echo $res['RequestMethod'];
		// echo '<br/>';
		// echo $res['RequestMethod'];
		// echo '<br/>';
		
		// echo '<br/>';
		var_dump($res);
	}
	
	
	
}
