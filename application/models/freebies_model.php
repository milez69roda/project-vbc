<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freebies_model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  

	public function get($where){
		
		if( !empty($where) ) $this->db->where($where);
		
		$this->db->order_by('date_created', 'desc');
		return $this->db->get('club_transaction_freebies')->result();
		
	}
	
	public function add($set){
		
		return $this->db->insert('club_transaction_freebies', $set);
		
	}
}

/* End of file freebies_model.php */
/* Location: ./application/core/freebies_model.php */	