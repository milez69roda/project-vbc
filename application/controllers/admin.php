<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	}
	 	
	/* public function index(){  
		//redirect(base_url().'home');
	} */
	 	
	public function index(){ 
		
		$this->load->model('Reports_model', 'reports');
		$this->load->model('Schedule_payment_model', 'payments');
		
		$data['expired_35_days'] = $this->reports->expired_35_days();
		$data['failed_transaction'] = $this->payments->get_failed_transaction("");
		$data['check_payments_today'] = $this->payments->check_payments_today();
		 
		$this->load->view('header'); 
		$this->load->view('home', $data); 
		$this->load->view('footer');
		
	}
	
	
	public function membershiptransaction(){
	
		$this->load->view('header'); 
		$this->load->view('membership_transaction'); 
		$this->load->view('footer');	
	
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */