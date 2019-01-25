<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund_approve extends MY_Admin {
	var $column_order = array(null); 
	
	public function __construct() 
	{
		parent::__construct();
		$lvl=$this->session->userdata('lvl');
		if(in_array($lvl,array('ADMIN','SPV'))){
			
		}else{
			redirect('admin/not_authorized');
		}
		
		$this->load->model('admin/M_refund_request','model1');
		
		
		
	}
	
	public function index()
	{
		$data['top_title']='Refund Approved';
		$data['box_title']='List';
		$data['content']='admin/v_refund_approve_list';
		$this->load->view('admin/template',$data);
	}
	
	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		//$dir=$_POST['order']['0']['dir'];
		$dir='DESC';
		
		$status='approve';
		
		$total=$this->model1->count_all($search,$status);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		
		$query=$this->model1->get_all($start,$length,$search,$this->column_order[$order], $dir,$status);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$refund_id=$row['refund_id'];
			$output['data'][]=array($nomor_urut
									,$row['trx_date']
									,$row['trx_type']
									,$row['trx_desc']
									,number_format($row['amount'],0)
									,$row['dk']
									,number_format($row['balance'],0)
									,$row['vacc_number']
									,$row['request_by']
									,$row['request_on']
									,$row['approve_by']
									,$row['approve_on']
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	
	public function jsonApproveRefund(){
		if($this->input->post()){
			$this->form_validation->set_rules('refund_id', 'refund_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$refund_id=strip_tags(trim($this->input->post('refund_id',true)));
				$result=$this->model1->refund_approved($refund_id);
				//var_dump($result);die();
				if($result==''){
					$data=array('status'=>'sukses','data'=>'Success Update Data');
				}else{
					$data=array('status'=>'error','data'=>$result);
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	
	
	
	
	
	
}
