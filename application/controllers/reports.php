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
	
	public function ajax_deleteschedulepayment(){

		if($_POST){
			$id = $this->input->post('id');

			$this->db->where('id', $id);
			if($this->db->delete('scheduled_payments') ){
				echo 'Delete Successfully';
			}else{
				echo 'Failed to Delete';
			}
		}

	}

	public function membership(){
		
		$this->load->model('Reports_model', 'report');
		
		$startDate 		= $this->input->get('startdate');
		$endDate 		= $this->input->get('enddate');
		$option1 		= $this->input->get('option1');
		$option2 		= $this->input->get('option2');
		/* $reportType 	= $this->input->get('report_type');
		$member_type 	= $this->input->get('member_type'); */
		$data = array('records'=>'');
		
		if($_GET){ 
			$data['records'] = $this->report->membership($option1, $option2, $startDate, $endDate);
		}
		/* if($reportType == 0){
			$data['title'] = 'Signup';
			$data['records'] = $this->report->signups($member_type, $startDate, $endDate);
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
		}  */
		
		//echo $this->db->last_query();
		
		$data['membership_type'] = $this->common_model->getMembershipTypeList();
		
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
		 
		$this->load->model('Reports_model', 'report'); 
		
		$data = array();
		$startDate 	= '';
		$endDate  	= '';
		$ref 		= '';
		
		if( !isset($_GET['bypass']) ){
			$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
			$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
		}
		$type	 		= (isset($_GET['report_type']))?$this->input->get('report_type'):0; 
		
		if( isset($_GET['ref']) AND $_GET['ref'] != '' ){
			$ref	 	= $this->input->get('ref');	
		}
		
		$data['title'] = 'Invoice';
		$data['records'] = $this->report->invoice($ref, $startDate, $endDate, $type);		
		
		//print_r($data['records']);
		//echo $this->db->last_query();
		$this->load->view('header'); 
		$this->load->view('reports/invoice_reports', $data); 
		$this->load->view('footer');			
	}	 
	
	public function invoiceindividual(){
		 
		$this->load->model('Reports_model', 'report'); 
		
		$data = array();
		$startDate 	= '';
		$endDate  	= '';
		$ref 		= '';
		
		if( !isset($_GET['bypass']) ){
			$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
			$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
		}
		$type	 		= (isset($_GET['report_type']))?$this->input->get('report_type'):0; 
		
		if( isset($_GET['ref']) AND $_GET['ref'] != '' ){
			$ref	 	= $this->input->get('ref');	
		}
		
		$data['title'] = 'Invoice';
		$data['records'] = $this->report->invoice($ref, $startDate, $endDate, $type);		
		
		//print_r($data['records']);
		//echo $this->db->last_query();
		$this->load->view('header'); 
		$this->load->view('reports/invoice_reports_individual', $data); 
		$this->load->view('footer');			
	}	
	
	public function invoicepdf(){ 
		
		$this->load->model('Reports_model', 'report');  
		$data = array(); 
		$startDate 	= '';
		$endDate  	= '';
		$ref 		= '';
		
		if( !isset($_GET['bypass']) ){
			$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
			$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
			
			$data['report_date']['startDate'] = date('d/m/Y', strtotime($startDate));	
			$data['report_date']['endDate'] = date('d/m/Y', strtotime($endDate));			
		}
		$type	 		= (isset($_GET['report_type']))?$this->input->get('report_type'):0; 
		
		if( isset($_GET['ref']) AND $_GET['ref'] != '' ){
			$ref	 	= $this->input->get('ref');	
		}
				  
 		require(APPPATH .'third_party/fpdf.php'); 
 		require(APPPATH .'libraries/PDF.php');
 		  
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		// Column headings
		$data_header = array('Name', 'Ref No.', 'Date', 'Failed', 'Success');
		
		// Data loading
		 
		$results = $this->report->invoice($ref, $startDate, $endDate, $type);	
	
		$data_content = array();
		foreach($results as $row){
			$data_content[] = array($row->ai_fname.' '.$row->ai_lname, $row->Merchant_Ref, $row->Order_Date, $row->failed, $row->success, );
		} 
		
		$data['content'] = $data_content;
		
		$pdf->AddPage();
		$pdf->setContents($data_header,$data); 
		ob_clean();
		$pdf->Output('invoice_'.strtotime('now').'.pdf', 'D');  
	 	
	}		
	
	public function invoicepdfmember(){ 
		 
		$this->load->model('Reports_model', 'report');  
		$data = array(); 
		$startDate 	= '';
		$endDate  	= '';
		$ref 		= '';
		
		if( !isset($_GET['bypass']) ){
			$startDate 	= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
			$endDate 	= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
			
			$data['report_date']['startDate'] = date('d/m/Y', strtotime($startDate));	
			$data['report_date']['endDate'] = date('d/m/Y', strtotime($endDate));	
		}
		$type	 		= (isset($_GET['report_type']))?$this->input->get('report_type'):0; 
		
		if( isset($_GET['ref']) AND $_GET['ref'] != '' ){
			$ref	 	= $this->input->get('ref');	
		}
				  
 		require(APPPATH .'third_party/fpdf.php'); 
 		require(APPPATH .'libraries/PDF.php');
 		  
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		// Column headings
		$data_header = array('Membership', 'Status', 'Due Date', 'Amount');
		
		// Data loading
		 
		$results = $this->report->invoice($ref, $startDate, $endDate, $type);	 
		$data_content = array();
		foreach($results as $row){
			$data_content[] = array( $row->status, $row->Order_Date, $row->failed, $row->success, );
		} 
		
		$this->db->where('pay_ref', $ref);
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id');
		$info = $this->db->get('club_transaction')->row();
		
		$data['header'] 	= $data_header;
		$data['content']	= $data_content;
		
		
		$pdf->AddPage();
		$pdf->individual($info, $data); 
		ob_end_clean();
		$pdf->Output('invoice_'.strtotime('now').'.pdf', 'D');  
	}
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
