<?php

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	public function index()
	{
		$this->load->view('home');
	}
	public function menu()
	{
		$this->load->view('menu2');
	}
	public function do_upload()
	{
		/*$dir = 'uploads';
		if ( !file_exists($dir) ) {
		     $oldmask = umask(0);  // helpful when used in linux server  
		     mkdir ($dir, 0744);
		}*/
		$config['upload_path'] = 'C:/wamp/www/tcdrive/uploads';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp';
		$config['max_size']	= '300';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = TRUE;
		$file = $_FILES['userfile']['name'];
		$ext = substr(strrchr($file, '.'), 1);
		$config['convert_dots'] = FALSE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('userfile')){
			$upload_data = $this->upload->data();
			echo $this->upload->display_errors();
		}
		else{
			$file_data = $this->upload->data();
			$data = base_url().'images/'.$file_data['file_name'];
			echo "sukses";
		}
	}
}