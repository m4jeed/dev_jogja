<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_poin_reward extends CI_Model {

	var $table = 'poin_rule'; 
	var $column_order = array(null, 'poin_reward','nominal_reward');
	var $column_search = array('poin_reward','nominal_reward');
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
			$order='poin_reward';
		}
		$sql="
			SELECT * FROM poin_rule 
			WHERE poin_reward LIKE '%".$keyword."%' 
			OR nominal_reward LIKE '%".$keyword."%'
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword=''){
		$sql="
			SELECT count(*) as jumlah 
			FROM poin_rule 
			WHERE poin_reward LIKE '%".$keyword."%' 
			OR nominal_reward LIKE '%".$keyword."%'
			";
		return $this->db->query($sql)->row()->jumlah;
	}

	function insert_data($data){
		$this->db->insert('poin_rule', $data);
		return $this->db->insert_id();
	}

	function get_one($id){
		$sql="SELECT *
			FROM poin_rule
			WHERE ids='".$id."'";
		return $this->db->query($sql)->row_array();
	}

	function update_data($id,$data){
		$this->db->where('ids',$id);
		$this->db->update('poin_rule',$data);
		return $this->db->affected_rows();
	}

	function delete($id){
		$this->db->where('ids',$id);
		$this->db->delete('poin_rule');
		//return $this->db->affected_rows();
	}

}