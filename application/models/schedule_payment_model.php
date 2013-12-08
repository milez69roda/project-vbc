<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_payment_model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
	function add($set){
		
		return $this->db->insert('scheduled_payments', $set);
		
	}
	
	//update failed previous failed payment
	function update_payment($where, $set){
		$this->db->where($where);
		$this->db->order_by('date_created', 'asc');
		$this->db->limit(1);
		return $this->db->update('scheduled_payments', $set);
	}
	
	function check_payments_today(){
		$this->db->select("id");
		$this->db->where("DATE_FORMAT(date_created, '%Y-%m-%d') = CURRENT_DATE");
		$this->db->where("transaction_type = 0");  
		$result = $this->db->get('scheduled_payments');	
		return $result->num_rows();	
	}
	/* function getSchedulePayment_by_ref($ref){
		
		$this->db->select(" Tran_date, status ");
		$this->db->where('Merchant_Ref', $ref);
		
		return $this->db->get('scheduled_payments')->result();
	} */	
	
	function get($where, $limit=''){
		
		if( !empty($where) ) {
			if( !is_array($where) ) $this->db->where($where, null, false);
			else $this->db->where($where);
		}
		
		if( $limit != '' ){
			$this->db->limit($limit);
		}
		
		$this->db->order_by('date_created', 'desc');
		return $this->db->get('scheduled_payments')->result();
		
	}
	
	function get_failed_transaction($date){
		
		
		$this->db->select("pay_ref, CONCAT(ai_fname, ' ', ai_lname) AS full_name, status, club_transaction.mem_id, Tran_Date", false);
		$this->db->join('club_transaction', 'club_transaction.pay_ref = scheduled_payments.Merchant_Ref', 'LEFT OUTER');
		$this->db->join('club_membership', 'club_membership.mem_id = club_transaction.mem_id', 'LEFT OUTER'); 
		
		$this->db->where("status != 'Accepted'"); 
		$this->db->where("pay_overide", 0); 
		
		return $this->db->get('scheduled_payments')->result();
	} 
	
	function get_list(){ 
	   
		$aColumns = array('id','Master_Sch_Id', 'Detail_Sch_Id', 'Merchant_Ref', 'Order_Date', 'Tran_Date', 'Amount', 'Payment_Ref', 'status', 'date_created' );
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
		
		/* DB table to use */
		$sTable = "scheduled_payments";
		$sJoin = "";
    
		/*
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
				$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) ){
				$sOrder = "ORDER BY ";
				for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				
						if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { 
								$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
										
								//$this->db->order_by($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $_GET['sSortDir_'.$i] );        
						}
				}
				
				$sOrder = substr_replace( $sOrder, "", -2 );
				if ( $sOrder == "ORDER BY" ){
						$sOrder = "";
				}
		}
		
		
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "WHERE 1 ";
		
		//$sWhere .= " DATE_FORMAT(date_received,'%Y-%m-%d') BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."'";
		 
		 
		 
		
		if ( $_GET['sSearch'] != "" ){
				
				$sWhere .= " AND (";        
				
				for ( $i=0 ; $i<count($aColumns) ; $i++ ){ 
					
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
						 
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
					if ( $sWhere == "" ) {
							$sWhere = "WHERE ";
					}else {
							$sWhere .= " AND";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
				}
		} 
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
				SELECT SQL_CALC_FOUND_ROWS
					id,				
					Master_Sch_Id,
					Detail_Sch_Id,
					Merchant_Ref,
					Order_Date,
					Tran_Date,
					Currency,
					Amount,
					Payment_Ref,
					status,
					date_created				
				FROM $sTable
				$sJoin
				$sWhere
				$sOrder
				$sLimit
		";
		
		$rResult = $this->db->query($sQuery);
		
		//echo $this->db->last_query();
		
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
				SELECT COUNT(".$sIndexColumn.") as numrow
				FROM $sTable
				$sJoin
				$sWhere
		";
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		
		
		/*
		 * Output
		 */
		$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				//"iTotalDisplayRecords" => $iFilteredTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array()
		);
		
		$rResult = $rResult->result();
		
		$iDisplayStart = $_GET['iDisplayStart']+1;
		 
		foreach( $rResult as $row ){
		
			$rows = array();
			$rows['DT_RowId'] = $row->id;
			
			$rows[] = $iDisplayStart++; 	 	
			$rows[] = $row->Master_Sch_Id; 
			$rows[] = $row->Detail_Sch_Id; 
			$rows[] = $row->Merchant_Ref; 
			$rows[] = $row->Order_Date; 
			$rows[] = $row->Tran_Date; 
			$rows[] = $row->Currency.' '.$row->Amount; 
			$rows[] = $row->Payment_Ref; 
			if( $row->status == 'Accepted' ) $rows[] = '<span class="label label-success">'.$row->status.'</span>'; 
			elseif( $row->status == 'Rejected' ) $rows[] = '<span class="label label-warning">'.$row->status.'</span>'; 
			elseif( $row->status == 'Suspend' )	$rows[] = '<span class="label label-default">'.$row->status.'</span>'; 
			else $rows[] = '';
			$rows[] = $row->date_created; 
 
			$output['aaData'][] = $rows;
		  
		}
		echo json_encode( $output );       
    }		
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */	