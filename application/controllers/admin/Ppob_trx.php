<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppob_trx extends MY_Admin {
	var $column_order = array(null, 'trx_date','reffnum','trx_desc','trx_status','trx_amount','sale_price','base_price','admin_fee','admin_bank','cashback'); 
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('admin/M_ppob_trx','M_ppob_trx');
		
	}
	
	public function index()
	{
		$data['top_title']='PPOB Trx';
		$data['box_title']='List';
		$data['content']='admin/v_ppob_trx_list';
		$this->load->view('admin/template',$data);
	}
	
	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->M_ppob_trx->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->M_ppob_trx->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			
			if($row['trx_status']=='Transaksi sedang diproses'){
				$trx_status='<b><font color="red">'.$row['trx_status'].'</font></b>';
				$reffnum='<a href="javascript:void(0)" onclick="jsonCekReffnum('.$row['reffnum'].')">'.$row['reffnum'].'</a>';
			}else{
				$trx_status=$row['trx_status'];
				$reffnum=$row['reffnum'];
			}
			$output['data'][]=array($nomor_urut
									,$row['trx_date']
									,'<a href="javascript:void(0)" onclick="jsonCekReffnum('.$row['reffnum'].')">'.$row['reffnum'].'</a>'
									,$row['trx_desc']
									,$trx_status
									,number_format($row['trx_amount'],0)
									,number_format($row['sale_price'],0)
									,number_format($row['base_price'],0)
									,number_format($row['admin_fee'],0)
									,number_format($row['admin_bank'],0)
									,number_format($row['cashback'],0)
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	
	
	public function jsonCekReffnum(){
		if($this->input->post()){
			$this->form_validation->set_rules('reffnum', 'reffnum', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$reffnum=strip_tags(trim($this->input->post('reffnum',true)));
				$this->load->model('M_id_biller');
				$data=$this->M_id_biller->data_transaction_service($reffnum,'','','');
				$result=$data['result'];
				if($result){
					if(isset($result['DataTransactions'][0]['TransDesc'])){
						$data_trx['trx_status']=$result['DataTransactions'][0]['TransDesc'];
						$this->db->where('reffnum',$reffnum);
						$this->db->update('ppob_trx',$data_trx);
					}
					
					$data=array('status'=>'sukses','data'=>$result);
				}else{
					$data=array('status'=>'error','data'=>'Error Insert Data');
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	
	
	
	
	
	
}
