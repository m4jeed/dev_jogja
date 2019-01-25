<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_poin extends CI_Model {

	var $table = 'ma_vacc'; 
	var $column_order = array(null, 'fullname','phone','poin','balance','vacc_number');
	var $column_search = array('fullname','phone','poin','balance','vacc_number');
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
			$order='poin';
		}
		$sql="SELECT ma_vacc.*, 
			ma_users.fullname,
			ma_users.phone
			FROM ma_vacc 
			INNER JOIN ma_users
			ON ma_vacc.user_id=ma_users.user_id
			WHERE ma_vacc.user_id=ma_users.user_id
			AND (poin LIKE '%".$keyword."%')";

			if($order=='poin'){
			$sql.=" ORDER BY poin";
			}else{
			$sql.=" ORDER BY ".$order." ".$dir." ";
			}
			$sql.=" LIMIT ".$limit." OFFSET ".$offset."";
			return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM ma_vacc 
			WHERE poin LIKE '%".$keyword."%' 
			OR user_id LIKE '%".$keyword."%'
			OR balance LIKE '%".$keyword."%'
			";
		return $this->db->query($sql)->row()->jumlah;
	}

}