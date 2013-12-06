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
					//an auto update of term status in case payments are failed
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
		
		$this->payments->get_list();
	} 
	
	public function membership(){
		
		$this->load->model('Reports_model', 'report');
		
		$startDate 	= $this->input->get('startdate');
		$endDate 	= $this->input->get('enddate');
		$reportType = $this->input->get('report_type');
		$data = array();
		
		if($reportType == 0){
			$data['title'] = 'Signup';
			$data['records'] = $this->report->signups($startDate, $endDate);
		} 
		
		if($reportType == 1){
			$data['title'] = 'Termination';
			$data['records'] = $this->report->termination($startDate, $endDate);
		} 
		
		if($reportType == 2){
			$data['title'] = 'Suspension';
			$data['records'] = $this->report->suspension($startDate, $endDate);
		} 
		
		if($reportType == 3){
			$data['title'] = 'Current';
			$data['records'] = $this->report->current($startDate, $endDate);
		} 
		
		if($reportType == 4){
			$data['title'] = 'Cash Payment';
			$data['records'] = $this->report->cashpayment($startDate, $endDate);
		} 
		
		if($reportType == 5){
			$data['title'] = 'Credit Card';
			$data['records'] = $this->report->creditcard($startDate, $endDate);
		} 
		
		$this->load->view('header'); 
		$this->load->view('reports/membership_reports', $data); 
		$this->load->view('footer');	 
	}
	
	public function terms(){
		
		$this->load->model('Reports_model', 'report'); 
		$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
		$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
		$reportType = $this->input->get('report_type');
		$data = array();
		
		$data['title'] = 'Terms';
		$data['records'] = $this->report->terms($startDate, $endDate, $reportType);		
		//echo $this->db->last_query();
		$this->load->view('header'); 
		$this->load->view('reports/terms_reports', $data); 
		$this->load->view('footer');			
	}
	
	public function freebies(){
		
		$this->load->model('Reports_model', 'report'); 
		$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
		$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
		$reportType = $this->input->get('report_type');
		$data = array();
		
		$data['title'] = 'Freebies';
		$data['records'] = $this->report->freebies($startDate, $endDate, $reportType);		
		//echo $this->db->last_query();
		$this->load->view('header'); 
		$this->load->view('reports/freebies_reports', $data); 
		$this->load->view('footer');			
	}
	
	public function invoice(){
		 
		$data = array();
		
		$this->load->model('Reports_model', 'report'); 
		$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
		$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
				
		$data['title'] = 'Invoice';
		$data['records'] = $this->report->invoice('', $startDate, $endDate);		
		
		//print_r($data['records']);
		//echo $this->db->last_query();
		$this->load->view('header'); 
		$this->load->view('reports/invoice_reports', $data); 
		$this->load->view('footer');			
	}		
	
	public function invoicepdf(){ 
		 
		$data = array(); 
		$data['title'] = 'Invoice'; 

		$this->load->model('Reports_model', 'report'); 
		$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
		$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
				  
 		require(APPPATH .'third_party/fpdf.php'); 
 		require(APPPATH .'libraries/PDF.php');
 		  
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		// Column headings
		$data_header = array('Name', 'Ref No.', 'Date', 'Amount');
		
		// Data loading
		 
		$results = $this->report->invoice('', $startDate, $endDate);		
		$data_content = array();
		foreach($results as $row){
			$data_content[] = array($row->ai_fname.' '.$row->ai_lname, $row->Merchant_Ref, $row->Order_Date, $row->Amount);
		} 
		$pdf->AddPage();
		$pdf->setContents($data_header,$data_content); 
		$pdf->Output('invoice_'.strtotime('now').'.pdf', 'D');  
	 	
	}		
	
	public function invoicepdfmember(){ 
		 
		$data = array(); 
		$data['title'] = 'Invoice'; 
		$ref = $_GET['ref'];
		
		$this->load->model('Reports_model', 'report');  
				  
 		require(APPPATH .'third_party/fpdf.php'); 
 		require(APPPATH .'libraries/PDF.php');
 		  
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		// Column headings
		$data_header = array('Name', 'Ref No.', 'Date', 'Amount');
		
		// Data loading
		 
		$results = $this->report->invoice($ref, '', '');		
		$data_content = array();
		foreach($results as $row){
			$data_content[] = array($row->ai_fname.' '.$row->ai_lname, $row->Merchant_Ref, $row->Order_Date, $row->Amount);
		} 
		$pdf->AddPage();
		$pdf->setContents($data_header,$data_content); 
		$pdf->Output('invoice_'.strtotime('now').'.pdf', 'D');  
	 	
	}
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
