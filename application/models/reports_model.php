<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_Model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
    public function signups($startdate, $enddate){ 
		
		$this->db->select("pay_ref, CONCAT(ai_fname,' ', ai_lname) AS full_name, ai_nric, mem_name, pay_amt, ai_hp, ai_email,club_transaction.create_date", false);
		$this->db->where("club_transaction.create_date BETWEEN '$startdate' AND '$enddate'");
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
		$this->db->where("term_type = ".TERM_TERMINATION." AND club_transaction.termination_date BETWEEN '$startdate' AND '$enddate'");
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
		$this->db->where("club_transaction_terms.term_type = ".TERM_SUSPENSION." AND club_transaction_terms.date_created BETWEEN '$startdate' AND '$enddate'");
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
							club_transaction_terms.date_created, term_reason, added_by ", false);
		//$this->db->where("club_transaction_terms.date_created BETWEEN '$startdate' AND '$enddate'");
		if($type != '' ){
			$this->db->where("club_transaction_terms.term_type", $type);
		}
		if($startdate != '' ){
			$this->db->where("club_transaction_terms.date_created BETWEEN '$startdate' AND '$enddate'");
		}
		  
		$this->db->join('club_transaction', 'club_transaction.tran_id = club_transaction_terms.tran_id', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id= club_transaction_terms.mem_id', 'LEFT OUTER');
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
	
}

/* End of file reports_model.php */
/* Location: ./application/core/reports_model.php */
