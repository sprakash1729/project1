
<?php
$serverName = getenv("AZURE_SQL_SERVERNAME");
$database = getenv("AZURE_SQL_DATABASE");
$username = getenv("AZURE_SQL_UID");
$password = getenv("AZURE_SQL_PWD");

// Corrected connectionOptions
$connectionOptions = array(
    "Database" => $database, 
    "Uid" => $username,
    "PWD" => $password
);

try {
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Sample query to check connection (optional for functional testing)
    $sql = "SELECT count(*) from dbo.users AS test_value";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt); 

} catch (Exception $e) {
    die();
}

sqlsrv_close($conn); 
?>
