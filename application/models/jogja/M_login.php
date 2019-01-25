<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model{

	public function cek_user($dataArray){
			$query = $this->db->get_where('adm_users', $dataArray);
			return $query;
		}

	public function count_all(){
		return $this->db->count_all_results('adm_users');
	}

}