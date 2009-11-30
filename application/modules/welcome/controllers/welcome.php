<?php

class Welcome extends Site_controller {
	private $views=array();
	
	function index()
	{
		$this->load_view('welcome_message',array("lang"=>$this->lang));
		$this->flush();
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */