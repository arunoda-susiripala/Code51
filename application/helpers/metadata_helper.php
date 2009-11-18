<?php

class Metadata{
	
	public static function set($key,$value,$namespace='global'){
		$CI= get_instance();
		$db=$CI->db;
		$sql="insert into metadata values('"
			.$key."','"
			.$value."','"
			.$namespace."') "
			." ON DUPLICATE KEY UPDATE `value`='$value'";
		return $db->query($sql);
		
	}
	
	public static function get($key,$namespace='global'){
		$CI= get_instance();
		$db=$CI->db;
		$sql="SELECT * FROM metadata WHERE `key` LIKE '$key' AND `namespace` ".
			"LIKE '$namespace'";
		$query= $db->query($sql);
		
		if($query->result()==null) return null;
		$rtn=array();
		foreach($query->result() as $val){
			$rtn[$val->namespace][$val->key]=$val->value;
		}
		return $rtn;
	}
	
	public static function delete($key,$namespace='global'){
		$CI= get_instance();
		$db=$CI->db;
		$sql="DELETE FROM metadata WHERE `key` LIKE '$key' AND `namespace` ".
			"LIKE '$namespace'";
		return $db->query($sql);
	}
	
}