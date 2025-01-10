
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
  $sqlr = "SELECT  bon FROM dbo.dbo.notice WHERE id='1'";
$resultr = $conn->query($sqlr);
$rowr = mysqli_fetch_array($resultr);
$mini=$rowr['bon'];
  


$opt="SELECT SUM(recharge) as total FROM dbo.dbo.recharge WHERE username='$username' AND status='Completed'";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']=="" or $sum['total']=="0"){
    
$bonus=$mini;
$win="select refcode FROM dbo.dbo.users WHERE  username='$username' ";
$result3 =$conn->query($win);
$row3 = mysqli_fetch_assoc($result3);
$refcode=$row3['refcode'];
$adb="UPDATE dbo.users SET balance= balance +$bonus WHERE usercode='$refcode'";
$conn->query($adb);
$addbrec="INSERT INTO dbo.bonus (giver,usercode,amount) VALUES ('$username','$refcode','$bonus')";
$conn->query($addbrec);
    
}

$addwin00="UPDATE dbo.dbo.recharge SET status='Completed' WHERE username='$username' AND recharge='$amount' AND utr='$utr'";
$conn->query($addwin00);

if($conn->query($addwin00)){
    $addwin0="UPDATE dbo.users SET balance= balance +($amount/2) WHERE username='$username'";
    $conn->query($addwin0);
    if($conn->query($addwin0)){
        header("location: rechargeRequests.php");
    }
}else{
    echo"FAILED";
}
?>
