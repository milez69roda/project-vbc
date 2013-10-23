<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership_Model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
    function get(){
 
		$aColumns = array('tran_id','pay_ref', 'club_transaction.mem_id', 'ai_fname', 'mem_name', 'pay_amt', 'ai_hp', 'ai_email', 'active_date', 'exp_date' );
	 

		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "club_transaction.tran_id";
		
		/* DB table to use */
		$sTable = "club_transaction";
		$sJoin = " LEFT OUTER JOIN club_membership ON club_membership.mem_id =  club_transaction.mem_id";
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
		if ( isset( $_GET['iSortCol_0'] ) )
		{
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
		$sWhere = "WHERE ";
		
		//$sWhere .= " DATE_FORMAT(date_received,'%Y-%m-%d') BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."'";
		
		$sel_sort_view = trim($this->input->get('sel_sort_view'));
		 
		switch($sel_sort_view){
			case 0:
				$sWhere .= " (payment_mode = '0' and exp_stat = '0') ";
				break;
			case 1:
				$sWhere .= " (payment_mode = '1'  and exp_stat = '0') ";
				break;			
			case 2:
				$sWhere .= " (payment_mode = '2'  and exp_stat = '0') ";
				break;			
			case 3:
				$sWhere .= " (exp_stat = '1') ";
				break;			
			case 5:
				$sWhere .= " (pay_status ='3' AND exp_date !='0000-00-00' AND due_date !='0000-00-00' AND exp_stat ='0') ";
				break;
			default:
				$sWhere .= " 1 ";
				break;
		}
		
		if ( $_GET['sSearch'] != "" ){
				
				$sWhere .= " AND (";        
				
				for ( $i=0 ; $i<count($aColumns) ; $i++ ){ 
						
						if( $aColumns[$i] == 'ai_fname'){
							
							$names = explode(' ',$_GET['sSearch']);
							foreach($names as $name){
								$sWhere .= "LOWER(ai_fname) LIKE '%".mysql_real_escape_string( $name )."%' OR ";
								$sWhere .= "LOWER(ai_lname) LIKE '%".mysql_real_escape_string( $name )."%' OR ";
							}
						}else{
							$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
						}
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
						if ( $sWhere == "" ) {
								$sWhere = "WHERE ";
						}
						else {
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
					tran_id, 
					pay_ref, 
					club_transaction.mem_id, 
					ai_fname,
					ai_lname, 
					mem_name, 
					pay_amt, 
					ai_hp, 
					ai_email, 
					active_date, 
					exp_date,
					payment_mode,
					full_payment,
					exp_stat,
					pay_status	
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

			$rows['DT_RowId'] = $this->common_model->enccrypData($row->tran_id);
			   
			if($row->pay_status ==3){

				if($row->payment_mode ==0 && $row->full_payment ==0  && $row->exp_stat ==0) {
					$rows['DT_RowClass'] = "TRANSAC_TYPE_online_mp";
				}elseif($row->payment_mode ==0 && $row->full_payment ==1 && $row->exp_stat ==0) {
					$rows['DT_RowClass'] = "TRANSAC_TYPE_online_fp";
				}elseif($row->payment_mode ==1 && $row->full_payment ==0 && $row->exp_stat ==0) {
					$rows['DT_RowClass'] = "TRANSAC_TYPE_offline_direct_mp";
				}elseif($row->payment_mode ==1 && $row->full_payment ==1 && $row->exp_stat ==0) {
					$rows['DT_RowClass'] = "TRANSAC_TYPE_offline_direct_fp";
				}elseif($row->payment_mode ==2 && $row->full_payment ==0 && $row->exp_stat ==0) {
					$rows['DT_RowClass'] = "TRANSAC_TYPE_offline_cash_mp"; 
				}elseif($row->payment_mode ==2 && $row->full_payment ==1 && $row->exp_stat ==0) {
					$rows['DT_RowClass'] ="TRANSAC_TYPE_offline_cash_fp";
				}elseif($row->exp_stat ==1) {
					$rows['DT_RowClass'] ="TRANSAC_TYPE_expire_mem";
				}
			 
				$rows[] = $iDisplayStart++; 	 	
				$rows[] = $row->pay_ref; 
				$rows[] = $row->ai_fname.' '.$row->ai_lname; 
				$rows[] = substr( $row->mem_name, 0,12); 
				$rows[] = 'S$'.$row->pay_amt; 
				$rows[] = $row->ai_hp; 
				$rows[] = $row->ai_email; 
				$rows[] = ($row->active_date == "0000-00-00")?'':date('d/m/Y',strtotime($row->active_date));
				$rows[] = ($row->exp_date == "0000-00-00")?'':date('d/m/Y',strtotime($row->exp_date));  
				$rows[] = '<a href="#">Details</a>|<a href="#">Form</a>|<a href="#">Delete</a>';

				$output['aaData'][] = $rows;
			}else{
			
				if( $row->payment_mode == 0 ){ 
					
					$rows['DT_RowClass'] = '';
					
					$rows[] = $iDisplayStart++; 	 	
					$rows[] = $row->pay_ref; 
					$rows[] = $row->ai_fname.' '.$row->ai_lname; 
					$rows[] = substr( $row->mem_name, 0,12); 
					$rows[] = 'S$'.$row->pay_amt; 
					$rows[] = $row->ai_hp; 
					$rows[] = $row->ai_email; 
					$rows[] = ($row->active_date == "0000-00-00")?'':date('d/m/Y',strtotime($row->active_date));
					$rows[] = ($row->exp_date == "0000-00-00")?'':date('d/m/Y',strtotime($row->exp_date));  
					$rows[] = '<a href="#">Details</a>|<a href="#">Form</a>|<a href="#">Delete</a>';	
					
					$output['aaData'][] = $rows;
				}
				
				
			}
			
			
		}
		echo json_encode( $output );        
    
    }	 	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
