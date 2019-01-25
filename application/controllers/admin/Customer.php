<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Admin {
	var $column_order = array(null, 'fullname','phone','email','vacc_number','balance','poin','is_confirmed_email','is_confirmed_hp',null); 
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('admin/M_customer','M_customer');
		
	}
	
	public function index()
	{
		$data['top_title']='Customer';
		$data['box_title']='List';
		$data['content']='admin/v_customer_list';
		$this->load->view('admin/template',$data);
	}
	
	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->M_customer->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->M_customer->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			if($row['is_confirmed_hp']=='1'){
				$is_confirmed_hp='<small class="label pull-right bg-green">TRUE</small>';
			}else{
				$is_confirmed_hp='<small class="label pull-right bg-red">FALSE</small>';
			}
			if($row['is_confirmed_email']=='1'){
				$is_confirmed_email='<small class="label pull-right bg-green">TRUE</small>';
			}else{
				$is_confirmed_email='<small class="label pull-right bg-red">FALSE</small>';
			}
			$user_id=$row['user_id'];
			$output['data'][]=array($nomor_urut
									,$row['fullname']
									,$row['phone']
									,$row['email']
									,$row['vacc_number']
									,number_format($row['balance'],0)
									,number_format($row['poin'],0)
									,$row['is_confirmed_email']
									,$row['is_confirmed_hp']
									,$row['created_on']
									,'<a href="javascript:void(0)" onclick="showModalData('.$user_id.')">Detil</a>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	public function jsonGetOneData(){
		if($this->input->post()){
			$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$result=$this->M_customer->get_one($user_id);
			if($result){
				$data=array('status'=>'sukses','data'=>$result);
			}else{
				$data=array('status'=>'error','data'=>'Data Not Found');
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	public function jsonUpdateData(){
		if($this->input->post()){
			$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$data['status_verifikasi']=strip_tags(trim($this->input->post('status_verifikasi',true)));
			$data['verifikasi_msg']=strip_tags(trim($this->input->post('verifikasi_msg',true)));
			if($data['status_verifikasi']=='berhasil'){
				$data['is_verified']='1';
				$data['verified_on']=date('Y-m-d H:i:s');
				$data['verified_by']=$this->session->userdata('uname');
				
				$res=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
				$gcmid[] =$res['fcm_id'];
				$message="Verifikasi akun berhasil";
				$this->load->helper('thirdparty');
				send_notif($gcmid,$message);
				
			}else{
				
				$data['is_verified']='0';
				$data['verified_on']=date('Y-m-d H:i:s');
				$data['verified_by']=$this->session->userdata('uname');
				
				$res=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
				$gcmid[] =$res['fcm_id'];
				$message="Verifikasi akun gagal, mohon perbaiki kembali data anda";
				$this->load->helper('thirdparty');
				send_notif($gcmid,$message);
				
			}
			$result=$this->M_customer->update_data($user_id,$data);
			if($result=='1'){
				$data=array('status'=>'sukses','data'=>'Success Update Data');
			}else{
				$data=array('status'=>'error','data'=>'Error Update Data');
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	public function jsonResetPassword(){
		if($this->input->post()){
			$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$user=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
			if($user){
				$mt_rand=mt_rand(10000000,99999999);
				$data['pass']=myhash($mt_rand,$user['salt']);
				$result=$this->M_customer->update_data($user_id,$data);
				if($result){
					
					//send mail
					$this->load->library('lib_phpmailer');
					$to=$user['email'];
					$subject='Reset Password Gerai@ccess';
					$message="
							<html>
								<body>
									<p>New Gerai@ccess Password: 
									".$mt_rand."
									</p>
								</body>
							</html>
							
							";
					$lib_phpmailer=$this->lib_phpmailer->send_email_nospam($to,$subject,$message);
					if($lib_phpmailer){
						$data=array('status'=>'sukses','data'=>'success reset password');
					}else{
						$data=array('status'=>'error','data'=>'email not sent');
					}
					
					 
				}else{
					$data=array('status'=>'error','data'=>'Data Not Found');
				}
			}else{
				$data=array('status'=>'error','data'=>'Data Not Found');
			}
			
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	public function jsonResetPin(){
		if($this->input->post()){
			$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$user=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
			if($user){
				$mt_rand=mt_rand(100000,999999);
				$data['pin']=myhash($mt_rand,$user['salt']);
				$result=$this->M_customer->update_data($user_id,$data);
				if($result){
					
					//send mail
					$this->load->library('lib_phpmailer');
					$to=$user['email'];
					$subject='Reset PIN Gerai@ccess';
					$message="
							<html>
								<body>
									<p>New Gerai@ccess PIN: 
									".$mt_rand."
									</p>
								</body>
							</html>
							
							";
					$lib_phpmailer=$this->lib_phpmailer->send_email_nospam($to,$subject,$message);
					if($lib_phpmailer){
						$data=array('status'=>'sukses','data'=>'success reset pin');
					}else{
						$data=array('status'=>'error','data'=>'email not sent');
					}
				}else{
					$data=array('status'=>'error','data'=>'Data Not Found');
				}
			}else{
				$data=array('status'=>'error','data'=>'Data Not Found');
			}
			
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	
	
	
}
