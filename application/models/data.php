<?php
class data extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	public function login($username, $password){
		$this -> db -> select('username, nama, password');
	   	$this -> db -> from('user');
	   	$this -> db -> where('username', $username);
	   	$this -> db -> where('password', $password);
	   	$this -> db -> limit(1);
	 	$query = $this -> db -> get();
	 	if($query -> num_rows() == 0)
	     return false;
	   else
	     return $query->result();
	 }
	public function get_info($username){
		$this -> db -> select('nama, password');
	   	$this -> db -> from('user');
	   	$this -> db -> where('username', $username);
	   	$query = $this -> db -> get();
	   	if($query -> num_rows() == 1) return $query->first_row();
	    else return false;
	}

}