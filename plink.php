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
  $utr=$_GET['utr'];
  
$addwin00="UPDATE dbo.recharge SET status='USDT Deposited' WHERE username='$username' AND recharge='$amount' AND utr='$utr'";
$conn->query($addwin00);
if($conn->query($addwin00)){

        header("location: rechargeRequests.php");
    
}else{
    echo"USDT Deposited";
}
?>