<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model { 
	
	function __construct(){
		parent::__construct(); 
	}  

	public function get($where=array()){
		
		if( !empty($where) ) $this->db->where($where);
		
		$this->db->order_by('user_name', 'asc');
		return $this->db->get('gear_admin_login')->result(); 
	}
	
	public function insert($set){
		
		return $this->db->insert('gear_admin_login', $set);
		
	}
	
	public function update($id, $set){
		
		$this->db->where("admin_id", $id);
		return $this->db->update('gear_admin_login', $set);
		
	}
	
	public function update_password($password,$username){
		
		$this->db->where('user_name', $username);
		$set['user_password'] = $password; 
		
		return $this->db->update('gear_admin_login', $set); 
	}
	
	public function check_username($username){
		$result = $this->db->get_where('gear_admin_login', array('user_name'=>$username));
		return ($result->num_rows > 0)?true:false;
	}
	
}

/* End of file freebies_model.php */
/* Location: ./application/core/freebies_model.php */	