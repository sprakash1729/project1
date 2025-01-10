
<?php
$serverName = getenv("AZURE_SQL_SERVERNAME");
$database = getenv("AZURE_SQL_DATABASE");
$username = getenv("AZURE_SQL_UID");
$password = getenv("AZURE_SQL_PWD");

$connectionOptions = array(
    "Database" => $database, 
    "Uid" => $username,
    "PWD" => $password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: mylogin.php");
    exit;
}

require_once "config.php";
$sqlr = "SELECT status FROM dbo..otp WHERE id='1'";
$resultr = $conn->query($sqlr);
$rowr = mysqli_fetch_array($resultr);
if ($rowr !== null && isset($rowr['status'])) {
  $otpstatus = $rowr['status'];
  // Proceed with using $otpstatus variable
} else {
  // Handle the case where $rowr is null or 'status' key is not set
  //echo "Error: Unable to retrieve OTP status.";
}

//$otpstatus=$rowr['status'];
//$un=trim($_POST["username"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if 'username' key exists in $_POST array
  if (isset($_POST["username"])) {
      // Access form data safely
      $un = trim($_POST["username"]);
      // Proceed with further processing
  } else {
      // Handle case where 'username' key is missing
      //echo "Error: Username field is missing.";
  }
} else {
  // Handle case where form has not been submitted via POST
  //echo "Error: Form submission method is not POST.";
}

// Check if form is submitted and 'otp' field is set in $_POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["otp"])) {
    // Trim the 'otp' value to remove any leading or trailing whitespace
    $otp = trim($_POST["otp"]);
    
    // Proceed with further processing
    // For example, you can validate the OTP value or perform other actions here
} else {
    // Handle the case where the form is not submitted via POST
    // or the 'otp' field is not set in the form data
    //echo "Error: OTP field is missing or form is not submitted.";
}
//$otp=trim($_POST["otp"]);
$otp = '';
$query0 =  "SELECT  username FROM dbo..verify  WHERE otp='$otp'";
$result3 =$conn->query($query0);
$row3 = mysqli_fetch_assoc($result3);
if ($row3 !== null && isset($row3['username'])) {
  // $row3 is not null and 'username' key exists
  $verun = $row3['username'];
  // Proceed with using $verun variable
} else {
  // $row3 is null or 'username' key is not set
  // Handle the case where $row3 is null or 'username' key is not set
  //echo "Error: Unable to fetch username.";
}

//$verun=$row3['username'];
$otpstatus = '';
if($otpstatus){
   if($un==$verun){
       $otp='true';
   }else{
      $otp='false'; 
   }
}else{
   $otp='true'; 
}
if($otp){
    

// Define variables and initialize with empty values
$username = $password =  "";
$username_err = $password_err =  "";
     
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM dbo.users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 7){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    $refcode = trim($_POST["refcode"]);
    // Validate confirm password
   $sql3 = "SELECT refcode,refcode1 FROM dbo..users WHERE usercode='$refcode'";
   $result3 =$conn->query($sql3);
   $row3 = mysqli_fetch_assoc($result3);
   
   $refcode1=$row3['refcode'];
   $refcode2=$row3['refcode1'];
    $ip=$_SERVER['REMOTE_ADDR'];
    // Check input errors before inserting in database
    if(empty($password_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO dbo..users (username, password, refcode,refcode1,refcode2,r_ip) VALUES (?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password,$param_refcode,$param_refcode1,$param_refcode2,$param_ip);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
            $param_refcode = $refcode;

            $param_refcode1 = $refcode1;
            $param_refcode2 = $refcode2;
            $param_ip=$ip;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $addwin0="UPDATE dbo..users SET balance= balance +1 WHERE usercode=$refcode";
                $conn->query($addwin0);
                header("location: mylogin.php");
            } else{
             echo "<script>
     document.addEventListener('DOMContentLoaded', function(event) { 
     
                 document.getElementById('snackbar').innerHTML='Data Error';
          document.getElementById('snackbar').style.display= '';
        setTimeout(function () { document.getElementById('snackbar').style.display= 'none'; }, 3000);
 
});
                
     
                </script>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }else{
          echo "<script>
     document.addEventListener('DOMContentLoaded', function(event) { 
     
                 document.getElementById('snackbar').innerHTML='Please Input Any Strong Password ! / Try Again Later';
          document.getElementById('snackbar').style.display= '';
        setTimeout(function () { document.getElementById('snackbar').style.display= 'none'; }, 3000);
 
});
                
     
                </script>";
    }
    
    // Close connection
    mysqli_close($conn);
}
}else{
     echo "<script>
     document.addEventListener('DOMContentLoaded', function(event) { 
     
                 document.getElementById('snackbar').innerHTML='Incorrect OTP';
          document.getElementById('snackbar').style.display= '';
        setTimeout(function () { document.getElementById('snackbar').style.display= 'none'; }, 3000);
 
});
                
     
                </script>";
}

?>

 <!DOCTYPE html>
<html lang="en" translate="no" data-dpr="1" style="font-size: 38.32px;"><head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        color: #343a40;
    }
    .navbar {
        background-color: #6f42c1;
    }
    .navbar-brand, .nav-link {
        color: #fff !important;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: none;
        border-radius: 15px;
    }
    .btn-primary {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }
    .btn-primary:hover {
        background-color: #563d7c;
        border-color: #563d7c;
    }
</style>

