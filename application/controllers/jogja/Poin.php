<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poin extends MY_Jogja {

	var $column_order = array(null, 'fullname','phone','poin','balance','vacc_number');
	public function __construct() {
	parent::__construct();
		$this->load->model('jogja/M_poin','point');
		//$this->load->model('jogja/M_cmb','cmb');
	} 

	public function index(){
		$data['top_title']='Poin';
		$data['box_title']='List';
		$data['content']='jogja/v_poin';
		//$id_group ['userID']=$this->cmb->cmb_get_user();
		// echo "<pre>";
		// print_r($id_group ['userID']);die();
		// $jml=count($id_group ['userID']);
		//  print_r($jml);die();
		$this->load->view('jogja/template',$data);
	}

	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->point->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->point->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$id=$row['ids'];
			$output['data'][]=array($nomor_urut									
									,$row['fullname']
									,$row['phone']
									,$row['poin']
									,$row['balance']
									,$row['vacc_number']
									// ,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$id.')"><i class="fa fa-edit"></i></a>
									,'<center><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$id.')"><i class="fa fa-trash"></i></a>
									</center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}


}
