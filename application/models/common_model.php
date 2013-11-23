<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_Model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  
	
	function randr($j = 6){
		$string = "";
		for($i=0;$i < $j;$i++){
			srand((double)microtime()*1234567);
			$x = mt_rand(0,2);
			switch($x){
				case 0:$string.= chr(mt_rand(97,122));break;
				case 1:$string.= chr(mt_rand(65,90));break;
				case 2:$string.= chr(mt_rand(48,57));break;
			}
		}
		return strtoupper($string); //to uppercase
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
	
	function getCountryDropdown(){
		$sql = "SELECT * FROM `gear_country` "; 
		$result = $this->db->query($sql)->result();  
		$countries = array();
		foreach($result as $row){
			$countries[$row->id] = $row->countryname;
		}
		return $countries;
	}	

	function getCompanyList(){	 
		$sql = "SELECT * FROM  company WHERE active_status = '0'";
		$result = $this->db->query($sql)->result();  
		
		return $result;		 
	}
	
	function companyName($id){
	 
		$sql_com = "select * from company_club_membership_type where mem_type_id ='".$id."'";
		$result_com = $this->db->query($sql_com);
		$row_com = $result_com->row_array();
		$sql = "SELECT * FROM company where company_id = '".$row_com['company_name']."'";
		$result = $this->db->query($sql);
		$row = $result->row_array();
		return	$row['company_name'];
	} 
	
	//get membership type information
	function getMembershipType($id){
		
		$row = $this->db->get_where('club_membership_type', array('mem_type_id'=>$id))->row();
		return $row;	
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


	function membershipEmail($orderRef,$send) {
	
		$orderRef = base64_decode($orderRef);
		$sql = "SELECT *  FROM `club_transaction`, `club_membership` where `club_transaction`.`pay_ref`='".$orderRef."' and `club_transaction`.pay_status='3' and `club_transaction`.`mem_id`=`club_membership`.`mem_id`";
		$result = $this->db->query($sql);
		//$count = $result->size();
		#main information details
		
		$row = $result->row_array();	
			
		$Refno 				= $row["pay_ref"];
		$pay_amount 		= $row["pay_amt"];
		$member_type 		= $row["mem_name"];
		$transction_date 	= $row["update_date"];
		$exp_date 			= $row["exp_date"];
		$due_date 			= $row["due_date"];
		$name 				= $row["ai_fname"]." ".$row["ai_lname"];	
		$nric 				= $row["ai_nric"];
		$email 				= $row["ai_email"];
		$unit 				= $row["unit"];
		$street1 			= $row["street1"];
		$street2 			= $row["street2"];
		$country 			= $row["country"];
		$postalcode 		= $row["postalcode"];
		$hp 				= $row["ai_hp"];
		$full_payment 		= $row["full_payment"];
		$payment_mode 		= $row["payment_mode"];
		$mem_type 			= $row["mem_type"];
		$ipAdd 				= $row["ipAdd"];		 
		
		$sender	=	"membership@vandaboxing.com";// sender email

		#for monthly online payment
		if($payment_mode==0 && $full_payment==0)
		{
			$subject = "Membership Payment - Monthly <".$Refno."> (SGD ".$pay_amount.") ";
		}
		#for full online payment
		elseif($payment_mode==0 && $full_payment==1)
		{
			$subject = "Membership Payment - Full <".$Refno."> (SGD ".$pay_amount.") ";
		}

		#for monthly payment through dd
		elseif($payment_mode==1 && $full_payment==0)
		{
			$subject = "Membership Confirmation - DD <".$Refno."> (SGD ".$pay_amount.") ";
		}
		#for FULL payment cash
		elseif($payment_mode==2 && $full_payment==1)
		{	
			$subject = "Membership Confirmation - Cash <".$Refno."> (SGD ".$pay_amount.") ";
		}
		// message

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
		<strong>Thank you for joining Vanda Boxing Club!</strong> <br /><br />
		Please bring the following items with you on your first day of training with us:<br /><br />
		1)	This membership confirmation email<br />
		2)	Identity Card (NRIC / S PASS / EP Card)<br />
		3)	A utility bill for proof of residential address *Must be in your name.<br /> 
		4)	For U21 Members only, please provide any official document as proof of residential address.<br /><br />
		We will then issue you with your exclusive VBC Membership Card upon verifying your membership. To facilitate a smooth process, please ensure your ID Card contains the same details entered when signing up.<br /><br />
		<strong>IMPORTANT</strong> - Please remember:<br /><br />
		<span class="red">1. After the contractual period of the membership, the membership will renew automatically unless the member terminates the agreement by giving the Company 30 days written notice. All such notices should be sent to <a href="mailto:membership@vandaboxing.com">membership@vandaboxing.com</a>. Please note that verbal notices will not be acknowledged. Termination request must be made in writing.<br /><br />
		2. If a person or persons must cancel the membership out of no fault of their own through being relocated via employment, or have to depart from Singapore, or for long term medical reasons (i.e. minimum 8 months) then a cancellation fee of $321.00 must be made, and the cancellation must be made in writing at <a href="mailto:membership@vandaboxing.com">membership@vandaboxing.com</a>, 30 days before the termination is to take place. Proof of departure or medical letter must be shown on applying for cancellation.</span><br /><br />
		</td>
		</tr>
		<tr valign="top">
		<td width="38%"><div align="right">Vanda Boxing Club</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">Membership</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Reference Number</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$Refno.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Amount(price inclusive of 7% GST)</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">S$'.$pay_amount.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Membership</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$member_type.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Application Date</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.date('d/m/Y',strtotime($transction_date)).'</div></td></tr>';

		if($full_payment==0) {
		
			$message .='<tr valign="top"><td width="38%"><div align="right">Payment Mode</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">Monthly'; 
			
			if($payment_mode==0){
				$message .=' - CC';
			}else if($payment_mode==1){
				$message .=' - Direct Debit';
			}

			$message .='</div></td></tr>';
			$message .='<tr valign="top"><td width="38%"><div align="right">Due Date</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">';

			if($due_date=="0000-00-00" || $due_date==""){ 
				$message .='0000-00-00';
			}else{
				$message .= date('d/m/Y',strtotime($due_date));
			}
			
			$message .= '</div></td></tr>';
		}
		else{
			$message .='<tr valign="top"><td width="38%"><div align="right">Payment Mode</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">Full';
		
		if($payment_mode==0){
			$message .=' - CC';
		}else if($payment_mode==2){
			$message .=' - Cash';
		}
			$message.='</div></td></tr>';
		}

		$message .='<tr valign="top"><td width="38%"><div align="right">Contracted Till</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">';
		if($exp_date=="0000-00-00" || $exp_date==""){ 
			$message .='0000-00-00';
		}else{
			$message .=date('d/m/Y',strtotime($exp_date));
		}
		
		$message .='</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Name</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$name.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">NRIC or FIN Number</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$nric.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">E-mail </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$email.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Address: Unit/Blk #</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$unit.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Street</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$street1.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Country </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$this->memCountry($country).'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Postal Code </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$postalcode.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Phone</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$hp.'</td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">IP Address </td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$ipAdd.'</td></tr>';

		$message .='<tr valign="top"><td colspan="3" align="left" style="padding:10px;"><input type="checkbox" name="dis" checked="checked" onclick="this.checked=true">Disclaimer<br />
		I have read and agree to the terms and conditions listed on the membership form. I confirm that the information I have supplied on the application is true and accurate. I understand that membership of the club requires adherence to the published club rules at all times and that failure to do so will result in termination of membership and all associated privileges.</td></tr>';
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
		$headers .= 'From: Vanda Boxing Club <membership@vandaboxing.com>' . "\r\n";
		#this is for admin - sending by admin panel 
		if($send=="admin")
		{	
			$jeet = "jeet@stagemode.com";
			mail($jeet, $subject, $message, $headers);
		}
		#this is for vanda - sending by admin panel
		if($send=="vanda") {	
			$email = "membership@vandaboxing.com";
			mail($email, $subject, $message, $headers);
		}
		#this is for user - sending by admin panel
		if($send=="email") {	
			$email = $email;
			mail($email, $subject, $message, $headers);
		}
		#this mail is for online payment
		if($send=="new") {
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($vanda, $subject, $message, $headers);
			mail($email, $subject, $message, $headers);
		}
		#this is for Direct Debit and  Cash Payment
		if($send=="ddcash") {
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($email, $subject, $message, $headers);
			mail($vanda, $subject, $message, $headers);
		}

		#this is for confirmation
		if($send=="confirmation") {
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($vanda, $subject, $message, $headers);
			mail($email, $subject, $message, $headers);
		}

		if($send=="conf_admin"){
			$jeet = "jeet@stagemode.com";
			mail($jeet, $subject, $message, $headers);
		}

		#only for display
		if($send=="print"){
			echo $message;
		}
	}
	


	function companyMembershipEmail($orderRef,$send){
		 
		$orderRef = base64_decode($orderRef);
		$sql = "SELECT *  FROM `company_club_transaction`, `company_club_membership` where `company_club_transaction`.`pay_ref`='".$orderRef."' and `company_club_transaction`.pay_status='3' and `company_club_transaction`.`mem_id`=`company_club_membership`.`mem_id`";
		 
		$result = $this->db->query($sql);

		$row = $result->row_array();	
		#main information details
	 
		$Refno 				= $row["pay_ref"];
		$pay_amount 		= $row["pay_amt"];
		$member_type 		= $row["mem_name"];
		$transction_date 	= $row["update_date"];
		$exp_date 			= $row["exp_date"];
		$due_date 			= $row["due_date"];
		$name  				= $row["ai_fname"]." ".$row["ai_lname"];	 	
		$email 				= $row["ai_email"];
		$nric 				= @$row["ai_nric"];
		$unit 				= $row["unit"];
		$street1 			= $row["street1"];
		$street2 			= $row["street2"];
		$country 			= $row["country"];
		$postalcode 		= $row["postalcode"];
		$hp 				= $row["ai_hp"];
		$full_payment 		= $row["full_payment"];
		$payment_mode 		= $row["payment_mode"];
		$mem_type 			= $row["mem_type"];
		  
		$sender="membership@vandaboxing.com";// sender email

		#for monthly online payment
		if($payment_mode==0 && $full_payment==0)
		{
			$subject = $this->companyName($mem_type)." Membership Payment - Monthly <".$Refno."> (SGD ".$pay_amount.") ";
		}
		#for full online payment
		elseif($payment_mode==0 && $full_payment==1)
		{
			$subject = $this->companyName($mem_type)." Membership Payment - Full <".$Refno."> (SGD ".$pay_amount.") ";
		}
		#for full payment through bank
		elseif($payment_mode==1 && $full_payment==0)
		{
			if($send=="confirmation" || $send=="conf_admin")
			{
				$subject = $this->companyName($mem_type)." Membership Confirmation - DD <".$Refno."> (SGD ".$pay_amount.") ";
			}
		}
		#for FULL payment cash
		elseif($payment_mode==2 && $full_payment==1)
		{	
			if($send=="confirmation" || $send=="conf_admin")
			{
				$subject = companyName($mem_type)." Membership Confirmation - Cash Full <".$Refno."> (SGD ".$pay_amount.") ";
			}
		}

		$message_info = 'Thank you! Please print this email and bring it to your next visit to VBC@Finexis Building. We will verify your membership and organise your photograph to be taken for your membership card.';

		// message
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
		Thank you for joining Vanda Boxing Club! Please print this email and bring it to your next visit to VBC@Finexis Building. We will verify your membership and organise your photograph to be taken for your membership card.
		</td>
		</tr>
		<tr valign="top">
		<td width="38%"><div align="right">Vanda Boxing Club </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">Membership</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Reference Number </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$Refno.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Amount(price inclusive of 7% GST)</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">S$'.$pay_amount.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Membership</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$member_type.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Application Date</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.date('d/m/Y',strtotime($transction_date)).'</div></td></tr>';

		if($full_payment==0)
		{
			$message .='<tr valign="top"><td width="38%"><div align="right">Payment Mode</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">Monthly-CC'; 
			$message .='</div></td></tr>';
			$message .='<tr valign="top"><td width="38%"><div align="right">Due Date</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">';
			
			if($due_date=="0000-00-00" || $due_date==""){ 
				$message .='0000-00-00';
			}else{
				$message .= date('d/m/Y',strtotime($due_date));
			}
			$message .= '</div></td></tr>';
		}
		else
		{
			$message .='<tr valign="top"><td width="38%"><div align="right">Payment Mode</div></td>
			<td width="4%"><div align="center">:</div></td>
			<td width="58%"><div align="left">Full';
			if($payment_mode==0){
				$message .=' - CC';
			}else if($payment_mode==1){
				$message .=' - Direct Debit';
			}if($payment_mode==2){
				$message .=' - Cash';
			}
			$message.='</div></td></tr>';
		}

		$message .='<tr valign="top"><td width="38%"><div align="right">Expiry Date</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">';
		
		if($exp_date=="0000-00-00" || $exp_date==""){ 
			$message .='0000-00-00';
		}else{
			$message .=date('d/m/Y',strtotime($exp_date));
		}
		
		$message .='</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Name</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$name.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Company</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$this->companyName($mem_type).'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">E-mail </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$email.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Address: Unit/Blk #</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$unit.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Street</div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$street1.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Country </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$this->memCountry($country).'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%"><div align="right">Postal Code </div></td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%"><div align="left">'.$postalcode.'</div></td></tr>';
		$message .='<tr valign="top"><td width="38%" align="right">Phone</td>
		<td width="4%"><div align="center">:</div></td>
		<td width="58%" align="left">'.$hp.'</td></tr>';
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
		$headers .= 'From: Vanda Boxing Club <membership@vandaboxing.com>' . "\r\n";
		#this is for admin - sending by admin panel 
		if($send=="admin")
		{	
			$email = "jeet@vandaboxing.com";
			mail($email, $subject, $message, $headers);
		}
		#this is for vanda - sending by admin panel
		if($send=="vanda")
		{	
			$email = "membership@vandaboxing.com";
			mail($email, $subject, $message, $headers);
		}
		#this is for user - sending by admin panel
		if($send=="email")
		{	
			$email = $email;
			mail($email, $subject, $message, $headers);
		}
		#this mail is for online payment(Default mail)
		if($send=="new")
		{
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($vanda, $subject, $message, $headers);
			mail($email, $subject, $message, $headers);
		}
		#this is for Direct Debit and  Cash Payment
		if($send=="ddcash")
		{
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($email, $subject, $message, $headers);
			mail($vanda, $subject, $message, $headers);
		}

		#this is for confirmation
		if($send=="confirmation")
		{
			$email = $email;
			$vanda = "membership@vandaboxing.com";
			mail($vanda, $subject, $message, $headers);
			mail($email, $subject, $message, $headers);
		}

		if($send=="conf_admin")
		{
			$jeet = "jeet@vandaboxing.com";
			mail($jeet, $subject, $message, $headers);
		}

		#only for display
		if($send=="print")
		{	
			echo $message;
		}
	}	

	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */