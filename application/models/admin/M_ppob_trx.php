<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ppob_trx extends CI_Model {
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
		$sql="
			SELECT * FROM ppob_trx 
			WHERE reffnum LIKE '%".$keyword."%' 
			OR trx_desc LIKE '%".$keyword."%'
			OR trx_status LIKE '%".$keyword."%'
			ORDER BY trx_id DESC
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="SELECT count(*) as jumlah FROM ppob_trx 
			WHERE reffnum LIKE '%".$keyword."%' 
			OR trx_desc LIKE '%".$keyword."%'
			OR trx_status LIKE '%".$keyword."%'";
		return $this->db->query($sql)->row()->jumlah;
	}
	
	
	
	
	
	
	
	
}