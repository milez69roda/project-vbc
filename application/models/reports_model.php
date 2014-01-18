<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_Model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
    public function signups($member_type = 0, $startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.create_date", false);
		$this->db->where("DATE_FORMAT(club_transaction.create_date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");
		if( $member_type > 0 ){
			$this->db->where("mem_type", $member_type);
		}
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.create_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'create_date'=>'Signup Date');
		$result['results'] = $results;
		
		return $result;
	}	
	
    public function termination($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.termination_date", false);
		$this->db->where("term_type = ".TERM_TERMINATION." AND DATE_FORMAT(club_transaction.termination_date,'%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.termination_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'termination_date'=>'Termination Date');
		$result['results'] = $results;
		
		return $result;
	}	
	
	//need to be cleared
    public function suspension($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email, club_transaction_terms.date_created, term_reason ", false);
		$this->db->where("club_transaction_terms.term_type = ".TERM_SUSPENSION." AND DATE_FORMAT(club_transaction_terms.date_created, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");
		$this->db->join('club_transaction', 'club_transaction.tran_id = club_transaction_terms.tran_id', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id= club_transaction_terms.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction_terms.date_created', 'asc');
		$results = $this->db->get('club_transaction_terms')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'date_created'=>'Suspension Date', 
								'term_reason'=>'Reason');
		$result['results'] = $results;
		
		return $result;
	}

    public function current($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.active_date", false);
		$this->db->where(" (pay_status ='3' AND term_type NOT IN(".TERM_EXPIRED.", ".TERM_SUSPENSION.", ".TERM_TERMINATION.", ".TERM_DELETED.") ) ", null, false);
		$this->db->where("DATE_FORMAT(club_transaction.create_date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'", null, false);
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.active_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'active_date'=>'Activated Date');
		$result['results'] = $results;
		
		return $result;
	}	

    public function cashpayment($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.active_date", false);
		$this->db->where("(payment_mode = '2' AND pay_status = '3' AND term_type NOT IN(".TERM_EXPIRED.", ".TERM_SUSPENSION.", ".TERM_TERMINATION.", ".TERM_DELETED.") ) ", null, false);
		$this->db->where("DATE_FORMAT(club_transaction.create_date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'", null, false);
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.active_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'active_date'=>'Activated Date');
		$result['results'] = $results;
		
		return $result;
	}	
	
    public function creditcard($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.active_date", false);
		$this->db->where("(payment_mode = '0' AND pay_status = '3' AND term_type NOT IN(".TERM_EXPIRED.", ".TERM_SUSPENSION.", ".TERM_TERMINATION.", ".TERM_DELETED.") ) ", null, false);
		$this->db->where("DATE_FORMAT(club_transaction.create_date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'", null, false);
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.active_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'active_date'=>'Activated Date');
		$result['results'] = $results;
		
		return $result;
	}	
	
	//DATE_FORMAT(club_transaction_terms.date_created, '%d/%m/%Y %h:%i:%s %p') as date_created, 
    public function terms($startdate, $enddate, $type){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name,
							CASE club_transaction_terms.term_type
								WHEN ".TERM_ACTIVE." THEN 'Activated/Reactivate'
								WHEN ".TERM_EXPIRED." THEN 'Expired'
								WHEN ".TERM_SUSPENSION." THEN 'Suspended'
								WHEN ".TERM_TERMINATION." THEN 'Terminated'
								WHEN ".TERM_ROLLING_MONTLY." THEN 'Rolling Monthtly'
								WHEN ".TERM_EXTEND_6." THEN 'Extend 6 Months'
								WHEN ".TERM_EXTEND_12." THEN 'Extend 12 Months'
								WHEN ".TERM_DELETED." THEN 'Deleted'
							END AS terms, 			
							club_transaction_terms.date_created, 
							term_reason, added_by ", false);
		//$this->db->where("club_transaction_terms.date_created BETWEEN '$startdate' AND '$enddate'");
		if($type != '' ){
			$this->db->where("club_transaction_terms.term_type", $type);
		}
		if($startdate != '' ){
			$this->db->where("DATE_FORMAT(club_transaction_terms.date_created, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");
		}
		  
		$this->db->join('club_transaction', 'club_transaction.tran_id = club_transaction_terms.tran_id', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id= club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction_terms.date_created', 'asc');
		$results = $this->db->get('club_transaction_terms')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'terms'=>'Term Type',  
								'date_created'=>'Date', 
								'term_reason'=>'Reason',
								'added_by'=>'Added by');
		$result['results'] = $results;
		
		return $result;
	}	

	public function freebies($startdate, $enddate, $type){ 

		$this->db->select("pay_ref, CONCAT(ai_fname, ' ', ai_lname) AS full_name, f_desc, club_transaction_freebies.date_created, added_by", false);
		$this->db->join('club_transaction', 'club_transaction.tran_id = club_transaction_freebies.tran_id', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id= club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction_freebies.date_created', 'asc');

		$this->db->where("DATE_FORMAT(club_transaction_freebies.date_created, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");

		$results = $this->db->get('club_transaction_freebies')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'f_desc'=>'Freebies/Others', 
								'date_created'=>'Date',  
								'added_by'=>'Added by');
		$result['results'] = $results;
		//echo $this->db->last_query();
		return $result;		
	}	
	
