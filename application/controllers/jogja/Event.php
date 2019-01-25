<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Jogja {
	var $column_order = array(null, 'event_image','created_on','created_by');

	public function __construct(){
		parent::__construct();
		$this->load->model('jogja/M_event','event');
		$this->load->model('jogja/M_cmb','cmb');
		$this->load->library('session');
	}

	public function index(){
		$data['top_title']='Event';
		$data['box_title']='List';
		$data['content']='jogja/v_event';
		$this->load->view('jogja/template',$data);
	}

	public function ajax_list(){
		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$search=strip_tags(trim($_REQUEST['search']["value"]));
		
		$order=$_POST['order']['0']['column'];
		$dir=$_POST['order']['0']['dir'];
		
		$total=$this->event->count_all($search);
		
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$total;
		$output['data']=array();
		
		$query=$this->event->get_all($start,$length,$search,$this->column_order[$order], $dir);
		//var_dump($query);die();
		$nomor_urut=$start+1;
		foreach ($query as $row) {
			$banner_id=$row['ids'];
			$output['data'][]=array($nomor_urut
									 ,'<img src="'.base_url().'assets/event/'.$row['event_image'].'" width="100px" hight="75px">'
									 ,$row['event_image']
									 ,$row['created_on']
									 ,$row['created_by']
									,'<center><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="jsonDeleteData('.$banner_id.')"><i class="fa fa-trash"></i></a></center>'
									);
									
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function jsonSaveData(){
		if($this->input->post()){
		   $ids_id=$this->input->post('ids',true);
		   if($ids_id==''){
				$this->form_validation->set_rules('event_image', 'event_image', 'trim|required[gerai_event.event_image]');
			}else{
				$this->form_validation->set_rules('event_image', 'event_image', 'trim|required');
			}if ($this->form_validation->run()==TRUE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
			   	if(isset($_FILES["image_file"]["name"])) { 
						$config['upload_path'] = './assets/event';  
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
							$data['event_image']=$data_upload["file_name"];
						}
				}
				
				
				if($ids_id==''){ //insert data
					$data['created_on']=date('Y-m-d H:i:s');
					$data['created_by']=$this->session->userdata('uname');
					$data['is_active']='1';
					$data['group_id'] ='4';
					$result=$this->event->insert_data($data);
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
			$this->form_validation->set_rules('ids', 'ids', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$data=array('status'=>'error_val','data'=>$this->form_validation->error_array());
			}else{
				$event_id=strip_tags(trim($this->input->post('ids',true)));
				$data['is_active']='0';
				$data['updated_by']=$this->session->userdata('uname');
				$data['updated_on']=date('Y-m-d H:i:s');
				$result=$this->event->update_data($event_id,$data);
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