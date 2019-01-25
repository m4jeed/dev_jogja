<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{
	var $table = 'ma_users'; 
	var $column_order = array(null, 'fullname','email','gender'); 
	var $column_search = array('fullname','email','gender');
	var $order = array('user_id' => 'asc');

	public function __construct(){
        parent::__construct();
        //$this->load->library('session');
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
			SELECT * FROM ma_users 
			WHERE is_active='1'
			AND (fullname LIKE '%".$keyword."%' 
			OR email LIKE '%".$keyword."%'
			OR gender LIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM ma_users 
			WHERE is_active='1'
			AND (fullname LIKE '%".$keyword."%' 
			OR email LIKE '%".$keyword."%'
			OR gender LIKE '%".$keyword."%'
			)";
		return $this->db->query($sql)->row()->jumlah;
	}

	function get_one($user_id){
		$sql="SELECT *
			FROM ma_users
			WHERE is_active='1'
			AND user_id='".$user_id."'";
		return $this->db->query($sql)->row_array();
	}

	function insert_data($data, $dataz){
		$this->db->insert('ma_users',$data);
		$id=$this->db->insert_id();
		$dataz['user_id']=$id;
		$this->db->insert('gerai_group_users', $dataz);
		return $id;
	}

	function update_data($user_id,$data,$dataz){
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		$this->db->where('user_id',$user_id);
		$this->db->update('gerai_group_users',$dataz);
		return $this->db->affected_rows();
	}


}