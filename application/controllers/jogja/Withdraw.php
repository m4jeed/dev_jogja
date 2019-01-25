<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw extends MY_Jogja {
	var $column_order = array(null, 'nama_pemilik','nominal','no_rekening','nama_bank','approve_by','status');

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_withdraw','withdraw');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Withdraw';
		$data['box_title']='List';
		$data['content']='jogja/v_withdraw';
		$this->load->view('jogja/template',$data);
		
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->withdraw->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
	
		$query=$this->withdraw->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$ids=$row['ids'];
			$output['data'][]=array($nomor_urut
									 ,$row['nama_pemilik']
									 ,$row['nominal']
									 ,$row['balance']
									 ,$row['no_rekening']
									 ,$row['nama_bank']
									 ,$row['request_on']
									 ,$row['status']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showEditData('.$ids.')"><i class="fa fa-edit"></i></a></center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonGetOneData(){ 
		if($this->input->post()){
			//$user_id
			$id=strip_tags(trim($this->input->post('ids',true)));
			$result=$this->withdraw->get_one($id);
			// var_dump($result);die();
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

	public function jsonDeleteData(){ 
		if($this->input->post()){
			$this->form_validation->set_rules('ids', 'ids', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
				$ids=strip_tags(trim($this->input->post('ids',true)));
				$data['is_active']='0';
				$data['updated_by']=$this->session->userdata('uname');
				$data['updated_on']=date('Y-m-d H:i:s');
				$result=$this->berita->update_data($ids,$data);
				if($result){
					$data=array('status'=>'sukses','data'=>'Success Delete Data');
				}else{
					$data=array('status'=>'error','data'=>'Error Delete Data');
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}

	public function jsonUpdateData(){ 
		if($this->input->post()){
			$id=strip_tags(trim($this->input->post('ids',true)));
			$data['status']=strip_tags(trim($this->input->post('status',true))); 
			//$data['verifikasi_msg']=strip_tags(trim($this->input->post('verifikasi_msg',true)));
			if($data['status']=='Berhasil'){
				//$data['is_verified']='1';
				$data['approve_on']=date('Y-m-d H:i:s');
				$data['approve_by']=$this->session->userdata('uname');
			
				$res=$this->db->query("select * from withdraw_request where ids='".$id."'")->row_array();
				
			}else{
				
				//$data['is_verified']='0';
				$data['approve_on']=date('Y-m-d H:i:s');
				$data['approve_by']=$this->session->userdata('uname');
				//$data['created_on']=date('Y-m-d H:i:s');
				$res=$this->db->query("select * from withdraw_request where ids='".$id."'")->row_array();
				
			}
			
			$rsGetData = $this->withdraw->get_one_get($id);
			$withdraw_req = $rsGetData[0]['user_id'];
			$nom_jogja_acc = $rsGetData[0]['balance'] - $rsGetData[0]['nominal'];
			
			$dataVacc = array('balance' => $nom_jogja_acc);
			$this->withdraw->update_vacc($withdraw_req, $dataVacc);

			$dataWithdraw = array(
				'status' => 'Berhasil',				
			);
			
			$result=$this->withdraw->update_data($id,$dataWithdraw); 
			if($result=='1'){
				$data = array('status'=>'sukses','data'=>'Success Approve Data'); 
			}else{
				$data=array('status'=>'error','data'=>'Error Update Data'); 
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}


}