<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_notifikasi extends CI_Model {
	var $table = 'gerai_notifikasi'; 
	var $column_order = array(null, 'notifikasi','fullname','created_on');
	var $column_search = array('notifikasi','fullname','created_on');
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
			$order='notifikasi';
		}
		$sql="SELECT gerai_notifikasi.*, 
			ma_users.fullname
			FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON gerai_notifikasi.userid=ma_users.user_id
			WHERE gerai_notifikasi.userid=ma_users.user_id
			AND (notifikasi LIKE '%".$keyword."%')";

			if($order=='notifikasi'){
			$sql.=" ORDER BY notifikasi";
			}else{
			$sql.=" ORDER BY ".$order." ".$dir." ";
			}
			$sql.=" LIMIT ".$limit." OFFSET ".$offset."";
			return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			WHERE notifikasi LIKE '%".$keyword."%' 
			OR userid LIKE '%".$keyword."%'
			OR created_on LIKE '%".$keyword."%'
			";
		return $this->db->query($sql)->row()->jumlah;
	}

	function create($data) {
	    $esk = $this->db->insert('gerai_notifikasi', $data);
	    return $esk;// $this->db->insert_id();
	}

	function get_one($id){
		$sql="SELECT * FROM gerai_notifikasi
			WHERE ids='".$id."' LIMIT 1";
		return $this->db->query($sql)->row_array();
	}

	public function hapus($id){
		$this->db->where('ids', $id);
		$this->db->delete('gerai_notifikasi');
		return $this->db->affected_rows();
	}


}