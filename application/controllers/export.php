<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	
	public function index(){
	 
	} 		

	public function download(){
		
		$this->load->model('Reports_model', 'report');
		$this->load->library('excel');
		$this->load->helper('download');
		
		$sheet = new PHPExcel();		

		$startDate 		= (isset($_GET['startdate']))?$this->input->get('startdate'):date('Y-m-d');
		$endDate 		= (isset($_GET['enddate']))?$this->input->get('enddate'):date('Y-m-d');
		$option1 		= $this->input->get('option1');
		$option2 		= $this->input->get('option2');
		
		/* $member_type 	= $this->input->get('member_type');
		$reportType 	= $this->input->get('report_type'); 
		$report_page 	= trim($this->input->get('report_page'));*/
		
		$title = 'membership_report';
		
		
		$records = $this->report->membership($option1, $option2, $startDate, $endDate);
		
		/* if( $report_page == "membership" ){
			if($reportType == 0){
				$title 		= 'Signup';
				$records 	= $this->report->signups($member_type, $startDate, $endDate);
			} 
			
			if($reportType == 1){
				$title 		= 'Termination';
				$records 	= $this->report->termination($startDate, $endDate);
			} 
			
			if($reportType == 2){
				$title 		= 'Suspension';
				$records 	= $this->report->suspension($startDate, $endDate);
			} 
			
			if($reportType == 3){
				$title 		= 'Current';
				$records 	= $this->report->current($startDate, $endDate);
			} 
			
			if($reportType == 4){
				$title 		= 'Cash Payment';
				$records 	= $this->report->cashpayment($startDate, $endDate);
			} 
			
			if($reportType == 5){
				$title 		= 'Credit Card';
				$records 	= $this->report->creditcard($startDate, $endDate);
			} 
		}elseif( $report_page == "terms" ){
			$title 		= 'Terms';
			$records 	= $this->report->terms($startDate, $endDate, $reportType);	 
		}elseif( $report_page == "freebies" ){
			$title 		= 'Freebies';
			$records 	= $this->report->freebies($startDate, $endDate, $reportType);	 
		}else{
		
		} */
		
		//delete files
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);         
		
		$dir = "files/";
		$current_dir = @opendir($dir); 
	
		while( $filename = @readdir($current_dir) ) {
				
				if ($filename != "." and $filename != ".." and $filename != "index.html") {
						$xfilename = explode("_",$filename);
						$xfilename = $xfilename[count($xfilename)-1];
						$name = str_replace(".xlsx", "", $xfilename);
						 
						if (($name+1800) < $now) { //3600
								@unlink($dir.$filename);
						}
				}
		}

		@closedir($current_dir); 		
		

		//Set Title of the Excel file and the sheet you would like to write to.
		$sheet->getProperties()->setTitle($title)->setDescription($title);
		$sheet->setActiveSheetIndex(0);

		//Populate column titles on first row.
		$col = 0;
		foreach ($records['header'] as $field=>$value) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $value);
				$col++;
		}

		//Populate values on rows and columns.
		$row = 2;
		foreach ($records['results'] as $data) {
			$col = 0;
			foreach($records['header'] as $field1=>$val) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field1);
				$col++;
			}
			$row++;
		}

		//Create a writer to write values to.
		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel2007');


		$filename1 = ''.str_replace(' ','_',$title).'_'.strtotime('now').'.xlsx';
		$sheet_writer->save('files/'.$filename1);

		///echo $filename1;	
		
		//Setup headers to download the excel file.
		/* header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename1.'"');
		header('Cache-Control: max-age=0');	 */	
		
		$data = file_get_contents('files/'.$filename1); // Read the file's contents
		$name = $filename1;
		ob_clean();
		force_download($name, $data); 		
	}
}

/* End of file export.php */
/* Location: ./application/controllers/export.php */
