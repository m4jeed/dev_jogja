<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_withdraw extends MY_Jogja {
	var $column_order = array(null, 'nama_pemilik','nominal','no_rekening','nama_bank','approve_by','status');

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_approve_withdraw','approve');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Approve Withdraw';
		$data['box_title']='List';
		$data['content']='jogja/v_approve_withdraw';
		$this->load->view('jogja/template',$data);
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->approve->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
	
		$query=$this->approve->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
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
									 ,$row['approve_by']
									 ,$row['approve_on']
									 ,$row['status']
								);
			$nomor_urut++;
		}

		echo json_encode($output);
	}
}

//update