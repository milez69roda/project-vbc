<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	
	public function index(){
	 
	} 		

	public function download(){

		$this->load->library('excel');
		$sheet = new PHPExcel();		


		
		

		//Set Title of the Excel file and the sheet you would like to write to.
		$sheet->getProperties()->setTitle('Attendance Report')->setDescription('Attendance Report');
		$sheet->setActiveSheetIndex(0);

		//Populate column titles on first row.
		$col = 0;
		foreach ($attendacne_data[0] as $field=>$value) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				$col++;
		}

		//Populate values on rows and columns.
		$row = 2;
		foreach ($attendacne_data as $data) {
			$col = 0;
			foreach ($data as $field_val) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $field_val);
				$col++;
			}
			$row++;
		}

		//Create a writer to write values to.
		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel2007');

		//Setup headers to download the excel file.
		/*header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="att_report_'.date('dMy').'.xls"');
		header('Cache-Control: max-age=0');*/

		$sheet_writer->save('filename.xlsx');		
	}
}

/* End of file export.php */
/* Location: ./application/controllers/export.php */
