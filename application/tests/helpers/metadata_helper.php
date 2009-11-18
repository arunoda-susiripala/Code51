<?php

class Metadata_helper extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertTrue(class_exists('Metadata'));
	}
	
	function test_set(){
		$this->assertTrue(Metadata::set('key','value','namespace'));
	}
	
	function test_get(){
		$users=Metadata::get('email','user._');
		$usernames=array();
		foreach ($users as $user){
			$usernames[]=$user['email'];
		}
	}
	
	function test_delete(){
		$this->assertTrue(Metadata::delete('email','user.1'));
	}
	
	function test_all1(){
		Metadata::set('username','arunoda','user.1');
		$res=Metadata::get('username','user.1');
		$this->assertEqual('arunoda',$res['user.1']['username']);
		
		Metadata::delete('user%','user.%');
		$res=Metadata::get('username','user.1');
		$this->assertNull($res,"found $res");
	}
}