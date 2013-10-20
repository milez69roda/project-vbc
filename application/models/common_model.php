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
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */