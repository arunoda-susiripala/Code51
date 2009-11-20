<?php

class User{
	private  $id;
	var $username;
	var $email;
	var $fullname;
	private $password;
	private $salt;
	
	function __construct($id="",$username="",$email="",$fullname="",$password="",$salt=""){
		$this->id=$id;
		$this->username=$username;
		$this->email=$email;
		$this->fullname=$fullname;
		$this->password=$password;
		$this->salt=$salt;
	}
	
	public function save(){
		$count=$this->id;
		if(!$count){
			$count=Metadata::get('user_count');
			$count=($count)?$count['global']['user_count']:0;
			$count++;
			$this->id=$count;
			Metadata::set('user_count',$count);
		}
		
		Metadata::set('username',$this->username,"user.$count");
		Metadata::set('id',$this->id,"user.$count");
		Metadata::set('email',$this->email,"user.$count");
		Metadata::set('fullname',$this->fullname,"user.$count");
		Metadata::set('password',$this->password,"user.$count");
		Metadata::set('salt',$this->salt,"user.$count");
		
	}
	
	public function get_id(){
		return $this->id;
	}
	
	public function set_password($password){
		$this->salt=substr(md5(rand()),0,25);
		$this->password=md5($password.$this->salt);
		Metadata::set('password',$this->password,"user.{$this->id}");
		Metadata::set('salt',$this->salt,"user.{$this->id}");
	}
	
	public function check_password($password){
		return $this->password==md5($password.$this->salt);
	}
	
	
	public static function by_id($id){
		$res=Metadata::get('%',"user.$id");
		if(!$res) return null;
		
		return new User(
			$res["user.$id"]['id'],
			$res["user.$id"]['username'],
			$res["user.$id"]['email'],
			$res["user.$id"]['fullname'],
			$res["user.$id"]['password'],
			$res["user.$id"]['salt']
		);
		
	}
	
	public static function by_username($username){
		$res=Metadata::get_namespace('username',$username,'user.%');
		if(!$res) return null;
		$namespace=$res[0];
		$res=Metadata::get('%',$namespace);
		if(!$res) return null;
		
		return new User(
			$res[$namespace]['id'],
			$res[$namespace]['username'],
			$res[$namespace]['email'],
			$res[$namespace]['fullname'],
			$res[$namespace]['password'],
			$res[$namespace]['salt']
		);
	}
	
	public static function by_email($email){
		$res=Metadata::get_namespace('email',$email,'user.%');
		if(!$res) return null;
		$namespace=$res[0];
		$res=Metadata::get('%',$namespace);
		if(!$res) return null;
		
		return new User(
			$res[$namespace]['id'],
			$res[$namespace]['username'],
			$res[$namespace]['email'],
			$res[$namespace]['fullname'],
			$res[$namespace]['password'],
			$res[$namespace]['salt']
		);
	}
	
	public static function by_session($session){
		throw new Exception("Not Implemented Yet!");
	}
}