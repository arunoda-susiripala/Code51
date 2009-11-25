<?php

class Welcome extends Site_controller {
	
	function index()
	{
		$this->load->view('welcome_message',array("lang"=>$this->lang));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */