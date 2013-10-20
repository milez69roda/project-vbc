<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	public $logged_in;
	public $user_name;
	protected $user_id;
	
	function __construct(){
		parent::__construct();
		 
		if( $this->session->userdata('logged_in') != ' '){
			redirect(base_url().'login');
		}
		
		$this->logged_in 	= $this->session->userdata('logged_in'); 
		$this->user_id 		= $this->session->userdata('vbc_userid'); 
		$this->user_name 	= $this->session->userdata('vbc_username'); 
	}  
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */