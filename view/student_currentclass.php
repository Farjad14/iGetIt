<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			td a {
				background-color:green; 
				display:block; 
				width:200px; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (student)</h1></header>
		<nav>
			<ul>
                        <li> <a href="?cla=class">Class</a>
                        <li> <a href="?prof=profile">Profile</a>
                        <li> <a href="?logo=logout">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form method = "post">
				<fieldset>
					<legend> <?php echo $_SESSION['user']->currCourse;?> </legend>
					<table style="width:100%;">
						<tr>
							<td><a style="background-color:green;" href="?igetIt=Y">i Get It</a></td>
							<td><a style="background-color:red;  " href="?igetIt=N">i Don't Get It</a></td>
						</tr>
					</table>
				</fieldset>
				
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

