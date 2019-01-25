<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MY_Oi {
	var $column_order = array(null, 'request_post','response','url','timestamp','ip_address','request_get','request_header');

	public function __construct() {
	parent::__construct();
		$this->load->model('oi/M_log','logrequest');
	} 

	public function index(){
		$data['top_title']='Log Request';
		$data['box_title']='List';
		$data['content']='oi/v_log';
		//$id_group ['userID']=$this->cmb->cmb_get_user();
		$this->load->view('oi/template',$data);
	}

	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->logrequest->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->logrequest->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$id=$row['log_id'];
			$output['data'][]=array($nomor_urut
									,$row['request_post']
									,$row['response']
									,$row['timestamp']
									,$row['ip_address']
									,$row['request_get']
									,$row['request_header']
									,$row['url']
									// ,'<center><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$id.')"><i class="fa fa-trash"></i></a>
									// </center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

}