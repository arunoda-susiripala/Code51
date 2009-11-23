<?php

class ACL {
	public function __construct(){
		
	}
	
	/**
	 * @todo This is to be implemented just to overcome performance issues..
	 */
	public function set_context(){
		
	}
	
	public function grant($role,$subject,$action){
		$code=md5($role.$subject.$action);
		$res=Metadata::get('%',"perm.$code");
		return ($res)?true:false; 
	}
	
	public static function add($role,$subject,$action){
		$code=md5($role.$subject.$action);
		Metadata::set('user',$role,"perm.$code");
		Metadata::set('subject',$subject,"perm.$code");
		Metadata::set('action',$action,"perm.$code");
	}
	
	public static function remove($role,$subject,$action){
		$code=md5($role.$subject.$action);
		Metadata::delete('%',"perm.$code");
	}
	
}