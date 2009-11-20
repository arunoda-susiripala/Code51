<?php

class User_helper extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertTrue(class_exists('User'));
	}
	
	
	
	function test_save(){
		//just to check and get
		$user=new User();
		$rand=md5(rand());
		$user->username='user_'.$rand;
		$user->fullname='This is the name';
		$user->email="$rand@email.com";
		$user->save();
		
		
		$user_g=User::by_id($user->get_id());
		$this->assertNotNull($user_g);
		$this->assertEqual($user_g->username,$user->username);
		$this->assertEqual($user_g->email,$user->email);
		$this->assertEqual($user_g->fullname,$user->fullname);
		$this->assertEqual($user_g->get_id(),$user->get_id());
		
	}
	
	function test_get_username(){
		//just to check and get
		$user=new User();
		$rand=md5(rand());
		$user->username='user_'.$rand;
		$user->fullname='This is the name';
		$user->email="$rand@email.com";
		$user->save();
		
		
		$user_g=User::by_username($user->username);
		$this->assertNotNull($user_g);
		$this->assertEqual($user_g->username,$user->username);
		$this->assertEqual($user_g->email,$user->email);
		$this->assertEqual($user_g->fullname,$user->fullname);
		$this->assertEqual($user_g->get_id(),$user->get_id());
		
	}
	
	function test_get_by_email(){
		//just to check and get
		$user=new User();
		$rand=md5(rand());
		$user->username='user_'.$rand;
		$user->fullname='This is the name';
		$user->email="$rand@email.com";
		$user->save();
		
		
		$user_g=User::by_email($user->email);
		$this->assertNotNull($user_g);
		$this->assertEqual($user_g->username,$user->username);
		$this->assertEqual($user_g->email,$user->email);
		$this->assertEqual($user_g->fullname,$user->fullname);
		$this->assertEqual($user_g->get_id(),$user->get_id());
		
	}
	
	function test_password(){
		$user=new User();
		$rand=md5(rand());
		$user->username='user_'.$rand;
		$user->fullname='This is the name';
		$user->email="$rand@email.com";
		$user->save();
		
		$user->set_password('abc.com');
		$this->assertTrue($user->check_password('abc.com'));
		$this->assertFalse($user->check_password('abc.codffdm'));
		
		//to check with the DB
		$user_g=User::by_email($user->email);
		$this->assertTrue($user_g->check_password('abc.com'));
		$this->assertFalse($user_g->check_password('abc.codffdm'));
	}
}