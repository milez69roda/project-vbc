<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  

	public function get($where){
		
		if( !empty($where) ) {
			if( !is_array($where) ) $this->db->where($where, null, false);
			else $this->db->where($where);
		}
		
		$this->db->order_by('date_created', 'desc');
		return $this->db->get('club_transaction_terms')->result();
		
	}
	
	public function add($set){
		
		return $this->db->insert('club_transaction_terms', $set);
		
	}
	
}

/* End of file terms_model.php */
/* Location: ./application/core/terms_model.php */	