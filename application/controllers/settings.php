<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	} 
	 
	public function index(){
	
		redirect(base_url().'settings/membershipplan');	
	
	}
	
	public function membershipplan(){
	
		$data['results'] = $this->db->query("SELECT * FROM club_membership_type WHERE mem_flag !='2' ORDER BY mem_type_id DESC")->result();
		
		$this->load->view('header'); 
		$this->load->view('settings/membership_plan', $data); 
		$this->load->view('footer');	
	
	}
	
	public function ajax_membershipplan_form(){
	
		if(isset($_POST['type']) AND $this->input->post('type') == 'update'){
			
			$json = array('status'=>FALSE,"msg"=>"Failed to update!", 'redirect'=>base_url().'settings/membershipplan');
			
			$id = $this->common_model->deccrypData($this->input->post('ref'));
			$set['title'] = $this->input->post('inputTitle');
			$set['month'] = $this->input->post('inputMonth');
			$set['price'] = $this->input->post('inputPrice');
			
			$this->db->where('mem_type_id', $id);
			if($this->db->update('club_membership_type', $set)){	
				$json['msg'] = "Update Successfully!";	
				$json['status'] = TRUE;
			}
			echo json_encode($json);
			
		}elseif(isset($_POST['type']) AND $this->input->post('type') == 'new'){
			
			$json = array('status'=>FALSE,"msg"=>"Failed to add!", 'redirect'=>base_url().'settings/membershipplan');
			
			$id = $this->common_model->deccrypData($this->input->post('ref'));
			$set['title'] = $this->input->post('inputTitle');
			$set['month'] = $this->input->post('inputMonth');
			$set['price'] = $this->input->post('inputPrice'); 
			 
			if($this->db->insert('club_membership_type', $set)){	
				$json['msg'] = "Added Successfully!";	
				$json['status'] = TRUE;
			}
			echo json_encode($json);	
			
		}else{
			$data['type'] 	= $this->input->post('formtype');
			$data['title'] 	= $this->input->post('title');
			if( $this->input->post('formtype') == 'update' ){
				$id = $this->common_model->deccrypData($this->input->post('ref')); 
				$this->db->where('mem_type_id', $id);
				$data['row'] = $this->db->get('club_membership_type')->row(); 
				$data['type'] = $this->input->post('formtype');
			}
			$this->load->view('settings/modal/membership_plan_modal', $data); 
		}
	}
	
	public function ajax_delete_memberplan(){
		$json = array('status'=>FALSE,"msg"=>"Failed to delete!", 'redirect'=>base_url().'settings/membershipplan');
		$id = $this->common_model->deccrypData($this->input->post('ref'));
		
		$this->db->where('mem_type_id', $id);
		if( $this->db->delete('club_membership_type') ){
			$json['msg'] = "Delete Successfully!";	
			$json['status'] = TRUE;
		} 
		echo json_encode($json);
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
	
	public function ajax_companyplan_form(){
	
		if(isset($_POST['type']) AND $this->input->post('type') == 'update'){
			
			$json = array('status'=>FALSE,"msg"=>"Failed to update!", 'redirect'=>base_url().'settings/companyplan');
			
			$id = $this->common_model->deccrypData($this->input->post('ref'));
			$set['title'] = $this->input->post('inputTitle'); 
			$set['month'] = $this->input->post('inputMonth');
			$set['price'] = $this->input->post('inputPrice');
			
			$set['company_name'] 	= $this->input->post('selectCompany'); 
			
			$payment_mode = implode(",", $this->input->post('payment_mode'));
			$cfull_payment = '';
			$dfull_payment = '';
			if($this->input->post('cfull_payment') !=""){ 
				$cfull_payment = implode(",", $this->input->post('cfull_payment'));
			}
			if($this->input->post('dfull_payment') !=""){   
				$dfull_payment = implode(",", $this->input->post('dfull_payment'));
			}  
			
			$set['payment_mode'] 	= $payment_mode; 
			$set['cfull_payment'] 	= $cfull_payment; 
			$set['dfull_payment'] 	= $dfull_payment; 			
			
			$this->db->where('mem_type_id', $id);
			if($this->db->update('company_club_membership_type', $set)){	
				$json['msg'] = "Update Successfully!";	
				$json['status'] = TRUE;
			}
			echo json_encode($json);
			
		}elseif(isset($_POST['type']) AND $this->input->post('type') == 'new'){
			
			$json = array('status'=>FALSE,"msg"=>"Failed to add!", 'redirect'=>base_url().'settings/companyplan');
			
			$id = $this->common_model->deccrypData($this->input->post('ref'));
			$set['title'] 			= $this->input->post('inputTitle');
			$set['month'] 			= $this->input->post('inputMonth');
			$set['price'] 			= $this->input->post('inputPrice'); 
			$set['company_name'] 	= $this->input->post('selectCompany'); 
			
			$payment_mode = implode(",", $this->input->post('payment_mode'));
			$cfull_payment = '';
			$dfull_payment = '';
			if($this->input->post('cfull_payment') !=""){ 
				$cfull_payment = implode(",", $this->input->post('cfull_payment'));
			}
			if($this->input->post('dfull_payment') !=""){   
				$dfull_payment = implode(",", $this->input->post('dfull_payment'));
			}  
			
			$set['payment_mode'] 	= $payment_mode; 
			$set['cfull_payment'] 	= $cfull_payment; 
			$set['dfull_payment'] 	= $dfull_payment; 
			$set['create_date'] 	= date('Y-m-d H:i:s'); 
			 
			 
			if($this->db->insert('company_club_membership_type', $set)){	
				$json['msg'] = "Added Successfully!";	
				$json['status'] = TRUE;
			}
			echo json_encode($json);	
			
		}else{
			$data['type'] = $this->input->post('formtype');
			$data['title'] = $this->input->post('title');
			if( $this->input->post('formtype') == 'update' ){
				$id = $this->common_model->deccrypData($this->input->post('ref')); 
				$this->db->where('mem_type_id', $id);
				$data['row'] = $this->db->get('company_club_membership_type')->row(); 
				$data['type'] = $this->input->post('formtype');
			}
			$this->load->view('settings/modal/company_plan_modal', $data); 
		}
	}
	
	public function ajax_delete_companyplan(){
		$json = array('status'=>FALSE,"msg"=>"Failed to delete!", 'redirect'=>base_url().'settings/companyplan');
		$id = $this->common_model->deccrypData($this->input->post('ref'));
		
		$this->db->where('mem_type_id', $id);
		if( $this->db->delete('company_club_membership_type') ){
			$json['msg'] = "Delete Successfully!";	
			$json['status'] = TRUE;
		} 
		echo json_encode($json);
	} 			
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */
