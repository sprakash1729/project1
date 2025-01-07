<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
require_once "config.php";
$sql = "SELECT  upi FROM notice WHERE id='1'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$upi=$row[upi];
$a=array($upi);
$random_keys=array_rand($a,1);
$upiid= $a[$random_keys];
$am=$_GET['am'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
$amount = $_POST['amount'];
$utr = $_POST['utr']; 
$upi = $_POST['upi']; 
$query1 = "SELECT * FROM `dbo.recharge` WHERE utr='$utr' ";
$result1 = mysqli_query($conn, $query1);
$utrcount = mysqli_num_rows($result1); 

if($utrcount==0){
    
 
$sql1 = "INSERT INTO recharge (username, recharge,status,upi,utr) VALUES ('".$_SESSION['username']."', '$amount','wait','$upi','$utr')";
                
$conn->query($sql1);

if ($conn->query($sql) == TRUE) {
    header("location: /rechargelist#");
} else {
  header("location: /rechargelist#");
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
<!DOCTYPE html>



<html lang="en"><head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="expires" content="1">
<meta name="google" value="notranslate">
<meta name="msapplication-TileColor" content="#34b26d">
<meta name="theme-color" content="#34b26d">
<meta name="msapplication-navbutton-color" content="#34b26d">
<meta name="apple-mobile-web-app-status-bar-style" content="#34b26d">
<meta name="description" content="Make money with Garuda Mall">
<link rel="shortcut icon" href="/includes/icons/fevicon.png" type="image/x-icon">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Garuda Mall">
<meta name="twitter:site" content="Garuda Mall">
<meta name="twitter:description" content="Make money with Garuda Mall">
<meta name="twitter:image" content="https://www.garudamall.co/includes/images/logo.jpg">
<meta property="og:title" content="Garuda Mall">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Garuda Mall">
<meta property="og:url" content="https://www.garudamall.co">
<meta name="msapplication-TileImage" content="https://www.garudamall.co/includes/images/logo.jpg">
<meta property="og:image" content="https://www.garudamall.co/includes/images/logo.jpg">
<meta property="og:description" content="Make money with Garuda Mall">
<meta property="url" content="https://www.garudamall.co">
<meta property="type" content="website">
<meta property="title" content="Garuda Mall">
<meta property="description" content="Make money with Garuda Mall">
<meta property="image" content="https://www.garudamall.co/includes/images/logo.jpg">
<meta itemprop="image" content="https://www.garudamall.co/includes/images/logo.jpg">
<link rel="stylesheet" href="https://www.garudamall.co/includes/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.garudamall.co/includes/assets/css/light.css?v2">
<link rel="stylesheet" href="https://www.garudamall.co/includes/dropzone/css/dropzone.css">
<script type="text/javascript" src="/includes/popper/popper.min.js"></script>
<script type="text/javascript" src="/includes/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/includes/jquery/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/includes/dropzone/js/dropzone.js"></script>
<script type="text/javascript" src="/includes/osqr/qrious.min.js"></script><title>GARUDA MALL</title>
</head><body>
<section class="container-fluid">
<div class="row mcas">
<div class="col-md-6 col-lg-4 main">
<div class="row" id="warea"><div class="col-12 m-record"><div class="row nav-top auto"><div class="col-6 tfw-7 tf-20 ddavc"><span class="nav-back wt" onclick="recharge()"></span> Recharge</div><div class="col-6 xtr">₹<span class="tfw-7 tf-24" id="amount"><?php echo $am;?></span></div></div><div class="row"><div class="col-12 xtl tf-14 mt-4 tfcdb">Pick and recharge method:</div><div class="col-12" id="dtaod">
<div class="row tfwr mcpl" onclick="return upiPay('bharatpe09907990461@yesbankltd','PhonePe')">
<div class="col-12 bd-b pt-2 pb-2 ddavc">
<span class="phonepe-logo"></span>
<span class="pl-2 tf-16"onclick="srcp()">PhonePe</span>
<span class="ml-2 tf-10"id="rcbsh" type="radio"  name="payment" value="2"  id="bonr">[UPI]</span>
<span class="ml-2 dipn" id="upx1">bharatpe09907990461@yesbankltd</span>
</div>
</div>
<div class="row tfwr mcpl" onclick="return upiPay('bharatpe09907990461@yesbankltd','GPay')">
<div class="col-12 bd-b pt-2 pb-2 ddavc">
<span class="gpay-logo"></span>
<span class="pl-2 tf-16"onclick="srcp()">GPay</span>
<span class="ml-2 tf-10"id="rcbsh" type="radio"  name="payment" value="2"  id="bonr">[UPI]</span>
<span class="ml-2 dipn" id="upx3">bharatpe09907990461@yesbankltd</span>
</div>
</div>
<div class="row tfwr mcpl" onclick="return autopay('https://garudamall.co/paytm/pay','Asmpay','9037142706')">
<div class="col-12 bd-b pt-2 pb-2 ddavc">
<span><img src="https://www.garudamall.co/includes/icons/Paytm.png" height="24"></span>
<span class="pl-2 tf-16"onclick="srcp()">Paytm</span>
<span class="ml-2 tf-10"id="rcbsh" type="radio"  name="payment" value="2"  id="bonr">[UPI, Credit/Debit Cards, Net Banking]</span>
</div>
</div>
</div></div></div></div>
<div class="row" id="odrea"></div>
<div class="row" id="footer"></div>
<div class="row" id="opffp"></div>
<div class="row" id="anof"></div>
<div class="row" id="dta_ref"></div>
<div class="telegram" onclick="telegram()">
<div class="telgm"></div>
<div class="telTL">Earn More</div>
</div>
</div>
</div>
</section>
<script>

 $("#bonr").prop("checked",true );

    function srcp(){
        p=document.getElementById("bonc").checked;
p1=document.getElementById("bonr").checked;
if(p){
  var payment=1;  
}else if(p1){
    var payment=2;
}
        if(payment==1){
        if( document.getElementById("amount").value>199){
         var link="/pay.php?am="
         var amount=document.getElementById("amount").value;
         var payurl=link.concat(amount);
    window.location.href= payurl;
        }
        else{ 
            var x = document.getElementById("copied");
            x.className = "show";
            setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
       
        }
            
        }
        else if(payment==2){
             if( document.getElementById("amount").value>199){
         var link="/manualsubmit?am="
         var amount=document.getElementById("amount").value;
         var payurl=link.concat(amount);
    window.location.href= payurl;
        }
        else{ 
            var x = document.getElementById("copied");
            x.className = "show";
            setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
       
        }
        }
    }

</script>

</body></html>