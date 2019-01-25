<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_banner extends CI_Model{
	var $table = 'gerai_banner'; 
	var $column_order = array(null, 'filename','create_on','create_by'); 
	var $column_search = array('filename','create_on','create_by');
	var $order = array('user_id' => 'asc');

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
			$order='filename';
		}

		$sql="
			SELECT * FROM gerai_banner 
			WHERE is_active='1' AND group_id='4'
			AND (filename LIKE '%".$keyword."%' 
			OR create_on LIKE '%".$keyword."%'
			OR create_by LIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM gerai_banner 
			WHERE is_active='1' AND group_id='4'
			AND (filename LIKE '%".$keyword."%' 
			OR create_on LIKE '%".$keyword."%'
			OR create_by LIKE '%".$keyword."%'
			)";
		return $this->db->query($sql)->row()->jumlah;
	}

	function insert_data($data){
		$this->db->insert('gerai_banner',$data);
		return $this->db->insert_id();
		//return $data;
	}

	function update_data($banner_id,$data){
		$this->db->where('banner_id',$banner_id);
		$this->db->update('gerai_banner',$data);
		return $this->db->affected_rows();
	}
}