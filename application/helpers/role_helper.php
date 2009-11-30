<?php

class Role{
	public $name;
	public $parent;

	
	public function save(){
		Metadata::set('name',$this->name,"role.$this->name");
		Metadata::set('parent',$this->parent,"role.$this->name");
	}
	
	public function delete(){
		Metadata::delete("%","role%");
		Metadata::delete("%","has.$this->name");
	}
	
	public static function by_name($name){
		$res=Metadata::get('%',"role.$name");
		if(!$res) return null;
		$role=new Role();
		$role->name=$res["role.$name"]['name'];
		$role->parent=$res["role.$name"]['parent'];
		
		return $role;
	}
	
	public function add_user($user){
		Metadata::set("$user",$this->name,"has.$this->name");
	}
	
	public function detete_user($user){
		Metadata::delete("$user","has.$this->name");
	}
	
	public function get_users(){
		$res=Metadata::get('%',"has.{$this->name}");
		if(!$res) return null;
		$users=array();
		foreach ($res["has.{$this->name}"] as $user => $role){
			$users[]=$user;
		}
		
		return $users;
	}
	
	public static function get_roles_for($user){
		$res=Metadata::get("$user","has.%");
		if(!$res) return null;
		$roles=array();
		foreach ($res as $val){
			$roles[]=$val["$user"];
		}
		
		return $roles;
	}	
}