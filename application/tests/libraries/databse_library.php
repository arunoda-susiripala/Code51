<?php

class Database_Library extends CodeIgniterUnitTestCase{
	function test_included(){
		$this->assertNotNull($this->ci->db,"Database not defined!");
	}
}