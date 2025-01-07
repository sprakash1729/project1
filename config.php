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
?>
<?php
// PHP Data Objects(PDO) Sample Code:
try {
  // Connect to the database
  $conn = new PDO("sqlsrv:server = tcp:gametrial.database.windows.net,1433; Database = gametrialdb", "gametrial_root", "Pass@123");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Sample query to check connection
  $sql = "SELECT * from dbo.users AS test_value";
  $stmt = $conn->prepare($prepared_stmt);
  $stmt->execute();

  // Check if query execution was successful
  if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Connection successful! Test value: " . $result['test_value'];
  } else {
    echo "Query execution failed.";
  }
} catch (PDOException $e) {
  echo "Error connecting to SQL Server: " . $e->getMessage();
  die();
} finally {
  // Close the connection (optional, but recommended)
  $conn = null;
}
?>