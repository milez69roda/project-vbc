<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Accounts_model', 'accounts');
	} 
	 
	public function index(){
	 
	
	}
	
	public function changepassword(){
		
		$this->load->library('form_validation');	
		
		if($_POST){
		 
			$this->form_validation->set_rules('currentPass', 'Current Password', 'trim|required|md5|callback_password_check');
			$this->form_validation->set_rules('newPass', 'New Password', 'trim|required|min_length[5]|matches[repeatPass]|md5');
			$this->form_validation->set_rules('repeatPass', 'Password Confirmation', 'trim|min_length[5]|required');
			
			
			if ($this->form_validation->run() ) {
				$user_password = $this->input->post('newPass'); 
				if( $this->accounts->update_password($user_password, $this->user_name) ){
					$this->session->set_flashdata('flash_message', '<div class="alert alert-info">Password Successfully Change</div>');
					redirect(base_url().'accounts/changepassword');
				}
			} 	
		} 
		$this->load->view('header'); 
		$this->load->view('accounts/changepassword'); 
		$this->load->view('footer');		
	}
	
	public function password_check($str){
	
		$this->db->where('user_name', $this->user_name);
		$row = $this->db->get('gear_admin_login')->row();
		
		if ($row->user_password != $str) { 
			$this->form_validation->set_message('password_check', 'Current Password is Incorrect');
			return FALSE;
		}else{
			return TRUE;
		}
	}	
	
	public function manageaccount(){
	 
		$data['results'] = $this->accounts->get();
	
		$this->load->view('header'); 
		$this->load->view('accounts/manageaccount', $data); 
		$this->load->view('footer');	
		
	}
	
	public function newaccount(){ 
	
		$data['results'] = $this->accounts->get();
	
		$this->load->view('header'); 
		$this->load->view('accounts/manageaccount', $data); 
		$this->load->view('footer');	
		
	}
	
	public function ajax_account_form(){ 
		
		$json = array('status'=>FALSE,"msg"=>"Saving Failed!", 'redirect'=>base_url().'accounts/manageaccount');
		
		if(isset($_POST['type']) AND $this->input->post('type') == 'update'){
			
				$id 					= $this->input->post('idx');
				$password 				= trim($this->input->post('user_password'));
				
				if($password != ''){
					$set['user_password'] 	= md5($password);
				}
				
				$set['fullname'] 		= trim($this->input->post('fullname'));  
				$set['email'] 			= trim($this->input->post('email'));
				$set['access_type'] 	= $this->input->post('access_type');
				$set['status_flag'] 	= $this->input->post('status_flag');			
				
				if($this->accounts->update($id, $set)){
					$json['status'] = TRUE;
					$json['msg'] 	= "Saving Successfully"; 
				}		
				
				echo json_encode($json);	
	
		}elseif(isset($_POST['type']) AND $this->input->post('type') == 'new'){
			
			$user_name = trim($this->input->post('user_name'));
			//echo 'asdasd -'.$this->accounts->check_username($user_name).'-';
			if( !$this->accounts->check_username($user_name)){
			 
				$set['fullname'] 		= $this->input->post('fullname'); 
				$set['user_name'] 		= $user_name;
				$set['user_password'] 	= md5(trim($this->input->post('user_password')));
				$set['email'] 			= $this->input->post('email');
				$set['access_type'] 	= $this->input->post('access_type');
				$set['status_flag'] 	= $this->input->post('status_flag');

				if($this->accounts->insert($set)){
					$json['status'] = TRUE;
					$json['msg'] 	= "Saving Successfully"; 
				}				
				
			}else{
				$json['msg'] = "Username already exist";
			}
			
			echo json_encode($json);
		}else{		
			$data['type'] 	= $this->input->post('formtype');
			$data['title'] 	= $this->input->post('title');
			
			if( $this->input->post('formtype') == 'update' ){
				$id 			= $this->input->post('id'); 
				$row 			= $this->accounts->get(array('admin_id'=>$id));
				$data['row'] 	= $row[0];  
			}			
			
			$this->load->view('accounts/modal/new_account_modal', $data); 
		}
	}
}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */
