<?php

class User_helper extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertTrue(class_exists('User'));
	}
	
	/**
	 * Functionalities we expect from the POC
	 * --------------------------------------
	 * 1.fields (id,username,email,fullname,salt,password)
	 * 2.save()
	 * 3.get_id()
	 * 4.set_password()
	 * 5.set_session()
	 * 5.check_password()
	 * 6.::by_id()
	 * 7.::by_username()
	 * 8.::by_email()
	 * 9.::by_session()
	 */
}