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
	
	public function ajax_membership_temporary_delete(){
	
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Delete');	
		
		$sql= "delete  FROM `club_transaction` WHERE tran_id = '".$this->input->post("delid")."' limit 1"; 
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership/temporary';
			$json['msg'] 	= 'Delete Successfully';
		}		
		
		echo json_encode($json);		
	
	}	
	
	public function details(){
		
		$mem_id = $this->common_model->deccrypData(urldecode($this->uri->segment(3)));
 
		
		$sql = "SELECT club_transaction.*, ai_fname, ai_lname, ai_email, ai_hp, postalcode, country, street1 
				FROM club_transaction 
				LEFT OUTER JOIN club_membership ON club_membership.mem_id = club_transaction.mem_id 
			 
				WHERE `club_transaction`.pay_status='3' 
					AND club_transaction.mem_id = $mem_id
				LIMIT 1
				";
		//echo $sql;
		$data['id'] = $this->uri->segment(3);
		$data['row'] = $this->db->query($sql)->row();
		
		$cResult = $this->db->get('gear_country')->result();
		$country = array();
		foreach( $cResult as $row ){
			$country[$row->id] = $row->countryname;
		}
		$data['country'] = $country;
		$this->load->view('header'); 
		$this->load->view('membership_details', $data); 
		$this->load->view('footer');
	}
	
	public function ajax_membership_details(){
		$token = $this->input->post('token');
		$mem_id = $this->common_model->deccrypData($token);
		
		$sql = "SELECT club_transaction.*, ai_fname, ai_lname, ai_email, ai_hp, postalcode, country, street1, unit, 
					emg_unit, emg_street1, emg_street2, emg_country, emg_postalcode,
					mh_curr_condi, mh_medicine
				FROM club_transaction 
				LEFT OUTER JOIN club_membership ON club_membership.mem_id = club_transaction.mem_id 
			 
				WHERE  club_transaction.mem_id = $mem_id
				LIMIT 1
				";		
				//`club_transaction`.pay_status='3' 
				//	AND
		$row = $this->db->query($sql)->row();
		$data['row'] = $row;
		 
		$data['schedulepayements'] = @$this->common_model->getSchedulePayment_by_ref($row->pay_ref);
		$data['countries'] = $this->common_model->getCountryDropdown();
		$data['title'] = $this->input->post('title');
		$data['token'] = $token;
		$this->load->view('modal/membership_details', $data); 
	}
	
	public function ajax_membership_mail(){
		
		$refno = $this->input->post('refno');
		$type = $this->input->post('type');
		
		$this->common_model->membershipEmail($refno, $type);
		//sleep(3);
		
		if($type=="admin") {
			echo "Your email has been send to Admin";
		}

		if($type=="email") {
			echo "Your email has been send to the Member";
		}

		if($type=="vanda") {
			echo "Your email has been send to Vanda";
		}
		
		if($type=="confirmation") {
			echo "Your email has been send to the Member";
		}
		
		if($type=="conf_admin") {
			echo "Your email has been send to Admin";
		} 
	}
	
	/*public function ajax_membership_update(){
		
		if($this->input->post("active_date")=="")
		{
			$active_date="0000-00-00";
		}else {
			$active_date = $this->input->post("active_date");
		}
		
		if($this->input->post("exp_date")==""){
			$exp_date="0000-00-00";
		}else{
			$exp_date= $this->input->post("exp_date");
		}
		
		if($this->input->post("due_date")==""){
			$due_date="0000-00-00";
		}else{
			$due_date= $this->input->post("due_date");
		}		
		
		$sql = "update `club_transaction` set 
					`pay_ref` 		= '".$this->input->post("ref")."', 
					`pay_amt` 		= '".$this->input->post("pay_amt")."', 
					`full_payment` 	='".$this->input->post("full_payment")."',
					`active_date` 	='".$active_date."',
					`due_date` 		='".$due_date."',
					`exp_date` 		='".$exp_date."', 
					payment_mode	= '".$this->input->post("payment_mode")."' 
				where tran_id	='".$this->input->post("tran_id")."' limit 1";		
				
		if( $this->db->query($sql) ){
			echo "Update Successfully";
		}else{
			echo "Failed to Update";
		}		
	}*/
	
	public function ajax_membership_update_details(){
		
		$response = array('status'=>false, 'msg'=>'Failed to update');
		
		$token = $this->input->post('token');
		$mem_id = $this->common_model->deccrypData($token);
		
		$set['ai_fname'] 	= $this->input->post('firstname');
		$set['ai_lname'] 	= $this->input->post('lastname');
		$set['ai_email'] 	= $this->input->post('email');
		$set['unit'] 		= $this->input->post('unit');
		$set['street1'] 	= $this->input->post('street1');
		$set['country'] 	= $this->input->post('country');
		$set['postalcode'] 	= $this->input->post('postalcode');
		$set['ai_hp'] 		= $this->input->post('phone');
		
		$set['emg_unit'] 		= $this->input->post('emg_unit');
		$set['emg_street1'] 		= $this->input->post('emg_street1');
		$set['emg_street2'] 		= $this->input->post('emg_street2');
		$set['emg_country'] 		= $this->input->post('emg_country');
		$set['emg_postalcode'] 		= $this->input->post('emg_postalcode');
		
		$set['mh_curr_condi'] 		= $this->input->post('mh_curr_condi');
		$set['mh_medicine'] 		= $this->input->post('mh_medicine');
		
		$this->db->where('mem_id', $mem_id);
		if( $this->db->update('club_membership', $set) ){
			$response['status'] = true;
			$response['msg'] = 'Successfully Updated';
			
			$response['fullname'] = $this->input->post('firstname').' '.$this->input->post('lastname');
		}
		
		echo json_encode($response);
	}
	
	/*public function ajax_membership_expire(){
		
		 	 
		$exp_stat = $this->input->post('stat');
		$tran_id = $this->input->post('tran_id');
		
		$sql = "update `club_transaction` set exp_stat ='{$exp_stat}' where tran_id='{$tran_id}' limit 1";
		
		if( $this->db->query($sql) ){
			echo ($exp_stat)?"Unexpired Successfully":"Expired Successfully";
		}else{
			echo "Failed to Process Request";
		}
	
	}*/
	 
	public function ajax_membership_transaction_sucess(){
		
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Activate');
		
		$orderRef = $this->input->post("Ref"); 
		$sql = "update `club_transaction` set `pay_status` ='3'  where `pay_ref`='".$orderRef."' limit 1";
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership';
			$json['msg'] 	= 'Activated Successfully';
		}		
		
		echo json_encode($json);
	}
	
	public function ajax_membership_transaction_delete(){
	
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Delete');	
		
		$sql= "delete  FROM `club_transaction` WHERE tran_id = '".$this->input->post("delid")."' limit 1"; 
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership';
			$json['msg'] 	= 'Delete Successfully';
		}		
		
		echo json_encode($json);		
	
	}
	
	public function ajax_membership_freebies_save(){
		
		
	}
	
	/*company transactions*/
	public function company(){
		$this->load->view('header'); 
		$this->load->view('membership_company'); 
		$this->load->view('footer');			
	}
	
	
	public function ajax_company_membership(){
		
		$this->load->model('Membership_Model', 'membership');	
		$this->membership->getCompany();
	}	
	
	public function companydetails(){
		
		$mem_id = $this->common_model->deccrypData(urldecode($this->uri->segment(3)));
		
		if( $_POST ){
		
			print_r($_POST);
		
		}
		
		$sql = "SELECT company_club_transaction.*, ai_fname, ai_lname, ai_email, ai_hp, postalcode, country, street1 
				FROM company_club_transaction 
				LEFT OUTER JOIN company_club_membership ON company_club_membership.mem_id = company_club_transaction.mem_id 
			 
				WHERE `company_club_transaction`.pay_status='3' 
					AND company_club_transaction.mem_id = $mem_id
				LIMIT 1
				";
	 
		$data['id'] = $this->uri->segment(3);
		$data['row'] = $this->db->query($sql)->row();
		
		$cResult = $this->db->get('gear_country')->result();
		$country = array();
		foreach( $cResult as $row ){
			$country[$row->id] = $row->countryname;
		}
		$data['country'] = $country;
		$this->load->view('header'); 
		$this->load->view('company_membership_details', $data); 
		$this->load->view('footer');
	}
	
	public function ajax_company_membership_expire(){
		
		 	 
		$exp_stat = $this->input->post('stat');
		$tran_id = $this->input->post('tran_id');
		
		$sql = "update `company_club_transaction` set exp_stat ='{$exp_stat}' where tran_id='{$tran_id}' limit 1";
		
		if( $this->db->query($sql) ){
			echo ($exp_stat)?"Unexpired Successfully":"Expired Successfully";
		}else{
			echo "Failed to Process Request";
		}
	
	} 
	
	public function ajax_company_membership_update(){
		
		if($this->input->post("active_date")=="")
		{
			$active_date="0000-00-00";
		}else {
			$active_date = $this->input->post("active_date");
		}
		
		if($this->input->post("exp_date")==""){
			$exp_date="0000-00-00";
		}else{
			$exp_date= $this->input->post("exp_date");
		}
		
		if($this->input->post("due_date")==""){
			$due_date="0000-00-00";
		}else{
			$due_date= $this->input->post("due_date");
		}		
		
		$sql = "update `company_club_transaction` set 
					`pay_ref` 		= '".$this->input->post("ref")."', 
					`pay_amt` 		= '".$this->input->post("pay_amt")."', 
					`full_payment` 	='".$this->input->post("full_payment")."',
					`active_date` 	='".$active_date."',
					`due_date` 		='".$due_date."',
					`exp_date` 		='".$exp_date."', 
					payment_mode	= '".$this->input->post("payment_mode")."' 
				where tran_id	='".$this->input->post("tran_id")."' limit 1";		
				
		if( $this->db->query($sql) ){
			echo "Update Successfully";
		}else{
			echo "Failed to Update";
		}		
	}	
	
	public function ajax_company_membership_mail(){
		
		$refno = $this->input->post('refno');
		$type = $this->input->post('type');
		
		$this->common_model->companyMembershipEmail($refno, $type);
		//sleep(3);
		
		if($type=="admin") {
			echo "Your email has been send to Admin";
		}

		if($type=="email") {
			echo "Your email has been send to the Member";
		}

		if($type=="vanda") {
			echo "Your email has been send to Vanda";
		}
		
		if($type=="confirmation") {
			echo "Your email has been send to the Member";
		}
		
		if($type=="conf_admin") {
			echo "Your email has been send to Admin";
		} 
	}	
	
	public function ajax_company_membership_transaction_sucess(){
		
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Activate');
		
		$orderRef = $this->input->post("Ref"); 
		$sql = "update `company_club_transaction` set `pay_status` ='3'  where `pay_ref`='".$orderRef."' limit 1";
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership';
			$json['msg'] 	= 'Activated Successfully';
		}		
		
		echo json_encode($json);
	}	
	
	public function ajax_company_membership_transaction_delete(){
	
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Delete');	
		
		$sql= "delete  FROM `company_club_transaction` WHERE tran_id = '".$this->input->post("delid")."' limit 1"; 
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership/company';
			$json['msg'] 	= 'Delete Successfully';
		}		
		
		echo json_encode($json);		
	
	}	
	
	public function runtest(){
		
		$sql = "SELECT exp_stat, term_type FROM club_transaction WHERE exp_stat = '1'";
		$result = $this->db->query($sql)->result();
		
		foreach( $result as $row){
			
			$temp = $this->db->update_string('club_transaction', array('term_type'=>$row->exp_stat), ' exp_stat=1');
			echo $temp.'<br/>';
		}		
		
	}
	
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
