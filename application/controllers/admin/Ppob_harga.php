<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppob_harga extends MY_Admin {
	
	public function __construct() 
	{
		parent::__construct();
		
		
	}
	
	public function index()
	{
		$data['res1AXIS']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='AXIS' order by product_price")->result_array();
		$data['res1INDOSAT']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='INDOSAT' order by product_price")->result_array();
		$data['res1TELKOMSEL']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='TELKOMSEL' order by product_price")->result_array();
		$data['res1THREE']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='THREE' order by product_price")->result_array();
		$data['res1XL']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='XL' order by product_price")->result_array();
		$data['res1SMARTFREN']=$this->db->query("select * from idbiller_price_service where product_type='pulsa_prabayar' and product_status='open' and provider='SMARTFREN' order by product_price")->result_array();
		
		$data['res2AXIS']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='AXIS' order by product_price")->result_array();
		$data['res2INDOSAT']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='INDOSAT' order by product_price")->result_array();
		$data['res2TELKOMSEL']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='TELKOMSEL' order by product_price")->result_array();
		$data['res2THREE']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='THREE' order by product_price")->result_array();
		$data['res2XL']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='XL' order by product_price")->result_array();
		$data['res2SMARTFREN']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='SMARTFREN' order by product_price")->result_array();
		$data['res2BOLT']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open' and provider='BOLT' order by product_price")->result_array();
		
		$data['res2']=$this->db->query("select * from idbiller_price_service where product_type='paket_data' and product_status='open'")->result_array();
		$data['top_title']='PPOB Harga Pulsa';
		$data['box_title']='List';
		$data['content']='admin/v_ppob_harga_list';
		$this->load->view('admin/template',$data);
	}
	
	public function jsonUpdateHarga(){
		$this->db->trans_start();
			$gerai_fee=1000;
			$this->db->query("truncate table idbiller_price_service");
			$this->load->model('M_id_biller');
			$Model='pulsa';
			$res=$this->M_id_biller->price_service($Model);
			if($res['is_error']=='0'){
				//var_dump($res['result']);
				foreach($res['result'] as $row){
					//var_dump($row['Provider']);
					$res2['provider']=$row['Provider'];
					foreach($row['DataProducts'] as $row1){
						$res2['code']=$row1['code'];
						$res2['name']=$row1['name'];
						$res2['price']=$row1['price'];
						$res2['status']=$row1['status'];
						
						$data['model']=$Model;
						$data['provider']=$res2['provider'];
						$data['product_code']=$res2['code'];
						$data['product_name']=$res2['name'];
						$data['product_price']=$res2['price'];
						$data['product_status']=$res2['status'];
						$data['product_saleprice']=(int)$res2['price']+(float)$gerai_fee;
						$data['product_type']='pulsa_prabayar';
						$data['updated_on']=date('Y-m-d H:i:s');
						$this->db->insert('idbiller_price_service',$data);
						
						
					}
					$res3[]=$res2;
					
				}
				//var_dump($res3);
			}
			
			$Model='data';
			$res=$this->M_id_biller->price_service($Model);
			if($res['is_error']=='0'){
				//var_dump($res['result']);
				foreach($res['result'] as $row){
					//var_dump($row['Provider']);
					$res2['provider']=$row['Provider'];
					foreach($row['DataProducts'] as $row1){
						$res2['code']=$row1['code'];
						$res2['name']=$row1['name'];
						$res2['price']=$row1['price'];
						$res2['status']=$row1['status'];
						
						$data['model']=$Model;
						$data['provider']=$res2['provider'];
						$data['product_code']=$res2['code'];
						$data['product_name']=$res2['name'];
						$data['product_price']=$res2['price'];
						$data['product_status']=$res2['status'];
						$data['product_saleprice']=(int)$res2['price']+(float)$gerai_fee;
						$data['product_type']='paket_data';
						$data['updated_on']=date('Y-m-d H:i:s');
						$this->db->insert('idbiller_price_service',$data);
						
						
					}
					$res3[]=$res2;
					
				}
				//var_dump($res3);
			}
			
			$this->db->query("UPDATE idbiller_price_service SET product_status='close' WHERE product_name LIKE '%TRANSFER%'");
			$this->db->query("UPDATE idbiller_price_service SET product_status='close' WHERE product_name LIKE '%TRANSER%'");
			$this->db->query("UPDATE idbiller_price_service SET provider='SMARTFREN' WHERE provider='SMARTFREN&apos;'");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result=false;
		} else {
			$this->db->trans_complete();
			$result=true;
		}

		if($result){
			$data=array('status'=>'sukses','data'=>"Success update data");
		}else{
			$data=array('status'=>'error','data'=>'Error update data');
		}
		echo json_encode($data);
	}
	
	
	
	
	
	
}
