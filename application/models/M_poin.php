<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_poin extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_poin_reward(){
		$sql="SELECT * FROM poin_reward
				WHERE is_active='1'
				AND end_date > '".date('Y-m-d')."'
				ORDER BY ids DESC ";
		$q=$this->db->query($sql);
		return $q->result_array();
	}
	
	public function get_one_poin($reward_poin_id){
		$sql="SELECT * FROM poin_reward
			where is_active='1' and ids=? ORDER BY ids DESC ";
		$q=$this->db->query($sql,array($reward_poin_id));
		return $q->row_array();
	}
	
	public function insert_poin_reward($data){
		$this->db->insert('poin_reward_claim',$data);
	}
	
	public function cek_double_claim($user_id,$reward_poin_id){
		$sql="SELECT * FROM poin_reward_claim WHERE status='pending' AND user_id=? AND reward_poin_id=?";
		$q=$this->db->query($sql,array($user_id,$reward_poin_id));
		return $q->row_array();
	}
	
	public function get_poin_reward_claim_by_user_id($user_id){
		$sql="select poin_reward_claim.*,
			poin_reward.poin_reward_desc,
			poin_reward.poin_reward_value,
			poin_reward.poin_reward_image,
			base_voucher_code.voucher_code,
			base_voucher_code.start_date,
			base_voucher_code.end_date
			from poin_reward_claim 
			INNER JOIN poin_reward
			ON poin_reward.ids=poin_reward_claim.reward_poin_id
			INNER JOIN base_voucher_code
			ON poin_reward_claim.id_voucher=base_voucher_code.ids
			WHERE poin_reward_claim.user_id=? and base_voucher_code.is_active='1'
			ORDER BY ids DESC";
		$q=$this->db->query($sql,array($user_id));
		return $q->result_array();
	}
	
	public function claim_reward_poin($data_voucher,$reward_poin_id){
		$this->db->trans_start();
			$this->db->insert('base_voucher_code',$data_voucher);
			$id_voucher=$this->db->insert_id();
			
			$data['reward_poin_id']=$reward_poin_id;
			$data['user_id']=$data_voucher['user_id'];
			$data['id_voucher']=$id_voucher;
			$data['create_on']=$data_voucher['create_on'];
			$this->db->insert('poin_reward_claim',$data);
			
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_complete();
			return TRUE;
		}
	}
	
	
	
	
	
}

