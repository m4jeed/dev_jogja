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
									 ,number_format($row['nominal'],0)
									 ,number_format($row['balance'],0)
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

	public function jsonUpdateData(){ 
		if($this->input->post()){
			$id=strip_tags(trim($this->input->post('ids',true)));
			$data['status']=strip_tags(trim($this->input->post('status',true))); 
			
			if( $data['status']=='Berhasil' ){
				$data['approve_by']=$this->session->userdata('uname');
				$data['approve_on']=date('Y-m-d H:i:s');
				
				$rsGetData = $this->withdraw->get_one_get($id);
				$withdraw_req = $rsGetData[0]['user_id'];
				$nom_jogja_acc = $rsGetData[0]['balance'] - $rsGetData[0]['nominal'];
				$dataVacc = array('balance' => $nom_jogja_acc);

				$this->withdraw->update_vacc($withdraw_req, $dataVacc);

			}else if( $data['status']=='Reject' ){
				$data['approve_by']=$this->session->userdata('uname');
				$data['approve_on']=date('Y-m-d H:i:s');
				
			}else{
				$data['approve_by']=$this->session->userdata('uname');
				$data['approve_on']=date('Y-m-d H:i:s');
			}
			
			$this->withdraw->update_data($id, $data); 
			if($data['status']=='Berhasil'){
				$data = array('status'=>'sukses','data'=>'Success Approve Data');
			}else if($data['status']=='Reject'){
				$data = array('status'=>'reject','data'=>'Success Reject Data'); 
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

//update controllers