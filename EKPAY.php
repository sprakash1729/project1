
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
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$sql = "SELECT  upi FROM notice WHERE id='1'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$upi=$row['upi'];
$a=array($upi);
$random_keys=array_rand($a,1);
$upiid= $a[$random_keys];
if (isset($_GET['am'])) {
    $am = $_GET['am'];
    // Use $am variable here
} else {
    // Handle the case where 'am' key is undefined
    //echo "Parameter 'am' is not set.";
}

//$am=$_GET['am'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
$amount = $_POST['amount'];
$utr = $_POST['utr']; 
$upi = $_POST['upi']; 
$query1 = "SELECT * FROM dbo.recharge WHERE utr='$utr' ";
$result1 = mysqli_query($conn, $query1);
$utrcount = mysqli_num_rows($result1); 

if($utrcount==0){
    
 
$sql1 = "INSERT INTO dbo.recharge (username, recharge,status,upi,utr) VALUES ('".$_SESSION['username']."', '$amount','EK-PAY','$upi','$utr')";
                
$conn->query($sql1);

if ($conn->query($sql) == TRUE) {
    header("location: /rechargerecord.php");
} else {
  header("location: /rechargerecord.php");
}
              
                





}else{
      echo "<script>
     document.addEventListener('DOMContentLoaded', function(event) { 
     
                 document.getElementById('copied').innerHTML='UTR Already Submited';
                 x=document.getElementById('copied');
           x.className = 'show';
        setTimeout(function () { x.className = x.className.replace('show', ''); }, 3000);
 
});
                
     
                </script>";
}

$conn->close();
}
?>
<html lang="en"><head>

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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" 
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    
    <title>UPI Pay</title>
    <link rel="shortcut icon" href="https://www.beautifulbangladesh.gov.bd/frontend/assets/img/link-ekpay.png" type="image/x-icon">
    <link href="css/app.46643acf.css" rel="preload" as="style">
    <link href="css/chunk-vendors.cf06751b.css" rel="preload" as="style">


    <link href="css/chunk-vendors.cf06751b.css" rel="stylesheet">
    <link href="css/app.46643acf.css" rel="stylesheet">



    <script>
    
   function pageRedirect() {
        window.location.replace("./recharge");
    }      
    setTimeout("pageRedirect()", 300000);
   
        </script>

