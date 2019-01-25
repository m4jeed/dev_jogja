<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_event extends CI_Model{
	var $table = 'gerai_event'; 
	var $column_order = array(null, 'event_image','created_on','created_by');
	//var $column_order = array(null, 'filename','create_on','create_by'); 
	var $column_search = array('event_image','created_on','created_by');
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
			$order='event_image';
		}

		$sql="
			SELECT * FROM gerai_event 
			WHERE is_active='1' AND group_id='4'
			AND (event_image LIKE '%".$keyword."%' 
			OR created_on LIKE '%".$keyword."%'
			OR created_by LIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM gerai_event 
			WHERE is_active='1'
			AND (event_image LIKE '%".$keyword."%' 
			OR created_on LIKE '%".$keyword."%'
			OR created_by LIKE '%".$keyword."%'
			)";
		return $this->db->query($sql)->row()->jumlah;
	}

	function insert_data($data){
		$this->db->insert('gerai_event',$data);
		return $this->db->insert_id();
		//return $data;
	}

	function update_data($event_id,$data){
		$this->db->where('ids',$event_id);
		$this->db->update('gerai_event',$data);
		return $this->db->affected_rows();
	}
}