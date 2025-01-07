<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', '91club');

$conn = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // The @ suppresses warnings

if (!$conn) {
    echo "<h1>Database Connection Error</h1>"; // More user-friendly message
    echo "<p>Error Number: " . mysqli_connect_errno() . "</p>"; // Display error number
    echo "<p>Error Message: " . mysqli_connect_error() . "</p>"; // Display error message
    // Optionally log the error to a file for debugging in production
    error_log("Database connection error: " . mysqli_connect_error(), 0);
    die(); // Stop execution
} else {
    // Remove in production, only for testing
 //   echo "<h1>Database connection established successfully!</h1>"; // Confirmation message
}
?>