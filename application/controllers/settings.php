<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	 
	public function index(){
	
		$this->load->view('header'); 
		$this->load->view('membership_transaction'); 
		$this->load->view('footer');	
	
	}
	
	public function membershipplan(){
	
		$data['results'] = $this->db->query("SELECT * FROM club_membership_type WHERE mem_flag !='2' ORDER BY mem_type_id DESC")->result();
		
		$this->load->view('header'); 
		$this->load->view('settings/membership_plan', $data); 
		$this->load->view('footer');	
	
	}
	
	public function companyplan(){
		$sql = "SELECT company_club_membership_type.*,company.company_name as co_name
				FROM company_club_membership_type 
				LEFT OUTER JOIN company ON company.company_id = company_club_membership_type.company_name
				WHERE mem_flag !='2' ORDER BY mem_type_id DESC";
		$data['results'] = $this->db->query($sql)->result();
		
		$this->load->view('header'); 
		$this->load->view('settings/company_plan', $data); 
		$this->load->view('footer');	
	
	}
	  
	
	
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */
