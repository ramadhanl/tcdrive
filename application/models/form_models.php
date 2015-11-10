<?php
class form_models extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	
	public function tokenisasi($email, $password){
		$query = $this->db->get('data_kp');
	 	$query = $this -> db -> get();
	 	if($query -> num_rows() == 0)
	     return false;
	   	else
	     return $query->result();
	 }
}