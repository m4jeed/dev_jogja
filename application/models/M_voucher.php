<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_voucher extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
		
	}
	
	function get_one($voucher_code){
		$sql="SELECT * FROM gerai_voucher_code WHERE lower(voucher_code)=? AND is_active='1'";
		$q=$this->db->query($sql,array(strtolower($voucher_code)));
		return $q->row_array();
	}
	
	
	function hitung_discount($voucher_code,$user_id,$product,$amount){
		$sql="SELECT * FROM gerai_voucher_code WHERE lower(voucher_code)=? AND user_id=? AND  product=? AND is_active='1'";
		$q=$this->db->query($sql,array(strtolower($voucher_code),$user_id,$product));
		$voucher=$q->row_array();
		//var_dump($voucher);die();
		if($voucher){
			if($voucher['is_percent']=='1'){
				$discount=((float)$amount*(float)$voucher['voucher_value'])/100;
			}else{
				$discount=(float)$voucher['voucher_value'];
			}
		}else{
			$discount=0;
		}
		return $discount;
	}
	
	function disable_voucher($voucher_code,$user_id,$product){
		$data['is_active']='N';
		$this->db->where('lower(voucher_code)',strtolower($voucher_code));
		$this->db->where('user_id',$user_id);
		$this->db->where('product',$product);
		$this->db->update('gerai_voucher_code',$data);
		
	}
	
	
}

