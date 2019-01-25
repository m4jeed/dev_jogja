<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_cmb extends CI_Model {

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	function get_product_type(){
		$sql="SELECT DISTINCT product_type FROM ppob_price ORDER BY product_type ASC";
		$result = $this->db->query($sql)
						   ->result();

		//$ret ['']= '';
		if($result)
		{
			foreach ($result as $key => $row)
			{
				$ret [$row->product_type] = $row->product_type;
			}
		}
		
		return $ret;
	}
	
	
	
}

