<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		//this is a test on my code comment
	}
	 
	public function index(){
		
		$data['msg'] = '';
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('InputUsername1', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('InputPassword1', 'Password', 'trim|required');
		
		if($this->input->post()) {
			if( $this->form_validation->run() ){
				
				$username = $this->input->post('InputUsername1');
				$password = $this->input->post('InputPassword1');
				
				$query = $this->db->get_where('gear_admin_login', array('user_name'=>$username));
				
				$flag_error = 1;
				$row = $query->row();
				
				if( $query->num_rows > 0 AND $row->status_flag == '1' ){
				 	
					if( $row->user_password == md5($password) ){ 
						$flag_error = 0;
						$session_data = array(
							'logged_in' => TRUE,
							'vbc_userid'=>$row->admin_id, 
							'vbc_username'=>$row->user_name, 
							'vbc_uaccess'=>$row->access_type 
						);
						
						$this->session->set_userdata($session_data);
						
						redirect(base_url().'admin');
					}  
				}elseif( @$row->status_flag == '0' ){ 
					$data['msg'] = ($flag_error)?'<div class="alert alert-danger"><p>Account is disabled</p></div>':'';
				}else{	
					$data['msg'] = ($flag_error)?'<div class="alert alert-danger"><p>Username or Password is Incorrect</p></div>':'';
				}	
				
			}else{
				$data['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			} 
		}
		 
		$this->load->view('login', $data);
	}	
	
	public function logout(){
	
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
