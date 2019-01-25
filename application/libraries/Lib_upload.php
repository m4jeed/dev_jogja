<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_upload
{
	protected $CI;
	
	protected $file_name;
	protected $mime_type;
	
	public $base_address;
	
	public $allowed_types = 'gif|jpg|png';
	public $max_size = 40000;
	
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->base_address = './assets/users_image/';
	}
	
	
	public function upload_file($upload_path,$file_name,$type=NULL,$size=NULL)
	{
		// if (!is_dir($upload_path))
			// mkdir($upload_path, 0777, TRUE);
		
		$upload_config = array();
		$upload_config['upload_path'] = $upload_path;
		$upload_config['allowed_types'] = (!empty($type)?$type:$this->allowed_types);
		$upload_config['overwrite'] = TRUE;
		$upload_config['max_size'] = (!empty($size)?$size:$this->max_size);
		
		$file_name_prefix = $this->_generate_auto_file_name();
		$this->file_name = $file_name;

		$upload_config['file_name'] = $file_name_prefix.'_'.$this->file_name;
		
		$this->CI->load->library('upload');
		$this->CI->upload->initialize($upload_config);
		if (!$this->CI->upload->do_upload($file_name))
		{
			$error_message = $this->CI->upload->display_errors();
			
			return $error_message;
			//return FALSE;
		}
		else
		{
			$upload_data = $this->CI->upload->data();
			$this->mime_type = $upload_data['file_type'];
			$file_address_destination = $upload_path.$upload_data['file_name'];
			
			//return $file_address_destination;
			return $upload_data['file_name'];
		}
	}
	
	protected function _generate_auto_file_name()
	{
		$prefix = date('YmdHis');
		$unique_value = uniqid();
		
		$file_name = $prefix.'_'.$unique_value;
		return $file_name;
	}
	
}