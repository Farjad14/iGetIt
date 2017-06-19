<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
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
		<title>iGetIt</title>
	</head>
	<body>
		<h1>Registration</h1>
		<form method ="post">
			<table>
				<!-- Trick below to re-fill the user form field -->
				<tr><th style="text-align:right;">User:</th><td><input type="user" name="user" value="<?php echo($_REQUEST['user']); ?>" /></td></tr>
				<tr><th style="text-align:right;">Password:</th><td> <input type="password" name="password" value="<?php echo($_REQUEST['password']); ?>"/></td></tr>
				<tr><th style="text-align:right;">First Name:</th><td> <input type="firstname" name="firstname" value="<?php echo($_REQUEST['firstname']); ?>"/></td></tr>
				<tr><th style="text-align:right;">Last Name:</th><td> <input type="lastname" name="lastname" value="<?php echo($_REQUEST['lastname']); ?>"/></td></tr>
				<tr><th style="text-align:right;">Email:</th><td> <input type="email" name="email" value="<?php echo($_REQUEST['email']); ?>"/></td></tr>
				<tr><label for="type"></label>
						<input type="radio" name="type" value="instructor">instructor</input> 
						<input type="radio" name="type" value="student">student</input> 
					</tr>
				<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="Sign Up" /></td></tr>
				<tr><th>&nbsp;</th><td><a href="?gback=goback">Go Back</a></td></tr>
				<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
			</table>
		</form>
	</body>
</html>

