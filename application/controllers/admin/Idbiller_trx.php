<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Idbiller_trx extends MY_Admin {
	
	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function index()
	{
		$data['top_title']='PPOB Trx';
		$data['box_title']='List';
		$data['content']='admin/v_idbiller_trx';
		$this->load->view('admin/template',$data);
	}
	
	
	
	function export_xls(){
		if($this->input->post()){
			$this->load->model('M_id_biller');
			$RefNumber='';
			$StartDate=trim($this->input->post('start_date',true));
			$EndDate=trim($this->input->post('end_date',true));
			$Limit='';
			$res=$this->M_id_biller->data_transaction_service($RefNumber,$StartDate,$EndDate,$Limit);
			if(isset($res['is_error'])){
				if($res['is_error']=='0'){
					
					// var_dump($res['result']['DataTransactions']);
					// die();
					//load our new PHPExcel library
					$this->load->library('excel');
					//activate worksheet number 1
					$this->excel->setActiveSheetIndex(0);
					//name the worksheet
					$this->excel->getActiveSheet()->setTitle('Report');
					
					$number=1;
					$this->excel->getActiveSheet()->setCellValue('A'.$number, 'RefNumber');
					$this->excel->getActiveSheet()->setCellValue('B'.$number, 'TransDate');
					$this->excel->getActiveSheet()->setCellValue('C'.$number, 'ProductCode');
					$this->excel->getActiveSheet()->setCellValue('D'.$number, 'ProductName');
					$this->excel->getActiveSheet()->setCellValue('E'.$number, 'CustomerNumber1');
					$this->excel->getActiveSheet()->setCellValue('F'.$number, 'CustomerNumber2');
					$this->excel->getActiveSheet()->setCellValue('G'.$number, 'CustomerNumber3');
					$this->excel->getActiveSheet()->setCellValue('H'.$number, 'TransPrice');
					$this->excel->getActiveSheet()->setCellValue('I'.$number, 'TransAdminCharge');
					$this->excel->getActiveSheet()->setCellValue('J'.$number, 'TransCashback');
					$this->excel->getActiveSheet()->setCellValue('K'.$number, 'TransSn');
					$this->excel->getActiveSheet()->setCellValue('L'.$number, 'TransVoucher');
					$this->excel->getActiveSheet()->setCellValue('M'.$number, 'TransStatus');
					$this->excel->getActiveSheet()->setCellValue('N'.$number, 'TransRc');
					$this->excel->getActiveSheet()->setCellValue('O'.$number, 'TransDesc');
					
					//var_dump($res['result']['DataTransactions']);
					$number=2;
					foreach($res['result']['DataTransactions'] as $row){
						$this->excel->getActiveSheet()->setCellValue('A'.$number, $row['RefNumber']);
						$this->excel->getActiveSheet()->setCellValue('B'.$number, $row['TransDate']);
						$this->excel->getActiveSheet()->setCellValue('C'.$number, $row['ProductCode']);
						$this->excel->getActiveSheet()->setCellValue('D'.$number, $row['ProductName']);
						$this->excel->getActiveSheet()->setCellValue('E'.$number, $row['CustomerNumber1']);
						$this->excel->getActiveSheet()->setCellValue('F'.$number, $row['CustomerNumber2']);
						$this->excel->getActiveSheet()->setCellValue('G'.$number, $row['CustomerNumber3']);
						$this->excel->getActiveSheet()->setCellValue('H'.$number, $row['TransPrice']);
						$this->excel->getActiveSheet()->setCellValue('I'.$number, $row['TransAdminCharge']);
						$this->excel->getActiveSheet()->setCellValue('J'.$number, $row['TransCashback']);
						$this->excel->getActiveSheet()->setCellValue('K'.$number, $row['TransSn']);
						$this->excel->getActiveSheet()->setCellValue('L'.$number, $row['TransVoucher']);
						$this->excel->getActiveSheet()->setCellValue('M'.$number, $row['TransStatus']);
						$this->excel->getActiveSheet()->setCellValue('N'.$number, $row['TransRc']);
						$this->excel->getActiveSheet()->setCellValue('O'.$number, $row['TransDesc']);
						$number++;
						
					}
					
					$filename='idbiller_trx_'.date('YmdHis').'.xls'; //save our workbook as this file name
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
								
					//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
					
				}
			}
			
		}else{
			redirect('admin/idbiller_trx');
		}
		
	
	}
	
	
	function wallet_export_xls(){
		if($this->input->post()){
			$StartDate=trim($this->input->post('start_date2',true));
			$EndDate=trim($this->input->post('end_date2',true));
			$sql="SELECT * FROM ma_trx
					INNER JOIN ma_trx_external_id
					ON ma_trx.trx_id=ma_trx_external_id.trx_id
					INNER JOIN ppob_trx 
					ON ma_trx_external_id.external_id=ppob_trx.trx_id
					WHERE ma_trx.trx_date>='".$StartDate." 00:00:00' 
					AND ma_trx.trx_date<='".$EndDate." 00:00:00' 
					AND ma_trx.trx_type='ppob' 
					ORDER BY ma_trx.trx_id ASC";
			$res=$this->db->query($sql)->result_array();
			
				if($res){
					
					//var_dump($res);
					// die();
					//load our new PHPExcel library
					$this->load->library('excel');
					//activate worksheet number 1
					$this->excel->setActiveSheetIndex(0);
					//name the worksheet
					$this->excel->getActiveSheet()->setTitle('Report');
					
					$number=1;
					$this->excel->getActiveSheet()->setCellValue('A'.$number, 'trx_id');
					$this->excel->getActiveSheet()->setCellValue('B'.$number, 'trx_type');
					$this->excel->getActiveSheet()->setCellValue('C'.$number, 'trx_date');
					$this->excel->getActiveSheet()->setCellValue('D'.$number, 'trx_desc');
					$this->excel->getActiveSheet()->setCellValue('E'.$number, 'amount');
					$this->excel->getActiveSheet()->setCellValue('F'.$number, 'dk');
					$this->excel->getActiveSheet()->setCellValue('G'.$number, 'balance');
					$this->excel->getActiveSheet()->setCellValue('H'.$number, 'vacc_number');
					$this->excel->getActiveSheet()->setCellValue('I'.$number, 'trx_id2');
					$this->excel->getActiveSheet()->setCellValue('J'.$number, 'provider');
					$this->excel->getActiveSheet()->setCellValue('K'.$number, 'product_name');
					$this->excel->getActiveSheet()->setCellValue('L'.$number, 'reffnum');
					
					//var_dump($res['result']['DataTransactions']);
					$number=2;
					foreach($res as $row){
						$this->excel->getActiveSheet()->setCellValue('A'.$number, $row['trx_id']);
						$this->excel->getActiveSheet()->setCellValue('B'.$number, $row['trx_type']);
						$this->excel->getActiveSheet()->setCellValue('C'.$number, $row['trx_date']);
						$this->excel->getActiveSheet()->setCellValue('D'.$number, $row['trx_desc']);
						$this->excel->getActiveSheet()->setCellValue('E'.$number, $row['amount']);
						$this->excel->getActiveSheet()->setCellValue('F'.$number, $row['dk']);
						$this->excel->getActiveSheet()->setCellValue('G'.$number, $row['balance']);
						$this->excel->getActiveSheet()->setCellValue('H'.$number, $row['vacc_number']);
						$this->excel->getActiveSheet()->setCellValue('I'.$number, $row['trx_id2']);
						$this->excel->getActiveSheet()->setCellValue('J'.$number, $row['provider']);
						$this->excel->getActiveSheet()->setCellValue('K'.$number, $row['product_name']);
						$this->excel->getActiveSheet()->setCellValue('L'.$number, $row['reffnum']);
						$number++;
						
					}
					
					// $sql="SELECT count(*) as jumlah FROM ma_trx
						// WHERE ma_trx.trx_date>='".$StartDate." 00:00:00' 
						// AND ma_trx.trx_date<='".$EndDate." 00:00:00' 
						// AND ma_trx.trx_type='ppob'";
					// $count=$this->db->query($sql)->row()->jumlah;
					
					// $number++;
					// $this->excel->getActiveSheet()->setCellValue('A'.$number, 'Jumlah:');
					// $this->excel->getActiveSheet()->setCellValue('B'.$number, $$count);
					
					
					$filename='wallet_trx_'.date('YmdHis').'.xls'; //save our workbook as this file name
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
								
					//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
					
				}else{
					echo 'data tidak ada';
				}
			
			
		}else{
			redirect('admin/idbiller_trx');
		}
		
	
	}
	
	
	
	
	
}
