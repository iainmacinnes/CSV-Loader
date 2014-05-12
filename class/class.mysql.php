<?php
$SID = session_id();
if(empty($SID)) session_start();
(!isset($_SESSION['staging'])?$_SESSION['staging']=0:'');
$_SESSION['database']=($_SESSION['staging']==1?$dev:$prod);

class mysql_connection{
	var $id;

	function connect($db){
		switch ($db) {
			case "database":
				$connection = mysql_connect($_SESSION['database'], $usr, $pwd);
				mysql_select_db('database', $connection);
				break;
			break;
		}
		return $connection;
	}
	
	function query($sql,$db){
		$connection = $this->connect($db);
		$resource = mysql_query($sql);
		$this->id = mysql_insert_id();
		mysql_close($connection);
		return $resource;
	}
	
}

