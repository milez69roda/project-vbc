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
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
