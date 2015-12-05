<?php
/*   
//Run when user presses submit button.
*/
//Start session
session_start();
//Look for sign out $_GET and quit session.
if ($_GET["logout"]==1 AND $_SESSION['id']){
    session_destroy();
    $message = "You have been logged out.";
}

    
//import conection    
include("connection.php");

//Validate and save data

    if($_POST['submit'] == "signup"){
        //Validate username
        if(!$_POST['username']) $error.="<br />Please enter your user name.";
        //Validate firstname
        if(!$_POST['firstname']) $error.="<br />Please enter your first name.";
        //Validate lastname
        if(!$_POST['lastname']) $error.="<br />Please enter your last name.";
        //Validate email.
        if(!$_POST['email']) $error.="<br />Please enter your email";
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error.="<br />Please enter a valid email address.";
        //Validate password.
        if(!$_POST['password']) $error.="<br />Please enter your password";
                else{
                
                if (strlen($_POST['password']) < 8) $error.="<br />Please enter a password with at least eight characters.";
                if (!preg_match('`[A-Z]`',$_POST['password'])) $error.="<br />Please include at least one upper case character in your password";
                
                }
    /*
    If there are no errors in the signup details check if email already exists, if not, add user to the database.
    */       
            if ($error) $error = "<br />There were error(s) in your sign up details:".$error;
             else {
            
             if (mysqli_connect_error()){
                die("Could not connect to database.");
             }
            //Check if email already exists on database
            //Protect against code injection with .mysqli_real_escape_string()
            $query = "SELECT * FROM `Users` WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."'";
           
           $result = mysqli_query($link, $query);
           
           $results = mysqli_num_rows($result);
            
            //Check if username already exists on database
            //Protect against code injection with .mysqli_real_escape_string()
            $query = "SELECT * FROM `Users` WHERE username='".mysqli_real_escape_string($link, $_POST['username'])."'";
           
           $result2 = mysqli_query($link, $query);
           
           $results2 = mysqli_num_rows($result);  
           
            if($results){$error = "That email addresss is already in use. Do you want to log in?";}else if($results2){$error = "That user name is already in use. Please choose a different user name.";}else{
/*

    md5 algorithm for password here.

*/
                $query = "INSERT INTO `Users` (`email`, `password`,`username`,`firstname`,`lastname`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".md5(md5($_POST['username']).$_POST['password'])."','".mysqli_real_escape_string($link, $_POST['username'])."','".mysqli_real_escape_string($link, $_POST['firstname'])."','".mysqli_real_escape_string($link, $_POST['lastname'])."')";
              
                mysqli_query($link, $query);
                
                echo "You've been signed up!";
                
                $_SESSION['id'] = mysqli_insert_id($link);
                
                //redirect to main app
                header("Location:webapp.php");
                
            }
            
        }  
        
    }

    if ($_POST['submit'] == "login"){
        
         $query = "SELECT * FROM `Users` WHERE username='".mysqli_real_escape_string($link, $_POST['loginusername'])."' AND password='".md5(md5($_POST['loginusername']).$_POST['loginpassword'])."' LIMIT 1";
           
         $result = mysqli_query($link, $query);
           
         $row = mysqli_fetch_array($result);
        
         if ($row){
             
             $_SESSION['id']=$row['id'];
             
             //Redirect to logged in page
             header("Location:webapp.php");
             
         }else{
             
             $error = "Not found. Please try again.";
             
         }
        
        
    }

?>