<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
		var_dump($this->user);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */