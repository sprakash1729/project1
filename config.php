<?php
$server = getenv("AZURE_SQL_SERVERNAME");
$database = getenv("AZURE_SQL_DATABASE");
$username = getenv("AZURE_SQL_UID");
$password = getenv("AZURE_SQL_PASSWORD");

$connectionOptions = array(
    "Database" => gametraildb,
    "Uid" => gametrial_root,
    "PWD" => Pass@123
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
?>