<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verified_masterusers extends MY_Jogja {
	var $column_order = array(null, 'fullname','phone','email','vacc_number','balance','poin','is_confirmed_email','is_confirmed_hp',null); 

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_verified_masterusers','verified');
		$this->load->library('session');
	}

	public function index()
	{
		$data['top_title']='Master Users Last Verified';
		$data['box_title']='List';
		$data['content']  ='jogja/v_verified_masterusers';
		$this->load->view('jogja/template',$data);
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->verified->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->verified->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$user_id=$row['user_id'];
			$output['data'][]=array($nomor_urut
									 // ,$row['poin']
									 // ,$row['status_verifikasi']
									,$row['fullname']
									,$row['my_referal_code']
									,$row['referal_code']
									,$row['phone']
									,$row['email']
									,$row['vacc_number']
									,number_format($row['balance'],0)
									,number_format($row['poin'],0)
									,$row['created_on']
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}
}