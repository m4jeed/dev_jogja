<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_oigroup extends CI_Model{
	var $table = 'oi_group'; //nama tabel dari database
	var $column_order = array(null, 'group_name','address','phone','city'); //field yang ada di table oigroup
	var $column_search = array('group_name','address','phone','city'); //field yang diizin untuk pencarian 
	var $order = array('ids' => 'asc'); // default order 

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
			$order='group_name';
		}

		$sql="
			SELECT * FROM oi_group 
			WHERE is_active='1'
			AND (group_name LIKE '%".$keyword."%' 
			OR address LIKE '%".$keyword."%'
			OR phone LIKE '%".$keyword."%'
			OR city lIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}

	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM oi_group 
			WHERE is_active='1'
			AND (group_name LIKE '%".$keyword."%' 
			OR address LIKE '%".$keyword."%'
			OR phone LIKE '%".$keyword."%'
			OR city LIKE '%".$keyword."%'
			)";
		return $this->db->query($sql)->row()->jumlah;
	}

	function insert_data($data_array){
		$this->db->insert('oi_group', $data_array);
	
	}

	// function role_exists($key)
	// {
	//     $this->db->where('group_name',$key);
	//     $query = $this->db->get('oi_group');
	//     if ($query->num_rows() > 0){
	//         return true;
	//     }
	//     else{
	//         return false;
	//     }
	// }

	function update_data($ids,$data){
		$this->db->where('ids',$ids);
		$this->db->update('oi_group',$data);
		return $this->db->affected_rows();
	}

	function get_one($id){
		$sql="SELECT *
			FROM oi_group
			WHERE is_active='1'
			AND ids='".$id."'";
		return $this->db->query($sql)->row_array();
	}

	// function get_one($id){
	// 	$sql="SELECT oi_group.*,
	// 	    base_postalcode.ids,
	// 		base_postalcode.city
	// 		FROM oi_group
	// 		INNER JOIN base_postalcode
	// 		ON oi_group.ids=base_postalcode.ids
	// 		-- INNER JOIN oi_member
	// 		-- ON ma_users.user_id=oi_member.user_id
	// 		WHERE oi_group.ids='".$id."' ";
	// 	return $this->db->query($sql)->row_array();

	// }
		

}