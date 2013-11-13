<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	
	public function index(){
	
		/* $this->load->view('header'); 
		$this->load->view('membership_transaction'); 
		$this->load->view('footer'); */	
	
	}
	
	
	/**
	*
	*	SCHEDULE PAYMENTS
	**/
	public function uploadschedulepayments(){
 
		$data = array('uploaded_data'=>'');
		$result = array();
		if($_POST){
			$str = $this->input->post("txt_payments");
			$str = explode("\n", $str); 
			$filter = array('\t',' ');
			 
			foreach($str as $i=>$rows){
				$row =  preg_replace('/\s+/', ' ', trim($rows));	 
				//$row =  str_replace('SGD', '', $row);	  
				$row = explode(" ",$row);
				
				array_push($result, $row);
				
			} 
			
			if( isset($_POST['Save']) ){
				
				foreach( $result as $row ){
					
					$set['Master_Sch_Id']	= $row[0];
					$set['Detail_Sch_Id'] 	= $row[1];
					$set['Merchant_Ref'] 	= $row[2];
					$set['Order_Date']	 	= $row[3];
					$set['Tran_Date'] 		= $row[4];
					$set['Currency'] 		= $row[5];
					$set['Amount'] 			= $row[6];
					$set['Payment_Ref'] 	= $row[7]; 
					$set['status'] 			= $row[8]; 
					$set['uploaded_by'] 	= $this->user_name; 
					
					$this->db->insert('scheduled_payments', $set);
					
				}
				
			}else{
				$data['results'] = $result;
				$data['uploaded_data'] = $this->input->post('txt_payments');			
			}
		}
		
		
		$this->load->view('header'); 
		$this->load->view('reports/scheduled_payments_upload', $data); 
		$this->load->view('footer');
	}
	
	public function schedulepayments(){
	 
		$this->load->view('header'); 
		$this->load->view('reports/scheduled_payments'); 
		$this->load->view('footer');
	}	
	
	public function ajax_schedule_payments(){
		$this->load->model('schedule_payment_model', 'payments');
		
		$this->payments->get();
	}
	
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
