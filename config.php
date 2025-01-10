
<?php
$serverName = "tcp:gametrial.database.windows.net,1433"; // Replace with your server
$connectionOptions = [
    "Database" => "gametraildb", // Replace with your database name
    "Uid" => "gametrial_root", // Replace with your username
    "PWD" => "Pass@123", // Replace with your password
    "Encrypt" => true,
    "TrustServerCertificate" => false
];

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check if the connection is successful
if ($conn === false) {
    echo "Connection failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}

echo "Connection successful!<br>";

sqlsrv_close($conn); 
?>
