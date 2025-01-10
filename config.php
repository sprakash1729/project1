<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connection Parameters
$serverName = "tcp:gametrial.database.windows.net,1433";
$connectionOptions = [
    "Database" => "gametraildb",
    "Uid" => "gametrial_root",
    "PWD" => "Pass@123",
    "Encrypt" => true,
    "TrustServerCertificate" => false
];

// Establish Connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check Connection
if ($conn === false) {
    echo "Connection failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}

echo "Connection successful!<br>";

// Test Query
$sql = "SELECT TOP 1 * FROM INFORMATION_SCHEMA.TABLES";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "Query execution failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}

// Display Query Results
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    print_r($row);
}

// Close Connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
