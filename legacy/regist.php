<?php
  // connect to db
  require("config.php");
  // if post data is not empty
  if(!empty($_POST)){
    //if username or password is empty
    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['firstname'])|| empty($_POST['lastname'])) {
      $response["success"] = 0; //create json response
      $response["message"] = "All Fields are required";
      die(json_encode($response)); // kill page and stop further execution
    }
    $query = "SELECT 1 FROM Users WHERE username = :user"; // check to see if user already exist.. using :user for security purposes

    $query_params = array(
      ':user' => $_POST['username']
    );

    // now query will run
    try{
      // run query against db
      $stmt = $db->prepare($query);
      $result = $stmt->execute($query_params);
    }catch (PDOException $ex){
      $response["success"] = 0; // it failed :(
      $response["message"] = "Database error. Please try again";
      die(json_encode($response));
    }

    $row = $stmt->fetch(); // get array of returned data
    if($row){
      $response["success"] = 0; // if a user with this username already exist, oh noes
      $response["message"] = "Username is already taken";
      die(json_encode($response)); // kill this
    }

    $query = "INSERT INTO Users (username, password, firstname, lastname) VALUES ( :user, :pass, :first, :last)";
    $query_params = array(
      ':user' => $_POST['username'],
      ':pass' => $_POST['password'],
      ':first' => $_POST['firstname'],
      ':last' => $_POST['lastname']
    );

    // run query
    try{
      // run query against db
      $stmt = $db->prepare($query);
      $result = $stmt->execute($query_params);
    }catch (PDOException $ex){
      $response["success"] = 0; // it failed :(
      $response["message"] = "Database error. Please try again";
      die(json_encode($response));
    }
     $response["success"] = 1; // we made it
     $response["messsage"] = "Username Successfully Added!";
     echo json_encode($response);
  } else{
    ?>
    <h1>Register</h1>
    <form action="regist.php" method="post">
      firstname:<br />
      <input type="text" name="firstname" value="" />
      <br /><br />
      lastname:<br />
      <input type="text" name="lastname" value="" />
      <br /><br />
        Username:<br />
        <input type="text" name="username" value="" />
        <br /><br />
        Password:<br />
        <input type="password" name="password" value="" />
        <br /><br />
        <input type="submit" value="Register New User" />
    </form>
    <?php
}
 ?>
