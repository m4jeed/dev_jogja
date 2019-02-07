<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_approve_withdraw extends CI_Model{
	var $table = 'withdraw_request';
	//var $column_order = array(null, 'news_title');
	var $column_order = array(null, 'nama_pemilik','nominal','no_rekening','nama_bank','approve_by','status');
	var $column_search = array('news_title');
	var $order = array('ids' => 'asc');

	public function __construct(){
        parent::__construct();
     
    }

    function get_all($offset='',$limit='',$keyword='',$order,$dir){
		if($offset==''){
			$offset=0;
		}
		if($limit==''){
			$limit=10;
		}
		if($order==''){
			$order='nama_pemilik';
		}

		$sql="SELECT withdraw_request.*,
			ma_vacc.user_id,
			ma_vacc.balance,
			ma_users.user_id
			FROM withdraw_request
			INNER JOIN ma_vacc
			ON withdraw_request.request_by=ma_vacc.user_id
			INNER JOIN ma_users
			ON withdraw_request.request_by=ma_users.user_id
			WHERE status='Berhasil'
			AND (nama_pemilik LIKE '%".$keyword."%'
			OR nominal LIKE '%".$keyword."%'
			OR no_rekening LIKE '%".$keyword."%'
			OR nama_bank LIKE '%".$keyword."%'
			OR approve_by LIKE '%".$keyword."%'
		)";
		if($order=='nama_pemilik'){
			$sql.=" ORDER BY nama_pemilik DESC ";
		}else{
			$sql.=" ORDER BY ".$order." ".$dir." ";
		}
		$sql.=" LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="SELECT count(*) as jumlah
			FROM withdraw_request
			INNER JOIN ma_vacc
			ON withdraw_request.request_by=ma_vacc.user_id
			JOIN ma_users
			ON withdraw_request.request_by=ma_users.user_id
			WHERE status='Berhasil'
			AND (nama_pemilik LIKE '%".$keyword."%'
			OR nominal LIKE '%".$keyword."%'
			OR no_rekening LIKE '%".$keyword."%'
			OR nama_bank LIKE '%".$keyword."%'
			OR approve_by LIKE '%".$keyword."%')";
		return $this->db->query($sql)->row()->jumlah;
	}

}

//update