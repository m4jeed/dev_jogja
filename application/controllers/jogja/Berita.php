<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends MY_Jogja {
	var $column_order = array(null, 'news_title');

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_berita','berita');
		//$this->load->helper('url');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Berita';
		$data['box_title']='List';
		$data['content']='jogja/v_berita';
		$this->load->view('jogja/template',$data);
	}

	public function add(){
		$data['top_title']='Add New Berita';
		$data['box_title']='List';
		$data['content']='jogja/v_formberita';
		$this->load->view('jogja/template',$data);
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->berita->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
	
		$query=$this->berita->get_all($start,$length,$search,$this->column_order[$order], $dir);
		
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$ids=$row['ids'];
			$output['data'][]=array($nomor_urut
									 ,$row['news_title']
									,'<center><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="showEditData('.$ids.')"><i class="fa fa-edit"></i></a>
									<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$ids.')"><i class="fa fa-trash"></i></a></center>'
									);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function jsonSaveData(){
		if ($this->input->post()){
			$ids =$this->input->post('ids',true);
			if ($ids=='') {// insert data
				$this->form_validation->set_rules('news_title', 'Nama Title', 'trim|required|min_length[4]|max_length[1000]|is_unique[gerai_news.news_title]');
			}else{
				$this->form_validation->set_rules('news_title', 'Nama Title', 'trim|required|min_length[4]|max_length[1000]');
			}
			$this->form_validation->set_rules('news_content','Content','trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{ 
				if($ids!=''){
					$news_title=$this->input->post('news_title',true);
					$cek=$this->db->query("SELECT count(*) as jumlah FROM gerai_news WHERE ids<>'".$ids."' and news_title='".$news_title."'")
										->row()->jumlah;
					if($cek>0){
						$data=array('status'=>'error','data'=>'Nama Judul Sudah Ada');
											
						header('Content-Type: application/json');
						echo json_encode($data);
						die();
					}
				}
						if(isset($_FILES["image_file"]["name"])){
							$config['upload_path'] = './assets/berita';  
							$config['allowed_types'] = 'jpg|jpeg|png|gif';  
							$config['file_name'] = ''.time().uniqid().'';  
							$this->load->library('upload', $config);  
							if(!$this->upload->do_upload('image_file'))  
							{  
								// $data=array('status'=>'error','data'=>$this->upload->display_errors());
												
								// header('Content-Type: application/json');
								// echo json_encode($data);
								// die();
							}  
							else  
							{  
								$data_upload = $this->upload->data();
								$data['news_image']=$data_upload["file_name"];
							}
					    }

						$data['news_title']=strip_tags(trim($this->input->post('news_title',true)));
						$data['news_content']=trim($this->input->post('news_content',true));

						if ($ids=='') {
						$data['created_on']=date('Y-m-d H:i:s');
						$data['created_by']=$this->session->userdata('uname');
						$data['is_active']='1';
						$data['group_id'] ='2';
						$result=$this->berita->insert_data($data);
						if($result){
						$data=array('status'=>'sukses','data'=>'Success Insert Data');
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
		$data['top_title']='Edit Berita';
		$data['box_title']='List';
		$data['content']='jogja/v_editformberita';

		$ids=$this->uri->segment(4);
		$result=$this->berita->get_one($ids);
		
		if($result){
			$data['ambil']=array('status'=>'sukses','data'=>$result);
		}else{
			$data['ambil']=array('status'=>'error','data'=>'Error Insert Data');
		}

		// echo "<pre>";
		// print_r($data);
		$this->load->view('jogja/template',$data);

		// die;
	}

	function execute($type="",$act="",$id=""){
		$uri_segments= $this->session->userdata('segments');
    	$uri = base_url()."jogja/berita".$uri_segments;
		if($type == 'update'){
			if ($act == "berita") {
				$data['news_title']=strip_tags(trim($this->input->post('news_title',true)));
				$data['news_content']=trim($this->input->post('news_content',true));
				$sql="SELECT * FROM gerai_news WHERE news_title LIKE '%".$data['news_title']."%' ";
				$result=$this->db->query($sql)->row();
				if ($result!=NULL) {
					echo "<script>javascript:alert('News title tidak boleh sama atau kosong'); window.location = '".$uri."'</script>";
				}else{
					//var_dump($result);die();
				if(isset($_FILES["image_file"]["name"])){
					$config['upload_path'] = './assets/berita';  
					$config['allowed_types'] = 'jpg|jpeg|png|gif';  
					$config['file_name'] = ''.time().uniqid().'';  
					$this->load->library('upload', $config);  
					if(!$this->upload->do_upload('image_file'))  
					{  
						// $data=array('status'=>'error','data'=>$this->upload->display_errors());
										
						// header('Content-Type: application/json');
						// echo json_encode($data);
						// die();
					}  
					else  
					{  
						$data_upload = $this->upload->data();
						$data['news_image']=$data_upload["file_name"];
					}
			    }
				$this->db->where('ids', $id);
				$this->db->update('gerai_news', $data);
				if ($data) {
					$this->session->set_flashdata('success', "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Data Berhasil Diupdate</span>
				</div>");
				redirect('jogja/berita');
				}else{
					$this->session->set_flashdata('failed', "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>		
					<span>Data Gagal Diupdate</span>
					</div>");
					redirect('jogja/berita');
					}
				// echo "<script>
				// alert('Success update');
				// </script>";
				}
				
				// $currentURL = "http://localhost/dev_gerai/jogja/berita";//base_url('jogja/berita');
				// echo $currentURL;die;
				// echo ("<script LANGUAGE='JavaScript'>
				//     window.alert('Succesfully Updated');
				//     window.location.href='".$currentURL.";
				//     </script>");
				 
				
				// echo "berhasil";
				//return $this->db->affected_rows();
				// echo "test";
				// var_dump($this->input->post());

			}
		}
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
				$result=$this->berita->update_data($ids,$data);
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