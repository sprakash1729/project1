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
        echo "Connection failed.<br/>";
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Connection to SQL Server established.<br/>";

        // Sample query to check connection
        $sql = "SELECT count(*) from dbo.users AS test_value";
        $stmt = sqlsrv_query($conn, $sql);

        if ($stmt === false) {
            echo "Query execution failed.<br/>";
            die(print_r(sqlsrv_errors(), true));
        } else {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            echo "Test value: " . $row['test_value'] . "<br/>";
        }

        sqlsrv_free_stmt($stmt); 
    }

} catch (Exception $e) {
    echo "Exception encountered: " . $e->getMessage() . "<br/>";
    die();
}

sqlsrv_close($conn); 
?>