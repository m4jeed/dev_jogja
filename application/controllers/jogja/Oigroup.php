<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oigroup extends MY_Jogja {
	var $column_order = array(null, 'group_name','address','phone','city');
	public function __construct(){
	  	parent::__construct();
	  	$this->load->model('jogja/M_oigroup','group');
	  	$this->load->model('jogja/M_cmb','cmb');
	  	$this->load->library('session');
	}

	public function index()
	{
		$data['top_title']='Oi Group';
		$data['box_title']='List';
		$data['content']  ='jogja/v_oigroup';
		$data['kota']     =$this->cmb->cmb_get_city();
		// print_r($data['kota']);die();
		$this->load->view('jogja/template',$data);
	}

	public function add()
	{
		$data['top_title']='Oi Group';
		$data['box_title']='List';
		$data['content']  ='jogja/v_formoi';
		$data['kota']     =$this->cmb->cmb_get_city();
		$this->load->view('jogja/template',$data);
	}

	 public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->group->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->group->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$ids=$row['ids'];
			$output['data'][]=array($nomor_urut
									 ,$row['group_name']
									 ,$row['address']
									 ,$row['phone']
									 ,$row['city']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$ids.')"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$ids.')"><i class="fa fa-trash"></i></a></center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function save(){
			$data['top_title']='Oi Group';
			$data['box_title']='List';
			$data['content']  ='jogja/v_formoi';
			$data['kota']     =$this->cmb->cmb_get_city();
		
			/*kode tidak bisa duplikat*/
			$this->form_validation->set_rules('group_name', 'Nama Group', 'required', 'callback_namagroup');
			$this->form_validation->set_rules(
				'group_name', 'Nama Group',
		        'required|min_length[4]|max_length[100]|is_unique[oi_group.group_name]',
		        array(
		                'required'      => 'You have not provided %s.',
		                'is_unique'     => 'Maaf %s sudah terdaftar.'
		        )	
		    );

			$this->form_validation->set_rules('address','Alamat','trim|required');
			$this->form_validation->set_rules('phone','No Telepon','trim|required|numeric|max_length[16]');
			$this->form_validation->set_rules('city','Kota','trim|required');

			if($this->form_validation->run() == false){
			   $this->load->view('jogja/template',$data);
			}else{
			$data_array=array(
				'group_name'=>strip_tags(trim($this->input->post('group_name', true))),
				'city'=>strip_tags(trim($this->input->post('city', true))),
				'phone'=>strip_tags(trim($this->input->post('phone', true))),
				'address'=>strip_tags(trim($this->input->post('address', true))),
				'is_active'=>'1',
				'created_by'=>$this->session->userdata('uname'),
				'created_on'=>date('Y-m-d H:i:s'),
				);
			$this->group->insert_data($data_array);
			if ($data_array) {
					$this->session->set_flashdata('success', "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Insert Data Berhasil</span>
				</div>");
				redirect('jogja/oigroup');
				}else{
					$this->session->set_flashdata('failed', "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Insert Data Gagal</span>
					</div>");
					redirect('jogja/oigroup');
				}
			
		}

	}

	public function jsonGetOneData(){
		$data['top_title']  ='Edit Oi';
		$data['box_title']  ='List';
		$data['content']	='jogja/v_editformoi';
		$data['kota']       =$this->cmb->cmb_get_city();
		$ids=$this->uri->segment(4);
		$result=$this->group->get_one($ids);
		
		if($result){
			$data['ambil_id']=array('status'=>'sukses','data'=>$result);
			// print_r($data['ambil_id']);die();
		}else{
			$data['ambil_id']=array('status'=>'error','data'=>'Error Insert Data');
		}
		$this->load->view('jogja/template',$data);

	}

	public function update($id=""){
		$data['top_title']  ='Edit Oi';
		$data['box_title']  ='List';
		$data['content']	='jogja/v_editformoi';
		$data['kota']       =$this->cmb->cmb_get_city();
		// $uri_segments= $this->session->userdata('segments');
		//$uri = base_url()."jogja/oigroup".$uri_segments;

		$group_name     = strip_tags(trim($this->input->post('group_name')));
		$address   		= strip_tags(trim($this->input->post('address')));
		$phone 			= strip_tags(trim($this->input->post('phone')));
		$city 	        = strip_tags(trim($this->input->post('city')));

		$this->form_validation->set_rules('group_name', 'Nama Group', 'required', 'callback_namagroup');
			$this->form_validation->set_rules(
				'group_name', 'Nama Group',
		        'required|min_length[2]|max_length[100]|is_unique[oi_group.group_name]',
		        array(
		                'required'      => 'You have not provided %s.',
		                'is_unique'     => 'Maaf %s sudah terdaftar.'
		        )	
		    );

		    if ($this->form_validation->run() == FALSE)
                {
                	$this->session->set_flashdata('validasi', "<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Group Name tidak boleh sama atau kosong</span>
					</div>");
                	redirect('jogja/oigroup');
                }else{
					$data = array(
								'group_name'=>$group_name,
								'address' 	=>$address,
								'phone' 	=>$phone,
								'city' 	  	=>$city
								);	
			//print_r($data);die();
			$this->db->where('ids',$id);
			$this->db->update('oi_group',$data);
			if ($data) {
					$this->session->set_flashdata('success', "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Data Berhasil Diupdate</span>
				</div>");
				redirect('jogja/oigroup');
				}else{
					$this->session->set_flashdata('failed', "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Data Gagal Diupdate</span>
					</div>");
					redirect('jogja/oigroup');
				}
            }
		
		 	
		 //}
		
	}


	public function jsonDeleteData(){
		if($this->input->post()){
			$this->form_validation->set_rules('ids', 'ids', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
				$ids=strip_tags(trim($this->input->post('ids',true)));
				$data['is_active']='0';
				$data['updated_by']=$this->session->userdata('uname');
				$data['updated_on']=date('Y-m-d H:i:s');
				$result=$this->group->update_data($ids,$data);
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