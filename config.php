<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:gametrial.database.windows.net,1433; Database = gametrialdb", "gametrial_root", "Pass@123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "gametrial_root", "pwd" => "Pass@123", "Database" => "gametrialdb", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:gametrial.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>