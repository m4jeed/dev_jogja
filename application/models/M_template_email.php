<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_template_email extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function verify_change_email($email_key){
		$url=site_url('change_email/email_key/'.$email_key);
		$msg='
			<html>
			<head></head>
			<body>
				Verifikasi Email baru anda dengan link 
				<a href="'.$url.'">'.$url.'</a>
				
			</body>
			</html>
			';
		return $msg;
	}
	
	public function verify_hp($email_key){
		$url=site_url('verify_email/email_key/'.$email_key);
		$msg='
			<html>
			<head></head>
			<body>
				Selamat Datang di GeraiAccess <br/>
				Mohon Segera Lakukan Verifikasi Akun & 
				Verifikasi Email anda dengan link 
				<a href="'.$url.'">'.$url.'</a>
				
			</body>
			</html>
			';
		return $msg;
	}
	
	public function reset_pass($new_pass){
		$msg='
			<html>
			<head></head>
			<body>
				Your New GeraiAccess Password:'.$new_pass.'
			</body>
			</html>
			';
		return $msg;
	}
	
	public function pembayaran_tv_cable($nama_customer,$nomor_invoice,$nomor_pelanggan,$atas_nama,
										$paket_tv_kabel,$nominal_tagihan,$biaya_admin,$total,$waktu){
		$msg='
			<html>
			<head>
			</head>
			<body>
				Hi Agent, '.$nama_customer.'
				<br/>
				Selamat Transaksi Pembayaran Tagihan TV Kabel anda sudah berhasil
				<br/>
				<br/>
				<table>
					<tr>
						<td>Nomor Invoice</td>
						<td>:</td>
						<td>'.$nomor_invoice.'</td>
					</tr>
					<tr>
						<td>Nomor Pelanggan</td>
						<td>:</td>
						<td>'.$nomor_pelanggan.'</td>
					</tr>
					<tr>
						<td>Atas Nama</td>
						<td>:</td>
						<td>'.$atas_nama.'</td>
					</tr>
					<tr>
						<td>Paket TV Kabel</td>
						<td>:</td>
						<td>'.$paket_tv_kabel.'</td>
					</tr>
					<tr>
						<td>Nominal Tagihan</td>
						<td>:</td>
						<td>'.$nominal_tagihan.'</td>
					</tr>
					<tr>
						<td>Biaya Admin</td>
						<td>:</td>
						<td>'.$biaya_admin.'</td>
					</tr>
					<tr>
						<td>Total yang dibayar</td>
						<td>:</td>
						<td>'.$total.'</td>
					</tr>
					<tr>
						<td>Waktu & Tanggal</td>
						<td>:</td>
						<td>'.$waktu.'</td>
					</tr>
					
				</table>
				<br/>
				Terima kasih atas kepercayaan anda bertransaksi di Gerai@ccess.
				<br/>
				TOP UP terus saldo anda dan nikmati kemudahan bertransaksi di Gerai@ccess
				<br/>
				<br/>
				Anda memperoleh e-mail ini karena keanggotaan Anda pada Gerai@ccess
				<br/>
				Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem. 
			</body>
			</html>
			';
			
		return $msg;
	}
	
	
}

