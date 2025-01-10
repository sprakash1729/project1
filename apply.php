
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
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

require_once "config.php";
$sql = "SELECT  bonus FROM dbo.dbo.users WHERE username='".$_SESSION['username']."'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$bonus=$row[bonus];
$addb1="UPDATE dbo.dbo.users SET balance= balance +$bonus WHERE  username='".$_SESSION['username']."'";

If($conn->query($addb1)=="true"){
     $addb2="UPDATE dbo.dbo.users SET bonus=0 WHERE username='".$_SESSION['username']."'";
            $conn->query($addb2);
            header("location: promotion#");
            
}



?>