<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_adm_user extends CI_Model {
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
			$order='fullname';
		}
		$sql="
			SELECT * FROM users_adm 
			WHERE aktif_flag='Y'
			AND (fullname LIKE '%".$keyword."%' 
			OR uname LIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM users_adm 
			WHERE aktif_flag='Y'
			AND (fullname LIKE '%".$keyword."%' 
			OR uname LIKE '%".$keyword."%')
			";
		return $this->db->query($sql)->row()->jumlah;
	}
	
	function get_one($user_id){
		$sql="SELECT *
			FROM users_adm
			WHERE aktif_flag='Y'
			AND user_id='".$user_id."'";
		return $this->db->query($sql)->row_array();
	}
	
	function insert_data($data){
		$this->db->insert('users_adm',$data);
		return $this->db->insert_id();
	}
	
	function update_data($user_id,$data){
		$this->db->where('user_id',$user_id);
		$this->db->update('users_adm',$data);
		return $this->db->affected_rows();
	}
	
	
	
	
	
		
		
		
}