<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_refund_request extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
		
	}
	
	function get_all($offset='',$limit='',$keyword='',$order,$dir,$status=''){
		
		if($status==''){
			$status='';
		}
		if($offset==''){
			$offset=0;
		}
		if($limit==''){
			$limit=10;
		}
		if($order==''){
			$order='gerai_refund_request.refund_id';
		}
		$sql="
			SELECT ma_trx.*,
			gerai_refund_request.refund_id,
			gerai_refund_request.request_by,
			gerai_refund_request.request_on,
			gerai_refund_request.approve_by,
			gerai_refund_request.approve_on,
			gerai_refund_request.status
			FROM gerai_refund_request
			INNER JOIN ma_trx
			ON gerai_refund_request.trx_id=ma_trx.trx_id
			WHERE status='".$status."'
			AND (ma_trx.trx_desc LIKE '%".$keyword."%' 
			OR ma_trx.vacc_number LIKE '%".$keyword."%')
			ORDER BY ".$order." ".$dir."
			LIMIT ".$limit." OFFSET ".$offset."";
		return $this->db->query($sql)->result_array();
	}
	
	function count_all($keyword='',$status){
		$sql="
			SELECT count(*) as jumlah
			FROM gerai_refund_request
			INNER JOIN ma_trx
			ON gerai_refund_request.trx_id=ma_trx.trx_id
			WHERE status='".$status."'
			AND (ma_trx.trx_desc LIKE '%".$keyword."%' 
			OR ma_trx.vacc_number LIKE '%".$keyword."%')
		";
		return $this->db->query($sql)->row()->jumlah;
	}
	
	function get_one($refund_id){
		$sql="
			SELECT ma_trx.*,
			gerai_refund_request.refund_id,
			gerai_refund_request.request_by,
			gerai_refund_request.request_on,
			gerai_refund_request.approve_by,
			gerai_refund_request.approve_on,
			gerai_refund_request.status
			FROM gerai_refund_request
			INNER JOIN ma_trx
			ON gerai_refund_request.trx_id=ma_trx.trx_id
			WHERE refund_id='".$refund_id."'
			";
		return $this->db->query($sql)->row_array();
	}
	
	function insert_data($data){
		$this->db->insert('gerai_refund_request',$data);
		return $this->db->insert_id();
	}
	
	function update_data($refund_id,$data){
		$this->db->where('refund_id',$refund_id);
		$this->db->update('gerai_refund_request',$data);
		return $this->db->affected_rows();
	}
	
	//hanya refund dana tidak refund poin, poin tidak di refund sebagai permintaaan maaf karena transaksi gagal
	function refund_approved($refund_id){
		$this->db->trans_start();
			$refund=$this->db->query("SELECT * FROM gerai_refund_request WHERE refund_id='".$refund_id."'")->row_array();
			if($refund){
				$data_refund['status']='approve';
				$data_refund['approve_by']=$this->session->userdata('uname');
				$data_refund['approve_on']=date('Y-m-d H:i:s');
				$this->db->where('refund_id',$refund_id);
				$this->db->update('gerai_refund_request',$data_refund);
				$affected_rows1=$this->db->affected_rows();
				if($affected_rows1!='1'){
					$this->db->trans_rollback();
					return 'trans_rollback1';
				}
				
				$trx_id=$refund['trx_id'];
				$trx=$this->db->query("SELECT * FROM ma_trx WHERE trx_id='".$trx_id."' OR cor_remark='".$trx_id."' AND trx_type='ppob'")->result_array();
				if($trx){
					foreach($trx as $row){
						$va=$this->db->query("SELECT * FROM ma_vacc WHERE vacc_number='".$row['vacc_number']."'")->row_array();
						if($va){
							//update trx
							$data['is_refund']='Y';
							$this->db->where('trx_id',$row['trx_id']);
							$this->db->update('ma_trx',$data);
							$affected_rows2=$this->db->affected_rows();
							if($affected_rows2!='1'){
								$this->db->trans_rollback();
								return 'trans_rollback2';
							}
							
							//update balance
							if($row['dk']=='d'){
								$balance=(float)$va['balance']+(float)$row['amount'];
							}else{
								$balance=(float)$va['balance']-(float)$row['amount'];
							}
							$data_balance['balance']=$balance;
							$this->db->where('vacc_number',$row['vacc_number']);
							$this->db->update('ma_vacc',$data_balance);
							$affected_rows3=$this->db->affected_rows();
							if($affected_rows3!='1'){
								$this->db->trans_rollback();
								return 'trans_rollback3';
							}
							
							//insert history
							$insert_id='';
							$data_trx['trx_type']='refund_'.$row['trx_type'];
							$data_trx['trx_desc']='COR '.$row['trx_desc'];
							$data_trx['amount']=$row['amount'];
							if($row['dk']=='d'){
								$dk='k';
							}else{
								$dk='d';
							}
							$data_trx['dk']=$dk;
							$data_trx['balance']=$balance;
							$data_trx['vacc_number']=$row['vacc_number'];
							$data_trx['vacc_from']='0';
							$data_trx['vacc_to']='0';
							$data_trx['cor_remark']=$trx_id;
							$data_trx['referral']=$row['referral'];
							$data_trx['trx_id2']='9'.generateCode();
							$this->db->insert('ma_trx',$data_trx);
							$insert_id=$this->db->insert_id();
							
							if($insert_id==''){
								$this->db->trans_rollback();
								return 'trans_rollback4';
							}
						}else{
							$this->db->trans_rollback();
							return 'trans_rollback5';
						}
					}
				}else{
					$this->db->trans_rollback();
					return 'trans_rollback6';
				}
			}else{
				$this->db->trans_rollback();
				return 'trans_rollback7';
			}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 'trans_rollback8';
		} else {
			$this->db->trans_complete();
			return '';
		}

	}
	
	
	
	
	
		
		
		
}