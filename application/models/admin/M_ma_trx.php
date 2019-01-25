<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ma_trx extends CI_Model {
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
			$order='trx_id';
		}
		$sql="SELECT * FROM ma_trx 
			WHERE vacc_number 
			LIKE '%".$keyword."%' 
			OR trx_desc LIKE '%".$keyword."%'
			ORDER BY trx_id DESC 
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="SELECT count(*) as jumlah FROM ma_trx 
			WHERE vacc_number 
			LIKE '%".$keyword."%' 
			OR trx_desc LIKE '%".$keyword."%'
			";
		return $this->db->query($sql)->row()->jumlah;
	}
	
	function get_one($trx_id){
		$sql="SELECT *
			FROM ma_trx
			WHERE trx_id='".$trx_id."'";
		return $this->db->query($sql)->row_array();
	}
	
	
	
	
	
	
	
	
}