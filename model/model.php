<?php

// class Database{
//	public function courses($user, $fname, $lname, $courses, $code){
//	}
// }
//psql -h mcsdb.utm.utoronto.ca -d abbass13_309 -U abbass13 90444

//psql -h mcsdb.utm.utoronto.ca -d alammoh5_309 -U alammoh5
//95688
class db {
    public function __construct() {
        $GLOBALS['dbconn'] = pg_connect("host= mcsdb.utm.utoronto.ca dbname= abbass13_309 user='$UTORID' password='$DBPASSWORD'") or die('Could not connect: ' . pg_last_error());
		$query2 = "SELECT type FROM appuser where username=$1;";
		$result = pg_prepare($GLOBALS['dbconn'], "getType", $query2);
		$query="INSERT INTO appuser(username, password, email, firstname, lastname, type, firsttime) VALUES ($1,$2, $3, $4, $5, $6, $7);";
		$result = pg_prepare($GLOBALS['dbconn'], "my_query", $query);
		$query  = "SELECT * FROM appuser where username =$1 and firsttime ='true';";
		$result = pg_prepare($GLOBALS['dbconn'], "firstTime", $query);
		$query  = "SELECT * FROM appuser where username =$1 and password =$2;";
		$result = pg_prepare($GLOBALS['dbconn'], "validateUser", $query);
		$query  = "SELECT * FROM appuser where username =$1;";
		$result = pg_prepare($GLOBALS['dbconn'], "checkUser", $query);
		$query  = "UPDATE appuser SET password = $1, firstname = $2, lastname = $3, email = $4 WHERE id = $5";
        $result = pg_prepare($GLOBALS['dbconn'], "updateUser", $query);
    }
    
    public function registerUser($user, $pwd, $fname, $lname, $email, $type) {
        $user  = strtolower($user);
        $check = $this->checkUser($user);
        if (!empty($check)) {
            $_SESSION['UserExists'] = "user exists";
        } else {
			$result = pg_execute($GLOBALS['dbconn'], "my_query", array($user, $pwd, $email, $fname, $lname, $type, 'true'));
			if($result){
		$rows_affected=pg_affected_rows($result);
       		//echo("rows_affected=$rows_affected");
	} else {
		echo("Could not execute query");
	}
        }
    }
    
