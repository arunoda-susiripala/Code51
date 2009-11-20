<?php

class Metadata_helper extends CodeIgniterUnitTestCase{
	function setUp(){
		Metadata::set('email','a@abc.com','**user.4');
		Metadata::set('email','a@abc.com','**man.2');
		Metadata::set('username','arunoda','**user.1');
	}
	
	function test_included(){
		$this->assertTrue(class_exists('Metadata'));
	}
	
	function test_set(){
		$this->assertTrue(Metadata::set('key','value','namespace'));
	}
	
	function test_get(){
		$users=Metadata::get('email','**user._');
		$usernames=array();
		foreach ($users as $user){
			$usernames[]=$user['email'];
		}
	}
	
	function test_delete(){
		$this->assertTrue(Metadata::delete('email','**user.1'));
	}
	
	function test_all1(){
		$res=Metadata::get('username','**user.1');
		$this->assertEqual('arunoda',$res['**user.1']['username']);
		
		Metadata::delete('user%','**user.%');
		$res=Metadata::get('username','**user.1');
		$this->assertNull($res,"found $res");
	}
	
	function test_get_metadata(){
		
		$res=Metadata::get_namespace('email','a@abc.com');
		$this->assertTrue(count($res)>0);
		
		$res=Metadata::get_namespace("email",'a@abc.com',"**user%");
		$this->assertEqual($res[0],"**user.4");
		
		$res=Metadata::get_namespace("email",'a@abc.com',"**man._");
		$this->assertEqual($res[0],"**man.2");
	}
	
	function test_get_null(){
		$res=Metadata::get("ppp",'gfd.gt');
		$this->assertNull($res);
	}
	
	
}