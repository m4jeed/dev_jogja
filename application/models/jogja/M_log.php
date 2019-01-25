<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model{
	var $table = 'log_request'; 
	//var $column_order = array(null, 'request_post','response','request_header','url');
	var $column_order = array(null, 'request_post','response','url','timestamp','ip_address','request_get','request_header'); 
	var $column_search = array('request_post','response','url','timestamp','ip_address','request_get','request_header');
	var $order = array('log_id' => 'asc');

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
			$order='request_post';
		}

		$sql="
			SELECT * FROM log_request 
			WHERE request_post LIKE '%".$keyword."%' 
			OR response LIKE '%".$keyword."%'
			OR timestamp LIKE '%".$keyword."%'
			OR ip_address LIKE '%".$keyword."%'
			OR request_get LIKE '%".$keyword."%'
			OR request_header LIKE '%".$keyword."%'
			OR url LIKE '%".$keyword."%'
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM log_request 
			WHERE request_post LIKE '%".$keyword."%' 
			OR response LIKE '%".$keyword."%'
			OR timestamp LIKE '%".$keyword."%'
			OR ip_address LIKE '%".$keyword."%'
			OR request_get LIKE '%".$keyword."%'
			OR request_header LIKE '%".$keyword."%'
			OR url LIKE '%".$keyword."%' ";
		return $this->db->query($sql)->row()->jumlah;
	}

	
}