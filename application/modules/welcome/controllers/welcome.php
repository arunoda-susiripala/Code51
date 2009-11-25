<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
		$this->load->language("home","english");	
	}
	
	function index()
	{
		$this->load->view('welcome_message',array("lang"=>$this->lang));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */