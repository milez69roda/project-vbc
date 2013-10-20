<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	}
	 
	public function index(){ 
	 
		$this->load->view('header'); 
		$this->load->view('home'); 
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