<style>
A {text-decoration: none;}
html,body {width:100%;height:100%}
body {font-family: "Microsoft YaHei", Helvetica,Arial,sans-serif!important;}
body * {box-sizing: border-box}
.setp {width:100%;height:100%;margin:0 auto;display:none}
.setp .box {margin: 0 auto;min-width: 300px;max-width: 520px}
.setp .box input {border:2px solid #333;border-radius:4px;height:36px;width: 100%;box-sizing: border-box;padding: 0 10px;text-align: left;margin-bottom:10px}
.setp .box input::placeholder {color:#ccc}
.setp .box input::-webkit-input-placeholder {color:#ccc}
.setp .box input::-ms-input-placeholder {color:#ccc}
.btns {/*padding-top:16px*/}
.btn {width:80%;max-width: 320px;height:42px;line-height: 42px;display: block;text-align: center;color: #fff;padding:0;margin:10px auto 0;}
.btn.sub {background-image: linear-gradient(90deg,#cd0103,#f64841);border-radius:6rem;}
.btn.can {background: #7d7d7d}
.btn:hover {color:#fff;text-decoration: none}
.btn-copy {
margin-left: 8px;
display: inline-block;
background-image: linear-gradient(90deg,#cd0103,#f64841);
color: #fff;
padding: 8px;
font-size: 12px;
border-radius: 4px;
cursor: pointer;
float: right;
}
.btn-copy:hover {color:#fff;text-decoration: none}
h5 {overflow: hidden}
p:not(.level-2) {font-size: 16px;color: #f64841;font-weight: 600;margin-bottom: 4px;}
.level-2 {color:#999;font-size:12px;margin-top:8px}
.navbar {min-height: 0}
.navbar .tit {margin: 0;color:#fff;background-image: linear-gradient(90deg,#cd0103,#f64841);padding: 15px 0}
.container-fluid label.text-info,
.container-fluid label.text-danger {padding-left:8px}
.container-fluid .info-box,.container-fluid .info-tit {border: 1px solid #F64841;border-radius: 8px;padding: 4px 12px;}
.container-fluid .info-tit {border-color: transparent}
.container-fluid .info-box h5,.container-fluid .info-tit h5 {display: flex;align-items: center;justify-content: space-between}
.icon-warn {font-size:12px;border-radius:50%;background:#ff4605;color:#fff;display: inline-block;width: 14px;height: 14px;text-align: center;line-height: 14px;margin-right: 6px;font-style: unset;}
.img-row {display:flex;align-items: center;justify-content: space-between;padding-bottom:20px}
.img-row img {width: 48%;max-width: 320px;height: auto;border: 2px solid #F64841;}
#show-big-img {position: absolute;width:100%;height:100%;z-index: 99;left: 0;top: 0;padding-top:20px;display:none;overflow-y: auto;background: rgba(0,0,0,0.5)}
#show-big-img img {display:block;width: 90%;margin:0 auto;max-width: 750px;height:auto}
.btn-close {
position: absolute;
right: 30px;
top: 30px;
font-size: 16px;
color: #fff;
border: 2px solid #fff;
width: 30px;
height: 30px;
text-align: center;
line-height: 30px;
border-radius: 50%;
}
h2 {font-size:16px;margin-bottom:8px;}
h2 span {font-weight: bold;font-size:18px;}
#hide-img img{width: 100%;height: 100%}
.fsize-16 {font-size: 16px;font-weight: 500}
#order_time {position:absolute;right: 6px;top: 14px;color:#fff}
</style>
<style>
   #copied{
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 50px;
            font-size: 17px;
        }

       

        #copied.show {
            visibility: visible;
            margin-bottom: 205px;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
     
ul,li,ol {list-style: none}
#model-menu {margin-top:12px;padding-left:0;display:flex;align-items: center;justify-content: center;border:1px solid #74a5f3;border-radius:6px;overflow: hidden}
#model-menu li {cursor:pointer;-webkit-user-select:none;width:80px;height:36px;line-height:34px;background: #fff;color:#333;text-align: center}
#model-menu li:first-child {border-right: 0}
#model-menu li.active {background-image: linear-gradient(90deg,#cd0103,#f64841);color:#fff}
</style>
<style>
.amount-title {text-align: center;margin-top:10px;font-weight: 800;line-height: 36px;font-size:20px}
.amount-title span {color:#00c282;font-size: 36px;font-weight:600;}
.upi-info {padding: 12px 0;border-top: 1px solid;border-bottom: 1px solid;border-color: #f64841;display:flex;align-items: center;justify-content: space-between;margin-bottom: 20px;line-height: 20px;font-size: 16px;}
.upi-info span {color:#00c282;font-weight:600;}
.upi-payment-step {display:flex;align-items: center;justify-content: flex-start;margin-bottom: 16px;}
.upi-payment-step span {font-weight: 800;color:#333}
.upi-payment-step a {text-decoration:none;display: flex;align-items: center;justify-content: center;flex: 1;margin-left: 10px;border:1px solid #74a5f3;background-image: linear-gradient(90deg,#cd0103,#f64841);color:#fff;border-radius: 6px;height: 32px;}
.upi-payment-step input {flex: 1;height:32px;border:2px solid red;margin-left: 10px;border-radius: 6px;padding-left: 8px;}
.enter-ref-warn-box {text-align: center;color:#00c282;font-weight:600;}
.enter-ref-warn-box .enter-ref-warn {width:80%;margin:22px auto 22px;min-width: 300px;}
</style>
</head>
<body class="">
<div class="setp" id="setp-1" style="display: block;">
<div class="navbar navbar-default" style="margin-bottom: 0;position: relative">
<h4 style="display: flex; justify-content: center;" class="text-center tit">Payment Information<span id="btn" style="display: flex;
    position: fixed;
    right: 13px;"></span></h4>

</div>

<p id="teach" style="text-align: center;font-size: 12px;color: #333;margin-bottom: -5px;text-decoration: underline;">
<span style="font-size: 14px;display: inline-block;margin-right: 6px;color: #fff;background-image: linear-gradient(90deg,#cd0103,#f64841);font-weight:600;;height: 16px;width: 16px;border-radius: 50%;line-height: 16px;text-align: center;">?</span>
How to pay?
</p>
<h3 class="amount-title">
Payment Amount
<br>
<span>₹&nbsp;<?php echo $am;?></span>
</h3>
<?php

$upi_link = "upi://pay?pa=$upiid&am=$am";
?>

<div style="text-align: center; padding: 20px;">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($upi_link); ?>" 
         alt="UPI QR Code" style="width: 200px; height: 200px;">
</div>
<div class="container-fluid highlight">
<div style="margin: 0 auto;max-width: 520px">



<div class="payment-model" data-model="upi">


<div  style="display: flex; justify-content: center;" >
<div id="qrcode" style="width:100px; display:none; height:100px; margin-top:15px;"></div>
</div><br>
<div class="upi-info" style="display: none; justify-content: center;" >
<a href="upi://pay?pa=<?php echo $upiid;?>&pn=TcsClubs&am=<?php echo $am;?>&cu=INR&tn=Recharge"  class="btn-copy"  style="text-align: center;font-size:16px" target="_blank">
Pay Now
</a>
</div>
<div class="upi-info">
<div>
Pay to UPI: <br>
<span id="id" style="color:#00c282;">
<?php echo $upiid;?>
</span>
</div>
<a class="btn-copy" data-clipboard-text="<?php echo $upiid;?>" onclick="copyToClipboard()" style="text-align: center;width: 60px;font-size:16px">copy</a>
</div>
<div class="upi-payment-step">
<span style="min-width: 52px;font-weight: 800;color:#333">STEP 1:</span>
<div id="copied">UPI ID Copied</div>
<div style="margin-left:10px">
 click on the above button to complete payment or copy upi id
</div>
</div>
<form id="payment" method="post" action="">
<div class="upi-payment-step">
<span style="min-width: 52px">STEP 2:</span>

<input type="text" id="upi-input" value="" name="utr" placeholder="ENTER REF NO.:2014xxxxxxxx" maxlength="12" oninput="this.value=this.value.replace(/[^\d]/g,'')" onchange="this.value=this.value.replace(/[^\d]/g,'')">
<input id="text" type="hidden" name="upi" value="<?php echo $upiid;?>"  />
<input id="text" type="hidden" name="amount" value="<?php echo $am;?>"  />
</div>

</form>
<input id="text" type="hidden" value="" style="width:80%" />
<div id="error" style="display:none;color:red;line-height: 26px; font-size: 16px; text-align: center;max-width: 90%;margin:10px auto 0">Invalid UTR Number!</div>
<div class="enter-ref-warn-box">
<div class="enter-ref-warn">
You must fill in the correct Ref No.,then click the button below to submit,and wait for it to arrive!
</div>
<div class="btns" style="margin-top: 0;margin-bottom:20px">
<a class="btn sub" style="width: 200px" onclick="submit()">Confirm REF NO.</a>
</div>
</div>
</div>



<script type="text/javascript">
   let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('btn').innerHTML = m + ':' + s;
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

}
timer(1800);

	function dis(sr){
	    document.getElementById("show-big-img").style.display="block";
	    document.getElementById("big-img").src=sr;
	}
    document.getElementById("close").onclick= function() {myFunction()};

function myFunction() {
   document.getElementById("show-big-img").style.display="none";
}
 function submit(){
    if(document.getElementById("upi-input").value.length<12){
        document.getElementById("error").style.display="";
        setTimeout(function error() {
            document.getElementById("error").style.display="none";
           }, 2000);
        
    }else{
        document.getElementById("payment").submit();
    }
   }
  function copyToClipboard(text) {
var inputc = document.body.appendChild(document.createElement("input"));
inputc.value =document.getElementById("id").innerHTML;
inputc.focus();
inputc.select();
document.execCommand('copy');
inputc.parentNode.removeChild(inputc);
var x = document.getElementById("copied");
        x.className = "show";
        setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
}

</script>
</body>



</html>