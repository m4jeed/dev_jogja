<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_Jogja {
	var $column_order = array(null, 'notifikasi','fullname','created_on');

	public function __construct() {
	parent::__construct();
		$this->load->model('jogja/M_notifikasi','notif');
		$this->load->model('jogja/M_cmb','cmb');
	} 

	public function index(){
		$data['top_title']='Notifikasi';
		$data['box_title']='List';
		$data['content']='jogja/v_notifikasi';
		$id_group ['userID']=$this->cmb->cmb_get_user();
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
		
		$total=$this->notif->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->notif->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$id=$row['ids'];
			$output['data'][]=array($nomor_urut
									,$row['notifikasi']
									,$row['fullname']
									,$row['created_on']
									// ,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showModalData('.$id.')"><i class="fa fa-edit"></i></a>
									,'<center><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$id.')"><i class="fa fa-trash"></i></a>
									</center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function add(){
		$data['top_title']='Notifikasi';
		$data['box_title']='List';
		$data['content']  ='jogja/v_formnotif';
		$data['notif']     =$this->cmb->cmb_get_notif();
		$id_group ['userID']=$this->cmb->cmb_get_user();
		// print_r($data['notif']);die();
		$this->load->view('jogja/template',$data);
	}

	public function save(){
		$data['top_title']='Notifikasi';
		$data['box_title']='List';
		$data['content']  ='jogja/v_formnotif';
		$data['notif']     =$this->cmb->cmb_get_notif();
		$id_group ['userID']=$this->cmb->cmb_get_user();
		//echo "<pre>";
		// print_r($id_group ['userID']);die(); 
		$jml=count($id_group ['userID']);
		 //$data = array();
		if ($_POST){ 
		    $desc   =$this->input->post('notifikasi');
		    $data = array();
		    for ($i = 0; $i < $jml; $i++){
		        $data = array(
		            'userid' => $id_group['userID'][$i]['user_id'],
		            'notifikasi'=>$desc
		        );
		       //  echo "<pre>";
		       // print_r($data);
		        $this->notif->create($data);
		    }
		    // die('yess');
		    
    	}
    	redirect('jogja/notifikasi');
	}

	public function jsonGetOneData(){
		$data['top_title']  ='Edit Notifikasi';
		$data['box_title']  ='List';
		$data['content']	='jogja/v_editnotifikasi';
		$data['notif']     =$this->cmb->cmb_get_notif();

		$id=$this->uri->segment(4);
		$result=$this->notif->get_one($id);
		
		if($result){
			$data['ambil_id']=array('status'=>'sukses','data'=>$result);
			// print_r($data['ambil_id']);die();
		}else{
			$data['ambil_id']=array('status'=>'error','data'=>'Error Insert Data');
		}
		$this->load->view('jogja/template',$data);

	}

	public function update($id=""){
		$data['top_title']  ='Edit Notifikasi';
		$data['box_title']  ='List';
		$data['content']	='jogja/v_editnotifikasi';
		$data['notif']     =$this->cmb->cmb_get_notif();

		$notifikasi     = strip_tags(trim($this->input->post('notifikasi')));
		$group_id 	    = strip_tags(trim($this->input->post('group_name')));

		$this->form_validation->set_rules('notifikasi', 'Notif', 'required', 'callback_namanotif');
			

		if ($this->form_validation->run() == FALSE){
        	$this->session->set_flashdata('validasi', "<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
			<span>Notifikasi tidak boleh kosong</span>
			</div>");
        	redirect('jogja/notifikasi');
        }else{
			$data = array(
				'notifikasi'=>$notifikasi,
				'group_name' 	=>$group_id,
				'created_on'=>date('Y-m-d H:i:s'),
			);	

		$this->db->where('ids',$id);
		$this->db->update('gerai_notifikasi',$data);
		if ($data) {
				$this->session->set_flashdata('success', "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
				<span>Data Berhasil Diupdate</span>
			</div>");
			redirect('jogja/notifikasi');
			}else{
				$this->session->set_flashdata('failed', "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
				<span>Data Gagal Diupdate</span>
				</div>");
				redirect('jogja/notifikasi');
			}
		}
	}

	public function hapus(){
		$id = $this->uri->segment(4);
		//var_dump($id);die();
		$result=$this->notif->hapus($id);
		//var_dump($result);die();
		if($result){
				$result=array('status'=>'sukses','data'=>'Success Delete Data');
			}else{
				$result=array('status'=>'error','data'=>'Error Delete Data');
				
			}
			echo json_encode($result);
			
		}

}