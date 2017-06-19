<?php

class db {

	public function __construct() {
		$this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=abbass13_309 user=abbass13 password=90444") or die('Could not connect: ' . pg_last_error());
    	}
	
	public function getAllCourses(){
		$query = "SELECT DISTINCT code FROM courses;";
		$result = pg_fetch_all(pg_query($this->dbconn, $query));
		return $result;
	}
	public function getInstructor($code){
		$query = "SELECT instructor FROM courses WHERE code = '" . $code . "';";
		$result = pg_fetch_all(pg_query($this->dbconn, $query));
		return $result;
	}
	public function registerUser($user, $pwd, $fname, $lname, $email, $type){
		
		pg_query($dbconn, "INSERT INTO appuser(username, password, email, firstname, lastname, type) VALUES('" . $user . "', '" . $pwd . "', '" . $email . "', '" . $fname . "', '" . $lname . "', '" . $type . "');");
	}
	public function exists($column, $val, $table){
		
	}
}
?>
