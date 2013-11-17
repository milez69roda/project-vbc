<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_payment_model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  

   function get(){ 
	   
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
			else;
			$rows[] = $row->date_created; 
 
			$output['aaData'][] = $rows;
		  
		}
		echo json_encode( $output );       
    }		
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */	