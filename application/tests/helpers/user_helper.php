<?php

class User_helper extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertTrue(class_exists('User'));
	}
}