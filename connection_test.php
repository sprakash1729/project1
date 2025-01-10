<?php
// SQL Server connection configuration
$serverName = "tcp:your_server.database.windows.net,1433"; // Replace with your server
$connectionOptions = [
    "Database" => "your_database", // Replace with your database name
    "Uid" => "your_username", // Replace with your username
    "PWD" => "your_password", // Replace with your password
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

// Define the query to fetch data from dbo.users
$sql = "SELECT TOP 10 * FROM dbo.users"; // Fetch the first 10 rows
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "Query execution failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}

// Display the results
echo "<h3>Query Results:</h3>";
echo "<table border='1'>";
echo "<tr>";
foreach (sqlsrv_field_metadata($stmt) as $field) {
    echo "<th>" . htmlspecialchars($field["Name"]) . "</th>";
}
echo "</tr>";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $col) {
        echo "<td>" . htmlspecialchars($col) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

// Free the statement and close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
