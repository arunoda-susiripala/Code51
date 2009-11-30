<?php

class Auth{
	public static function init(){
		session_start();
	}
	
	public static function get_logged_in_user(){
		$user=isset($_SESSION['USER'])?$_SESSION['USER']:null;
		return $user;
	}
	
	public static function is_user_logged_in(){
		return (Auth::get_logged_in_user())?true:false;
	}
	
	public static function login($user,$remember=false){
		if(!session_id()) session_start();
		else session_regenerate_id();
		
		$_SESSION['USER']=$user;
		
	}
	
	public static function logout(){
		unset($_SESSION['USER']);
		session_destroy();
	}
	
	public static function authenticate($username,$password,$remember=false){
		$user=User::by_username($username);
		if(!$user) return false;
		
		if($user->check_password($password)){
			Auth::login($user);
			return true;
			
		}
		else{
			return false;
		}
	}
}