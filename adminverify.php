<?php
session_start();

if(isset($_SESSION['adusername']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "manager")) { 
    header("location: admin.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username + password";
        echo $err;
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }

    // Check for special ID and password
    if($username=="SSI@1729" && $password=="Pass@1729"){
        session_start();
        $_SESSION["adusername"] = $username; 
        $_SESSION["adloggedin"] = true; 
        $_SESSION["role"] = "manager"; // Set a role for this user
        header("location: manager.php"); 
        exit; 
    } else {
        // Check for regular user login
        $sql = "SELECT id, username, password FROM dbo.users WHERE username = ?"; 
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if ($password == $hashed_password) {
                            session_start();
                            $_SESSION["adusername"] = $db_username; 
                            $_SESSION["id"] = $id;
                            $_SESSION["adloggedin"] = true;
                            $_SESSION["role"] = "user"; // Set a role for regular users
                            header("location: mylogin.php"); // Redirect to a different page for regular users
                            exit; 
                        } else {
                            echo "<h1>Please enter correct password</h1>";
                        }
                    }
                } else {
                    echo "<h1>Username not found</h1>";
                }
            } else {
                echo "Query execution failed: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Statement preparation failed: " . mysqli_error($conn);
        }
    }
}
?>
