<?php
	include("../config/dbconfig.php");
	$connection = new mysqli($host, $username, $password, $dbname);
	$email = $_POST["email"];
	$password = $_POST["password"];
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];

	$sql = "SELECT * FROM `users` WHERE LOWER(email) = LOWER(\"$email\")";
	$records = $connection->query($sql);
	if ($records->num_rows > 0) {
		header("Location: ../general/alert.php?alert=This email was already used&direct=../login/login.html");
	} else {
		$sql = "INSERT INTO `Users` (email, firstname, lastname, password)"
				." VALUES (\"$email\", \"$firstName\", \"$lastName\", \""
				.md5($password)."\")";
		$connection->query($sql);
		header("Location: ../general/alert.php?alert=Registration successful!&direct=../login/register.html");		
	}
?>
