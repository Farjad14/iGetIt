	<?php
require_once "model/model.php";

session_save_path("sess");
session_start();
ini_set('display_errors', 'On');
$_SESSION['db'] = new db();
$errors         = array();
$view           = "";
/* controller code */
if (isset($_REQUEST['logo'])) {
    session_destroy();
    session_unset();
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/");
    
}
if (isset($_REQUEST['gback'])) {
    session_destroy();
    session_unset();
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/");
    
}

if (isset($_REQUEST['prof'])) {
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/");
    $_SESSION['state'] = 'profile';
    $view              = "profile.php";
    
}
if (isset($_REQUEST['cla'])) {
	$host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/");
    if ($_SESSION['db']->getType($_SESSION['user']->user) == 'student') {
        $_SESSION['state'] = 'studentjclass';
        $view              = "student_joinclass.php";
    } else {
        $_SESSION['state'] = 'instructCreateClass';
        $view              = "instructor_createclass.php";
    }
}

if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = 'login';
}
switch ($_SESSION['state']) {
    case "register":
        
        // the view we display by default
        
        $view = "register.php";
        
        // check if submit or not
        // if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="register"){
        // break;
        // }
        // validate and set errors
	$user  = $_REQUEST['user'];
        $pwd   = $_REQUEST['password'];
        $fname = $_REQUEST['firstname'];
        $lname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
        $type  = $_REQUEST['type'];
        
        if (empty($user) || empty($pwd) || empty($fname) || empty($lname) || empty($email) || empty($type) ) {
            $errors[] = 'Missing required information';
        }else{
        
        
        $_SESSION['db']->registerUser($user, $pwd, $fname, $lname, $email, $type);
        if (isset($_SESSION['UserExists'])) {
            $errors[] = "Username already exists";
            unset($_SESSION['UserExists']);
        } else {
            $_SESSION['state']    = 'login';
            $view                 = "login.php";
            $_SESSION['firstime'] = "true";
        }
        }

        break;
    
    case "login":
        
        // the view we display by default
        
        $view = "login.php";
        if (isset($_POST["register"])) {
            $_SESSION['state'] = "register";
            $view              = "register.php";
        }
        
        // check if submit or not
        
        if (empty($_REQUEST['submit']) || $_REQUEST['submit'] != "login") {
            break;
        }
        
        // validate and set errors
        
        if (empty($_REQUEST['user'])) {
            $errors[] = 'Username is required';
        }
        
        if (empty($_REQUEST['password'])) {
            $errors[] = 'Password is required';
        }
        
        if (!empty($errors))
            break;
        
        $valid     = $_SESSION['db']->validateUser($_REQUEST['user'], $_REQUEST['password']);
        $firsttime = $_SESSION['db']->firstTime($_REQUEST['user']);
        if ($valid) {
			$_SESSION['user'] = new user($_REQUEST['user']);
            if ($_SESSION['db']->getType($_REQUEST['user']) == 'student') {
                $_SESSION['user']->setReq();
                if ($firsttime) {
                    $_SESSION['state'] = 'profile';
                    $view              = "profile.php";
                } else {
                    $_SESSION['user']->getAllCoursesStdnt();
                    $_SESSION['state'] = 'studentjclass';
                    $view              = "student_joinclass.php";
                }
            } else if ($_SESSION['db']->getType($_REQUEST['user']) == 'instructor') {
                $_SESSION['user']->setReq();
                if ($firsttime) {
                    $_REQUEST['user']  = $_SESSION['user']->user;
                    $_SESSION['state'] = 'profile';
                    $view              = "profile.php";
                } else {
                    $_SESSION['user']->getAllCoursesIns();
                    $_SESSION['state'] = 'instructCreateClass';
                    $view              = "instructor_createclass.php";
                }
            }
        } else {
            $errors[] = "invalid login";
        }
        
        break;
    
    case "profile":
        
        // the view we display by default
        $view = "profile.php";
        
	$pwd   = $_REQUEST['password'];
        $fname = $_REQUEST['firstname'];
        $lname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
	if (isset($_REQUEST['proff'])) {  
		if (empty($pwd) || empty($fname) || empty($lname) || empty($email)) {
			    $errors[] = 'Please fill out all fields!';
		}else{
			

			    $arr = array(
				'password' => $_REQUEST['password'],
				'firstname' => $_REQUEST['firstname'],
				'lastname' => $_REQUEST['lastname'],
				'email' => $_REQUEST['email']
			    );
			    $_SESSION['db']->setVisited($_SESSION['user']->user);
			    $_SESSION['db']->updateProfile($arr);
			    $_SESSION['user']->updateUser($arr);
			    
			    
			    if ($_SESSION['db']->getType($_REQUEST['user']) == 'student') {
				$_SESSION['user']->getAllCoursesStdnt();
				$_SESSION['state'] = 'studentjclass';
				$view              = "student_joinclass.php";
			    } else {
				$_SESSION['user']->getAllCoursesIns();
				$_SESSION['state'] = 'instructCreateClass';
				$view              = "instructor_createclass.php";
			    }
			}
        }
        break;
    
    case "studentjclass":
        
        // the view we display by default
        
        $view = "student_joinclass.php";
        $_SESSION['user']->getAllCoursesStdnt();
        
        // check if submit or not
        $cde   = $_REQUEST['code'];
	$cls   = $_REQUEST['class'];

        if (isset($_REQUEST['open'])) {
		if (empty($cde)) {
			    $errors[] = 'Missing Code';
		}else{
		    $_SESSION['user']->currCourse = $_POST['curr'];
		    $valid                        = $_SESSION['user']->validateCodeStdnt($_REQUEST['code']);
		    if ($valid) {
			$_SESSION['state'] = 'studentCurrentClass';
			$view              = "student_currentclass.php";
		    } else {
			$errors[] = "invalid code";
		    }
        	}
	}
        break;
    
    case "instructCreateClass":
        $view = "instructor_createclass.php";

	$cde   = $_REQUEST['code'];
	$cls   = $_REQUEST['class'];

        $_SESSION['user']->getAllCoursesIns();
        if (isset($_REQUEST['create']) && ($_REQUEST['create'] == "Submit")) {
		if (empty($cde) || empty($cls)) {
			    $errors[] = 'Missing Required Information';
		}else{
		    $_SESSION['user']->createClass($_REQUEST['class'], $_REQUEST['code']);
		    $_SESSION['user']->getAllCoursesIns();
		    $view = "instructor_createclass.php";
			break;
		}
		
	}
            
        
        
        if (isset($_REQUEST['open'])) {
	    $_SESSION['user']->currCourse = $_POST['curr'];
		    //echo $_SESSION['user']->currCourse;
		    $valid = $_SESSION['user']->validateCodeIns($_REQUEST['code']);
		    if ($valid) {
					//$res = $_SESSION['user']->getResults();
					$_SESSION['user']->setGetItVals($_SESSION['user']->getResults());
			$_SESSION['state'] = 'instructCurrentClass';
			$view              = "instructor_currentclass.php";
		    } else {
			$errors[] = "invalid code";
		    }
        }
        
        break;
    
    case "instructCurrentClass":
        
        // the view we display by default
		$_SESSION['user']->setGetItVals($_SESSION['user']->getResults());
		$view = "instructor_currentclass.php";
	break;
    
    case "studentCurrentClass":
        // the view we display by default
        $view = "student_currentclass.php";
		if (isset($_REQUEST['igetIt'])) {
			$_SESSION['user']->v = $_REQUEST['igetIt'];
			$host = $_SERVER['HTTP_HOST'];
			$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			header("Location: http://$host$uri/");
		}
		if(isset($_SESSION['user']->voted)){
			
			$_SESSION['user']->updateVote($_SESSION['user']->v);
			echo "updated!";
		}
		else{
		
		$_SESSION['user']->vote($_SESSION['user']->v);
		$_SESSION['user']->voted = "voted";
			echo "voted!";
		}
			break;
}

require_once "view/view_lib.php";

require_once "view/$view";

// require_once "view/*";

?>
