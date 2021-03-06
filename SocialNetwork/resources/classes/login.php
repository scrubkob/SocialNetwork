<?php

require_once(realpath(dirname(__FILE__) ."/../config.php"));
require_once(CLASSES_PATH ."/sql.php");
require_once(CLASSES_PATH ."/user.php");

class login
{

	public static function loginUser($username, $password)
	{
		$sql = "SELECT * FROM user
			WHERE username = :username";
		$params = array(":username" => $username);
		$result = sql::exe($sql, $params);
		if(password_verify($password, $result[0]['passwort'])) {
			$user = new user($username);
			$user->changeSid();
			return true;
		} else {
			return false;
		}
	}

	public static function isLoggedIn($sid)
	{
		$sql = "SELECT * FROM user
			WHERE sid = :sid";
		$params = array(":sid" => $sid);
		$result = sql::exe($sql, $params);
		if(sizeof($result) > 0) {
			return true;
		} else {
			return false;
		}
	}

}

?>