<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Jogja {
	var $column_order = array(null, 'filename','create_on','create_by');

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_banner','banner');
		$this->load->model('jogja/M_cmb','cmb');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Banner';
		$data['box_title']='List';
		$data['content']='jogja/v_banner';
		$this->load->view('jogja/template',$data);
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->banner->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->banner->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$banner_id=$row['banner_id'];
			$output['data'][]=array($nomor_urut
									 ,'<img src="'.base_url().'assets/banner/'.$row['filename'].'" width="100px" hight="75px">'
									 ,$row['filename']
									 ,$row['create_on']
									 ,$row['create_by']
									,'<center><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$banner_id.')"><i class="fa fa-trash"></i></a></center>'
									);
									
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonSaveData(){
		if($this->input->post()){
		   $banner_id=$this->input->post('banner_id',true);
		   if($banner_id==''){
				$this->form_validation->set_rules('filename', 'filename', 'trim|required[gerai_banner.filename]');
			}else{
				$this->form_validation->set_rules('filename', 'filename', 'trim|required');
			}if ($this->form_validation->run()==TRUE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
			   	if(isset($_FILES["image_file"]["name"])) { 
						$config['upload_path'] = './assets/banner';  
						$config['allowed_types'] = 'jpg|jpeg|png|gif';  
						$this->load->library('upload', $config);  
						if(!$this->upload->do_upload('image_file'))  
						{  
							$data=array('status'=>'error','data'=>$this->upload->display_errors());
											
							header('Content-Type: application/json');
							echo json_encode($data);
							die();
						}  
						else  
						{  
							$data_upload = $this->upload->data();
							$data['filename']=$data_upload["file_name"];
						}
				}
				
				
				if($banner_id==''){ //insert data
					$data['create_on']=date('Y-m-d H:i:s');
					$data['create_by']=$this->session->userdata('uname');
					$data['is_active']='1';
					$data['group_id'] ='4';
					$data['sort_id']  ='2';
					$result=$this->banner->insert_data($data);
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

	public function jsonDeleteData(){
		if($this->input->post()){
			$this->form_validation->set_rules('banner_id', 'banner_id', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
				$banner_id=strip_tags(trim($this->input->post('banner_id',true)));
				$data['is_active']='0';
				$data['update_by']=$this->session->userdata('uname');
				$data['update_on']=date('Y-m-d H:i:s');
				$result=$this->banner->update_data($banner_id,$data);
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