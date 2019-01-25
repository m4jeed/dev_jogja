<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ppob extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
		
	}
	
	function cek_double_ppob_trx($user_id,$provider,$product_name,$trx_date,$trx_desc){
		$sql="SELECT count(*) as jumlah  
				FROM ppob_trx 
				WHERE user_id=?
				AND provider=? 
				AND product_name=?
				AND to_char(trx_date, 'YYYYMMDD')=?
				AND trx_desc=?";
		$q=$this->db->query($sql,array($user_id,$provider,$product_name,$trx_date,$trx_desc));
		if((int)$q->row()->jumlah>0){
			return false;
		}else{
			return true;
		}
	}
	
	function get_product_by_product_code($product_code){
		$sql="SELECT * FROM ppob_price WHERE biller1_product_code=?";
		$q=$this->db->query($sql,array($product_code));
		return $q->row_array();
		
	}
	
	
	function get_ppob_biller($type_ppob){
		$sql="select biller from ppob_settings where type_ppob=?";
		$q=$this->db->query($sql,array($type_ppob));
		if($q->num_rows()>0){
			return $q->row()->biller;
		}else{
			return '';
		}
	}
	
	function get_product_price($product_name,$product_type){
		$sql="SELECT * FROM ppob_price WHERE product_name=? and product_type=?";
		$q=$this->db->query($sql,array($product_name,strtolower($product_type)));
		return $q->row_array();
		
	}
	function get_product($product_name){
		$sql="SELECT * FROM ppob_price WHERE product_name=?";
		$q=$this->db->query($sql,array($product_name));
		return $q->row_array();
		
	}
	
	function get_product_name($provider,$product_type){
		$sql="SELECT product_name,product_type,sale_price FROM ppob_price WHERE provider=? and product_type=? order by sale_price ASC";
		$q=$this->db->query($sql,array($provider,$product_type));
		if($q->num_rows()>0){
			foreach($q->result_array() as $row){
				if($row['product_type']=='pulsa_prabayar'||$row['product_type']=='paket_data'){
					//$result[]=$row['product_name'].' (Rp.'.formatNomor($row['sale_price']).')';
					$result[]=$row['product_name'];
				}else{
					$result[]=$row['product_name'];
				}
				
			}
			return $result;
		}else{
			return array();
		}
	}
	
	function get_all_provider($product_type){
		$sql="SELECT DISTINCT provider FROM ppob_price where product_type=? order by provider";
		$q=$this->db->query($sql,array($product_type));
		if($q->num_rows()>0){
			foreach($q->result_array() as $row){
				$result[]=$row['provider'];
			}
			return $result;
		}else{
			return array();
		}
	}
	
	function get_all_product_type(){
		$sql="SELECT DISTINCT product_type FROM ppob_price order by product_type";
		$q=$this->db->query($sql);
		if($q->num_rows()>0){
			foreach($q->result_array() as $row){
				$result[]=$row['product_type'];
			}
			return $result;
		}else{
			return array();
		}
	}
	
	function insert_ppob_trx($data){
		$this->db->insert('ppob_trx',$data);
		return $this->db->insert_id();
	}
	
	function update_ppob_trx($trx_id,$data){
		$this->db->where('trx_id',$trx_id);
		$this->db->update('ppob_trx',$data);
	}
	
	function get_ppob_trx($start_date,$end_date,$user_id,$limit,$offset){
		$end_date=date('Y-m-d', strtotime($end_date . ' +1 day'));
		//var_dump($end_date);die();
		$sql="SELECT * FROM ppob_trx
			WHERE trx_date>=? AND trx_date<=?
			AND user_id=?
			ORDER BY trx_id DESC
			LIMIT ? OFFSET ?
			";
		$q=$this->db->query($sql,array($start_date,$end_date,$user_id,$limit,$offset));
		//var_dump($q->result_array());die();
		return $q->result_array();
	}
	
	function count_ppob_trx($start_date,$end_date,$user_id){
		$end_date=date('Y-m-d', strtotime($end_date . ' +1 day'));
		$sql="SELECT count(*) as jumlah FROM ppob_trx
			WHERE trx_date>=? AND trx_date<=?
			AND user_id=?
			";
		$q=$this->db->query($sql,array($start_date,$end_date,$user_id));
		return $q->row()->jumlah;
	}
	
	function get_idbiller_tagihan(){
		
	}

	
}

