<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trx_detail extends MY_Jogja {
	var $column_order = array(null, 'trx_type','trx_date','trx_desc','amount','balance','vacc_number','vacc_from','vacc_to','cor_remark','referral'); 

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_trx_detail','trx');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Trx Detail';
		$data['box_title']='List';
		$data['content']  ='jogja/v_trx_detail';
		$this->load->view('jogja/template',$data);

	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->trx->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->trx->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$user_id=$row['trx_id'];
			$output['data'][]=array($nomor_urut
				                    ,$row['trx_type']
									,$row['trx_date']
									,$row['trx_desc']
									,number_format($row['amount'],0)
									,number_format($row['balance'],0)
									,$row['vacc_number']
									,$row['vacc_from']
									,$row['vacc_to']
									,$row['phone']
									,$row['referral']
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

}
