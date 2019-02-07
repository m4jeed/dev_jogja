<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Baru nih

class Masterusers extends MY_Jogja {
	var $column_order = array(null, 'fullname','phone','email','vacc_number','balance','poin','is_confirmed_email','is_confirmed_hp',null); 

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_masterusers','muser');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Master Users';
		$data['box_title']='List';
		$data['content']  ='jogja/v_masterusers';
		$this->load->view('jogja/template',$data);

	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->muser->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->muser->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
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
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$user_id.')"><i class="fa fa-edit"></i></a></center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonGetOneData(){
		if($this->input->post()){
			$user_id=strip_tags(trim($this->input->post('user_id',true)));
			$result=$this->muser->get_one($user_id);
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
				$data['created_on']=date('Y-m-d H:i:s');
				
				$res=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
			}else{
				
				$data['is_verified']='0';
				$data['verified_on']=date('Y-m-d H:i:s');
				$data['verified_by']=$this->session->userdata('uname');
				$data['created_on']=date('Y-m-d H:i:s');
				
				$res=$this->db->query("select * from ma_users where user_id='".$user_id."'")->row_array();
				
			}

			//FUNGSI BUAT NAMBAH 5 POIN DI USER LAMA
			$dataPoin 		=$this->muser->get_one_get($user_id);			
			$req_poin 		=$dataPoin['user_id'];
			$nominal 		=$dataPoin['poin'] + 5;
			//$rere=$dataPoin['my_referal_code'];
			//var_dump($rere);die();

			$poin 			= array('poin' => $nominal);
			$this->muser->update_vacc($req_poin,$poin);

			$referal 		= $this->muser->get_one_get($user_id);
			$RefAtas		= $referal['referal_code'];
			//var_dump($RefAtas);die();

			//FUNGSI BUAT NAMBAH 5 POIN DI USER BARU & USER LAMA 2 POIN
			$datareferal = $this->muser->get_one_geting($RefAtas);
			
			$user_id_ref 	= $datareferal['user_id'];
			$nom 			= $datareferal['poin'] + 2;
			$poin_ref 		= array('poin' => $nom);

			$this->muser->update_poin_atasan($user_id_ref,$poin_ref);
			//var_dump($referal['referal_code']);die();
			$datas['trx_desc']		='Selamat Anda Mendapatkan Reward Poin Dari Verifikasi Akun.';
			$datas['trx_type']		='reward_poin';
			$datas['trx_date']		=date('Y-m-d H:i:s');
			$datas['is_refund']		='N';
			$datas['dk']			='K';
			$datas['vacc_from']		='0';
			$datas['vacc_to']		='0';
			$datas['amount']		='5';
			$datas['cor_remark']	='0';
			$datas['trx_id2']		='9'.generateCode();
			$datas['balance']		=$referal['poin'];
			$datas['vacc_number']	=$referal['vacc_number'];	
			$trx_id_pertama=$this->muser->insert_data_users($datas);

			if ($datareferal['vacc_number']!=NULL) {
				$dataz['trx_desc']		='Selamat Anda Mendapatkan Reward Poin Dari Verifikasi Akun.';
				$dataz['trx_type']		='reward_poin';
				$dataz['trx_date']		=date('Y-m-d H:i:s');
				$dataz['is_refund']		='N';
				$dataz['dk']			='K';
				$dataz['vacc_from']		='0';
				$dataz['vacc_to']		='0';
				$dataz['amount']		='2';
				$dataz['cor_remark']	=$trx_id_pertama;
				$dataz['trx_id2']		='9'.generateCode();
				$dataz['balance']		=$datareferal['poin'] + 2;
				$dataz['vacc_number']	=$datareferal['vacc_number'];	
				//var_dump($datas,$nomi_ref,$vacc_number,$referral);die();
				$this->muser->insert_data_atasan($dataz);
			}	
	
			$result=$this->muser->update_data($user_id,$data);
			if($result=='1'){
				$data=array('status'=>'sukses','data'=>'Success Approve Data');
			}else{
				$data=array('status'=>'error','data'=>'Error Update Data');
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}

	public function jsonSendMailKonfirmasi(){
		//$result=$this->muser->get_one($user_id);
		//$test=$this->jsonGetOneData();
		$user_id=$this->session->userdata('user_id');
		$data=$this->muser->get_one($user_id);
		//var_dump($data);die();
		$this->load->library('lib_phpmailer_jogja');
		$to=$data['email'];
		$subject='Selamat Datang di JogjaAccess';
		$this->load->model('M_template_email');
		$message=$this->M_template_email->verify_hp($data['email_key']);
		$send_email=$this->lib_phpmailer_jogja->send_email($to,$subject,$message,true);
		//var_dump($send_email);die();
		//------------------------------------
		$this->result=$data;
		
		if($send_email){
			$data=array('status'=>'sukses','data'=>'Success Resend Email');
		}else{
			$data=array('status'=>'error','data'=>'Error Update Data');
			//send sms otp
			$this->load->helper('thirdparty');
			$telepon='085779801499';
			$message='SEND MAIL ERROR '.$to;
			$res=MASendSms($telepon,$message);
			//--------------
			 
		}
		echo json_encode($data);
	}

}