<?php
	require("../config/dbconfig.php");
	$connection = new mysqli($host, $username, $password, $dbname); // what is this for ?
	if(!empty($_POST)){

	$email = $_POST["email"];
	$password = $_POST["password"];
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	
	}
	$query = "SELECT 1 FROM Users WHERE email = :email";
	$query_params = array(':email' => $email);
	try{
		$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}catch (PDOException $ex){
		$response["success"] = 0;
		$response["message"] = "Database error. Please try again"; // this lines might need to be changed
		die(json_encode($response));
	}

	$row = $stmt->fetch();
	if($row){
		$response["success"] = 0;
		header("Location: ../general/alert.php?alert=This email was already used&direct=../login/login.html");
		// die ?
	}else{
		$query = "INSERT INTO Users (firstname,lastname,email,password) VALUES ( :first, :last, :email, :pass)";
		$query_params = array(
			':first' => $firstName,
			':last' => $lastName,
			':email' => $email,
			':password' => md5($password)
			);
	}

	try{
		$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}catch (PDOException $ex){
      $response["success"] = 0; // it failed :(
      $response["message"] = "Database error. Please try again";
      die(json_encode($response));
    }
    $response["success"] = 1; // if we are here then registration successful
    header("Location: ../general/alert.php?alert=Registration successful!&direct=../login/register.html");
?>
