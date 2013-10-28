<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	
	public function index(){
	
		$this->load->view('header'); 
		$this->load->view('membership_transaction'); 
		$this->load->view('footer');	
	
	}
	
	public function ajax_membership_transaction(){
		
		$this->load->model('Membership_Model', 'membership');	
		$this->membership->get();
	}	
	
	public function temporary(){
	
		$this->load->view('header'); 
		$this->load->view('membership_temporary'); 
		$this->load->view('footer');	
	
	}
	
	public function ajax_membership_temporary(){
		
		$this->load->model('Membership_Model', 'membership');	
		$this->membership->getTemp();
	}
	
	public function ajax_membership_temporary_activate(){
		$msg = 'Failed to Activate';
		$ref = trim($this->input->post('ref'));
		$sql = "SELECT pay_ref, payment_mode,mem_type, club_membership_type.month 
			FROM club_transaction 
			LEFT OUTER JOIN club_membership_type ON club_membership_type.mem_type_id = club_transaction.mem_type	
			WHERE pay_ref='".$ref."' and pay_status ='0' LIMIT 1";
		$row = $this->db->query($sql)->row();
		
		$month = date("m");
		$day = date("d");
		$year = date("Y");		
		
		if($row->payment_mode==1){
			$due_date = date("Y-m-d", mktime(0, 0, 0, $month+1, $day, $year));
			$exp_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
		}elseif($row->payment_mode==2){
			$due_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
			$exp_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
		}	

		$sql = "UPDATE `club_transaction` SET `pay_status` ='3', due_date='".$due_date."', exp_date='".$exp_date."'  WHERE `pay_ref`='".$ref."' LIMIT 1";
		if( $this->db->query($sql) ){
			//send email notification
			$this->common_model->tempMemActEmail($ref); 
			$msg = "Successfully Activated";
		}
		
		echo $msg;
	} 
	
	public function details(){
		$this->load->view('header'); 
		$this->load->view('membership_details'); 
		$this->load->view('footer');	
	}
	
	public function company(){
		$this->load->view('header'); 
		$this->load->view('membership_company'); 
		$this->load->view('footer');			
	}
	
	public function ajax_membership_company(){
		
		$this->load->model('Membership_Model', 'membership');	
		$this->membership->getCompany();
	}	
	
	
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
