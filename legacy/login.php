<!DOCTYPE html>
<html>
<head>
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="sweetalert-master/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="find-book.js"></script>
  <link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
</head>
<script type="text/javascript">
var login = function logonUser(){
    var user = $(this).children('form').children('input[type="text"]').val();
    var pass = $(this).children('form').children('input[type="password"]').val();
    if(user.length < 1 || pass.length < 1){
        alert('Invalid!\nPlease fill all required forms');
    } else {
        alert('username: '+user+'\npassword: '+pass);
        $.fallr('hide');
    }
}
//var login = 'logonUser';

$.fallr('show', {
    icon        : 'secure',
    width       : '320px',
    content     : '<h4>Sign in</h4>'
                + '<form>'
                +     '<input placeholder="username" type="text"/'+'>'
                +     '<input placeholder="password" type="password"/'+'>'
                + '</form>',
    buttons : {
        button1 : {text: 'Submit', onclick: login},
        button4 : {text: 'Cancel'}
    },
});

function nav(){
  swal({
    title: 'Buy or Sell',
    text: 'Please select an option to proceed',
    confirmButtonText: 'Sell',
    confirmButtonText: 'Buy'
  },
function(){
  swal(
    'Going',
    'success'
  );
});
}

function errorMsg(){
  sweetAlert("Oops...", "Something went wrong!", "error");
}

function sell(){
  swal({
    title: "ISBN",
    text: "ISBN used for searching...",
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputPlaceholder: "Please enter ISBN"
  },
function(inputValue){
  if(inputValue === false) return false;
  if(inputValue === ""){
    swal.showInputError("You need to enter an ISBN to sell");
    return false;
  }else{
    window.location.href = 'find-book.php?isbn='+inputValue;
  }
  swal("Nice!", "Click Ok to import book details with "+ inputValue, "success");
});
}
</script>
<body>
  <?php
    require("config.php");
    if(!empty($_POST)){
      $query= "
      SELECT
      id, username, password FROM Users WHERE username = :username
      ";

      $query_params = array(
        ':username' => $_POST['username']
      );

      try{
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
      }catch (PDOException $ex){
        $response["success"] = 0;
        $response["message"] =  "Database error, please try again";
        die(json_encode($response));
      }
      $login_ok = false;
      $validate_info = false;
      $row = $stmt->fetch();
      if($row){
        if($_POST['password'] === $row['password']){
          $login_ok = true;
        }
      }

      if($login_ok){
        ?>
        <script>sell();</script>
        <label>Type an ISBN</label><br/>
        <input type="text" id="isbn" /><br/>
        <button id="getBook">Get Info</button>
        <div id="bookInfo">

        </div>


<?php
      }else{
        echo "<script> errorMsg(); </script>";
        $response["success"] = 0;
        $response["message"] = "Invalid Credentials";
        die(json_encode($response));
      }
    }else{
      ?>
    <h1>Login</h1>
        <form action="login.php" method="post" id="logon">
            Username:<br />
            <input type="text" name="username" placeholder="username" />
            <br /><br />
            Password:<br />
            <input type="password" name="password" placeholder="password" value="" />
            <br /><br />
            <input type="submit" value="Login" />
        </form>
        <a href="regist.php">Register</a>
    <?php
  }
 ?>
 </body>
 </html>
