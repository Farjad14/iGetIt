<?php
	// So I don't have to deal with uninitialized $_REQUEST['guess']
	$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
    $_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
    $_REQUEST['firstname']=!empty($_REQUEST['firstname']) ? $_REQUEST['firstname'] : '';
    $_REQUEST['lastname']=!empty($_REQUEST['lastname']) ? $_REQUEST['lastname'] : '';
    $_REQUEST['email']=!empty($_REQUEST['email']) ? $_REQUEST['email'] : '';
    $_REQUEST['type']=!empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>
		<nav>
			<ul>
                        <li> <a href="?cla=class">Class</a>
                        <li> <a href="?prof=profile">Profile</a>
                        <li> <a href="?logo=logout">Logout</a>
                        </ul>

		</nav>
		<main>
			<h1>Profile</h1>
			<form method = "post">
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user" value="<?php echo($_SESSION['user']->user); ?>" readonly></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password" value="<?php echo($_SESSION['user']->pass); ?>"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstname" value="<?php echo($_SESSION['user']->fname); ?>"></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastname" value="<?php echo($_SESSION['user']->lname); ?>"></input> </p>
					<p> <label for="email">email</label><input type="email" name="email" value="<?php echo($_SESSION['user']->email); ?>"></input> </p>
					<p> <label for="type">type</label>
						<input type="radio" name="type" value="instructor" disabled>instructor</input> 
						<input type="radio" name="type" value="student" disabled>student</input> 
					</p>
					<p> <input type="submit" name="proff" value="submit"/>
					<?php echo(view_errors($errors)); ?>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

