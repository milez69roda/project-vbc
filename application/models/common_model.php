<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_Model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
	function urlUniqueId() {
		$random_id_length = 10;
		$rnd_id = crypt(uniqid(rand(),1));
		$rnd_id = strip_tags(stripslashes($rnd_id));
		$rnd_id = str_replace(".","",$rnd_id);
		$rnd_id = strrev(str_replace("/","",$rnd_id));
		$rnd_id = substr($rnd_id,0,$random_id_length);
		$rnd_id = str_replace( "$", "",$rnd_id );
		return $rnd_id;
	}	
	
	function enccrypData($data) {
		$final = base64_encode(base64_encode($data));
		return $this->urlUniqueId().$final.$this->urlUniqueId();
	}
	
	function deccrypData($data) {
		$final = substr($data, 10, -10); 
		return base64_decode(base64_decode($final));
	}	
	
	function memCountry($id){
		$sql = "SELECT * FROM `gear_country` WHERE `id` = '".$id."'"; 
		$row = $this->db->query($sql)->row_array();  
		return $row['countryname'];
	}	
	
	//send email to the member
	function tempMemActEmail($orderRef){
	   
		$sql = "SELECT *  FROM club_transaction, club_membership 
			WHERE club_transaction.mem_id = club_membership.mem_id 
				AND club_transaction.pay_ref='".$orderRef."' 
				AND pay_status ='3'";
		$result = $this->db->query($sql);
		//$count = $result->size();
		#main information details
		
		$row = $result->row_array();
		 
		$pay_amount			= $row["pay_amt"];
		$member_type 		= $row["mem_name"];
		$transction_date 	= $row["create_date"];
		$name  				= $row["ai_fname"]." ".$row["ai_lname"];	
		$nric 				= $row["ai_nric"]; 	
		$email 				= $row["ai_email"];
		$hp 				= $row["ai_hp"];
		$payment_mode 		= $row["payment_mode"];
		$Refno 				= $row["pay_ref"];
		$exp_date 			= $row["exp_date"];
		$ipAdd 				= $row["ipAdd"];
		$unit 				= $row["unit"];
		$street1 			= $row["street1"];
		$country 			= $row["country"];
		$postalcode 		= $row["postalcode"];
	 
		$sender = "membership@vandaboxing.com";// sender email

		#for monthly payment through dd
		if($payment_mode==1){
			$subject = "Membership Confirmation  - DD <".$Refno."> (SGD ".$pay_amount.") ";
		}elseif($payment_mode==2){	#for FULL payment cash 
			$subject = "Membership Confirmation - Cash <".$Refno."> (SGD ".$pay_amount.") ";
		}
		 
		$message ='
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Vanda Boxing Club</title>
		<script type="text/javascript" src="ajax_file.js"></script>
		<style type="text/css">
		<!--
		body{font-family: Helvetica, Arial, sans-serif; font-size:12px; color: #000; width:620px;line-height:normal;}
		a { color: #115cdd; cursor: pointer; text-decoration:none}
		a:hover { color: #000; text-decoration:underline}
		h2 {font-size:14px; color: #000; margin: 0 2px 10px 2px;border-bottom:1px dotted #999 }
		#footer {font-size:11px;clear: both; height:30px; padding:15px 20px 20px 20px; margin: 0; color: #777;  }
		#footer .blue  {color: #06c;}
		#footer .right  { float: right; text-align: left;}
		#footer a { text-decoration: none; color:#666}
		#footer a:hover{ text-decoration: underline; color:#000}
		.bluBdr{border:1px solid #1a1a1a;}
		.blubg{background-color:#ffffff;}
		#tablediv{font-size:12px;color: #545454;}
		.red {color:#ff0000;}
		.blue{color: #115cdd;}
		.black {color: #000;}
		-->
		</style>
		</head>
		<body>
		<div id="top" align="center">
		';
		$message .='
		<table width="620" border="0" cellspacing="0" cellpadding="10" class="bluBdr" id="tablediv" align="center">
		<tr><td width="60" align="left" valign="top"><img src="http://www.vandaboxing.com/vandastore/images/mail-logo.gif" width="60" height="61" /></td>
		<td width="280" align="left" valign="middle">Vanda Boxing Club<br />Finexis Building<br />108 Robinson Road #01-01<br />Singapore 068900</td>
		<td width="280" align="left" valign="middle">
		<span class="red">T</span>&nbsp;&nbsp;&nbsp;+65 6305 2288<br />
		<span class="red">F</span>&nbsp;&nbsp;&nbsp;+65 6305 2299<br />
		<span class="red">E</span>&nbsp;&nbsp;&nbsp;membership@vandaboxing.com<br />
		<span class="red">W</span>&nbsp;&nbsp;&nbsp;www.vandaboxing.com</td></tr>';
		$message .='<tr><td colspan="3" align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bluBdr blubg" >';
		$message .='
		<tr valign="top"><td colspan="3" style="padding:10px;">
		<br />
		<strong>Membership Confirmation</strong></td></tr>';
		$message .='
		<tr valign="top"><td colspan="3" style="padding:10px;">
		<strong>Thank you for joining Vanda Boxing Club!</strong> <br /><br />
		Thank you for joining Vanda Boxing Club! Please print this email and bring it to your next visit to VBC @ Finexis Building. We will verify your membership and organise your photograph to be taken for your membership card. We look forward in being a partner in your journey to a stronger, fitter, healthier you.<br /><br />
		</td></tr>';

		$message .='<tr valign="top"><td width="38%"><div align="right">Membership Status</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">Active</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Reference Number </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$Refno.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Amount</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">S$'.$pay_amount.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Membership</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$member_type.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Application Date</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.date('d/m/Y',strtotime($transction_date)).'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Payment Mode</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'; 
		if($payment_mode==1){
			$message .='Monthly - Direct Debit';
		}
		if($payment_mode==2){
			$message .='Full - Cash';
		}
		$message .='</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Contracted Till</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.date('d/m/Y',strtotime($exp_date)).'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Name</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$name.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">NRIC or FIN Number</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$nric.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">E-mail</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$email.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Address: Unit/Blk#</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$unit.'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Street</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$street1.'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Country</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$this->memCountry($country).'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Postal Code</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$postalcode.'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Phone</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$hp.'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">IP Address </td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$ipAdd.'</td></tr>';
		$message .='<tr valign="top" colspan="3"><td >&nbsp;</td>
		<td width="4%">&nbsp;</td>
		<td width="58%">&nbsp;</td></tr></table>';
		$message .='</div>
		</div>
		</body>
		</html>';
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// Additional headers
		$headers .= 'From: Vanda Boxing Club' . "\r\n";
		#this is for admin - sending by admin panel 
		$temp = "membership@vandaboxing.com";
		//echo $subject;
		//echo $message;
		mail($email, $subject, $message, $headers);
		mail($temp, $subject, $message, $headers);
	}	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */