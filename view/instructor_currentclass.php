<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="refresh" content="3" > 
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			span {
				background-color:green; 
				display:block; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (instructor)</h1></header>
		<nav>
  			<ul>
                        <li> <a href="?cla=class">Class</a>
                        <li> <a href="?prof=profile">Profile</a>
                        <li> <a href="?logo=logout">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form>
				<fieldset>
					<legend> <?php echo $_SESSION['user']->currCourse . " " . $_SESSION['user']->name;?> </legend>
					i Get It
					<span style="background-color:green; width:<?php echo $_SESSION['igetit%']; ?>%;" ><?php echo $_SESSION['igetit%'];?>%</span>
					i Don't Get It
					<span style="background-color:red;  width:<?php echo  $_SESSION['idontgetit%']?>%;"  ><?php echo $_SESSION['idontgetit%'];?>%</span>
				</fieldset>
			</form> 
		</main>
		<footer>
		</footer>
	</body>
</html>