    public function firstTime($user) {
        $user   = strtolower($user);
		$result = pg_execute($GLOBALS['dbconn'], "firstTime", array($user));
        $result = pg_fetch_array($result);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function setVisited($user) {
        $query = "UPDATE appuser SET firsttime = 'false' WHERE username = '$user';";
        pg_query($query);
    }
    
    public function updateProfile($arr) {
        $query = "SELECT id FROM appuser WHERE username = $1";
        
        $result = pg_prepare($GLOBALS['dbconn'], "getUser", $query);
        $result = pg_execute($GLOBALS['dbconn'], "getUser", array(
            $_SESSION['user']->user
        ));
        $id     = pg_fetch_result($result, 0, 0);
        array_push($arr, $id);
        $result = pg_execute($GLOBALS['dbconn'], "updateUser", $arr);
    }
    
    public function getType($user) {
        $result = pg_execute($GLOBALS['dbconn'], "getType", array($user));
        $result = pg_fetch_result($result, 0, 0);
        return $result;
    }
    
    public function validateUser($user, $pwd) {
        $user   = strtolower($user);
		$result = pg_execute($GLOBALS['dbconn'], "validateUser", array($user, $pwd));
        $result = pg_fetch_array($result);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkUser($user) {
        $user   = strtolower($user);
		$result = pg_execute($GLOBALS['dbconn'], "checkUser", array($user));
        $result = pg_fetch_array($result);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
}

class user {
    
    public function __construct($user) {
        $this->user  = $user;
        $query       = "SELECT * FROM appuser WHERE username = '$user';";
		$result=pg_query($GLOBALS['dbconn'], $query);
		$row = pg_fetch_array($result);
		$this->id  = $row[0];
		$this->pass  = $row[2];
		$this->email = $row[3];
		$this->fname = $row[4];
		$this->lname = $row[5];
        $this->name  = $this->fname . " " . $this->lname;
    }
    
    public function updateUser($arr) {
        $this->pass  = $arr['password'];
        $this->fname = $arr['firstname'];
        $this->lname = $arr['lastname'];
        $this->email = $arr['email'];
    }
    
    public function createClass($class, $code) {
        $name  = $this->name;
        $query = "INSERT INTO courses(name, instructor, code) VALUES('$class', '$name', '$code');";
        pg_query($GLOBALS['dbconn'], $query);
    }
    
    public function getAllCoursesIns() {
        $name                = $this->name;
        $query               = "SELECT * FROM courses WHERE instructor = '$name';";
        $_SESSION['courses'] = pg_fetch_all_columns(pg_query($GLOBALS['dbconn'], $query), 1);
    }
	
	function getAllCoursesStdnt() {
        $query = "SELECT * FROM courses;";
        $arr1  = pg_fetch_all_columns(pg_query($GLOBALS['dbconn'], $query), 1);
        $arr2  = pg_fetch_all_columns(pg_query($GLOBALS['dbconn'], $query), 2);
        for ($i = 0; $i < sizeof($arr1); $i++) {
            $_SESSION['courses'][$i] = $arr1[$i] . " " . $arr2[$i];
        }
    }
    
    public function setReq() {
        $_REQUEST['user']      = $this->user;
        $_REQUEST['password']  = $this->pass;
        $_REQUEST['firstname'] = $this->fname;
        $_REQUEST['lastname']  = $this->lname;
        $_REQUEST['email']     = $this->email;
    }
	
	public function getCid($name){
		$query       = "SELECT * FROM courses WHERE name = '$name';";
		$temp  = pg_fetch_all_columns(pg_query($GLOBALS['dbconn'], $query), 0);
        return $temp[0];
	}
    
    public function validateCodeIns($code) {
        $arr        = explode(' ', trim($_SESSION['user']->currCourse));
        $name       = $arr[0];
        $instructor = $this->name;
        $query      = "SELECT * FROM courses where name ='$name' and instructor ='$instructor' and code = '$code';";
        $result     = pg_fetch_array(pg_query($query));
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
	
	public function updateVote($result){
		$arr        = explode(' ', trim($_SESSION['user']->currCourse));
        $name       = $arr[0];
		$uid = $this->id;
		$cid = $this->getCid($name);
		$query = "UPDATE igetit SET getit = '$result' WHERE cid = '$cid' and uid = '$uid';";
		pg_query($query);
	}
	
    public function vote($result){
		$arr        = explode(' ', trim($_SESSION['user']->currCourse));
        $name       = $arr[0];
		$uid = $this->id;
		$cid = $this->getCid($name);
		$query = "INSERT INTO igetit(cid, uid, getit) VALUES('$cid', '$uid', '$result');";
		pg_query($query);
	}
	
	public function getResults(){
		$cid = $this->getCid($this->currCourse);
		$getit = "N";
		$query = "SELECT COUNT(*) FROM igetit where cid ='$cid' and getit = '$getit';";
		$res[0] = pg_fetch_result(pg_query($GLOBALS['dbconn'], $query), 0, 0);
		$getit = "Y";
		$query = "SELECT COUNT(*) FROM igetit where cid ='$cid' and getit = '$getit';";
		$res[1] = pg_fetch_result(pg_query($GLOBALS['dbconn'], $query), 0, 0);
		return $res;
	}
	
	public function setGetItVals($res){
				//$_SESSION['igetit'] = $res[1];
				//$_SESSION['idontgetit'] = $res[0];
				$total = $res[0] + $res[1];
				$_SESSION['igetit%'] = round(($res[1] / $total) * 100);
				$_SESSION['idontgetit%'] = round(($res[0] / $total) * 100);
	}
    
    public function validateCodeStdnt($code) {
        $arr        = explode(' ', trim($_SESSION['user']->currCourse));
        $name       = $arr[0];
        $instructor = $arr[1] . " " . $arr[2];
        $query      = "SELECT * FROM courses where name ='$name' and instructor ='$instructor' and code = '$code';";
        $result     = pg_fetch_array(pg_query($query));
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
}

?>
