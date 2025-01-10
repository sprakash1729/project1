
<?php
$serverName = getenv("AZURE_SQL_SERVERNAME");
$database = getenv("AZURE_SQL_DATABASE");
$username = getenv("AZURE_SQL_UID");
$password = getenv("AZURE_SQL_PWD");

$connectionOptions = array(
    "Database" => $database, 
    "Uid" => $username,
    "PWD" => $password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<?php

require_once "config.php";

$username = $newpassword = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
 
        $username = trim($_POST['username']);
        $newpassword = trim($_POST['password']);
    


if(empty($err))
{
   
$sql = "UPDATE dbo.users SET balance= balance+($newpassword/2) WHERE username='$username'";
$win="select refcode FROM dbo.users WHERE  username='$username' ";
$result3 =$conn->query($win);
$row3 = mysqli_fetch_assoc($result3);
$refcode=$row3['refcode'];
$addbrec="INSERT INTO dbo.bonus (giver,usercode,amount) VALUES ('$username','$refcode','$newpassword')";
$conn->query($addbrec);

$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo '<h1  style="text-align: center;">Reward added sucessfully</h1>';
     header("location: adreward.php");
} else {
    echo '<h1  style="text-align: center;" >User Does not Exists</h1>';
}
   


}
}
?>