<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cmb extends CI_Model{
	function cmbGroup(){
            $query = $this->db->query('SELECT * FROM gerai_group');
             return $query->result();
    }

    function cmbMausers(){
    	$query= $this->db->query('SELECT * FROM ma_users');
		return $query->result();	
    }

    function cmboi(){
    	$query= $this->db->query('SELECT * FROM oi_group');
		return $query->result();	
    }

    function cmb_get_city(){
        $query =$this->db->query('SELECT ids, city FROM base_postalcode group by city');
        return $query->result_array();
    }

    function cmb_get_notif(){
        $query =$this->db->query('SELECT * FROM gerai_group');
        return $query->result_array();
    }

    function cmb_get_user(){
        $query =$this->db->query('SELECT user_id FROM gerai_group_users group by user_id');
        return $query->result_array();
    }

    // function cmb_get_balance($user_id){
    //     $query =$this->db->query('SELECT balance FROM ma_vacc where user_id="$user_id"');
    //     return $query->result_array();
    // }

    // function cmb_get_nominal(){
    //     $query =$this->db->query('SELECT nominal FROM withdraw_request');
    //     return $query->result_array();
    // }

    // function cmb_users(){
    //      $query =$this->db->query('SELECT fullname FROM ma_users where is_active="1" ');
    //     //return $query->result_array();
    //     return $query->count_all_results();
    // }

    public function cmb_users(){
        return $this->db->count_all_results('ma_users');
    }

}