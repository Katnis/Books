<?php
	include("../config/dbconfig.php");
	$connection = new mysqli($host, $username, $password, $dbname);
	$email = $_POST["email"];
	$password = $_POST["password"];

	$sql = "SELECT * FROM `users` WHERE LOWER(email) = LOWER(\"$email\")";
	$records = $connection->query($sql);
	if ($records->num_rows > 0) {
		$record = $records->fetch_assoc();
		if (md5($_POST["password"]) == $record["password"]) {
			header("Location: ../general/alert.php?alert=WEEEEE&direct=../login/login.html");
		} else {
			header("Location: ../general/alert.php?alert=Username or Password is incorrect.&direct=../login/login.html");
		}
	} else {
		header("Location: ../general/alert.php?alert=Username or Password is incorrect.&direct=../login/login.html");
	}
?>
