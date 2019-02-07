<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verified_masterusers extends MY_Jogja {
	var $column_order = array(null, 'fullname','phone','email','vacc_number','balance','poin','is_confirmed_email','is_confirmed_hp',null); 

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_verified_masterusers','verified');
		$this->load->library('session');
	}

	public function index(){
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
			$vacc   =$row['vacc_number'];
			$output['data'][]=array($nomor_urut
									,$row['fullname']
									,$row['my_referal_code']
									,$row['referal_code']
									,$row['phone']
									,$row['email']
									,$row['vacc_number']
									,number_format($row['balance'],0)
									,number_format($row['poin'],0)
									,$row['created_on']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$user_id.')">Detail</a>
										<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showVaccNumber('.$vacc.')">Vacc</a>
									</center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonGetOneData(){
		$data['top_title']='Detail List Masterusers';
		$data['box_title']='List';
		$data['content']='jogja/v_detailverified';

		$user_id=$this->uri->segment(4);
		$result=$this->verified->get_one($user_id);
		
		if($result){
			$data['ambil']=array('status'=>'sukses','data'=>$result);
		}else{
			$data['ambil']=array('status'=>'error','data'=>'Error Insert Data');
		}

		// echo "<pre>";
		// print_r($data);
		$this->load->view('jogja/template',$data);

		// die;
	}

	public function jsonGetVacc(){
		$data['top_title']='Detail List Vacc Number';
		$data['box_title']='List';
		$data['content']='jogja/v_detailvacc';

		$vacc=$this->uri->segment(4);
		$data['data_vacc']=$this->verified->get_one_vacc($vacc);
		$this->load->view('jogja/template',$data);

	}
}

/*update*/