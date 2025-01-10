<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true){
    header("location: adlogin.php");
    exit;
}
require_once "config.php";
  $username=$_GET['un'];
  $amount=$_GET['am'];
  $id=$_GET['id'];
  
$addwin00="UPDATE dbo.record SET status='Failed' WHERE username='$username' AND withdraw='$amount' AND id='$id'";
$conn->query($addwin00);
if($conn->query($addwin00)){
      
       $return=$amount+30; 
   
     $addwin0="UPDATE dbo.users SET balance=balance+($return) WHERE username='$username'";
    
    if($conn->query($addwin0)){
        header("location: adwith.php");
    }

        
    
}else{
    echo"FAILED";
}
?>