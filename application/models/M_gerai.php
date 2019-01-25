<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_gerai extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_province(){
		$sql="SELECT DISTINCT province FROM base_postalcode ORDER BY province ASC";
		$q=$this->db->query($sql);
		return $q->result_array();
	}
	
	public function get_city(){
		$province=strip_tags(trim($this->input->post('province',true)));
		
		$sql="SELECT DISTINCT city FROM base_postalcode WHERE province=? ORDER BY city ASC";
		$q=$this->db->query($sql,array($province));
		return $q->result_array();
	}
	
	public function get_districts(){
		$province=strip_tags(trim($this->input->post('province',true)));
		$city=strip_tags(trim($this->input->post('city',true)));
		
		$sql="SELECT DISTINCT districts FROM base_postalcode 
			WHERE province=? AND city=? 
			ORDER BY districts ASC";
		$q=$this->db->query($sql,array($province,$city));
		return $q->result_array();
	}
	
	public function get_village(){
		$province=strip_tags(trim($this->input->post('province',true)));
		$city=strip_tags(trim($this->input->post('city',true)));
		$districts=strip_tags(trim($this->input->post('districts',true)));
		
		$sql="SELECT DISTINCT village FROM base_postalcode 
				WHERE province=? AND city=? AND districts=?
				ORDER BY village ASC";
		$q=$this->db->query($sql,array($province,$city,$districts));
		return $q->result_array();
	}
	
	public function get_postalcode(){
		$province=strip_tags(trim($this->input->post('province',true)));
		$city=strip_tags(trim($this->input->post('city',true)));
		$districts=strip_tags(trim($this->input->post('districts',true)));
		$village=strip_tags(trim($this->input->post('village',true)));
		
		$sql="SELECT DISTINCT postalcode FROM base_postalcode 
			WHERE province=? AND city=? 
			AND districts=? AND village=?
			ORDER BY postalcode ASC";
		$q=$this->db->query($sql,array($province,$city,$districts,$village));
		return $q->row_array();
	}
	
	public function get_postalcode_data($province,$city,$districts,$village){
		$sql="SELECT * FROM base_postalcode 
			WHERE province=? AND city=? 
			AND districts=? AND village=?
			ORDER BY postalcode ASC";
		$q=$this->db->query($sql,array($province,$city,$districts,$village));
		return $q->row_array();
	}
	
	
	public function get_jobs(){
		$sql="SELECT job_name as pekerjaan FROM base_jobs ORDER BY job_id ASC";
		$q=$this->db->query($sql);
		return $q->result_array();
	}
	
	
	function get_banner(){
		$sql="SELECT filename FROM gerai_banner WHERE is_active='1' ORDER BY sort_id ASC";
		$q=$this->db->query($sql);
		return $q->result_array();
	}
	
	
	function get_promo(){
		$sql="SELECT filename,promo_desc FROM gerai_promo WHERE is_active='1' ORDER BY promo_id DESC";
		$q=$this->db->query($sql);
		return $q->result_array();
	}
	
	function get_ver(){
		$sql="SELECT * FROM ver_apk  ORDER BY ver_id DESC LIMIT 1";
		$q=$this->db->query($sql);
		return $q->row_array();
	}
	
	function get_job(){
		$sql="SELECT * FROM base_jobs ORDER BY job_id";
		$q=$this->db->query($sql);
		return $q->result_array();
	}

	
	
		
		
		
}