<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model {
	public function __construct() 
	{
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
			ma_vacc.poin 
			FROM ma_users
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			WHERE is_active='1'
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
			WHERE is_active='1'
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
			INNER JOIN base_postalcode
			ON ma_users.postalcode_id=base_postalcode.ids
			WHERE ma_users.user_id='".$user_id."'";
		return $this->db->query($sql)->row_array();
	}
	
	function update_data($user_id,$data){
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
	}
	
	
	
		
		
		
}