<?php

class Base_controller extends Controller{
	private $views=array();
	private $context;
	
	//fetch from the DB
	
	private $template='default';
	
	public function __construct($context='site'){
		$this->context=$context;
		parent::Controller();
		include_once APPPATH."config/template.php";
		if(isset($template) && isset($template['default'])){
			$this->template=$template['default'];
		}
	}
	
	public function load_view($view_name,$params=array()){
		$view=$this->load->view($view_name,$params,true);
		$this->views[]=$view;
		
	}
	
	public function flush(){
		$template=file(APPPATH."templates/{$this->template}/{$this->context}.php");
		$template=implode("\n",$template);
		$template=str_replace("<code51:module/>",implode("\n",$this->views),$template);
		echo $template;
	}
}