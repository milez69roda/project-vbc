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
		
		$month 	= date("m");
		$day 	= date("d");
		$year 	= date("Y");		
		
		if($row->payment_mode==1){
			$due_date = date("Y-m-d", mktime(0, 0, 0, $month+1, $day, $year));
			$exp_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
		}elseif($row->payment_mode==2){
			$due_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
			$exp_date = date("Y-m-d", mktime(0, 0, 0, $month+$row->month, $day, $year));
		}	

		$sql = "UPDATE `club_transaction` SET `pay_status` ='3', due_date='".$due_date."', exp_date='".$exp_date."', update_date=now()  WHERE `pay_ref`='".$ref."' LIMIT 1";
		if( $this->db->query($sql) ){
	
			$set['Merchant_Ref'] 	=  
			$set['Currency'] 		= 
			$set['Amount'] 			= 
			$set['Order_Date'] 		= 
			$set['Tran_Date'] 		= 
			$set['status'] 			= 
			$set['uploaded_by'] 	= 
			$set['transaction_type']= 	
			
			
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
	
	/* public function details(){
		
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
	} */
	
	public function ajax_membership_details(){
		
		$this->load->model('Terms_model', 'terms_model');
		$this->load->model('Freebies_model', 'freebies_model');
		$this->load->model('Schedule_payment_model', 'schedule_payment_model');
		
		$token = $this->input->post('token');
		//$mem_id = $this->common_model->deccrypData($token);
		$mem_id = $token;
		
		$sql = "SELECT club_transaction.*, ai_nric, ai_fname, ai_lname, ai_email, ai_hp, postalcode, country, street1, street2, unit, 
					emg_unit, emg_street1, emg_street2, emg_country, emg_postalcode,
					mh_curr_condi, mh_medicine
				FROM club_transaction 
				LEFT OUTER JOIN club_membership ON club_membership.mem_id = club_transaction.mem_id 
			 
				WHERE  club_transaction.mem_id = $mem_id
				LIMIT 1
				";		
				//`club_transaction`.pay_status='3' 
				//	AND
				
		$row 								= $this->db->query($sql)->row();
		$data['row'] 						= $row;
		
		
		if( $row->pay_status == PAY_STATUS_3 AND $row->payment_mode == PAYMENT_MODE_CC AND $row->full_payment == PAYMENT_CC_MONTLY AND in_array($row->term_type, $this->terms_active) ){
			
			//check for date expirate and alert
			$exp_date = strtotime($row->exp_date);
			$now = strtotime(date('Y-m-d'));

			$timeDiff = $exp_date-$now; 
			$numberDays = $timeDiff/86400;  // 86400 seconds in one day  
			$numberDays = intval($numberDays);	// and you might want to convert to integer		
			
			if( $numberDays < 36 ){
				
				if( $numberDays < 0 ){
					$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">Expired date was already past more than a month(s)</div>'; 
				}else{
					$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">'.$numberDays.' days before membership expired</div>'; 
				}
			}
			
			//check for payments status
			$signup_day 			= explode('-',$row->active_date);
			$schedule_payment_date 	= date('Y').'-'.date('m').'-'.$signup_day[2];

			if( strtotime($schedule_payment_date) >= strtotime(date('Y-m-d')) ){
				
				$check_payment = $this->schedule_payment_model->get(" Merchant_Ref = '{$row->pay_ref}' AND Tran_Date BETWEEN '".date('Y-m-d',strtotime('first day of last month'))."' AND '".date('Y-m-d',strtotime('last day of last month'))."' ", 1);
				$check_payment = @$check_payment[0];	
				if( count($check_payment) == 0 ){
					$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">No Payment has been made on '.date('d/m/Y',strtotime($schedule_payment_date)).'</div>';
				}else{
					if($check_payment->status != 'Accepted'){
						$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">Payment for this month was '.$check_payment->status.'</div>';
					}
				}
			}else{
				$check_payment = $this->schedule_payment_model->get(array('Merchant_Ref' => $row->pay_ref), 1); 
				$check_payment = @$check_payment[0];	 
				if( count($check_payment) > 0 ){ 
					if( $check_payment->status != 'Accepted' ){
						$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">Last payment of '.date('d/m/Y',strtotime($check_payment->Tran_Date)).' was '.$check_payment->status.'</div>';
					}
				}

			}
		}elseif( $row->pay_status == PAY_STATUS_3 AND $row->payment_mode == PAYMENT_MODE_CASH AND in_array($row->term_type, $this->terms_active) ){
		
			//check for date expirate and alert
			$exp_date = strtotime($row->exp_date);
			$now = strtotime(date('Y-m-d'));

			$timeDiff = $exp_date-$now; 
			$numberDays = $timeDiff/86400;  // 86400 seconds in one day  
			$numberDays = intval($numberDays);	// and you might want to convert to integer		
			
			if( $numberDays < 36 ){
				
				if( $numberDays < 0 ){
					$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">Expired date was already past more than a month(s)</div>'; 
				}else{
					$data['alerts'][] = '<div class="alert alert-danger" style="padding:3px 3px; margin:0; font-weigth:bold; color: red; font-size:14px">'.$numberDays.' days before membership expired</div>'; 
				}
			}
		
		}else{

		}		
		  
		$data['membership_type_month'] 		= @$this->common_model->getMembershipType($row->mem_type)->month; 
		$data['schedulepayements_results'] 	= @$this->schedule_payment_model->get(array('Merchant_Ref' => $row->pay_ref));
		$data['terms_results'] 				= $this->terms_model->get(array('tran_id'=>$row->tran_id));
		$data['freebies_results'] 			= $this->freebies_model->get(array('tran_id'=>$row->tran_id));
		$data['countries'] 					= $this->common_model->getCountryDropdown();
		$data['title'] 						= $this->input->post('title');
		$data['token'] 						= $token;
		
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
		//$mem_id = $this->common_model->deccrypData($token);
		$mem_id = $token;
		
		$set['ai_nric'] 		= $this->input->post('ai_nric');
		$set['ai_fname'] 		= $this->input->post('firstname');
		$set['ai_lname'] 		= $this->input->post('lastname');
		$set['ai_email'] 		= $this->input->post('email');
		$set['unit'] 			= $this->input->post('unit');
		$set['street1'] 		= $this->input->post('street1');
		$set['country'] 		= $this->input->post('country');
		$set['postalcode'] 		= $this->input->post('postalcode');
		$set['ai_hp'] 			= $this->input->post('phone');
		
		$set['emg_unit'] 		= $this->input->post('emg_unit');
		$set['emg_street1'] 	= $this->input->post('emg_street1');
		$set['emg_street2'] 	= $this->input->post('emg_street2');
		$set['emg_country'] 	= $this->input->post('emg_country');
		$set['emg_postalcode'] 	= $this->input->post('emg_postalcode');
		
		$set['mh_curr_condi'] 	= $this->input->post('mh_curr_condi');
		$set['mh_medicine'] 	= $this->input->post('mh_medicine');
		
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
	
	/* public function ajax_membership_transaction_delete(){
	
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Failed to Delete');	
		
		$sql= "delete  FROM `club_transaction` WHERE tran_id = '".$this->input->post("delid")."' limit 1"; 
		if($this->db->query($sql) ){
			$json['status'] = true;
			$json['url'] 	= base_url().'membership';
			$json['msg'] 	= 'Delete Successfully';
		}		
		
		echo json_encode($json);		
	
	} */
	
	public function ajax_membership_terms_save(){
		
		$this->load->model('Terms_model', 'terms_model');
		
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Submit Failed');
		
		$mem_id = $this->input->post('token');
		$tran_id = $this->input->post('token1');
		$term = $this->input->post('terms');
		$reason = $this->input->post('reason');
		$expire_date = $this->input->post('expire_date');
		
		$set1 = array();
		$set2 = array();
		
		$set1['term_type']		= $term; 
		$set1['update_date']	= date('Y-m-d H:i:s');  
		$set1['term_updated']	= date('Y-m-d H:i:s');
		

		if( $term == TERM_ACTIVE ){ //activate or reactivate
			$set1['pay_status']		= '3';
			$set1['deleted']		= 0; 
			
			$json['term']			= $term;
			$json['url']			= '';
		}
		
		if( $term == TERM_EXTEND_6 ){ //Extend 6 months
			
			$xp_date = ($expire_date == '0000-00-00') ? date('Y-m-d', strtotime('NOW +6 month ')): date('Y-m-d', strtotime($this->input->post('expire_date').' +6 month '));
			
			$set1['exp_date']		= $xp_date;
			$set1['pay_status']		= '3';
			$set1['deleted']		= 0; 
			
			$json['term']			= $term;
			$json['url']			= '';
		}
		
		if( $term == TERM_EXTEND_12 ){ //Extend 12 months
			
			$xp_date = ($expire_date == '0000-00-00') ? date('Y-m-d', strtotime('NOW +12 month ')): date('Y-m-d', strtotime($this->input->post('expire_date').' +12 month '));
			
			$set1['exp_date']		= $xp_date;
			$set1['pay_status']		= '3';
			$set1['deleted']		= 0; 
			
			$json['term']			= $term;
			$json['url']			= '';
		}

		if( $term == TERM_DELETED ){
			$set1['deleted']		= 1; 
			$set1['deleted_reason']	= $reason; 
			$set1['deleted_user']	= $this->user_name; 
		}	
		
		if( $term == TERM_TERMINATION ){ //terminated
			$set1['terminated_date'] = date('Y-m-d');  
		}	
		
		if( $term == TERM_SUSPENSION ){ //terminated
			$set1['suspension_date'] = date('Y-m-d');  
		}		
		
		$set2['mem_id'] 		= $mem_id;
		$set2['tran_id'] 		= $tran_id;
		$set2['term_type'] 		= $term;
		$set2['term_reason'] 	= $reason;
		$set2['term_status'] 	= 1;
		$set2['added_by'] 		= $this->user_name;
		 
		$this->db->where('tran_id', $tran_id);
		if( $this->db->update('club_transaction', $set1) ){
			$json['status'] = true;
			$json['msg'] = 'Update Successfully.'; 
			$json['msg'] .= ' Page will be refresh';
			
			
			$this->terms_model->add($set2);
		}
		
		echo json_encode($json);
	}
	
	public function ajax_membership_freebies_save(){
		
		$this->load->model('Freebies_model', 'freebies_model');
		
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Submit Failed');
		
		$mem_id 		= $this->input->post('token');
		$tran_id 		= $this->input->post('token1'); 
		$freebiesdesc 		= $this->input->post('freebiesdesc');		
		
		$set['mem_id'] 		= $mem_id;
		$set['tran_id'] 	= $tran_id;
		$set['f_desc'] 		= $freebiesdesc; 
		$set['added_by'] 	= $this->user_name;
		
		if( $this->freebies_model->add($set) ){
			$json['status'] = true;
			$json['msg'] = 'Update Successfully.'; 
		}
		$set['date'] = date('Y-m-d H:i:s');
		$json['data'] = $set;
		
		echo json_encode($json);
	}
	
	public function ajax_membership_otherpayment_save(){ 
		
		$this->load->model('Schedule_payment_model', 'schedule_payment_model');
		
		$json = array('status'=>false, 'url'=>'', 'msg'=>'Submit Failed');
		
		$mem_id			= $this->input->post('token');
		$tran_id 		= $this->input->post('token1'); 
		$pay_ref 		= $this->input->post('pay_ref');		
		$amount 		= $this->input->post('other_amount');		
		$paytment_type 	= $this->input->post('other_payment_type');		
		$duedate 		= explode('/',$this->input->post('other_duedate'));		
		$duedate 		= date('Y-m-d', strtotime($duedate[2].'-'.$duedate[1].'-'.$duedate[0]));		
		$desc 			= $this->input->post('other_desc');		
		
		$set['Order_Date'] 			= $duedate; 
		$set['Tran_Date'] 			= $duedate;
		$set['Currency'] 			= 'SGD';
		$set['Amount'] 				= $amount;
		$set['Merchant_Ref'] 		= $pay_ref;
		$set['status'] 				= 'Accepted';
		$set['transaction_type'] 	= $paytment_type;
		$set['reason'] 				= $desc;
		$set['uploaded_by'] 		= $this->user_name; 
		
		if( $this->schedule_payment_model->add($set) ){
			$json['status'] = true;
			$json['msg'] = 'Update Successfully.'; 
			
			//there must be update of the status if upload is automatic update the status
		}
		$set['date'] 			= date('Y-m-d H:i:s');
		$set['Order_Date'] 		= date('d/m/Y',strtotime($duedate)); //overide date format
		$json['data'] = $set;
		
		echo json_encode($json);		
		
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
				LIMIT 1 ";
	 
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
		
		/* $sql = "SELECT exp_stat, term_type FROM club_transaction WHERE exp_stat = '1'";
		$result = $this->db->query($sql)->result();
		
		foreach( $result as $row){
			
			$temp = $this->db->update_string('club_transaction', array('term_type'=>$row->exp_stat), ' exp_stat=1');
			echo $temp.'<br/>';
		} */	

		echo date('Y-m-d', strtotime('NOW + 2 Month'));	
		
	}
	
}

/* End of file membership.php */
/* Location: ./application/controllers/membership.php */