/* 	public function expired(){
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.termination_date", false);
		$this->db->where("term_type = ".TERM_TERMINATION." AND DATE_FORMAT(club_transaction.termination_date,'%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'");
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.termination_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		$result['header'] = array( 
								'pay_ref'=>'Ref', 
								'full_name'=>'Name', 
								'ai_nric'=>'NRIC/FIN No',
								'mem_name'=>'Membership', 
								'pay_amt'=>'Amount', 
								'ai_hp'=>'Phone', 
								'ai_email'=>'Email', 
								'termination_date'=>'Termination Date');
		$result['results'] = $results;
		
		return $result;
	} */
	
	public function expired_35_days(){
	
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, pay_ref, club_transaction.mem_id, club_transaction.exp_date", false);
		$this->db->where(" (pay_status ='3' AND term_type NOT IN(".TERM_EXPIRED.", ".TERM_SUSPENSION.", ".TERM_TERMINATION.", ".TERM_DELETED.") ) ", null, false);
		$this->db->where(" (exp_date - INTERVAL 35 DAY) < CURRENT_DATE ", null, false);
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$this->db->order_by('club_transaction.exp_date', 'asc');
		$results = $this->db->get('club_transaction')->result();
		return $results;
	}
	
	function invoice($ref, $startdate, $enddate, $status = 0){
	 
		$this->db->select("ai_fname, ai_lname, scheduled_payments.Merchant_Ref, Amount,  status, IF(STATUS = 'Accepted', Amount, '' ) AS 'success', IF(STATUS != 'Accepted', Amount, '' )AS 'failed', DATE_FORMAT(Order_Date, '%d/%m/%Y') as Order_Date", false);
		
		//$this->db->where('scheduled_payments.status', 'Accepted');
		
		if( $status > 0 ){
			if( $status == 1) $this->db->where('scheduled_payments.status', 'Accepted');
			else $this->db->where("scheduled_payments.status != 'Accepted'", null, false);
		}
		
		if( $ref != '' ){
			$this->db->where('scheduled_payments.Merchant_Ref', $ref);
		}
		
		if($startdate != '' ){
			$this->db->where("DATE_FORMAT(scheduled_payments.Order_Date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'", null, false);
		}		
		
		$this->db->order_by('scheduled_payments.Order_Date', 'ASC');
		
		$this->db->join('club_transaction', 'club_transaction.pay_ref = scheduled_payments.Merchant_Ref', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$results = $this->db->get('scheduled_payments')->result();	
		
		return $results;
	}
	
	
	function invoice_individual($ref, $startdate, $enddate, $status = 0){
	 
		$this->db->select("ai_fname, ai_lname, scheduled_payments.Merchant_Ref, Amount,  status, IF(STATUS = 'Accepted', Amount, '' ) AS 'success', IF(STATUS != 'Accepted', Amount, '' )AS 'failed', DATE_FORMAT(Order_Date, '%d/%m/%Y') as Order_Date", false);
		
		//$this->db->where('scheduled_payments.status', 'Accepted');
		
		if( $status > 0 ){
			if( $status == 1) $this->db->where('scheduled_payments.status', 'Accepted');
			else $this->db->where("scheduled_payments.status != 'Accepted'", null, false);
		}
		
		if( $ref != '' ){
			$this->db->where('scheduled_payments.Merchant_Ref', $ref);
		}
		
		if($startdate != '' ){
			$this->db->where("DATE_FORMAT(scheduled_payments.Order_Date, '%Y-%m-%d' ) BETWEEN '$startdate' AND '$enddate'", null, false);
		}		
		
		$this->db->order_by('scheduled_payments.Order_Date', 'ASC');
		
		$this->db->join('club_transaction', 'club_transaction.pay_ref = scheduled_payments.Merchant_Ref', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER');
		$results = $this->db->get('scheduled_payments')->result();	
		
		
		
		return $results;
	}
 
}

/* End of file reports_model.php */
/* Location: ./application/core/reports_model.php */
