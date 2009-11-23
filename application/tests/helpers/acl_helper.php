<?php

class ACL_helper extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertTrue(class_exists('ACL'));
	}
	
	function test_join_test(){
		ACL::add('dummy','blog:posts','add');
		$acl=new ACL();
		$this->assertTrue($acl->grant('dummy','blog:posts','add'));
		$this->assertFalse($acl->grant('dummy','blog:posts','edit'));
		
		ACL::remove('dummy','blog:posts','add');
		$this->assertFalse($acl->grant('dummy','blog:posts','add'));
	}
}