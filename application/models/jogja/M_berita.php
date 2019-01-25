<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_berita extends CI_Model{
	var $table = 'gerai_news';
	var $column_order = array(null, 'news_title');
	var $column_search = array('news_title');
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
			$order='news_title';
		}

		$sql="
			SELECT * FROM gerai_news 
			WHERE is_active='1'
			AND (news_title LIKE '%".$keyword."%') 
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM gerai_news 
			WHERE is_active='1'
			AND (news_title LIKE '%".$keyword."%')";
		return $this->db->query($sql)->row()->jumlah;
	}

	function insert_data($data){
		$this->db->insert('gerai_news', $data);
		return $this->db->insert_id();
	}

	function get_one($ids){
		$sql="SELECT *
			FROM gerai_news
			WHERE is_active='1'
			AND ids='".$ids."'";
		return $this->db->query($sql)->row_array();

	}

	function update_data($ids,$data){
		$this->db->where('ids', $ids);
		$this->db->update('gerai_news', $data);
		return $this->db->affected_rows();
	}


}