<?php
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

require_once "config.php";
$sql = "SELECT  bonus FROM dbo.users WHERE username='".$_SESSION['username']."'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$bonus=$row[bonus];
$addb1="UPDATE dbo.users SET balance= balance +$bonus WHERE  username='".$_SESSION['username']."'";

If($conn->query($addb1)=="true"){
     $addb2="UPDATE dbo.users SET bonus=0 WHERE username='".$_SESSION['username']."'";
            $conn->query($addb2);
            header("location: promotion#");
            
}



?>