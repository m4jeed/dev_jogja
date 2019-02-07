<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_verified_masterusers extends CI_Model{
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
			$order='created_on';
		}
		$sql="SELECT ma_users.*,
			ma_vacc.vacc_number,
			ma_vacc.balance,
			ma_vacc.poin,
			ma_trx.vacc_number 
			FROM ma_users
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			INNER JOIN ma_trx
			ON ma_users.user_id=ma_trx.trx_id
			WHERE is_active='1'
			AND is_verified='1'
			AND (fullname LIKE '%".$keyword."%'
			OR email LIKE '%".$keyword."%')";
		if($order=='created_on'){
			$sql.=" ORDER BY created_on DESC ";
		}else{
			$sql.=" ORDER BY ".$order." ".$dir." ";
		}
		$sql.=" LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="SELECT count(*) as jumlah
			FROM ma_users
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			INNER JOIN ma_trx
			ON ma_users.user_id=ma_trx.trx_id
			WHERE is_active='1'
			AND is_verified='1'
			AND (fullname LIKE '%".$keyword."%'
			OR email LIKE '%".$keyword."%')
			";
		return $this->db->query($sql)->row()->jumlah;
	}

	function get_one($user_id){
		$sql="SELECT ma_users.*,
			ma_vacc.vacc_number,
			ma_vacc.balance,
			ma_vacc.poin,
			base_postalcode.city,
			base_postalcode.districts,
			base_postalcode.postalcode,
			base_postalcode.province,
			base_postalcode.village
			FROM ma_users
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			LEFT JOIN base_postalcode
			ON ma_users.postalcode_id=base_postalcode.ids
			WHERE ma_users.user_id='".$user_id."'";
			//var_dump($sql);die();
		return $this->db->query($sql)->row_array();
	}

	function get_one_vacc($vacc){
		$sql="SELECT ma_trx.*,
			ma_vacc.user_id,
			ma_users.user_id,
			ma_users.fullname
			FROM ma_trx
			INNER JOIN ma_vacc
			ON ma_trx.vacc_number=ma_vacc.vacc_number
			INNER JOIN ma_users
			ON ma_trx.trx_id=ma_users.user_id
			WHERE ma_trx.vacc_number='".$vacc."' 
			GROUP BY trx_date DESC";
		return $this->db->query($sql)->result_array();
	}

}

/*update*/