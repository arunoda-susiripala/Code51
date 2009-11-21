<?php

class Auth_library extends CodeIgniterUnitTestCase{
	/**
	 * Todo list
	 * ---------------
	 * 1.get_loggedin_user()
	 * 2.is_user_logged_in();
	 * 3.login();
	 * 4.logout();
	 * 5.init();//for persisnstant login and other stuff...
	 */
	var $user;
	
	public function test_included(){
		$this->assertTrue(class_exists('Auth'));
	}
	
	public function setUp(){
		$user=new User(null,'test_auth','test_mail','My Name');
		$user->save();
		$user->set_password('password');
		$this->user=$user;
	}
	
	public function test_logout_first(){
		$this->assertFalse(Auth::is_user_logged_in());
	}
	
	public function test_login(){
		Auth::login($this->user);
		$this->assertTrue(Auth::is_user_logged_in());
		$lu=Auth::get_logged_in_user();
		$this->assertEqual($this->user->get_id(),$lu->get_id());
	}
	
	public function test_logout(){
		Auth::logout();
		$this->assertFalse(Auth::is_user_logged_in());
	}
	
	public  function test_authenticate(){
		$this->assertTrue(Auth::authenticate('test_auth','password'));
		$this->assertTrue(Auth::is_user_logged_in());
		$lu=Auth::get_logged_in_user();
		$this->assertEqual($lu->username,$this->user->username);
		$this->assertEqual($lu->get_id(),$this->user->get_id());
	}
	
	public function tearDown(){
		$this->user->delete();
	}
}