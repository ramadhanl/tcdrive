<?php
class user extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	
	public function add_user($data){
		$this->db->insert("user",$data);
	}
	public function update_user($data){
		$this->db->update("user",$data);
	}
	public function get_info($username){
		$this -> db -> select('nama, password');
	   	$this -> db -> from('user');
	   	$this -> db -> where('username', $username);
	   	$query = $this -> db -> get();
	   	if($query -> num_rows() == 1) return $query->first_row();
	    else return false;
	}

	public function login($email, $password){
		$this -> db -> select('email, nama, password,hak_akses');
	   	$this -> db -> from('user');
	   	$this -> db -> where('email', $email);
	   	$this -> db -> where('password', $password);
	   	$this -> db -> limit(1);
	 	$query = $this -> db -> get();
	 	if($query -> num_rows() == 0)
	     return false;
	   else
	     return $query->result();
	 }

}