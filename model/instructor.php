<?php

class instructor {

	public function __construct($fname, $lname) {
		$this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=abbass13_309 user=abbass13 password=90444") or die('Could not connect: ' . pg_last_error());
		$this->name = $fname . " " . $lname;
    	}
	
	public function createClass($class, $code){
		$query = "INSERT INTO courses(code, instructor, name) VALUES('" . $code . "', '" . $this->name . "', '" . $class . "');");
		pg_query($this->dbconn, $query);
		return $result;
	}
}
?>
