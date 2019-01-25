<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_voucheruser extends CI_Model{
	var $table = 'gerai_voucher_code'; 
	var $column_order = array(null, 'voucher_code','voucher_desc','voucher_value','product','start_date','end_date','is_percent','filename');
	var $column_search = array(null, 'voucher_code','voucher_desc','voucher_value','product','start_date','end_date','is_percent','filename');
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
			$order='voucher_code';
		}

		$sql="SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.ids
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND end_date > now()
			AND gerai_voucher_users.is_active='1'
			AND (voucher_code LIKE '%".$keyword."%'
		    OR voucher_desc LIKE '%".$keyword."%')";
		    if($order=='voucher_code'){
			$sql.=" ORDER BY voucher_code DESC ";
			}else{
				$sql.=" ORDER BY ".$order." ".$dir." ";
			}
			$sql.=" LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();

	}


	function count_all($keyword=''){
		$query="SELECT count(*) as jml 
		FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%".$keyword."%' 
		OR voucher_desc LIKE '%".$keyword."%'
		OR voucher_value LIKE '%".$keyword."%'
		OR product LIKE '%".$keyword."%'
		OR start_date LIKE '%".$keyword."%'
		OR end_date LIKE '%".$keyword."%'
		OR filename LIKE '%".$keyword."%'
		)";
		return $this->db->query($query)->row()->jml;
	}

	// function count_all($keyword=''){
	//  	$query="SELECT count(*) as jml 
	 	
	//  	FROM gerai_voucher_code
	// 	INNER JOIN gerai_group_users
	// 	ON gerai_voucher_code.ids=gerai_group_users.ids
	// 	WHERE gerai_voucher_users.ids
	// 	AND gerai_voucher_users.is_active='1'
	//  	AND (voucher_code LIKE '%".$keyword."%' 
	//  	OR voucher_desc LIKE '%".$keyword."%'
	//  	OR voucher_value LIKE '%".$keyword."%'
	//  	OR product LIKE '%".$keyword."%'
	//  	OR start_date LIKE '%".$keyword."%'
	//  	OR end_date LIKE '%".$keyword."%'
	//  	OR filename LIKE '%".$keyword."%'
	//  	)";
	//  	return $this->db->query($query)->row()->jml;
	// }

	// function insert_data($data){
	// 	$this->db->insert('gerai_voucher_code', $data);
	// 	return $this->db->insert_id();
	// }

	function update_data($id,$data){
		$this->db->where('ids',$id);
		$this->db->update('gerai_voucher_users',$data);
		return $this->db->affected_rows();
	}


}