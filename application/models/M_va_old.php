<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_va extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		$this->load->helper('myhash');
		$this->vacc_gerai='15203259019267';
		$this->limit=10;
		$this->ma_fee_tariksetor=0;

		
	}
	
	function get_balance_by_vacc($vacc_number){
		$res=$this->db->query("SELECT ids,vacc_number,balance,poin,user_id FROM ma_vacc WHERE vacc_number='".$vacc_number."'");
		return $res->row_array();
	}
	
	function get_balance_by_user_id($user_id){
		$res=$this->db->query("SELECT ids,vacc_number,balance,poin,user_id FROM ma_vacc WHERE user_id='".$user_id."'");
		return $res->row_array();
	}
	
	function get_rule(){
		$res=$this->db->query("SELECT max_balance,min_balance,max_trx_in_month FROM ma_rule");
		return $res->row_array();
	}
	
	function get_config(){
		$res=$this->db->query("SELECT * FROM ma_config");
		return $res->row_array();
	}
	
	function get_referal_code_from_vacc_number($vacc_number){
		$sql="SELECT referal_code 
			FROM ma_users 
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			WHERE vacc_number='".$vacc_number."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_vacc_number_upline($referal_code){
		$sql="SELECT vacc_number 
				FROM ma_users 
				INNER JOIN ma_vacc
				ON ma_users.user_id=ma_vacc.user_id
				WHERE my_referal_code='".$referal_code."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_user_by_phone($phone){
		$sql="SELECT ma_users.*,ma_vacc.vacc_number,ma_vacc.balance,ma_vacc.poin
				FROM ma_users
				INNER JOIN ma_vacc
				ON ma_users.user_id=ma_vacc.user_id
				WHERE phone='".$phone."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_user_by_email($email){
		$sql="SELECT ma_users.*,ma_vacc.vacc_number,ma_vacc.balance,ma_vacc.poin
				FROM ma_users
				INNER JOIN ma_vacc
				ON ma_users.user_id=ma_vacc.user_id
				WHERE email='".$email."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_user_by_vacc_number($vacc_number){
		$sql="SELECT ma_users.*,ma_vacc.vacc_number,ma_vacc.balance,ma_vacc.poin
				FROM ma_users
				INNER JOIN ma_vacc
				ON ma_users.user_id=ma_vacc.user_id
				WHERE ma_vacc.vacc_number='".$vacc_number."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_user_by_user_id($user_id){
		$sql="SELECT *
				FROM ma_users
				WHERE user_id='".$user_id."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_user_by_email_phone_vacc_number($params){
		$sql="SELECT ma_users.*,ma_vacc.vacc_number,ma_vacc.balance,ma_vacc.poin
				FROM ma_users
				INNER JOIN ma_vacc
				ON ma_users.user_id=ma_vacc.user_id
				WHERE ma_vacc.vacc_number='".$params."'
				OR ma_users.phone='".$params."'
				OR ma_users.email='".$params."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_tarik_setor_tunai($start_date,$end_date,$offset,$trx_type){
		$offset=(int)$offset;
		if($offset==''){
			$offset=0;
		}
		
		if($offset<0){
			$offset=0;
		}
		
		$sql="SELECT * FROM ma_tariksetor WHERE trx_status='Pending'
			AND trx_date>='".$start_date." 00:00:00' 
			AND trx_date<='".$end_date." 23:59:59'
			AND trx_type='".$trx_type."'";
		$sql.=" ORDER BY trx_id DESC";
		$sql.=" LIMIT ".$this->limit." OFFSET ".$offset."";
		$res=$this->db->query($sql);
		//return $sql;
		return $res->result_array();
	}
	
	function get_trx_history($vacc_number,$start_date,$end_date,$offset,$trx_type=''){
		$offset=(int)$offset;
		if($offset==''){
			$offset=0;
		}
		
		if($offset<0){
			$offset=0;
		}
		
		$sql="SELECT * FROM ma_trx 
			WHERE trx_date>='".$start_date." 00:00:00' 
			AND trx_date<='".$end_date." 23:59:59'";
		if($vacc_number!=''){
			$sql.=" AND vacc_number='".$vacc_number."'";
		}
		if($trx_type=='poin'){
			$sql.=" AND trx_type in('poin','reward_poin','referal_poin')";
		}else{
			$sql.=" AND trx_type in('transfer','topup','cashout','ppob','refund_ppob')";
		}
		$sql.=" ORDER BY trx_id DESC";
		$sql.=" LIMIT ".$this->limit." OFFSET ".$offset."";
		$res=$this->db->query($sql);
		return $res->result_array();
	}
	
	function count_trx_history($vacc_number,$start_date,$end_date,$offset,$trx_type=''){
		
		$sql="SELECT count(*) as jumlah FROM ma_trx 
			WHERE trx_date>='".$start_date." 00:00:00' 
			AND trx_date<='".$end_date." 23:59:59'";
		if($vacc_number!=''){
			$sql.=" AND vacc_number='".$vacc_number."'";
		}
		if($trx_type=='poin'){
			$sql.=" AND trx_type in('poin','reward_poin','referal_poin')";
		}else{
			$sql.=" AND trx_type in('transfer','topup','cashout','ppob')";
		}
		$res=$this->db->query($sql);
		return $res->row()->jumlah;
	}
	
	function inquiry_vacc($vacc_number){
		$sql="SELECT vacc_number,user_id,poin,balance FROM ma_vacc WHERE vacc_number='".$vacc_number."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function transfer($trx_type,$trx_desc,$amount,$vacc_from,$vacc_to,$pin='',$referral=''){
		$data_from='';
		$data_to='';
		
		$rule=$this->get_rule();
		$from=$this->get_user_by_vacc_number($vacc_from);
		$to=$this->get_user_by_vacc_number($vacc_to);
		//cek vacc_from exits
		if(!$from){
			$response_msg['is_error']='1';
			$response_msg['response_msg']='VA sumber tidak ditemukan';
			$response_msg['result']=[];
			return $response_msg;
		}
		
		//cek vacc_to exits
		if(!$to){
			$response_msg['is_error']='1';
			$response_msg['response_msg']='VA tujuan tidak ditemukan';
			$response_msg['result']=[];
			return $response_msg;
		}
		
		//cek PIN vacc_from exits
		//var_dump($from['pin']);
		//var_dump(myhash($pin,$from['salt']));
		//die();
		if($from['pin']!=myhash($pin,$from['salt'])){
			$response_msg['is_error']='1';
			$response_msg['response_msg']='PIN salah';
			$response_msg['result']=[];
			return $response_msg;
		}
		
		//cek amount > balance vacc_from
		if((float)$amount>(float)$from['balance']){
			$response_msg['is_error']='1';
			$response_msg['response_msg']='Saldo tidak cukup';
			$response_msg['result']=[];
			return $response_msg;
		}
		
			
		//cek vacc_to max_balance jika trx_type='transfer'
		if($trx_type=='transfer'){
			$new_balance_to=(float)$amount+(float)$to['balance'];
			if((float)$rule['max_balance']<(float)$new_balance_to){
				$response_msg['is_error']='1';
				$response_msg['response_msg']='Saldo tidak boleh melebihi Rp.'.number_format($rule['max_balance'],0);
				$response_msg['result']=[];
				return $response_msg;
			}
		}
		
		
		
		$this->db->trans_start();
			//update ma_vacc
			if($trx_type=='poin'){
				//debit
				$data_from_vacc['poin']=(float)$from['poin']-(float)$amount;
				$balance_from=$data_from_vacc['poin'];
				$this->db->where('vacc_number',$vacc_from);
				$this->db->update('ma_vacc',$data_from_vacc);
			
				//credit
				$data_to_vacc['poin']=(float)$to['poin']+(float)$amount;
				$balance_to=$data_to_vacc['poin'];
				$this->db->where('vacc_number',$vacc_to);
				$this->db->update('ma_vacc',$data_to_vacc);
			
			}elseif($trx_type=='ppob'){
				//debit
				$data_from_vacc['balance']=(float)$from['balance']-(float)$amount;
				$balance_from=$data_from_vacc['balance'];
				$this->db->where('vacc_number',$vacc_from);
				$this->db->update('ma_vacc',$data_from_vacc);
			
			}elseif($trx_type=='transfer'){
				//debit
				$data_from_vacc['balance']=(float)$from['balance']-(float)$amount;
				$balance_from=$data_from_vacc['balance'];
				$this->db->where('vacc_number',$vacc_from);
				$this->db->update('ma_vacc',$data_from_vacc);
			
				//credit
				$data_to_vacc['balance']=(float)$to['balance']+(float)$amount;
				$balance_to=$data_to_vacc['balance'];
				$this->db->where('vacc_number',$vacc_to);
				$this->db->update('ma_vacc',$data_to_vacc);
			
				
			}elseif($trx_type=='topup'){
				//credit
				$data_to_vacc['balance']=(float)$to['balance']+(float)$amount;
				$balance_to=$data_to_vacc['balance'];
				$this->db->where('vacc_number',$vacc_to);
				$this->db->update('ma_vacc',$data_to_vacc);
			
				
			}elseif($trx_type=='cashout'){
				//debit
				$data_from_vacc['balance']=(float)$from['balance']-(float)$amount;
				$balance_from=$data_from_vacc['balance'];
				$this->db->where('vacc_number',$vacc_from);
				$this->db->update('ma_vacc',$data_from_vacc);
			
			}
			
			//update ma_trx
			$trx_id_from='0';
			if($trx_type=='transfer'||$trx_type=='poin'||$trx_type=='ppob'||$trx_type=='cashout'){
				//insert ma_trx vacc_from --debit
				
				$data_from['trx_type']=$trx_type;
				$data_from['trx_desc']=$trx_desc;
				$data_from['amount']=$amount;
				$data_from['dk']='d';
				$data_from['balance']=$balance_from;
				$data_from['vacc_number']=$vacc_from;
				$data_from['vacc_from']='0';
				$data_from['vacc_to']=$vacc_to;
				$data_from['cor_remark']=$trx_id_from;
				$data_from['referral']=$referral;
				$data_from['trx_id2']='9'.generateCode();
				$this->db->insert('ma_trx',$data_from);
				$trx_id_from=$this->db->insert_id();
			}
			
			$trx_id_to='0';
			//if($trx_type=='transfer'||$trx_type=='poin'||$trx_type=='ppob'||$trx_type=='topup'){
			if($trx_type=='transfer'||$trx_type=='poin'||$trx_type=='topup'){
				//insert ma_trx vacc_to --credit
				$data_to['trx_type']=$trx_type;
				$data_to['trx_desc']=$trx_desc;
				$data_to['amount']=$amount;
				$data_to['dk']='k';
				$data_to['balance']=$balance_to;
				$data_to['vacc_number']=$vacc_to;
				$data_to['vacc_from']=$vacc_from;
				$data_to['vacc_to']='0';
				$data_to['cor_remark']=$trx_id_from;
				$data_to['referral']=$referral;
				$data_to['trx_id2']='9'.generateCode();
				$trx_id_to=$this->db->insert('ma_trx',$data_to);
			}
			
			//poin reward utk ppob
			if($trx_type=='ppob'){
				$config=$this->get_config();
				//kasih reward poin utk customer utk setiap transaksi ppob
				//update poin credit
				$data_vacc_reward_poin['poin']=(int)$from['poin']+(int)$config['reward_poin'];
				$this->db->where('vacc_number',$vacc_from);
				$this->db->update('ma_vacc',$data_vacc_reward_poin);
				//insert ma_trx vacc_to --credit
				$data_reward_poin['trx_type']='reward_poin';
				$data_reward_poin['trx_desc']='Reward Poin '.$trx_desc;
				$data_reward_poin['amount']=$config['reward_poin'];
				$data_reward_poin['dk']='k';
				$data_reward_poin['balance']=$data_vacc_reward_poin['poin'];
				$data_reward_poin['vacc_number']=$vacc_from;
				$data_reward_poin['vacc_from']=$this->vacc_gerai;
				$data_reward_poin['vacc_to']='0';
				$data_reward_poin['cor_remark']=$trx_id_from;
				$data_reward_poin['trx_id2']='9'.generateCode();
				$this->db->insert('ma_trx',$data_reward_poin);
				
				
				//ambil referal_code customer yg beli ppob
				$get_referal_code=$this->get_referal_code_from_vacc_number($vacc_from);
				if($get_referal_code['referal_code']!=''){
					$vacc_number_upline=$this->get_vacc_number_upline($get_referal_code['referal_code']);
					if($vacc_number_upline['vacc_number']!=''){
						$referal_vacc=$this->get_balance_by_vacc($vacc_number_upline['vacc_number']);
						
						//credit
						$data_vacc_referal_poin['poin']=(int)$referal_vacc['poin']+(int)$config['referal_poin'];
						$this->db->where('vacc_number',$vacc_number_upline['vacc_number']);
						$this->db->update('ma_vacc',$data_vacc_referal_poin);
						//insert ma_trx vacc_to --credit
						$data_referal_poin['trx_type']='referal_poin';
						$data_referal_poin['trx_desc']='Referal Poin '.$trx_desc;
						$data_referal_poin['amount']=$config['referal_poin'];
						$data_referal_poin['dk']='k';
						$data_referal_poin['balance']=$data_vacc_referal_poin['poin'];
						$data_referal_poin['vacc_number']=$vacc_number_upline['vacc_number'];
						$data_referal_poin['vacc_from']=$this->vacc_gerai;
						$data_referal_poin['vacc_to']='0';
						$data_referal_poin['cor_remark']=$trx_id_from;
						$data_referal_poin['trx_id2']='9'.generateCode();
						$this->db->insert('ma_trx',$data_referal_poin);
					}
				}
				
			}
			
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$response_msg['is_error']='1';
			$response_msg['response_msg']='error transaction DB';
			$response_msg['result']=[];
			return $response_msg;
		} else {
			$this->db->trans_complete();
			if($trx_type=='topup'){
				$trx_id=$trx_id_to;
			}else{
				$trx_id=$trx_id_from;
			}
			
			$response_msg['is_error']='0';
			$response_msg['response_msg']='';
			$response_msg['result']=array('data_from'=>$data_from,
											'data_to'=>$data_to,
											'trx_id'=>$trx_id);
			return $response_msg;
		}
		
		
	}
	
	function register_user($data){
		$this->db->trans_start();
			//var_dump($data);die();
			$this->db->insert('ma_users',$data);
			$user_id=$this->db->insert_id();
			
			$data_va['vacc_number']=generateCode();
			$data_va['user_id']=$user_id;
			$data_va['balance']=0;
			$data_va['poin']=0;
			$this->db->insert('ma_vacc',$data_va);
			
			// $data_referal['my_referal_code']=$user_id;
			// $this->db->where('user_id',$user_id);
			// $this->db->update('ma_users',$data_referal);
			
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_complete();
			return $data;
		}

	
	}
	
	function update_user($user_id,$data){
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
		
	}
	
	function change_pin($user_id,$old_pin,$new_pin){
		$data['pin']=myhash($new_pin,$this->salt);
		$this->db->where('pin',myhash($old_pin,$this->salt));
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
	}
	
	function reset_pin($user_id,$new_pin){
		//$new_pin=mt_rand(123456,999999);
		$data['pin']=myhash($new_pin,$this->salt);
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
	}
	
	function change_pass($user_id,$old_pass,$new_pass){
		$data['pass']=myhash($new_pass,$this->salt);
		$this->db->where('pass',myhash($old_pass,$this->salt));
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
	} 
	
	function reset_pass($user_id,$new_pass){
		//$new_pass=mt_rand(12345678,99999999);
		$data['pass']=myhash($new_pass,$this->salt);
		$this->db->where('user_id',$user_id);
		$this->db->update('ma_users',$data);
		return $this->db->affected_rows();
	}
	
	function cor_transfer($trx_id){
		$sql="SELECT * FROM ma_trx WHERE trx_id='".$trx_id."'
			UNION ALL
			SELECT * FROM ma_trx WHERE cor_remark='".$trx_id."'";
		$trx=$this->db->query($sql)->result_array();
		if($trx){
			foreach($trx as $row){
				$user=$this->get_balance_by_vacc($trx['vacc_number']);
				if($user){
					if($row['trx_type']=='ppob' && $row['dk']=='d'){
						//credit
						$balance=(float)$user['balance']+(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('balance'=>$balance));
						
						//insert ma_trx vacc_to --credit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
						
					}elseif($row['trx_type']=='ppob' && $row['dk']=='k'){
						//debit
						$balance=(float)$user['balance']-(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('balance'=>$balance));
						
						//insert ma_trx vacc_to --debit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='d';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
					
					}elseif($row['trx_type']=='reward_poin' && $row['dk']=='d'){
						//credit
						$balance=(float)$user['poin']+(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('balance'=>$balance));
						
						//insert ma_trx vacc_to --credit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
					
					}elseif($row['trx_type']=='reward_poin' && $row['dk']=='k'){
						//debit
						$balance=(float)$user['poin']-(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('poin'=>$balance));
						
						//insert ma_trx vacc_to --debit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='d';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
					
					}elseif($row['trx_type']=='referal_poin' && $row['dk']=='d'){
						//credit
						$balance=(float)$user['poin']+(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('balance'=>$balance));
						
						//insert ma_trx vacc_to --credit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
					
					}elseif($row['trx_type']=='referal_poin' && $row['dk']=='k'){
						//debit
						$balance=(float)$user['poin']-(float)$row['amount'];
						$this->db->where('vacc_number',$trx['vacc_number']);
						$this->db->update('ma_vacc',array('poin'=>$balance));
						
						//insert ma_trx vacc_to --debit
						$data_to['trx_type']=$trx['trx_type'];
						$data_to['trx_desc']='COR '.$trx['trx_desc'];
						$data_to['amount']=$trx['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$balance;
						$data_to['vacc_number']=$trx['vacc_number'];
						$data_to['vacc_from']=$trx['vacc_from'];
						$data_to['vacc_to']=$trx['vacc_to'];
						//$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
					
					
					}
					
					
				}
			}
		}
		$response_msg['is_error']='0';
		$response_msg['response_msg']='';
		$response_msg['result']=$trx;
		return $response_msg;
	}
	
	
	function cek_phone($phone){
		$sql="SELECT user_id FROM ma_users WHERE phone='".$phone."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function cek_email($email){
		$sql="SELECT user_id FROM ma_users WHERE email='".$email."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function cek_phone_otp($phone,$otp){
		$sql="SELECT user_id,is_confirmed_hp FROM ma_users WHERE phone='".$phone."' and otp='".$otp."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function cek_pin($user_id,$pin){
		$user=$this->db->query("select user_id,pin,salt from ma_users  where user_id='".$user_id."'")
								->row_array();
		//var_dump($user);die();
		if($user['pin']==myhash($pin,$user['salt'])){
			return true;
		}else{
			return false;
		}
	}
	
	function verify_phone($phone,$otp){
		$data['is_confirmed_hp']='1';
		$this->db->where('phone',$phone);
		$this->db->where('otp',$otp);
		$this->db->update('ma_users',$data);
		return true;
	}
	
	function request_tariksetor($trx_type,$trx_desc,$amount,$vacc_agent,$vacc_customer,$ma_fee,$agent_fee){
		if($trx_type=='setortunai'){
			$agent=$this->get_balance_by_vacc($vacc_agent);
			if((float)$agent['balance']<($amount+$ma_fee)){
				$response_msg['is_error']='1';
				$response_msg['response_msg']='Saldo Agent tidak cukup';
				$response_msg['result']=[];
				return $response_msg;
			}
		}elseif($trx_type=='tariktunai'){
			$customer=$this->get_balance_by_vacc($vacc_customer);
			if((float)$customer['balance']<($amount+$ma_fee+$agent_fee)){
				$response_msg['is_error']='1';
				$response_msg['response_msg']='Saldo Anda tidak cukup';
				$response_msg['result']=[];
				return $response_msg;
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='trx_type tidak ada';
			$response_msg['result']=[];
			return $response_msg;
		}
		
		$data['trx_type']=$trx_type;
		$data['trx_desc']=$trx_desc;
		$data['amount']=$amount;
		$data['vacc_agent']=$vacc_agent;
		$data['vacc_customer']=$vacc_customer;
		$data['trx_status']='Pending';
		$data['ma_fee']=$ma_fee;
		$data['agent_fee']=$agent_fee;
		$this->db->insert('ma_tariksetor',$data);
		
		$response_msg['is_error']='0';
		$response_msg['response_msg']='Berhasil';
		$response_msg['result']=$data;
		return $response_msg;
	}
	
	function proses_tariksetor($trx_id){
		$sql="SELECT * FROM ma_tariksetor WHERE trx_id='".$trx_id."' AND trx_status='Pending'";
		$tariksetor=$this->db->query($sql)->row_array();
		if($tariksetor){
			$agent=$this->get_balance_by_vacc($tariksetor['vacc_agent']);
			$customer=$this->get_balance_by_vacc($tariksetor['vacc_customer']);
			if($tariksetor['trx_type']=='setortunai'){
				if((float)$agent['balance']>($tariksetor['amount']+$tariksetor['ma_fee'])){
					$this->db->trans_start();
						//debit agent
						$data_agent['balance']=(float)$agent['balance']-(float)$tariksetor['amount'];
						//update trx
						$trx_id_from='';
						$data_from['trx_type']=$tariksetor['trx_type'];
						$data_from['trx_desc']=$tariksetor['trx_desc'];
						$data_from['amount']=$tariksetor['amount'];
						$data_from['dk']='d';
						$data_from['balance']=$data_agent['balance'];
						$data_from['vacc_number']=$tariksetor['vacc_agent'];
						$data_from['vacc_from']='0';
						$data_from['vacc_to']=$tariksetor['vacc_customer'];
						$data_from['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_from);
						$trx_id_from=$this->db->insert_id();
						
						//update balance
						$this->db->where('vacc_number',$tariksetor['vacc_agent']);
						$this->db->update('ma_vacc',$data_agent);
						
						//credit customer
						$data_customer['balance']=(float)$agent['balance']+(float)$tariksetor['amount'];
						
						$data_to['trx_type']=$tariksetor['trx_type'];
						$data_to['trx_desc']=$tariksetor['trx_desc'];
						$data_to['amount']=$tariksetor['amount'];
						$data_to['dk']='d';
						$data_to['balance']=$data_customer['balance'];
						$data_to['vacc_number']=$tariksetor['vacc_customer'];
						$data_to['vacc_from']=$tariksetor['vacc_agent'];
						$data_to['vacc_to']='0';
						$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
						
						//update balance
						$this->db->where('vacc_number',$tariksetor['vacc_customer']);
						$this->db->update('ma_vacc',$data_customer);
						
						//update tariksetor trx
						$data_tariksetor['trx_status']='Setlement';
						$data_tariksetor['setlement_on']=date('Y-m-d H:i:s');
						$this->db->where('trx_id',$trx_id);
						$this->db->update('ma_tariksetor',$data_tariksetor);
						
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response_msg['is_error']='1';
						$response_msg['response_msg']='Trx Error';
						$response_msg['result']=[];
						return $response_msg;
					} else {
						$this->db->trans_complete();
						$response_msg['is_error']='0';
						$response_msg['response_msg']='Success';
						$response_msg['result']=[];
						return $response_msg;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='Saldo Agent tidak cukup';
					$response_msg['result']=[];
					return $response_msg;
				}
			}elseif($tariksetor['trx_type']=='tariktunai'){
				if($customer['balance']>($tariksetor['amount']+$tariksetor['ma_fee']+$tariksetor['agent_fee'])){
					$this->db->trans_start();
						//debit customer
						$data_customer['balance']=(float)$customer['balance']-(float)$tariksetor['amount'];
						//insert trx
						$trx_id_from='';
						$data_from['trx_type']=$tariksetor['trx_type'];
						$data_from['trx_desc']=$tariksetor['trx_desc'];
						$data_from['amount']=$tariksetor['amount'];
						$data_from['dk']='d';
						$data_from['balance']=$data_customer['balance'];
						$data_from['vacc_number']=$tariksetor['vacc_customer'];
						$data_from['vacc_from']='0';
						$data_from['vacc_to']=$tariksetor['vacc_agent'];
						$data_from['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_from);
						$trx_id_from=$this->db->insert_id();
						
						$data_customer['balance']=$data_customer['balance']-((float)$tariksetor['ma_fee']+(float)$tariksetor['agent_fee']);
						//insert trx
						$data_from['trx_type']=$tariksetor['trx_type'];
						$data_from['trx_desc']='Biaya Admin '.$tariksetor['trx_desc'];
						$data_from['amount']=$tariksetor['amount'];
						$data_from['dk']='d';
						$data_from['balance']=$data_customer['balance'];
						$data_from['vacc_number']=$tariksetor['vacc_customer'];
						$data_from['vacc_from']='0';
						$data_from['vacc_to']=$tariksetor['vacc_agent'];
						$data_from['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_from);
						
						//update balance customer
						$this->db->where('vacc_number',$tariksetor['vacc_customer']);
						$this->db->update('ma_vacc',$data_customer);
						
						//credit agent
						$data_agent['balance']=(float)$agent['balance']+(float)$tariksetor['amount'];
						
						$data_to['trx_type']=$tariksetor['trx_type'];
						$data_to['trx_desc']=$tariksetor['trx_desc'];
						$data_to['amount']=$tariksetor['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$data_agent['balance'];
						$data_to['vacc_number']=$tariksetor['vacc_agent'];
						$data_to['vacc_from']=$tariksetor['vacc_customer'];
						$data_to['vacc_to']='0';
						$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
						
						//credit agent
						$data_agent['balance']=(float)$agent['balance']+((float)$tariksetor['ma_fee']+(float)$tariksetor['agent_fee']);
						
						$data_to['trx_type']=$tariksetor['trx_type'];
						$data_to['trx_desc']='Komisi '.$tariksetor['trx_desc'];
						$data_to['amount']=$tariksetor['amount'];
						$data_to['dk']='k';
						$data_to['balance']=$data_agent['balance'];
						$data_to['vacc_number']=$tariksetor['vacc_agent'];
						$data_to['vacc_from']=$tariksetor['vacc_customer'];
						$data_to['vacc_to']='0';
						$data_to['cor_remark']=$trx_id_from;
						$this->db->insert('ma_trx',$data_to);
						
						//update balance
						$this->db->where('vacc_number',$agent['vacc_number']);
						$this->db->update('ma_vacc',$data_agent);
						
						//update tariksetor trx
						$data_tariksetor['trx_status']='Setlement';
						$data_tariksetor['setlement_on']=date('Y-m-d H:i:s');
						$this->db->where('trx_id',$trx_id);
						$this->db->update('ma_tariksetor',$data_tariksetor);
						
						
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response_msg['is_error']='1';
						$response_msg['response_msg']='Trx Error';
						$response_msg['result']=[];
						return $response_msg;
					} else {
						$this->db->trans_complete();
						$response_msg['is_error']='0';
						$response_msg['response_msg']='Success';
						$response_msg['result']=[];
						return $response_msg;
					}
				}else{
					$response_msg['is_error']='1';
					$response_msg['response_msg']='Saldo Customer tidak cukup';
					$response_msg['result']=[];
					return $response_msg;
				}
			}else{
				$response_msg['is_error']='1';
				$response_msg['response_msg']='trx_type tidak ditemukan';
				$response_msg['result']=[];
				return $response_msg;
			}
		}else{
			$response_msg['is_error']='1';
			$response_msg['response_msg']='Transaksi tidak ditemukan';
			$response_msg['result']=[];
			return $response_msg;
		}
		
	}
	
	function cancel_tariksetor($trx_id){
		$data['cancel_on']=date('Y-m-d H:i:s');
		$data['trx_status']='Cancel';
		$this->db->where('trx_id',$trx_id);
		$this->db->where('trx_status','Pending');
		$this->db->update('ma_tariksetor',$data);
		return $this->db->affected_rows();
	}
	
	function get_postalcode_by_id($ids){
		$sql="select * from base_postalcode where ids='".$ids."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function get_referal_downline($referal_code){
		return $this->db->query("SELECT ma_users.fullname,ma_users.email,ma_vacc.vacc_number 
								FROM ma_users 
								INNER JOIN ma_vacc
								ON ma_users.user_id=ma_vacc.user_id
								WHERE referal_code='".$referal_code."'")
								->result_array();
	}
	function get_user_by_my_referal_code($my_referal_code){
		$sql="SELECT * FROM ma_users WHERE my_referal_code='".$my_referal_code."'";
		$res=$this->db->query($sql);
		return $res->row_array();
	}
	
	function generate_vacc_number($user_id='0'){
		if(strlen($user_id)==1){
			$vacc_number='100000'.$user_id;
		}elseif(strlen($user_id)==2){
			$vacc_number='10000'.$user_id;
		}elseif(strlen($user_id)==3){
			$vacc_number='1000'.$user_id;
		}elseif(strlen($user_id)==4){
			$vacc_number='100'.$user_id;
		}elseif(strlen($user_id)==5){
			$vacc_number='10'.$user_id;
		}elseif(strlen($user_id)==6){
			$vacc_number='1'.$user_id;
		}else{
			$vacc_number='1'.$user_id;
		}
		
		return $vacc_number;
	}
	
	
	function ppob_trx($user_id,$referal_code,$trx_desc,$idbiller_payment){
		$this->db->trans_start();
			$va=$this->db->query("select * from ma_vacc where user_id='".$user_id."'")->row_array();
			if($va){
				//do nothing
				if((float)$va['balance']<(float)$idbiller_payment['trx_amount']){
					$this->db->trans_rollback();
					$response_msg['is_error']='1';
					$response_msg['response_msg']='Saldo Anda tidak cukup';
					$response_msg['result']=[];
					return $response_msg;
				}
			}else{
				$this->db->trans_rollback();
				$response_msg['is_error']='1';
				$response_msg['response_msg']='User tidak ditemukan';
				$response_msg['result']=[];
				return $response_msg;
			}
			$ma_config=$this->db->query("select * from ma_config")->row_array();
			if($ma_config){
				//do nothing
			}else{
				$this->db->trans_rollback();
				$response_msg['is_error']='1';
				$response_msg['response_msg']='ma_config empty';
				$response_msg['result']=[];
				return $response_msg;
			}
			
			//debet saldo
			$data_va['vacc_number']=$va['vacc_number'];
			$data_va['balance']=(float)$va['balance']-(float)$idbiller_payment['trx_amount'];
			$data_va['poin']=(float)$va['poin']+(float)$ma_config['reward_poin'];
			$data_va['user_id']=$user_id;
			$this->db->where('user_id',$user_id);
			$this->db->update('ma_vacc',$data_va);

			//trx saldo
			$data_trx['trx_type']='ppob';
			//$data_trx['trx_date']=date('Y-m-d H:i:s');
			$data_trx['trx_desc']=$trx_desc;
			$data_trx['amount']=$idbiller_payment['trx_amount'];
			$data_trx['dk']='d';
			$data_trx['balance']=$data_va['balance'];
			$data_trx['vacc_number']=$va['vacc_number'];
			$data_trx['vacc_from']='0';
			$data_trx['vacc_to']=$idbiller_payment['ref_number'];
			$data_trx['cor_remark']='0';
			$data_trx['trx_id2']='9'.generateCode();
			//$data_trx['referral']='0';
			$this->db->insert('ma_trx',$data_trx);
			$trx_id=$this->db->insert_id();
			
			//trx poin
			$data_trx2['trx_type']='reward_poin';
			//$data_trx['trx_date']=date('Y-m-d H:i:s');
			$data_trx2['trx_desc']='REWARD POIN '.$trx_desc;
			$data_trx2['amount']=$ma_config['reward_poin'];
			$data_trx2['dk']='k';
			$data_trx2['balance']=$data_va['poin'];
			$data_trx2['vacc_number']=$va['vacc_number'];
			$data_trx2['vacc_from']=$idbiller_payment['ref_number'];
			$data_trx2['vacc_to']='0';
			$data_trx2['cor_remark']=$trx_id;
			$data_trx2['trx_id2']='9'.generateCode();
			//$data_trx2['referral']='0';
			$this->db->insert('ma_trx',$data_trx2);
			$trx_id2=$this->db->insert_id();
			
			//insert external_id
			$data_ext['trx_id']=$trx_id;
			$data_ext['external_id']=$idbiller_payment['ids'];
			$data_ext['external_table']='idbiller_payment';
			$this->db->insert('ma_trx_external_id',$data_ext);
			
			//jika punya referal_code
			if($referal_code!=''){
				$data_va_rc['vacc_number']=$va['vacc_number'];
				$data_va_rc['balance']=(float)$va['balance']-(float)$amount;
				$data_va_rc['poin']=(float)$va['poin']+(float)$ma_config['reward_poin'];
				$data_va_rc['user_id']=$user_id;
				$this->db->where('user_id',$user_id);
				$this->db->update('ma_vacc',$data_va_rc);
				
				//trx poin
				$data_trx_rc['trx_type']='reward_poin';
				//$data_trx_rc['trx_date']=date('Y-m-d H:i:s');
				$data_trx_rc['trx_desc']='REFERRAL POIN '.$trx_desc;
				$data_trx_rc['amount']=$ma_config['referal_poin'];
				$data_trx_rc['dk']='k';
				$data_trx_rc['balance']=$data_va_rc['poin'];
				$data_trx_rc['vacc_number']=$va['vacc_number'];
				$data_trx_rc['vacc_from']='0';
				$data_trx_rc['vacc_to']=$ref_number;
				$data_trx_rc['cor_remark']=$trx_id;
				$data_trx_rc['trx_id2']='9'.generateCode();
				//$data_trx_rc['referral']='0';
				$this->db->insert('ma_trx',$data_trx_rc);
				$trx_id4=$this->db->insert_id();
				
			}
			
			
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$response_msg['is_error']='1';
			$response_msg['response_msg']='trans_rollback 3';
			$response_msg['result']=[];
			return $response_msg;
		} else {
			$this->db->trans_complete();
			$response_msg['is_error']='0';
			$response_msg['response_msg']='Success';
			$response_msg['result']=[];
			return $response_msg;
		}

	}
	
	
	function gen_referral_code($str){
		$fullname=str_replace(" ","",strtoupper($str));
		
		$mt_rand=mt_rand(100,9999);
		$substr=substr($fullname,0,3);
		$code=$substr.$mt_rand;
		
		$cek=$this->db->query("select count(*) as jumlah from ma_users where my_referal_code='".$code."'")->row()->jumlah;
		if($cek==0){
			return $code;
		}else{
			while($cek!=0) {
				$mt_rand=mt_rand(100,9999);
				$substr=substr($fullname,0,2);
				$code=$substr.$mt_rand;
				
				$cek=$this->db->query("select count(*) as jumlah from ma_users where my_referal_code='".$code."'")->row()->jumlah;
			}
			return $code;
		}
		
	}
	
	function get_detil_ppob_trx($trx_id){
		$sql="SELECT ma_trx_external_id.*,ppob_trx.remark1 
			FROM ma_trx_external_id 
			INNER JOIN ppob_trx
			ON ma_trx_external_id.external_id=ppob_trx.trx_id
			WHERE ma_trx_external_id.trx_id='".$trx_id."'";
		return $this->db->query($sql)->row_array();
	}
	
	
	
}

