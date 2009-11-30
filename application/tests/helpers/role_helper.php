<?php

class Role_helper extends CodeIgniterUnitTestCase{
	
	public function test_included(){
		$this->assertTrue(class_exists('Role'));
	}
	var $role;
	public function setUp(){
		$ro=new Role();
		$name='test_role_here';
		$ro->name=$name;
		$ro->save();
		$ro->add_user('pissa');
		$ro->add_user('pissa2');
		$this->role=$ro;
		
		$ro=new Role();
		$name='test_role_here2';
		$ro->name=$name;
		$ro->save();
		$ro->add_user('pissa');
		$ro->add_user('pissa2');
		$this->role2=$ro;
	}
	
	public function test_create(){
		$ro=new Role();
		$name='test_role'.rand();
		$ro->name=$name;
		$ro->parent='test_parent';
		$ro->save();
		
		$get=Role::by_name($name);
		$this->assertNotNull($get);
		
		$get->delete();
		$get=Role::by_name($name);
		$this->assertNull($get);	
	}
	
	public function tearDown(){
		$this->role->delete();
		$this->role2->delete();
	}
	
	public function test_add_delete_user(){
		$r=$this->role;
		$r->add_user('kamal');
		$this->assertNotNull(Role::get_roles_for('kamal'));
		
		$r->detete_user('kamal');
		$this->assertNull(Role::get_roles_for('kamal'));
		
	}
	
	public function test_get_users(){
		$users=$this->role->get_users();
		$this->assertEqual(2,count($users));
		$this->assertTrue(in_array('pissa',$users));
		$this->assertTrue(in_array('pissa2',$users));
		$this->assertFalse(in_array('pis3sa',$users));
	}
	
	public function test_get_roles_for(){
		$roles=Role::get_roles_for('pissa');
		$this->assertEqual(2,count($roles));
		$this->assertTrue(in_array('test_role_here',$roles));
		$this->assertTrue(in_array('test_role_here2',$roles));
		$this->assertFalse(in_array('pis3sa',$roles));
		
		$this->assertNull(Role::get_roles_for('dda'));
	}
}