<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_trx_detail extends CI_Model{
	// var $table = 'ma_trx'; 
	// var $column_order = array(null, 'trx_type','trx_date','trx_desc','amount','balance','vacc_number','vacc_from','vacc_to','cor_remark','referral');  
	// var $column_search = array('trx_type','trx_date','trx_desc','amount','balance','vacc_number','cor_remark','referral'); 
	// var $order = array('trx_id' => 'asc');

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
			$order='trx_date';
		}
		$sql="
			SELECT * FROM ma_trx 
			INNER JOIN ma_vacc 
			ON ma_trx.vacc_number=ma_vacc.vacc_number
			INNER JOIN ma_users
			ON ma_vacc.user_id=ma_users.user_id
			WHERE ma_users.phone like '%".$keyword."%'
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		//var_dump($sql);die();
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM ma_trx 
			INNER JOIN ma_vacc
			ON ma_trx.vacc_number=ma_vacc.vacc_number
			INNER JOIN ma_users
			ON ma_vacc.user_id=ma_users.user_id
			WHERE ma_users.phone like '%".$keyword."%' ";
		return $this->db->query($sql)->row()->jumlah;
	}

	// function count_all($keyword=''){
	// 	$sql="
	// 		SELECT count(*) as jumlah 
	// 		FROM ma_trx 
	// 		WHERE (trx_type LIKE '%".$keyword."%'
	// 		OR trx_date LIKE '%".$keyword."%'
	// 		OR trx_desc LIKE '%".$keyword."%'
	// 		OR amount LIKE '%".$keyword."%'
	// 		OR balance LIKE '%".$keyword."%'
	// 		OR vacc_number LIKE '%".$keyword."%'
	// 		OR cor_remark LIKE '%".$keyword."%'
	// 		OR referral LIKE '%".$keyword."%') ";
	// 	return $this->db->query($sql)->row()->jumlah;
	// }

	

}

/*update baru*/