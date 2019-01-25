<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ma_trx extends MY_Admin {
	var $column_order = array(null, 'trx_date','trx_type','trx_desc','amount','dk','balance','vacc_number','vacc_from','vacc_to',null); 
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('admin/M_ma_trx','model1');
		
	}
	
	public function index()
	{
		$data['top_title']='Wallet History';
		$data['box_title']='List';
		$data['content']='admin/v_ma_trx_list';
		$this->load->view('admin/template',$data);
	}
	
	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->model1->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->model1->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			if($row['dk']=='d' && $row['trx_type']=='ppob'){
				if($row['is_refund']=='Y'){
					$refund='<a href="javascript:void(0)"  class="btn btn-danger">REFUNDED</a>';
				}else{
					$refund='<a href="javascript:void(0)" onclick="jsonGetOneData('.$row['trx_id'].')" class="btn btn-primary">REFUND</a>';
				}
			}else{
				$refund='';
			}
			$output['data'][]=array($nomor_urut
									,$row['trx_date']
									,$row['trx_type']
									,$row['trx_desc']
									,number_format($row['amount'],0)
									,$row['dk']
									,number_format($row['balance'],0)
									,$row['vacc_number']
									,$row['vacc_from']
									,$row['vacc_to']
									,$refund
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	
	public function jsonGetOneData(){
		if($this->input->post()){
			$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$trx_id=strip_tags(trim($this->input->post('trx_id',true)));
				$result=$this->model1->get_one($trx_id);
				if($result){
					$data=array('status'=>'sukses','data'=>$result);
				}else{
					$data=array('status'=>'error','data'=>'Error Insert Data');
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	public function jsonRefundRequest(){
		if($this->input->post()){
			$this->form_validation->set_rules('trx_id', 'trx_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$data['trx_id']=strip_tags(trim($this->input->post('trx_id',true)));
				
				$cek=$this->db->query("select count(*) as jumlah from gerai_refund_request where trx_id='".$data['trx_id']."'")->row()->jumlah;
				if($cek!=0){
					$data=array('status'=>'error','data'=>'Refund Request Alredy Exist');
				}else{
					$data['request_by']=$this->session->userdata('uname');
					$data['request_on']=date('Y-m-d H:i:s');
					$data['status']='request';
					$this->db->insert('gerai_refund_request',$data);
					$result=$this->db->insert_id();
					if($result){
						$data=array('status'=>'sukses','data'=>'Success Refund Request');
					}else{
						$data=array('status'=>'error','data'=>'Error Refund Request');
					}
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	
	
	
	
	
	
}
