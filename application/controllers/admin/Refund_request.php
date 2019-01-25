<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund_request extends MY_Admin {
	var $column_order = array(null); 
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('admin/M_refund_request','model1');
		
	}
	
	public function index()
	{
		$data['top_title']='Refund Requested';
		$data['box_title']='List';
		$data['content']='admin/v_refund_request_list';
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
		
		$status='request';
		
		$total=$this->model1->count_all($search,$status);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		
		$query=$this->model1->get_all($start,$length,$search,$this->column_order[$order], $dir,$status);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$refund_id=$row['refund_id'];
			$refund='<a href="javascript:void(0)" class="btn btn-primary" onclick="jsonApproveRefund('.$refund_id.')" >Approve</a>';
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
									,$refund
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
