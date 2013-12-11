<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/class.phpmailer.php";
 
class Mailer extends PHPMailer { 

	function __construct() {
      // Call the Model constructor
      
	}
	
	public function sendMail($toName, $to, $subject, $message, $attachments) {
	
		$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

		try{
			$mail->AddAddress($to, $toName);
			$mail->SetFrom('membership@vandaboxing.com', 'Vanda Boxing Club');
			$mail->AddReplyTo('membership@vandaboxing.com', 'Vanda Boxing Club');
			$mail->Subject = $subject;
			//$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($message); 
			
			foreach($attachments as $attach){
				$mail->AddAttachment($attach);   
			}
			$mail->Send();
		  
			echo "Message Sent OK</p>\n";
		}catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}	
	
	}
	
	public function sendSMTPMail($toName, $to, $subject, $message) {
	
		$mail = new PHPMailer();
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = ''; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'mail.welldone.com.au';
		$mail->Port = 25; 
		$mail->Username = 'collection';  
		$mail->Password = 'C0113Ct10n';
		
		// Start Create Email Addr Array - added 2013-10-22 JS
		$to = str_replace(" ","",$to);
		$to = str_replace(";",",",$to);
		$send_to = array($to);
		if(strpos($to, ",") > 0){
			$send_to = explode(",",$to);
		}
		// End Create Email Addr Array
		
		$mail->SetFrom($this->from, $this->fromName);
		$mail->Subject    = $subject;
		//$this->mail->Body = $message;		
		$mail->MsgHTML($message);
		//$mail->AddAddress($to,$toName); // Replace by for loop below - 2013-10-22 JS
		for($z=0;$z<count($send_to);$z++){$mail->AddAddress($send_to[$z],$toName);} // Line added 2013-10-22 JS
		if(!$mail->Send()) return "Mailer Error: " . $mail->ErrorInfo;
		else return "Message sent to ".$to;
	}

}

?>
