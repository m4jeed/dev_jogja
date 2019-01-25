<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends My_Oi {
	var $column_order = array(null, 'fullname','email','gender');

	public function __construct(){
		parent::__construct();
		$this->load->model('oi/M_user','user');
		$this->load->model('oi/M_cmb','cmb');
		$this->load->library('session');
	}

	public function index()
	{
		$data['top_title']='Oi Users';
		$data['box_title']='List';
		$data['content']='oi/v_user';
		$data['groups'] = $this->cmb->cmbGroup();
		$this->load->view('oi/template',$data);
	}

	// public function index() {
	// 	$data['side'] 			='admin/side';
	// 	$data['judul'] 			='Admin Users';
	// 	$data['sub_judul']		='admin users';
	// 	$data['groups'] = $this->cmb->cmbGroup();
	// 	$data['content'] 		='admin/user/vUser';
		
	// 	$this->load->view('admin/halaman', $data);
	// }

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->user->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		//$query=$this->user->get_all($start,$length,$search,$order,$dir);
		$query=$this->user->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$user_id=$row['user_id'];
			$output['data'][]=array($nomor_urut
									 ,$row['fullname']
									 ,$row['email']
									 ,$row['gender']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$user_id.')"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$user_id.')"><i class="fa fa-trash"></i></a></center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	
	public function jsonInsertData(){
		if($this->input->post()){
		   $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[4]|max_length[20]|is_unique[ma_users.fullname]');
		   $this->form_validation->set_rules('email', 'email', 'trim|required|min_length[4]|max_length[100]|is_unique[ma_users.email]');
		   $this->form_validation->set_rules('gender', 'gender', 'trim|required');
		   $this->form_validation->set_rules('group_id', 'group_id', 'trim|required');
		   if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
				
				//$data=array('status'=>'error','data'=>$this->form_validation->error_array());
			}else{
				$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
				$data['email']=strip_tags(trim($this->input->post('email',true)));
				$data['gender']=strip_tags(trim($this->input->post('gender',true)));
				$dataz['group_id']=strip_tags(trim($this->input->post('group_id',true)));
				$data['is_active']='1';
				$result=$this->user->insert_data($data, $dataz);
				//var_dump($result);die();
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

	public function jsonGetOneData(){
		if($this->input->post()){
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>strip_validation_msg(validation_errors()));
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				$result=$this->user->get_one($user_id);
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

	public function jsonUpdateData(){
		if($this->input->post()){
		  $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[4]|max_length[100]|is_unique[ma_users.fullname]');
		   $this->form_validation->set_rules('gender', 'gender', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error','data'=>validation_errors());
			}else{
				$user_id=strip_tags(trim($this->input->post('user_id',true)));
				//$group_id=strip_tags(trim($this->input->post('group_id',true)));
				$data['fullname']=strip_tags(trim($this->input->post('fullname',true)));
				//$data['email']=strip_tags(trim($this->input->post('email',true)));
				$data['gender']=strip_tags(trim($this->input->post('gender',true)));
				$dataz['group_id']=strip_tags(trim($this->input->post('group_id',true)));
				$data['is_active']='1';
				$result=$this->user->update_data($user_id,$data,$dataz);
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
				$data['is_active']='0';
				//$data['update_by']=$this->session->userdata('uname');
				//$data['update_on']=date('Y-m-d H:i:s');
				$result=$this->user->update_data($user_id,$data);
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


}