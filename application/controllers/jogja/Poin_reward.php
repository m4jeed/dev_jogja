<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poin_reward extends MY_Jogja {

	var $column_order = array(null, 'poin_reward','nominal_reward');
	public function __construct() {
	parent::__construct();
		$this->load->model('jogja/M_poin_reward','reward');
		//$this->load->model('jogja/M_cmb','cmb');
	} 

	public function index(){
		$data['top_title']='Poin Reward';
		$data['box_title']='List';
		$data['content']='jogja/v_poin_reward';
		//$id_group ['userID']=$this->cmb->cmb_get_user();
		// echo "<pre>";
		// print_r($id_group ['userID']);die();
		// $jml=count($id_group ['userID']);
		//  print_r($jml);die();
		$this->load->view('jogja/template',$data);
	}

	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->reward->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->reward->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$id=$row['ids'];
			$output['data'][]=array($nomor_urut									
									,$row['poin_reward']
									,$row['nominal_reward']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$id.')"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$id.')"><i class="fa fa-trash"></i></a>
									</center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonSaveData(){
		if ($this->input->post()){
			$id=$this->input->post('ids', TRUE);
			
			$this->form_validation->set_rules('poin_reward','Poin Reward','trim|required');
			$this->form_validation->set_rules('nominal_reward','Nominal','trim|required');

			if ($this->form_validation->run()==FALSE){
				$data=array('status'=>'hasil_error','data'=>$this->form_validation->error_array());
			}else{
				if($id!=''){
					$poin_reward=$this->input->post('poin_reward',true);
					$cek=$this->db->query("SELECT count(*) as jumlah FROM reward_poin WHERE ids<>'".$id."' and poin_reward='".$poin_reward."'")
										->row()->jumlah;
					if($cek>0){
						$data=array('status'=>'error','data'=>'Poin Reward Sudah Ada');
											
						header('Content-Type: application/json');
						echo json_encode($data);
						die();
					}
				}

				$data['poin_reward']=strip_tags(trim($this->input->post('poin_reward', true)));
				$data['nominal_reward']=strip_tags(trim($this->input->post('nominal_reward', true)));

				if ($id==''){
						$result=$this->reward->insert_data($data);
						if($result){
							$data=array('status'=>'sukses','data'=>'Success Insert Data');
							}else{
								$data=array('status'=>'error','data'=>'Error');
							}
					// 	$result='update oke';
	
				}else{
						$result=$this->reward->update_data($id, $data);
						if($result){
						$data=array('status'=>'sukses','data'=>'Success Update Data');
						}else{
							$data=array('status'=>'error','data'=>'Error Data');
						}

					 }
				
			}
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			
		}
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function jsonGetOneData(){
		if($this->input->post()){
			$this->form_validation->set_rules('ids', 'ids', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
				$id=strip_tags(trim($this->input->post('ids',true)));
				$result=$this->reward->get_one($id);
				
				if($result){
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

	public function jsonDeleteData(){
		if($this->input->post()){
				$id=strip_tags(trim($this->input->post('ids',true)));
				$result=$this->reward->delete($id);
				if($result){
					$id=array('status'=>'sukses','data'=>'Success Delete Data');
				}else{
					$id=array('status'=>'error','data'=>'Error Delete Data');
				}
			echo json_encode($id);
		}else{
			$id=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($id);
		}
	}


}
