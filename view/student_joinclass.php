<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
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
			<form method="post">
				<fieldset>
					<legend>Current Classes</legend>
					<select name = 'curr'>
						<?php 
						foreach ($_SESSION['courses'] as &$value) {
    							echo "<option> $value " . $_SESSION['instructor']->name . "</option>";
						}?>
					</select>
   					<p> <label for="code">code</label><input type="text" name="code"></input> </p>
                                        <p> <input type="submit" name="open"/>
					<?php echo(view_errors($errors)); ?>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

