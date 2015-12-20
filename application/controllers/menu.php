<?php

class Menu extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	public function index()
	{
		if($this->session->userdata('nama')){
			$dir = './uploads/';
			$dir = $dir.$this->session->userdata('username');
			$map = directory_map($dir);
			$data = array('files' => $map);
			$this->load->view('menu',$data);
		}
		else
			redirect(base_url("menu/login/"));
	}
	public function enc_upload(){
		$dir = 'uploads/'.$this->session->userdata('username');
		if ( !file_exists($dir) ) {
		     $oldmask = umask(0);  // helpful when used in linux server  
		     mkdir ($dir, 0744);
		}
		$cipher=$this->input->post('cipher');
		$filename=$this->input->post('filename');
		//echo $cipher;
		$file = $dir.'/'.$filename.'.encrypted';
		file_put_contents($file, $cipher);
		redirect(base_url("menu/"));
	}

	public function cloud(){
		$dir = './uploads/';
		$dir = $dir.$this->session->userdata('username');
		if ( !file_exists($dir) ) {
		     $oldmask = umask(0);
		     mkdir ($dir, 0744);
		 }
		$map = directory_map($dir);
		var_dump($map);
		foreach ($map as $key) {
			echo $key."<br>";
		}
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function login_proses()
	{
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$this->load->model("data");
		$this->load->database();
		$result = $this->data->login($username, $password);
 		if($result)
		   {
		     $sess_array = array();
		     foreach($result as $row)
		     {
		       $sess_array = array(
		         'username' => $row->username,
		         'nama' => $row->nama,
		         'password' => $row->password
		       );
		       $this->session->set_userdata($sess_array);
		     }
		     redirect(base_url(""));
		     return TRUE;
		   }
	   else
	   {
	     $this->form_validation->set_message('check_database', 'Invalid username or password');
	     redirect(base_url("menu/login/"));
	     return false;
	   }
		
	}
	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->sess_destroy();
		redirect(base_url());
	}
}