<meta charset="UTF-8">
<link rel="icon" href="./ico.png">
<meta name="google" content="notranslate">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="manifest">
<title>91 Club</title>
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/modules-96f5a6e8.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-activity-871556fb.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-home-0d70abbb.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/index-08abe1f5.css">
<link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-login-c581a4df.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-login-1f545390.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-register-928b0021.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/index-f3c80c83.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/home-c9e2cd52.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/activity-46c093bd.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/promotion-5577fd39.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/wallet-d91dc187.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/main-b43b53ed.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/messageIcon-12ca5522.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/noticeBarSpeaker-a4b974d3.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/noticeBarHot-28d96456.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-main-eac2089d.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-main-8cf260fb.css"></head>
<body style="font-size: 12px;">
<div id="app" data-v-app=""><!----><!----><div data-v-064fe117="" class="resgister__C" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div data-v-4c21fa9e="" data-v-064fe117="" class="navbar"><div data-v-4c21fa9e="" class="navbar-fixed" style="background: rgb(247, 248, 255);"><div data-v-4c21fa9e="" class="navbar__content"><div data-v-4c21fa9e="" onclick="window.location.href='/mylogin.php';" class="navbar__content-left"><i data-v-4c21fa9e="" class="van-badge__wrapper van-icon van-icon-arrow-left"><!----><!----><!----></i></div><div data-v-4c21fa9e="" class="navbar__content-center"><div data-v-4c21fa9e="" class="headLogo" style="background-image: url(&quot;Wlogo.png&quot;);"></div><div data-v-4c21fa9e="" class="navbar__content-title"></div></div><div data-v-4c21fa9e="" class="navbar__content-right"></div></div></div></div><div data-v-064fe117="" class="resgister__C-heading"><h1 data-v-064fe117="" class="resgister__C-heading__title">Register</h1><form action="" id="createuser" method="POST"><div data-v-064fe117="" class="resgister__C-heading__subTitle"><span data-v-064fe117="">Please register by phone number</span></div></div><div data-v-064fe117="" class="login_container-tab"><div data-v-064fe117="" class="tab active"><div data-v-064fe117="" class="phonebg phoneactive"></div><div data-v-064fe117="" class="font30 phonefont30active">Register your phone</div></div><div data-v-064fe117="" class="tab" style="display:none;"><div data-v-064fe117="" class="emialbg"></div><div data-v-064fe117="" class="font30">email registration</div></div></div><div data-v-064fe117="" class="resgister__C-form"><div data-v-064fe117="" class="tab-content activecontent"><div data-v-4e8ccd02="" data-v-064fe117="" class="register__container"><div data-v-5f6a9e3a="" data-v-4e8ccd02="" class="phoneInput__container"><div data-v-5f6a9e3a="" class="phoneInput__container-label"><img data-v-5f6a9e3a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAM1BMVEUAAAD/cXH/cXH/cXL/cHL/cHL/cHD/cXH/cHL/cXH/cXH/c3P/cXL/cHD/eXn/cnL/cXLCBnslAAAAEHRSTlMAmXO/YJ9ATo9/Vh7fMBOvdmI8dQAAAHdJREFUSMft0UkOgCAQRNEGZB70/qd1o9F0hMKVmPCXpN6GpqGLQVYKhR6yopFFeyyKAEUGAgKBAYmAnGCCCf4EXmcXkGFAbSD1KVD6aO0D+nrVXUDertMFkjmzaZRf6gIOAcdARiASy7f3nggLvudFpyq5TCO3A483HtOoE/1VAAAAAElFTkSuQmCC" class="phoneInput__container-label__icon"><span data-v-5f6a9e3a="">Phone number</span></div><div data-v-5f6a9e3a="" class="phoneInput__container-input"><div data-v-ada8d273="" data-v-5f6a9e3a="" class="dropdown"><div data-v-ada8d273="" class="dropdown__value"><span data-v-ada8d273="">+91</span><i data-v-ada8d273="" class="van-badge__wrapper van-icon van-icon-arrow-down"><!----><!----><!----></i></div><div data-v-ada8d273="" class="dropdown__list"><div data-v-ada8d273="" class="dropdown__list-item active"><span data-v-ada8d273="">+91</span> India (भारत)</div></div></div><input data-v-5f6a9e3a="" id="num" type="tel" name="username" maxlength="10" minlength="10" autocomplete="off" placeholder="Please enter the phone number"></div></div><div data-v-4e8ccd02="" class="tip"><!----><!----></div><!----><div data-v-f1cfbd6f="" data-v-4e8ccd02="" class="passwordInput__container"><div data-v-f1cfbd6f="" class="passwordInput__container-label"><img data-v-f1cfbd6f="" class="passwordInput__container-label__icon" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII=" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII="><span data-v-f1cfbd6f="">Set password</span></div><div data-v-f1cfbd6f="" class="passwordInput__container-input"><input data-v-f1cfbd6f="" type="password" placeholder="Please enterSet password" id="pass" autocomplete="off" name="password" maxlength="15"><img data-v-f1cfbd6f="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAP1BMVEUAAADExMTExMTDw8PExMTFxcXFxcXExMS/v7/FxcXFxcXExMTExMTDw8PExMTFxcXFxcXExMTPz8+/v7/ExMTkagEbAAAAFHRSTlMAIO/ff29fvxDfMD/PoI+fr1AQMBwdwB4AAAFQSURBVDjL5ZJbkoQgDEXDI4iAqN3sf61DIEFHqmvmv/OhEE5ycwvgm0Il+z9uLQU/HJ0OrTvD4IqdoZdbdOHQh+sczphlSmKlvZu4uPZG2bkqfnDRzFlKL/FKuM9cig+/OoLCmcs8Au7ZqUDcG4IW00OGE2Fh040D/G1baeFO8mDo07gmpdUAa5djVGQPgej3OFtuwqZX7U3o1C0RmjevL+/rWLZqVzqnyV0bc70atgVJInPUaR/ip5TkATrmIBYBd3Gq6pGSVWpc18mPY9jYGKk0jgeP0nCjPxtDTgpnZXDkjGy0kgv3AK+4FG6opMmQXJVwob8wK0/jgCu8qWS+c/oU7hJumUqyrl2MOdDLzd85maVs/p6iQScOMnG1HcYXANlBwsriH9zWua2NZ4zmR8l+Jy6Ycotk/czJfQU8kqmRdgwwhU9y7X+F3yx8VfwAZv4b1F/KTEQAAAAASUVORK5CYII=" class="eye"></div></div><div data-v-4e8ccd02="" class="register__container-tip" style="display: ;"><div data-v-4e8ccd02="" class="tipbg"></div><span data-v-4e8ccd02="">The password must be at least 8 digits and must contain letters + numbers</span></div><div data-v-f1cfbd6f="" class="passwordInput__container" style="display:none;"><div data-v-f1cfbd6f="" class="passwordInput__container-label"><img data-v-f1cfbd6f="" class="passwordInput__container-label__icon" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII=" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII="><span data-v-f1cfbd6f="">Confirm password</span></div><div data-v-f1cfbd6f="" class="passwordInput__container-input"><input data-v-f1cfbd6f="" type="password" placeholder="Please enterConfirm password" maxlength="15"><img data-v-f1cfbd6f="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAP1BMVEUAAADExMTExMTDw8PExMTFxcXFxcXExMS/v7/FxcXFxcXExMTExMTDw8PExMTFxcXFxcXExMTPz8+/v7/ExMTkagEbAAAAFHRSTlMAIO/ff29fvxDfMD/PoI+fr1AQMBwdwB4AAAFQSURBVDjL5ZJbkoQgDEXDI4iAqN3sf61DIEFHqmvmv/OhEE5ycwvgm0Il+z9uLQU/HJ0OrTvD4IqdoZdbdOHQh+sczphlSmKlvZu4uPZG2bkqfnDRzFlKL/FKuM9cig+/OoLCmcs8Au7ZqUDcG4IW00OGE2Fh040D/G1baeFO8mDo07gmpdUAa5djVGQPgej3OFtuwqZX7U3o1C0RmjevL+/rWLZqVzqnyV0bc70atgVJInPUaR/ip5TkATrmIBYBd3Gq6pGSVWpc18mPY9jYGKk0jgeP0nCjPxtDTgpnZXDkjGy0kgv3AK+4FG6opMmQXJVwob8wK0/jgCu8qWS+c/oU7hJumUqyrl2MOdDLzd85maVs/p6iQScOMnG1HcYXANlBwsriH9zWua2NZ4zmR8l+Jy6Ycotk/czJfQU8kqmRdgwwhU9y7X+F3yx8VfwAZv4b1F/KTEQAAAAASUVORK5CYII=" class="eye"></div></div><div data-v-4e8ccd02="" class="register__container-tips" style="display: none;"><span data-v-4e8ccd02="">Entered twice the password does not match!</span></div><div data-v-4e8ccd02="" class="register__container-invitation"><div data-v-4e8ccd02="" class="register__container-invitation__label"><img data-v-4e8ccd02="" class="register__container-invitation__label-icon" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAYFBMVEUAAAD/cHP/cXH/cXL/cXP/cXL/bnP/cXL/c3P/cXL/cXL/cnP/cHL/cnP/cXH/cXL/cXL/cHL/c3P/bnX/cXL/cXL/cnP/cHL/cXH/b3H/cHL/cXH/bnL/cnL/cHP/cXKP6u3nAAAAH3RSTlMAZh/tjCYzxQ7fvZ+fTs+xgXlZGfXZqpZfLnA/Op9Aj7uD6gAAAPBJREFUSMft0tmugjAQgOG2U8+hhbKobG7z/m9pNJQypgy9MSbG73IyvzIE8XUOF7eXxOAuh9X1zMmofbay7388tbjJVS4aSEb0YC6IHb7jgh0XaPs/sb2fjVyAwdHP/rgAQgBJwUnPTnwQ8aagOU4X1IlBhZMq9R9aeGob+emjmz7Pc0039WNUx4JM+3fTL9ZhmnXqdX8EnBV+vwszM9J9ZdALRbGcQUaCKxLdvB/UJCiRAmtbpAwJMAE5ISVQvyAB+fJwWymWYDsoSFBtB2cSONxiBFUiD5SglOH3B/FKFcy+VSJCDVUJkYe39Vl8lztCCFqrftOCzgAAAABJRU5ErkJggg==" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAYFBMVEUAAAD/cHP/cXH/cXL/cXP/cXL/bnP/cXL/c3P/cXL/cXL/cnP/cHL/cnP/cXH/cXL/cXL/cHL/c3P/bnX/cXL/cXL/cnP/cHL/cXH/b3H/cHL/cXH/bnL/cnL/cHP/cXKP6u3nAAAAH3RSTlMAZh/tjCYzxQ7fvZ+fTs+xgXlZGfXZqpZfLnA/Op9Aj7uD6gAAAPBJREFUSMft0tmugjAQgOG2U8+hhbKobG7z/m9pNJQypgy9MSbG73IyvzIE8XUOF7eXxOAuh9X1zMmofbay7388tbjJVS4aSEb0YC6IHb7jgh0XaPs/sb2fjVyAwdHP/rgAQgBJwUnPTnwQ8aagOU4X1IlBhZMq9R9aeGob+emjmz7Pc0039WNUx4JM+3fTL9ZhmnXqdX8EnBV+vwszM9J9ZdALRbGcQUaCKxLdvB/UJCiRAmtbpAwJMAE5ISVQvyAB+fJwWymWYDsoSFBtB2cSONxiBFUiD5SglOH3B/FKFcy+VSJCDVUJkYe39Vl8lztCCFqrftOCzgAAAABJRU5ErkJggg=="><span data-v-4e8ccd02="">Invite code</span></div><div data-v-4e8ccd02="" class="register__container-invitation__input"><input data-v-4e8ccd02="" type="tel" id="code" name="refcode" auto-complete="new-password" autocomplete="off" placeholder="Please enter the invitation code" maxlength="10"></div></div><div data-v-4e8ccd02="" class="register__container-remember"><div data-v-4e8ccd02="" role="checkbox" class="van-checkbox" tabindex="0" aria-checked="true"><div class="van-checkbox__icon van-checkbox__icon--round van-checkbox__icon--checked"><i class="van-badge__wrapper van-icon van-icon-success" style="border-color: rgb(255, 113, 114); background-color: rgb(255, 113, 114);"><!----><!----><!----></i></div><span class="van-checkbox__label">I have read and agree <a href="#popup1" style="width: 6.5rem;
    height: 0.5rem;
    color: #fff;
    font-size: .30rem;
    font-weight: 700;
    letter-spacing: .05333rem;
    border-radius: 1.06667rem;
    border: none;
    background: linear-gradient(180deg,#ff867a 0%,#f95959 100%);
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
}" onclick="myFunction()">【Read Privacy Agreement】</a></span></div></div><div data-v-4e8ccd02="" class="register__container-button"><button onclick="sub()" data-v-4e8ccd02="">Register</button></form><button data-v-4e8ccd02="" class="login"><div data-v-4e8ccd02="" class="account">I have an account</div><div data-v-4e8ccd02="" onclick="window.location.href='/mylogin.php';" class="loginin">Login</div></button><div id="snackbar" class="van-toast van-toast--middle van-toast--text" style="z-index: 2009;display:none "><div class="van-toast__text">OTP SENT</div></div></div></div></div><div data-v-20ea4d57="" class="content" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div id="popup1" class="overlay">
	<div class="popup">
		<h2 ></h2>
		<div class="content">
			<div role="dialog" tabindex="0" class="van-popup van-popup--center van-dialog" style="z-index: 2001;"><!----><div class="van-dialog__content"><div data-v-4e8ccd02="" class="promptHeader">Privacy Agreement</div><a class="close" href="#">×</a><div data-v-4e8ccd02="" class="promptContent"><div data-v-d52d5a81="" class="about-container-content"><div class="content" style="padding: 16px;"><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Interpretation and Definitions</h1><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Interpretation</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The words of which the initial letter is capitalized have meanings defined under the following conditions.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Definitions</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">For the purposes of this Privacy Policy:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">You</span>&nbsp;means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Company</span>&nbsp;(referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to 91 Club.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Affiliate</span>&nbsp;means an entity that controls, is controlled by or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Account</span>&nbsp;means a unique account created for You to access our Service or parts of our Service.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Website</span>&nbsp;refers to&nbsp;<a href="https://mzplay.com/" target="_blank">91 Club</a>, accessible from&nbsp;<a href="https://17lottery.5g.in" target="_blank">https://17lottery.5g.in</a></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Service</span>&nbsp;refers to the Website.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Country</span>&nbsp;refers to: Uttar Pradesh, India</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Service Provider</span>&nbsp;means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Third-party Social Media Service</span>&nbsp;refers to any website or any social network website through which a User can log in or create an account to use the Service.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Personal Data</span>&nbsp;is any information that relates to an identified or identifiable individual.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Cookies</span>&nbsp;are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Device</span>&nbsp;means any device that can access the Service such as a computer, a cellphone or a digital tablet.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Usage Data</span>&nbsp;refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</li></ul></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Collecting and Using Your Personal Data</h1><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Types of Data Collected</h2><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Personal Data</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Email address</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">First name and last name</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Phone number</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Address, State, Province, ZIP/Postal code, City</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Usage Data</li></ul></h3><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Usage Data</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Usage Data is collected automatically when using the Service.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Usage Data may include information such as Your Device's Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</p></h3><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Tracking Technologies and Cookies</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Cookies can be "Persistent" or "Session" Cookies. Persistent Cookies remain on your personal computer or mobile device when You go offline, while Session Cookies are de1eted as soon as You close your web browser.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We use both session and persistent Cookies for the purposes set out below:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Necessary / Essential Cookies</span></p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Type: Session Cookies</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Administered by: Us</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Cookies Policy / Notice Acceptance Cookies</span></p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Type: Persistent Cookies</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Administered by: Us</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Purpose: These Cookies identify if users have accepted the use of cookies on the Website.</p></li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">Functionality Cookies</span></p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Type: Persistent Cookies</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Administered by: Us</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px;">Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.</p></li></ul><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy.</p></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Use of Your Personal Data</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The Company may use Personal Data for the following purposes:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">To provide and maintain our Service</span>, including to monitor the usage of our Service.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">To manage Your Account:</span>&nbsp;to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">For the performance of a contract:</span>&nbsp;the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">To contact You:</span>&nbsp;To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application's push notifications regarding upda7es or informative communications related to the functionalities, products or contracted services, including the security upda7es, when necessary or reasonable for their implementation.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">To provide You</span>&nbsp;with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">To manage Your requests:</span>&nbsp;To attend and manage Your requests to Us.</li></ul><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We may share your personal information in the following situations:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">With Service Providers:</span>&nbsp;We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">For Business transfers:</span>&nbsp;We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of our business to another company.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">With Affiliates:</span>&nbsp;We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">With Business partners:</span>&nbsp;We may share Your information with Our business partners to offer You certain products, services or promotions.</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;"><span style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px; font-weight: bolder;">With other users:</span>&nbsp;when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside. If You interact with other users or register through a Third-Party Social Media Service, Your contacts on the Third-Party Social Media Service may see You name, profile, pictures and description of Your activity. Similarly, other users will be able to view descriptions of Your activity, communicate with You and view Your profile.</li></ul></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Retention of Your Personal Data</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</p></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Transfer of Your Personal Data</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Your information, including Personal Data, is processed at the Company's operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</p></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Disclosure of Your Personal Data</h2><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Business Transactions</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p></h3><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Law enforcement</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</p></h3><h3 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Other legal requirements</h3><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Comply with a legal obligation</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Protect and defend the rights or property of the Company</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Prevent or investigate possible wrongdoing in connection with the Service</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Protect the personal safety of Users of the Service or the public</li><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">Protect against legal liability</li></ul></h3><h2 style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Security of Your Personal Data</h2><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</p></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Children's Privacy</h1><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent's consent before We collect and use that information.</p></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Links to Other Websites</h1><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party's site. We strongly advise You to review the Privacy Policy of every site You visit.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Changes to this Privacy Policy</h1><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We may update our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the "Last updated" date at the top of this Privacy Policy.</p><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p></h3><h1 style="box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; font-family: Futura; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250);">Contact Us</h1><h3 class="text-xs-center" style="box-sizing: inherit; font-family: Futura; color: rgba(0, 0, 0, 0.87); margin: 0px 0px 12px; background-repeat: no-repeat; padding: 0px; background-color: rgb(250, 250, 250); text-align: center !important;"><p style="box-sizing: inherit; margin-bottom: 16px; background-repeat: no-repeat; padding: 0px; font-size: 14px; text-align: start;">If you have any questions about this Privacy Policy, You can contact us:</p><ul style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; background-repeat: no-repeat; padding: 0px 0px 0px 24px; font-size: 14px; text-align: start;"><li style="box-sizing: inherit; background-repeat: no-repeat; padding: 0px; margin: 0px;">By visiting this page on our website:&nbsp;<a href="https://17lottery.5g.in" target="_blank">https://17lottery.5g.in</a></li></ul></h3></div> </div></div></div><div class="van-hairline--top van-dialog__footer"><!----></div><!----></div>
</div><div data-v-064fe117="" class="tab-content"><div data-v-5784c926="" data-v-064fe117="" class="register__container"><div data-v-9ea79214="" data-v-5784c926="" class="emailcontainer"><div data-v-9ea79214="" class="emailinput__container"><div data-v-9ea79214="" class="emailinput__container-label"><img data-v-9ea79214="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAANsSURBVHgB7Vj/edowED25C9ANPELZINkgTFAyQW13AJwFsDNB6QRkg3SDskHYoEzg693JkoUwtgUE+MPv+5wgWz/eWffuTgYYMWLEiBEjRtwOyr+BSTIBiAp68kTNCdwHtoDwpspl6j+I/BuqLHcA1SuZsoO7AdJV/W57YneA3nxM/3bagLqt1Dt1ieGmQHr7+Ei8ttISD4GJaTc7EEULUNHf2hCQDjSQhmzgVkD8Q9fUIR8zRyL7w3RpdiDN/oH2eSJezWiQJY5JxppI4JpAKF2fJ/LfiPyafsbAnlIsv/J9VwNGsLHeicwSlokU5HA1YOKRn+s3L+TB4XooYgsFBQ3MbXO5fOGdoZ+fKe6d7H5RvJobmKY5kf91bEDUOZ2KFpiR+5hmWb7RAlMR1sXBYq2msgZosRL5Fa266BoV9U1LvpjQRG3i3sLFQIFiP9KYCPi9b2S/AQLFAnr3jJiSm73BuVCw8sjLWrLmAAw0QFCLO3mSdSlfkC5mZ4kbq5zmeHZyz1yTt2LtRYgBjAmHshZxpxAMjjTli201Yg0qX0IN0DgUdwmohuqC3jY+eJGm7BPrUSrNJBlCKDhTAj63iC8+MuCwLFBf1mwQBIISmXA/bQfsLOqB/lqxdZcfEmlsWVDj6RTyLs4zQPvxXiRiguQeUy4Fmm5UFtA9R6yTuu/qNP00ON0AjiC1H7PrkAt+tJYf3G+vLKA+OpoZI8pzItlpGhBSOoJoP1ZN3MbqhZ7lrcO0WOtK0iYvvStZtqCdygcyOEMDDnk9E4vQSTpehJIhXBZk2bohLx1pjFrbloRjx+0GImwHKGty4mnGSK1yJN3LG57pcR3JKWhOZ1j4DuDGWyjvXkjKjw+5ujIrwnwvMRbFPOQQNdAA7a+2pcmflHhawW7nGBFyEhxggCSfmRXbpckbOEbIWuJ+/Zm9x4CDzDn/FPIGbESailsOLds7DPDJ/3zoOhldDmoVYsQxA3a122y5oWt0XMPVoEpZE6wRR4+y7QZg9Wi+StSfMpj8Nb/STbwD1IY5tXV0DagtxLlHPuiAcUG0GfG8z9U1gL491vWNfMK7MXmD2DNiJcUfNkdZZweq1KtvzEekW8MY0RR/0FSwqm2E1C0oX6fvCPvFn8GBiMXSSo59W7gfUFRUrMtrBpIRI0aMGID/EYgKCbjmh1gAAAAASUVORK5CYII=" class="emailinput__container-label__icon"><span data-v-9ea79214="">Mail</span></div><div data-v-9ea79214="" class="emailinput__container-input"><input data-v-9ea79214="" type="text" name="userEmail" maxlength="250" placeholder="please input your email"></div></div></div><div data-v-d45f19d6="" data-v-5784c926="" class="verifyInput__container"><div data-v-d45f19d6="" class="verifyInput__container-label"><img data-v-d45f19d6="" class="verifyInput__container-label__icon ar-lazyload" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAS1BMVEUAAAD/cHP/cHD/cXH/cXP/cXL/cHH/cXL/cXH/cXP/bm7/cHP/cXH/dHT/cXL/cHH/cHL/cHL/cHL/cnL/cHT/bXT/cXH/cXH/cXJv9I07AAAAGHRSTlMAZjGAWN8gX6BNETkMBu+/j29AJkYZz5By3a/ZAAAA7ElEQVRIx93TSY7DMAxEUUrWYEmeh27e/6SdRQOBUiGZdf76lQ0aMH1ps7+Cc+E6P+N3y+6/cEzmw1NxXeVUuc9Par/mLk6oveM+O7mKvjmtCfypek9Q0T0WDF/zAQPNp8i8w0D2/uH5BwayX/hRhIHkM7MyQL+zNkA/sDVAbw/Q48Dw+FlNz2s3uHSPg2Z63rrBif6X+0o3mMCP/FKirmD5SH0ePZzQNRueE/6kTz+gH+m1qnpOBDXNb4TNQfYxEWFTugXPnoQEP8g+6x7bdI8d6HdSS7HnEe5Vz16GSnZpBG5O8srLulf60v4AtscrR80IptoAAAAASUVORK5CYII="><span data-v-d45f19d6="">Verification Code</span></div><div data-v-d45f19d6="" class="verifyInput__container-input"><input data-v-d45f19d6="" type="text" placeholder="Please enter the confirmation code" maxlength="6"><button data-v-d45f19d6="" class=""><span data-v-d45f19d6="">Send</span></button></div><div data-v-d45f19d6="" class="verifyInput__container-tip" style="display: none;"><i data-v-d45f19d6="" class="van-badge__wrapper van-icon van-icon-warning-o"><!----><!----><!----></i><span data-v-d45f19d6="">Did not receive verification code?</span><span data-v-d45f19d6="">Contact customer service</span></div></div><div data-v-f1cfbd6f="" data-v-5784c926="" class="passwordInput__container"><div data-v-f1cfbd6f="" class="passwordInput__container-label"><img data-v-f1cfbd6f="" class="passwordInput__container-label__icon ar-lazyload" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII="><span data-v-f1cfbd6f="">Set password</span></div><div data-v-f1cfbd6f="" class="passwordInput__container-input"><input data-v-f1cfbd6f="" type="password" placeholder="Please enterSet password" maxlength="15"><img data-v-f1cfbd6f="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAP1BMVEUAAADExMTExMTDw8PExMTFxcXFxcXExMS/v7/FxcXFxcXExMTExMTDw8PExMTFxcXFxcXExMTPz8+/v7/ExMTkagEbAAAAFHRSTlMAIO/ff29fvxDfMD/PoI+fr1AQMBwdwB4AAAFQSURBVDjL5ZJbkoQgDEXDI4iAqN3sf61DIEFHqmvmv/OhEE5ycwvgm0Il+z9uLQU/HJ0OrTvD4IqdoZdbdOHQh+sczphlSmKlvZu4uPZG2bkqfnDRzFlKL/FKuM9cig+/OoLCmcs8Au7ZqUDcG4IW00OGE2Fh040D/G1baeFO8mDo07gmpdUAa5djVGQPgej3OFtuwqZX7U3o1C0RmjevL+/rWLZqVzqnyV0bc70atgVJInPUaR/ip5TkATrmIBYBd3Gq6pGSVWpc18mPY9jYGKk0jgeP0nCjPxtDTgpnZXDkjGy0kgv3AK+4FG6opMmQXJVwob8wK0/jgCu8qWS+c/oU7hJumUqyrl2MOdDLzd85maVs/p6iQScOMnG1HcYXANlBwsriH9zWua2NZ4zmR8l+Jy6Ycotk/czJfQU8kqmRdgwwhU9y7X+F3yx8VfwAZv4b1F/KTEQAAAAASUVORK5CYII=" class="eye"></div></div><div data-v-5784c926="" class="register__container-tip" style="display: none;"><div data-v-5784c926="" class="tipbg"></div>
<span data-v-5784c926="">The password must be at least 8 digits and must contain letters + numbers</span></div><div data-v-f1cfbd6f="" data-v-5784c926="" class="passwordInput__container"><div data-v-f1cfbd6f="" class="passwordInput__container-label"><img data-v-f1cfbd6f="" class="passwordInput__container-label__icon ar-lazyload" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAWlBMVEUAAAD/cXH/cHD/cnL/cXL/cXL/cXL/cXH/cnL/cnL/cXH/cHD/cXL/cXL/cnL/cnL/cXP/cnL/cHH/cXH/cnL/Zmb/cXP/cHH/cHD/cXH/cHD/cnL/dHT/cXJ2Y/zhAAAAHXRSTlMAmR8mj+/ffzlMExCvoYZfb0NAz2kKv7+Gc1ZyVs4lXHAAAAE4SURBVEjH3ZRbloMgEEQtBCUiiK8k6rD/bU7CzDEJCMJv6hPqnqKhm+I7Va6TogDUspYJ9p7iTYqf2JvF+qiqN/VH1k3UrwBs/N/T8O0ZMkeADriXH/XcgSlS7sPfOJkUKGMBXpF9LILi7q3NFHQOn2g6jCUBgAP9wcMAPABcDuvjwCULKMPAmgt02YCUPfHE5TEw0JGZgNgoB8dOruZEFfnwV8ZkEa1J0O0twCTpVUedBtQ74FXMqNbSq6vdgdHZoeIwuNoBFoh2CLYD/m30y8L9swaAwbYh8PN4/iRAFA2s5kIkAbZBAdu6iQkzrJrEhMHOnp2CzgHCt8Sn7jlLVQDIfge3CaTtZEGd5THS3beaXlm4l7RJkt4BkQaQzImTxUsid6YLIs/8rXA/Gt2GPiZWtZoUX6Rf0glhk/KUKW0AAAAASUVORK5CYII="><span data-v-f1cfbd6f="">Confirm password</span></div><div data-v-f1cfbd6f="" class="passwordInput__container-input"><input data-v-f1cfbd6f="" type="password" placeholder="Please enterConfirm password" maxlength="15"><img data-v-f1cfbd6f="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAP1BMVEUAAADExMTExMTDw8PExMTFxcXFxcXExMS/v7/FxcXFxcXExMTExMTDw8PExMTFxcXFxcXExMTPz8+/v7/ExMTkagEbAAAAFHRSTlMAIO/ff29fvxDfMD/PoI+fr1AQMBwdwB4AAAFQSURBVDjL5ZJbkoQgDEXDI4iAqN3sf61DIEFHqmvmv/OhEE5ycwvgm0Il+z9uLQU/HJ0OrTvD4IqdoZdbdOHQh+sczphlSmKlvZu4uPZG2bkqfnDRzFlKL/FKuM9cig+/OoLCmcs8Au7ZqUDcG4IW00OGE2Fh040D/G1baeFO8mDo07gmpdUAa5djVGQPgej3OFtuwqZX7U3o1C0RmjevL+/rWLZqVzqnyV0bc70atgVJInPUaR/ip5TkATrmIBYBd3Gq6pGSVWpc18mPY9jYGKk0jgeP0nCjPxtDTgpnZXDkjGy0kgv3AK+4FG6opMmQXJVwob8wK0/jgCu8qWS+c/oU7hJumUqyrl2MOdDLzd85maVs/p6iQScOMnG1HcYXANlBwsriH9zWua2NZ4zmR8l+Jy6Ycotk/czJfQU8kqmRdgwwhU9y7X+F3yx8VfwAZv4b1F/KTEQAAAAASUVORK5CYII=" class="eye"></div></div><div data-v-5784c926="" class="register__container-tips" style="display: none;"><span data-v-5784c926="">Entered twice the password does not match!</span></div><div data-v-5784c926="" class="register__container-invitation"><div data-v-5784c926="" class="register__container-invitation__label"><img data-v-5784c926="" class="register__container-invitation__label-icon ar-lazyload" data-origin="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAYFBMVEUAAAD/cHP/cXH/cXL/cXP/cXL/bnP/cXL/c3P/cXL/cXL/cnP/cHL/cnP/cXH/cXL/cXL/cHL/c3P/bnX/cXL/cXL/cnP/cHL/cXH/b3H/cHL/cXH/bnL/cnL/cHP/cXKP6u3nAAAAH3RSTlMAZh/tjCYzxQ7fvZ+fTs+xgXlZGfXZqpZfLnA/Op9Aj7uD6gAAAPBJREFUSMft0tmugjAQgOG2U8+hhbKobG7z/m9pNJQypgy9MSbG73IyvzIE8XUOF7eXxOAuh9X1zMmofbay7388tbjJVS4aSEb0YC6IHb7jgh0XaPs/sb2fjVyAwdHP/rgAQgBJwUnPTnwQ8aagOU4X1IlBhZMq9R9aeGob+emjmz7Pc0039WNUx4JM+3fTL9ZhmnXqdX8EnBV+vwszM9J9ZdALRbGcQUaCKxLdvB/UJCiRAmtbpAwJMAE5ISVQvyAB+fJwWymWYDsoSFBtB2cSONxiBFUiD5SglOH3B/FKFcy+VSJCDVUJkYe39Vl8lztCCFqrftOCzgAAAABJRU5ErkJggg==">
<span data-v-5784c926="">Invite code</span></div><div data-v-5784c926="" class="register__container-invitation__input"><input data-v-5784c926="" type="text" auto-complete="new-password" autocomplete="off" name="userNumber" placeholder="Please enter the invitation code" maxlength="20"></div></div><div data-v-5784c926="" class="register__container-remember"><div data-v-5784c926="" role="checkbox" class="van-checkbox" tabindex="0" aria-checked="true"><div class="van-checkbox__icon van-checkbox__icon--round van-checkbox__icon--checked"><i class="van-badge__wrapper van-icon van-icon-success" style="border-color: rgb(255, 113, 114); background-color: rgb(255, 113, 114);"><!----><!----><!----></i></div><span class="van-checkbox__label">I have read and agree <span data-v-5784c926="">【Privacy Agreement】</span></span></div></div><div data-v-5784c926="" class="register__container-button"><button data-v-5784c926="">Register</button><button data-v-5784c926="" class="login"><div data-v-5784c926="" class="account">I have an account</div><div data-v-5784c926="" class="loginin">Login</div></button></div></div></div></div></div><div class="customer" id="customerId" style="--36a344b0: 'Roboto', 'Inter', sans-serif; --17a7a9f6: bahnschrift; left: 311px; top: 590px;"><img onclick="window.location.href='/keFuMenu.php';" class="" data-origin="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png" src="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png" ></div><!----><!----></div><style>
  
      .van-toast {
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    top:20px;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    box-sizing: content-box;
    -webkit-transition: all var(--van-duration-fast);
    transition: all var(--van-duration-fast);
    width: var(--van-toast-default-width);
    max-width: var(--van-toast-max-width);
    min-height: var(--van-toast-default-min-height);
    padding: var(--van-toast-default-padding);
    color: var(--van-toast-text-color);
    font-size: var(--van-toast-font-size);
    line-height: var(--van-toast-line-height);
    white-space: pre-wrap;
    word-break: break-all;
    text-align: center;
    background: var(--van-toast-background);
    border-radius: var(--van-toast-radius);
}
.van-toast--html, .van-toast--text[data-v-023602e0] {
    width: -webkit-fit-content;
    width: fit-content;
    min-width: 96px;
    min-height: 0;
    padding: 8px 12px;
}
  </style><style>.box {
    width: 40%;
    margin: -24px auto;
    background: rgba(255,255,255,0.2);
    padding: 37px;
    border: 2px solid #fff;
    border-radius: 20px/50px;
    background-clip: padding-box;
    text-align: center;
}

.button {
  font-size: 1em;
  padding: 10px;
  color: #000;
  border: 2px solid white;
  border-radius: 20px/50px;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease-out;
}
.button:hover {
  background: white;
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}

.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
    position: absolute;
    top: 0px;
    right: 13px;
    transition: all 200ms;
    font-size: 40px;
    /* font-weight: bold; */
    text-decoration: none;
    color: #fff;
}
.popup .close:hover {
  color: white;
}
.content {
    background: #ffffff!important;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
}
.popup {
    margin: -300px auto;
    padding: 20px;
    background: #fff0;
    border-radius: 5px;
    width: 30%;
    position: relative;
    transition: all 5s ease-in-out;
}</style><script>window.onload = function () {
			let cfg  = JSON.parse(localStorage.getItem('clientCfg'));
			// console.log(cfg)
			if (cfg) {
				var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
				// var meta = document.querySelector("meta[name*='google-site-verification']") || document.createElement('meta');
				// meta.content = '是十四'
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = cfg.WebIco;//'http://47.56.7.183:5001/https://91dreamclub.com/img/tatalogo.jpg';
				document.getElementsByTagName('head')[0].appendChild(link);
				// document.getElementsByTagName('head')[0].appendChild(meta);
				
				document.getElementsByTagName("title")[0].innerText = cfg.ProjectName;
			}
			document.addEventListener('touchstart', function (event) {
				if (event.touches.length > 1) {
					event.preventDefault();  //阻止元素的默认行为
				}
			}, {
				capture: false,
				passive: false,
				once: false
			});
			// document.addEventListener('touchmove', function (event) {
			// 	event.preventDefault();  //阻止元素的默认行为
			// }, {
			// 	passive: false,
			// });
		}</script><style>html,body{ height: 100%; width: 100%; background-color: #9195a3;padding: 0;margin: 0;}</style>
   <script>
     setInterval(function () { 
  if(document.getElementById("pass").value.length>7 && document.getElementById("num").value.length==10 && document.getElementById("otp").value.length>3 && document.getElementById("code").value.length>4){
      document.getElementById("btn").className="btn-main sign act";
  }else{
       
  }
     }, 300);
     
       let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('otpbtn').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  document.getElementById('otpbtn').innerHTML="RESEND"
   document.getElementById("otpbtn").onclick = sendcode();
}


      
     function sendcode(){
         var number=document.getElementById("num").value;
         if(number!=null && number.length==10){
             var xmlhttp = new XMLHttpRequest();
             xmlhttp.open("GET", "otp.php?num="+number, true);
             xmlhttp.send();
             timer(60);
             document.getElementById('otpbtn').removeAttribute("onclick");
             document.getElementById("snackbar").innerHTML="Success! ";
               document.getElementById("snackbar").style.display= "";
        setTimeout(function () { document.getElementById("snackbar").style.display= "none"; }, 3000);
     
  
         }else{
                 document.getElementById("snackbar").innerHTML="Input Mobile Phone Number";
          document.getElementById("snackbar").style.display= "";
        setTimeout(function () { document.getElementById("snackbar").style.display= "none"; }, 3000);
     
  
         }
         
     }
     
   
      
  </script>
  <script type='text/JavaScript'>



 function sub() {
      document.getElementById('createuser').submit();      
}
    </script>  
  <?php
   if(isset($_GET["r_code"])){
    $id=$_GET["r_code"];
   echo" <script>

function ref() {
      document.getElementById('code').value= '$id';      
}
ref()
</script>";
}


   ?>
<foreignobject></foreignobject>

<!----><!----><!----><!----></body></html>