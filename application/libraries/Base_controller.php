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
		ob_start();
		//$template=file(APPPATH."templates/{$this->template}/{$this->context}.php");
		define('TEMPLATE_PATH',APPPATH."templates/{$this->template}/");
		include TEMPLATE_PATH."{$this->context}.php";
		//$template=implode("\n",$template);
		$template=ob_get_contents();
		ob_end_clean();
		$template=str_replace("<code51:module/>",implode("\n",$this->views),$template);
		echo $template;
	}
}