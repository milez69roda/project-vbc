<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	public $logged_in;
	public $user_name;
	public $uaccess;
	protected $user_id;
	public $terms_desc;
	public $terms_active;
	public $payment_type;
	
	function __construct(){
		parent::__construct();
		 
		if( $this->session->userdata('logged_in') != ' '){
			redirect(base_url().'login');
		}
		
		$this->logged_in 	= $this->session->userdata('logged_in'); 
		$this->user_id 		= $this->session->userdata('vbc_userid'); 
		$this->user_name 	= $this->session->userdata('vbc_username');
		$this->uaccess 		= $this->session->userdata('vbc_uaccess');
		
		$this->terms_desc = array(
			TERM_ACTIVE 		=> 'Activated/Reactivated',
			TERM_EXPIRED 		=> 'Expired',
			TERM_SUSPENSION 	=> 'Suspension',
			TERM_TERMINATION 	=> 'Termination',
			TERM_ROLLING_MONTLY => 'Rolling Monthly',
			TERM_DELETED 		=> 'Deleted',
			TERM_EXTEND_6 		=> 'Extend 6 Months',
			TERM_EXTEND_12 		=> 'Extend 12 Months' 
		);		

		$this->terms_active = array(TERM_ACTIVE, TERM_ROLLING_MONTLY, TERM_EXTEND_6, TERM_EXTEND_12 ); //collection of active term indicator	
		$this->payment_type = json_decode(PAYMENT_TYPE, true);	
 
	}  
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */