<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_user extends MY_Admin {
	var $column_order = array(null, 'uname','fullname','lvl'); 
	
	public function __construct() 
	{
		parent::__construct();
		$lvl=$this->session->userdata('lvl');
		if(in_array($lvl,array('ADMIN'))){
			
		}else{
			redirect('admin/not_authorized');
		}
		
		$this->load->model('admin/M_adm_user','model1');
		
		
	}
	
	public function index()
	{
		$data['top_title']='Admin Users';
		$data['box_title']='List';
		$data['content']='admin/v_adm_user_list';
		$this->load->view('admin/template',$data);
	}
	
	function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->model1->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->model1->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$user_id=$row['user_id'];
			$output['data'][]=array($nomor_urut
									,$row['uname']
									,$row['fullname']
									,$row['lvl']
									,'<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$user_id.')">Edit</a>
									<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$user_id.')">Delete</a>
									<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="showModalCP('.$user_id.')">ChangePassword</a>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
		
		
	}
	
	public function jsonGetOneData(){
		if($this->input->post()){
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				$result=$this->model1->get_one($user_id);
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
	
	
	public function jsonInsertData(){
		if($this->input->post()){
			$this->form_validation->set_rules('uname', 'Username', 'trim|required|min_length[4]|max_length[20]|is_unique[users_adm.uname]');
			$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('lvl', 'Level', 'trim|required');
			$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('retype_pass', 'Retype Password', 'trim|required|min_length[8]|max_length[20]|matches[pass]');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$data['uname']=strip_tags(trim($this->input->post('uname',true)));
				$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
				$data['lvl']=strip_tags(trim($this->input->post('lvl',true)));
				$data['create_by']=$this->session->userdata('uname');
				$data['create_on']=date('Y-m-d H:i:s');
				$data['aktif_flag']='Y';
				$data['salt']=uniqid().time();
				$data['pass']=myhash(strip_tags(trim($this->input->post('pass',true))),$data['salt']);
				
				$result=$this->model1->insert_data($data);
				if($result){
					$data=array('status'=>'sukses','data'=>'Success Insert Data');
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
	
	
	public function jsonUpdateData(){
		if($this->input->post()){
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('lvl', 'Level', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
				$data['lvl']=strip_tags(trim($this->input->post('lvl',true)));
				$data['update_by']=$this->session->userdata('uname');
				$data['update_on']=date('Y-m-d H:i:s');
				$result=$this->model1->update_data($user_id,$data);
				if($result){
					$data=array('status'=>'sukses','data'=>'Success Update Data');
				}else{
					$data=array('status'=>'error','data'=>'Error Update Data');
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
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				$data['aktif_flag']='N';
				$data['update_by']=$this->session->userdata('uname');
				$data['update_on']=date('Y-m-d H:i:s');
				$result=$this->model1->update_data($user_id,$data);
				if($result){
					$data=array('status'=>'sukses','data'=>'Success Delete Data');
				}else{
					$data=array('status'=>'error','data'=>'Error Delete Data');
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	public function jsonCP(){
		if($this->input->post()){
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('retype_pass', 'Retype Password', 'trim|required|min_length[8]|max_length[20]|matches[pass]');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				$user=$this->model1->get_one($user_id);
				$data['pass']=myhash(strip_tags(trim($this->input->post('pass',true))),$user['salt']);
				$data['update_by']=$this->session->userdata('uname');
				$data['update_on']=date('Y-m-d H:i:s');
				$result=$this->model1->update_data($user_id,$data);
				if($result){
					$data=array('status'=>'sukses','data'=>'Success Change Password');
				}else{
					$data=array('status'=>'error','data'=>'Error Change Password');
				}
			}
			echo json_encode($data);
		}else{
			$data=array('status'=>'error','data'=>'Only POST Data');
			echo json_encode($data);
		}
	}
	
	
	
	
	
	
}
