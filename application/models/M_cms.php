<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_cms extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_all_users($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM users 
				INNER JOIN base_postalcode
				ON users.postalcode_id=base_postalcode.ids
				WHERE lower(fullname) LIKE '%".strtolower($keyword)."%' 
				OR lower(email) like '%".strtolower($keyword)."%' 
				OR lower(no_hp) like '%".strtolower($keyword)."%' 
				OR lower(vacc_number) like '%".strtolower($keyword)."%' 
				ORDER BY fullname 
				LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_all_users(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM users 
				INNER JOIN base_postalcode
				ON users.postalcode_id=base_postalcode.ids
				WHERE lower(fullname) LIKE '%".strtolower($keyword)."%' 
				OR lower(email) like '%".strtolower($keyword)."%' 
				OR lower(no_hp) like '%".strtolower($keyword)."%' 
				OR lower(vacc_number) like '%".strtolower($keyword)."%' 
				";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function get_one_users($user_id){
		$sql="SELECT * FROM users 
				INNER JOIN base_postalcode
				ON users.postalcode_id=base_postalcode.ids
				WHERE user_id=?";
		$q=$this->db->query($sql,array($user_id));
		return $q->row_array();
	}
	
	public function update_users($user_id,$data){
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
	}
	
	public function login_admin($uname){
		$sql="SELECT * FROM users_adm WHERE uname=? and aktif_flag='1'";
		$q=$this->db->query($sql,array($uname));
		return $q->row_array();
	}
	
	public function get_all_users_admin($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM users_adm 
			WHERE (lower(uname) like '%".$keyword."%' OR lower(fullname) like '%".$keyword."%')
			and aktif_flag='1'
			ORDER BY fullname ASC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_all_users_admin(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM users_adm 
			WHERE (lower(uname) like '%".$keyword."%' OR lower(fullname) like '%".$keyword."%')
			and aktif_flag='1'";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function get_one_users_admin($user_adm_id){
		$sql="SELECT * FROM users_adm 
			WHERE user_adm_id=?";
		$q=$this->db->query($sql,array($user_adm_id));
		return $q->row_array();
	}
	
	public function add_users_admin(){
		$data['user_adm_id']='';
		$data['uname']='';
		$data['pass']='';
		$data['fullname']='';
		$data['lvl']='';
		$data['create_by']='';
		$data['create_on']='';
		$data['update_by']='';
		$data['update_on']='';
		$data['aktif_flag']='0';
		return $data;
	}
	
	public function save_users_admin($data){
		$this->db->insert('users_adm',$data);
	}
	
	public function update_users_admin($user_adm_id,$data){
		$this->db->where('user_adm_id',$user_adm_id);
		$this->db->update('users_adm',$data);
	}
	
	public function del($user_adm_id){
		$data['aktif_flag']='0';
		$this->db->where('user_adm_id',$user_adm_id);
		$this->db->update('users_adm',$data);
	}
	
	public function get_idbiller_bill($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM idbiller_bill 
			WHERE ref_number LIKE '%".$keyword."%'
			ORDER BY bill_id DESC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_idbiller_bill(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM idbiller_bill 
			WHERE product_code LIKE '%".$keyword."%'
			";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function get_idbiller_log($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM idbiller_log 
			WHERE lower(log_request) LIKE '%".$keyword."%'
			ORDER BY logid DESC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_idbiller_log(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM idbiller_log 
			WHERE lower(log_request) LIKE '%".$keyword."%'
			";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function get_request_log($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM log_request
				WHERE lower(request_post) like '%".$keyword."%'
				ORDER BY log_id DESC
				LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_request_log(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM log_request
			WHERE lower(request_post) like '%".$keyword."%'
			";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function get_all_claim_poin($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT poin_reward_claim.*, 
				poin_reward.poin_reward_desc,
				users.fullname,
				users.no_hp,
				users.email,
				users.vacc_number
				FROM poin_reward_claim 
				INNER JOIN poin_reward
				ON poin_reward.ids=poin_reward_claim.reward_poin_id
				INNER JOIN users
				ON users.user_id=poin_reward_claim.user_id
				WHERE (lower(users.fullname) like '%".$keyword."%' or lower(users.email) like '%".$keyword."%' 
				OR lower(users.no_hp) like '%".$keyword."%' OR lower(users.vacc_number) like '%".$keyword."%'  )
				ORDER BY poin_reward_claim.ids DESC
				LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_all_claim_point(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT poin_reward_claim.*, 
				poin_reward.poin_reward_desc,
				users.fullname,
				users.no_hp,
				users.email,
				users.vacc_number
				FROM poin_reward_claim 
				INNER JOIN poin_reward
				ON poin_reward.ids=poin_reward_claim.reward_poin_id
				INNER JOIN users
				ON users.user_id=poin_reward_claim.user_id
				WHERE (lower(users.fullname) like '%".$keyword."%' or lower(users.email) like '%".$keyword."%' 
				OR lower(users.no_hp) like '%".$keyword."%' OR lower(users.vacc_number) like '%".$keyword."%'  )
				ORDER BY poin_reward_claim.ids DESC
				";
		$q=$this->db->query($sql);
		return $q->num_rows();
	}
	
	//fadli
	
	public function get_all_base_voucher($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * from base_voucher_code 
		WHERE (lower(voucher_code) like '%".$keyword."%' OR lower(voucher_desc) like '%".$keyword."%') 
		and is_active='1'
			ORDER BY ids ASC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_all_base_voucher(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah from base_voucher_code 
		WHERE (lower(voucher_code) like '%".$keyword."%' OR lower(voucher_desc) like '%".$keyword."%')
		and is_active='1'";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	public function add_base_voucher(){
		$data['ids']='';
		$data['voucher_code']='';
		$data['voucher_desc']='';
		$data['voucher_value']='';
		$data['product']='';
		$data['start_date']='';
		$data['end_date']='';
		$data['is_percent']='';
		$data['create_on']='';
		$data['create_by']='';
		$data['is_active']='1';
		return $data;
	}
	
	public function save_base_voucher($data){
		$this->db->insert('base_voucher_code',$data);
	}
	
	public function get_one_base_voucher($ids){
		$sql="SELECT * FROM base_voucher_code
			WHERE ids=?";
		$q=$this->db->query($sql,array($ids));
		return $q->row_array();
	}
	
	public function update_base_voucher($ids,$data){
		$this->db->where('ids',$ids);
		$this->db->update('base_voucher_code',$data);
		//var_dump($data);die();
	}
	
	public function del_base_voucher($ids){
		$data['is_active']='0';
		$this->db->where('ids',$ids);
		$this->db->update('base_voucher_code',$data);
	}
	
	public function get_trx_ppob($limit,$offset){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT * FROM ppob_trx 
			WHERE reffnum LIKE '%".$keyword."%'
			ORDER BY trx_id DESC LIMIT ? OFFSET ?";
		$q=$this->db->query($sql,array($limit,$offset));
		return $q->result_array();
	}
	
	public function count_trx_ppob(){
		$keyword=strip_tags(trim($this->session->userdata('keyword')));
		$sql="SELECT count(*) as jumlah FROM ppob_trx 
			WHERE reffnum LIKE '%".$keyword."%'
			";
		$q=$this->db->query($sql);
		return $q->row()->jumlah;
	}
	
	
}

