
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
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:login.php");
    exit;
}

require_once "config.php";
$sql = "SELECT  nickname FROM dbo.users WHERE username='".$_SESSION['username']."'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);

if ($_SERVER['REQUEST_METHOD'] == "POST"){
 
        $nickname = trim($_POST['nick']);
  
    


if(!empty($nickname))
{
   
$sql = "UPDATE dbo.users SET nickname= '$nickname' WHERE username='".$_SESSION['username']."'";


$conn->query($sql);
if ($conn->query($sql) === TRUE) {
     header("location: main#");
} else {
     header("location: main#");
}
   


}
else{
      header("location: main#"); 
}
$opt="SELECT SUM(amount) as total FROM dbo.bonus WHERE usercode='".$_SESSION['usercode']."'";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']==""){
    $bonus="0.00";
    
}else{
    $bonus=round($sum['total'],2);
}
}
$sql = "SELECT  balance FROM users WHERE username='".$_SESSION['username']."'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$balance=round($row['balance'],2);
echo ""

?>

<html lang="en" translate="no" data-dpr="1" style="font-size: 38.56px;"><head>

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
<link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-wallet-d4d609cb.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-login-c581a4df.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-login-1f545390.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-test-b23bed1b.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-test-b38d710a.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-promotion-db066b5a.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-main-eac2089d.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-main-8cf260fb.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-promotion-24bf6ab6.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-wallet-24fc13b6.css"></head>
<body style="font-size: 12px;">
<div id="app" data-v-app=""><!----><!----><div data-v-c32a0642="" class="Recharge__box" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div data-v-c32a0642="" class="Recharge__container"><div data-v-4c21fa9e="" data-v-c32a0642="" class="navbar"><div data-v-4c21fa9e="" class="navbar-fixed" style="background: rgb(247, 248, 255);"><div data-v-4c21fa9e="" class="navbar__content"><div data-v-4c21fa9e="" onclick="window.location.href='/main#';" class="navbar__content-left"><i data-v-4c21fa9e="" class="van-badge__wrapper van-icon van-icon-arrow-left"><!----><!----><!----></i></div><div data-v-4c21fa9e="" class="navbar__content-center"><!----><div data-v-4c21fa9e="" class="navbar__content-title">Deposit</div></div><div data-v-4c21fa9e="" class="navbar__content-right" style="display:none;"><div data-v-c32a0642="" class="title">Deposit history</div></div></div></div></div><div data-v-d42c1f7a="" data-v-c32a0642="" class="balanceAssets"><div data-v-d42c1f7a="" class="balanceAssets__header"><div data-v-d42c1f7a="" class="balanceAssets__header__left"><img data-v-d42c1f7a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAMAAABiM0N1AAAArlBMVEUAAAD/sjH/zRj/zR//1zbuR0f/zBb/zRf/zhr/zRn/+HfuSUn/zBn/+njvSUn/zCH/+Xf/+XX/+HT/+nj/zBn/zRr/pSL/20H/2T3/1Db/zBf/30j/1zn/7mP/8Gb/3UT/9nL/9W//8mn/82z/7GDuSEj/+Xf/0zP/5lX/5FL/4Uz/6Vv/6Fj/40//613/+HT/vTT/2033kj3/xzz+yzX/rSj/sSr/0kH/sSz/rym/OY7sAAAAFnRSTlMAIsBCE+/v3IFxkZGRgYEy7+/v7rBhR1ORgAAAAh9JREFUWMPtkuly2jAQgA3hyJ2e1BKyMYGC7dbYXEn6/i/W1QqNughsI03+dPIh7SXzDSMcfPD/czXsQfTmqcv5tb+md88lHV/PzYAjXd/L4ZorD02nyw1D98u55oQb98uhDHpOl9PlFvcOl/ONn+Lp4ssZWA6XV+D70DI0vwIPnxZOfL2lnttFA6VV6vqBiL6UNouyFZ+JKDlNWSY1HA6pyB0qmgIJbJOxSnAnZowBk4GK3KGimWI6lcEs7LDChP3hMQMVuUNFz4rZIet2Rqa6PJpSkROxLYrj5xi3A1Rk8BZFcSQXFpoYw+FAT2IcmIeIKHKHiubRfC43xkguDIAa6KkeSXSkIg+IaDVfwWi1khtrALKu1AEs1aisayq6gPV2PyJ0AsOv1qSVMfiI0rdRreh3W6pRa1Gqc0pHyHrUIErboS5om63ffEUv8L0K8vqcKCOk2Tn2UiSLelEz8hft8yzbnhMVRZHBByKEGvCO9ltI50R5cZLj+WvTv5YXuYE2lKpJ1JbxS71onI81WJGGVlW96AJeqz81Ig+Cf5l48D6iH8gEtiomWE90g6VusMOEWCJnbFGIERMl1DmUoVYUevBOIiFECAFPhGyELDDgR00EgqXujkTCAyJiMGAQIApmSgOjpQ7MEl2KMCUR7ZgzOyLasCVjyyUsCTMBUYeqx83wXLEhov5mt3Rit+kT0eNPZ+4Cwl3fTdN/DD5oy19QoJEcy1l/8AAAAABJRU5ErkJggg=="> Balance</div></div><div data-v-d42c1f7a="" class="balanceAssets__main"><p data-v-d42c1f7a="">₹<?php echo $balance?></p><img data-v-d42c1f7a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFkAAAA7CAMAAAAn6dbMAAAAOVBMVEUAAAD///////////////////////////////////////////////////////////////////////8KOjVvAAAAEnRSTlMAIN9AgO8QMM9gcKC/kK9Qj29ZmZoEAAAB7klEQVRYw93Y23LjIAwGYHE+OU5W7/+wO2M1/r31QAzBN6uLTqd0voAEyA79H6EWvhAurtZ0ypEvhy6qR+au6LGXPtrl63nW3BfFTy2zMnlfXFTTd9FD/9CepttF6IXmRxY60/xIQgeaH+m2fNBjow3ND++uTNpka81YFZs7L8jm18+RSedL5zoNZLo0PlrggXo8t5XWx1dGuNCVjnaiLfMwvSVaVQb/MI/TupFBJZzsDfmppshKNDmpIYL+WhbLShNUCrP+Vn5t0ko/Mn2kfTIN2RuFbSHOW/5EB8dsK7KMZmx0dop2GbSv93d7llEzd6weQcZfo6/mFTRkDOJQW4L8XlOVznykIaNmej/UK/2S27QVOp9k1Ay/nWQyvMVabyScfssBbTG+q3eWKXH9qimgD7LSWMsi42cZNFGDDpBR2tPWhHwslW3eui4c5Nc/fVw9A1VlUslUz2HcaZFRM0RNlmjRIokccOK+lEFvcpIkP+l7GXeA4z0sTZBBIx7NizbQMK1988Uq0RDd7hVFVjRKhw+PaJEG6dz6L3lCGqKdwM1EF+oMY8sjeWqGRb5uecyOs1lM+jUfRlucH4Zvo+1Nb9PoQ1zUbTQv2UzWLXdE39tY0n208x3fXfTRpuu7i555q96LZonXknFuFn8BRodWROohzGIAAAAASUVORK5CYII=" alt=""></div><div data-v-d42c1f7a="" class="balanceAssets__tip"><img data-v-d42c1f7a="" src="https://91dreamclub.com/assets/png/cip-7ed1a634.png" alt=""></div></div><div data-v-5aaf3cbf="" data-v-c32a0642=""><!----><div data-v-5aaf3cbf="" class="Recharge__container-tabcard"><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__items active"><div data-v-5aaf3cbf="" class="centers"><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__top"><img data-v-5aaf3cbf="" class="img" src="https://ossimg.91admin123admin.com/91club/payNameIcon/payNameIcon2_20230814220354nknu.png" alt=""></div><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__bot">UPI-APP <!----></div></div></div><div data-v-5aaf3cbf="" onclick="window.location.href='/bankpay#';" class="Recharge__container-tabcard__items"><div data-v-5aaf3cbf="" class="centers"><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__top"><img data-v-5aaf3cbf="" class="img" src="https://ossimg.91admin123admin.com/91club/payNameIcon/payNameIcon_20230814220427bfg8.png" alt=""></div><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__bot">UPI-Transfer <!----></div></div></div><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__items" style="display:none;"><div data-v-5aaf3cbf="" class="centers"><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__top"><img data-v-5aaf3cbf="" class="img" src="https://ossimg.91admin123admin.com/91club/payNameIcon/payNameIcon_20230814220511nays.png" alt=""></div><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__bot">PAYTM <!----></div></div></div><div data-v-5aaf3cbf="" onclick="window.location.href='/usdtpay#';" class="Recharge__container-tabcard__items"><div data-v-5aaf3cbf="" class="centers"><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__top"><img data-v-5aaf3cbf="" class="img" src="https://ossimg.91admin123admin.com/91club/payNameIcon/payNameIcon_202308142205192wpa.jpg" alt=""></div><div data-v-5aaf3cbf="" class="Recharge__container-tabcard__bot">USDT <span data-v-5aaf3cbf="">3%</span></div></div></div></div></div><div data-v-37666d52=""><div data-v-37666d52="" class="recharge"><div data-v-37666d52="" style="display:none;" class="title c-row p-l-15 c-row-middle"><div data-v-37666d52="" class="van-image" style="width: 20px; height: 20px;"><img src="data:image/png;base64,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" class="van-image__img"></div><span data-v-37666d52="" style="display:none;" class="m-l-10">Fast UPI</span></div><div data-v-37666d52="" style="display:none;" class="rechargeType"><div data-v-37666d52=""  class="customerBox"><div data-v-37666d52="" class="c-row"><div data-v-37666d52="" style="border-radius: 0.26667rem;" class="item c-row c-row-center"><div data-v-37666d52=""><div data-v-37666d52="" class="c-row c-row-center van-ellipsis name">E-PAY</div><input class="hw-20 radiobtn" type="radio" checked="checked" name="payment" value="2"  id="bonr"><div data-v-37666d52="" class="txt m-t-5">Amount:200 - 30K</div><!----></div><div data-v-37666d52="" class="icon"><i data-v-37666d52="" style="color: rgb(255, 255, 255); font-size: 14px;"><!----></i></div></div><div data-v-37666d52="" class="item c-row c-row-center" style="border-radius: 0.26667rem;"><div data-v-37666d52=""><input class="hw-20 radiobtn" type="radio"  name="payment" value="1" id="bonc"><div data-v-37666d52="" class="c-row c-row-center van-ellipsis name">FAST PAY</div><div data-v-37666d52="" class="txt m-t-5">Amount:300 - 50K</div><!----></div><!----></div><div data-v-37666d52="" class="item c-row c-row-center" style="border-radius: 0.26667rem;"><div data-v-37666d52=""><input class="hw-20 radiobtn" type="radio"  name="payment" value="4" id="bonb"><div data-v-37666d52="" class="c-row c-row-center van-ellipsis name">TB PAY</div><div data-v-37666d52="" class="txt m-t-5">Amount:200 - 30K</div><!----></div><!----></div><div data-v-37666d52="" class="item c-row c-row-center" style="border-radius: 0.26667rem;"><div data-v-37666d52=""><input class="hw-20 radiobtn" type="radio"  name="payment" value="5" id="bond"><div data-v-37666d52="" class="c-row c-row-center van-ellipsis name">EK PAY</div><div data-v-37666d52="3" class="txt m-t-5">Amount:500 - 100K</div><!----></div><!----></div><div data-v-37666d52="" class="item c-row c-row-center" style="border-radius: 0.26667rem;"><div data-v-37666d52=""><input class="hw-20 radiobtn" type="radio"  name="payment" value="" id="bona"><div data-v-37666d52="" class="c-row c-row-center van-ellipsis name">Right-Pays</div><div data-v-37666d52="" class="txt m-t-5">Amount:200 - 30K</div><!----></div><!----></div></div></div></div><div data-v-a6dc3363="" data-v-c32a0642="" class="Recharge__content"><div data-v-a6dc3363="" class="Recharge__content-quickInfo boxStyle"><div data-v-a6dc3363="" class="Recharge__content-quickInfo__title"><div data-v-a6dc3363="" class="title"><img data-v-a6dc3363="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAANlBMVEUAAAD/cXL/cXP/cHT/cXL/cHL/cHD/cnP/cXP/cHD/cXH/c3P/cXL/cnL/cXL/cXL/cXP/cXLtIiw8AAAAEXRSTlMA379AYCAQn88wkFDvgLBwkJqQ7/MAAADYSURBVEjH1dJLDoMwEAPQyYf8CKS5/2W7gCmqFWSQ2kp9qywMkjWWn7P9nReig4nkHeSNEAt8ED9dIWyxWsy9Cl78xQply2V9rLSC/jfdqrDqo2fywaz/nb9VIUGFdq1CfFVI9uBJBWRGJ4x63cLzWAHULAOTVpg6cvQKfLNHhbw/DouMmf1arbK8Vhh7yAk/zkcBUAGlIAAqAHOeD263woEpC3kKBkE5GATVYBC8AhyYqjfzGQZBeRgEFWEQVIJBMAEOTM2QpwoMgrIwCAoGQTk4MJWb/KEnEComr7MGPBMAAAAASUVORK5CYII=" alt=""><p data-v-a6dc3363="">Select channel</p></div></div><div data-v-a6dc3363="" class="Recharge__content-quickInfo__item item_active"><div data-v-a6dc3363="" class="other"><div data-v-a6dc3363="">UPI-ALL Pay</div><div data-v-a6dc3363="">Balance:200 - 50K</div><!----></div></div><div data-v-a6dc3363="" class="Recharge__content-quickInfo__item" style="display:none;"><div data-v-a6dc3363="" class="other"><div data-v-a6dc3363="">UPI-Win</div><div data-v-a6dc3363="">Balance:50 - 50K</div><!----></div></div><div data-v-a6dc3363="" class="Recharge__content-quickInfo__item" style="display:none;"><div data-v-a6dc3363="" class="other"><div data-v-a6dc3363="">Mpay-India</div><div data-v-a6dc3363="">Balance:100 - 100K</div><!----></div></div></div><!----><!----><div data-v-a6dc3363="" class="Recharge__content-paymoney boxStyle"><div data-v-a6dc3363="" class="Recharge__content-paymoney__title"><img data-v-a6dc3363="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAMAAADVRocKAAAAS1BMVEUAAAD/cXL/cXL/cXL/cXP/cXL/cID/cHD/cnL/cHD/cHj/cnT/cXP/cXL/cXH/cnP/cHL/c3P/cHP/cHD/cnP/cHX/cXP/cnL/cXJIiAqNAAAAGHRSTlMA79+gv4AQEGAgIEDPcJCPYFBQMK8wkK/DVpbzAAAC9ElEQVRo3u2Z27ajIAyGk4goHmq17S7v/6SzXE0noxWQDdzM6n+5l5svJ2Ji4auvvoqXHu9KVTMUUq/sS9RBfvUT2r/CR/bQKLsRdnlDg3avCnLpVqM9ki4UmstyfQGXHKF57oxXfQMAlV3VQqJMvT+9Xk8XQO7Q9MASQGrJi9TMxucA6H1oiEOTBaBbR2gyAcZ9aFo2Pg9Ab61HDk02gCZvaNIBdzlejWx8TkAroTHAygogNp5DkxcgDtQABQDyXwTFAINddS0H4LdIacB6HfppQBspVNN8CiCtLl5Ud2HAjDZB1AYA6apLA2xVGmCn0gA7lwagdgOKJtqWdsHmU18a8FMaMJQGYBTgeHZpRh8hBjCCQ3UaILzHNMUBaTkI998xtqNah8ZDH7QnBWQKlSmSWsVllxuAdWgixLTLK2HxJA3VuJgGoLn14zMKSA2EZW7bp5bn+fgY+JVMFfOKeSiU4eWsFjoFWB3o0HHR/GouZ9uzCrWK6KYmUvsy92zJ1Tr34lC1WgjZAN2EVlR1pwnkCFGou0xa9gG/1gcNCfDQ/OHAMnaioTNlaioOAB6tSY/DM+jBX18CgPAXwo7Pd/mgQlkIELQzBqTZhYDIv0BN/NTbY/yYxpUN6T5rd4DeE58ZOGX/3N9OXAiJVqmxc6yliusF5U/ygm0wonfrYwcUvKoZ9XrgsJuVVcJs2lorm/UN7SS1Lwv3mDA6Vpuxu3/fG9rEaLYR2gGG7X25ii/SjMEkAHB3X2rxRRxuEkL0UQAD+8LFGj3WKA/AcMVcJTnxgB/3RHTjfNbcoH4XosWRZLb7gXK+JPkRcdHAVaZ87qsw9bAt04Q9ud2ezybfxS1JuChmuOY+Q2+7DTdYVmyrOHifXSQUdwbVu2bXJX1IMHyP2e5l03kMh/GkKs9wRXfOq1IfBlHCku8dGwhiOhEu4JAhT0WE3zfye4NTN/JX3JUChw+Xno/3+RC/FyUN6j8ek9IXGrwYyK/mWike3xv46j/RH4+wbTO2s0jgAAAAAElFTkSuQmCC" alt=""><p data-v-a6dc3363="">Deposit amount</p></div><div data-v-a6dc3363="" class="Recharge__content-paymoney__money-list"><div data-v-a6dc3363="" id="500" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 1K</div><div data-v-a6dc3363="" id="1000" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 3K</div><div data-v-a6dc3363="" id="2000" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 5K</div><div data-v-a6dc3363="" id="5000" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 10K</div>
<div data-v-a6dc3363="" id="10000" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 30K</div><div  id="20000" data-v-a6dc3363="" class="Recharge__content-paymoney__money-list__item"><span data-v-a6dc3363="">₹</span> 50K</div></div><!----><div data-v-a6dc3363="" class="Recharge__content-paymoney__money-input"><div data-v-a6dc3363="" class="place-div">₹</div><div data-v-a6dc3363="" class="van-cell van-field amount-input" modelmodifiers="[object Object]"><!----><!----><div class="van-cell__value van-field__value"><div class="van-field__body"><input type="tel" maxlength="5" autocomplete="off"  id="amount" class="van-field__control" placeholder="Please enter the amount"><!----><!----><!----></div><!----><!----></div><!----><!----></div><!----><div data-v-a6dc3363="" class="place-right" style="display:none;"><img data-v-a6dc3363="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAMAAADVRocKAAAAPFBMVEUAAABoaGhoaGhmZmZnZ2dmZmZmZmZwcHBmZmZnZ2doaGhnZ2dmZmZmZmZmZmZpaWlmZmZgYGBnZ2dmZmbTzN1eAAAAE3RSTlMAXyDvv3DfEK+fQN+AUM8wkBDPjWztQAAAAuRJREFUaN7tWduu4yAM5H4LNO3p///rbkO1PNhh4BBVWql+aomZwWMSLhZf+9rHTMkcjXPPv6adCbnsF4J7G/STmA5SXYNunqdmljlS1M++RbUCb5og5i6LOsD8nuzd6HUKFf4pYZmU7tasUdj3GLfsz6fW9qbI88M378Gnvl95+zk1P/wKDy3VKLSdwb/XPnLMW26TMvkadvDDesapDurGh4wlvakhfHfMncmkqW001f4Y/w/rieO+YZXCge/FtD0OBoPcMsCHDHeQLISPGWxXSI3yizOte90dcIAMup+GDELEZrsI6vj0iiULPQ0iTgBO9Euk0AlAikWTL5R0HoBYNnOWZ8VRF+1Kd7z0eToLIXLMjqhG9NBcCPEkADJaTfJC9N4EE4L2rPPGtTYG/iGVcGPfBVOBMAN+lN9iU4UUgBmkfrweeOpeWTEQFs8wGoXWhqFoI/0iBWa67AIwDOKLvc1e0oQZaAM1TRJaWgowA8XHUzK31RQwtD9gZ5i5HGOG9hN5RxJTEgMMGJ9X3LVJBBgAfnttHUm7FyMMLD4mePUSyCTGp3i0ATNI8b8STEpEZpFaSTL9YGtAsDRNdzKLDFn7ll60RF60CPrgTwVdED77sZPLn2uguLp+wdk/sGR+dNG3V29bJNgszW+86CaOsmYAM0FtWN0caS0UBDO42sodrhLxxdt3zQ5KDR5AND6AbJ0DCD76lE3z+O154XAUOL2tmDs9bKfrjrGqc0r3a/iqBtC5yghrBJEGQK8yFsyC+01zxXXOhhycWkgAGqAFV4fowhJLfAcMED8jNwMYAH4YvDq8/fJi9scvXBIvXUivX47PXEg/wmRlxtcOZjxzuZZNRgsU+nC//6LE4tJoLYxKilNdwy4QvvpxemKZqlCnfX12TzB8UJkZLNQFMHxIUUuNNu3+aFVFtlIjqoVhir7pmJYr1b1yr/XXVMP5gjVBX7G95GDcweOciVkq8bWvfcr+APQTXgFY+Cs5AAAAAElFTkSuQmCC" alt=""></div></div><!----></div><div data-v-a6dc3363="" class="Recharge__content-waitPay boxStyle" style="display: none;"><img data-v-a6dc3363="" src="https://91dreamclub.com/assets/png/tip-0498e3f9.png" alt=""><div data-v-a6dc3363="" class="wait_text">You have 1 unpaid order</div><div data-v-a6dc3363="" class="Recharge__content-waitPay__countdown"><span data-v-a6dc3363="">3</span><span data-v-a6dc3363="">0</span><span data-v-a6dc3363="">:</span><span data-v-a6dc3363="">0</span><span data-v-a6dc3363="">0</span></div><div data-v-a6dc3363="" class="go_pay">Go pay</div></div><!----><!----></div><div data-v-c32a0642="" onclick="srcp()" class="Recharge__container-rechageBtn rechage_active">Deposit</div><div data-v-9875b8ec="" data-v-c32a0642="" class="Recharge__container-intro"><div data-v-9875b8ec="" class="Recharge__container-intro__title"><img data-v-9875b8ec="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAMAAADVRocKAAAAP1BMVEUAAAD/cXL/cXL/cXL/cHD/cXL/cHP/cXP/cXT/cnP/cnL/c3P/cHj/cXP/cnL/cHj/cnL/cnL/cHL/cHD/cXJEdSoUAAAAFHRSTlMA799fIJBQv0Cfn1Agz3AQr4BwMGQ0OlkAAADtSURBVGje7dm5jgIxEIThPjz3sOxR7/+siwhABIzssSpAqj9z9EnuxHKbUupN83BxtBRpDWWgObfq9glnsto2BxXYgD4g/XAeu/cCcTyPQC9wfF0JMhBkYAYZGNjAxAacDUCAAAECBAgQIECAAAECBAgQ8BFAkAHPNsDXsVhbTcD31cyIwK8ZFfgxLrAaGShkYDUyMLKBv8cpHZVFNgCnfmn9FOCoLioBB1BOLEI8K4ELe8gDgIEJzAD8SgQsACxMIHHriwjY9BQ4QHHcWnYaYCPuLVshATY6urPDSpCAZ9lJRM26d/KeN5JS6qV/A1tBf8qroqkAAAAASUVORK5CYII=" alt=""><p data-v-9875b8ec="">Recharge instructions</p></div><div data-v-9875b8ec="" class="Recharge__container-intro__lists"><!----><!----><!----><div data-v-9875b8ec="" class="item"><p data-v-9875b8ec="">If the transfer time is up, please fill out the deposit form again.</p><p data-v-9875b8ec="">The transfer amount must match the order you created, otherwise the money cannot be credited successfully.</p><p data-v-9875b8ec="">If you transfer the wrong amount, our company will not be responsible for the lost amount!</p><!----><p data-v-9875b8ec="">Note: do not cancel the deposit order after the money has been transferred.</p></div><!----><!----><!----><!----></div></div><div data-v-60a0184e="" data-v-c32a0642="" class="record__main" payid="2" style="display: none;"><div data-v-60a0184e="" class="record__main-title"><img data-v-60a0184e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgBAMAAAAQtmoLAAAAJFBMVEUAAAD/cXL/cXL/cHL/cXP/cHj/cXL/////9vb/7e3/pqf/pqaEf2fZAAAABnRSTlMA799ftyBNH49qAAAAiElEQVRYw+3ToQ2AQAyF4TNMQMICl+BhAwyeEUB0BWACBAOQMAFsia3oNT0BIen7/Wea14DsFR2liwIYSGkUQE9aAqB8EJIBfA0aUooCqNVFCYDUAAAAAFLgmlmnARwcLAawcbAawM3B/osrAXgB+AcA74D1CqhyQWsHPAAvQF3UJAB1UWVA5h68Q9V5A73wNQAAAABJRU5ErkJggg==" alt=""><span data-v-60a0184e="">Deposit history</span></div><div data-v-91f2fefc="" data-v-60a0184e="" class="empty__container mgt40"><img data-v-91f2fefc="" alt="" class="" data-origin="https://91dreamclub.com/assets/png/empty-4ac9a431.png" src="https://91dreamclub.com/assets/png/empty-4ac9a431.png"><p data-v-91f2fefc="">No data</p></div><!----></div></div><!----><!----><div data-v-8a55a30e="" data-v-c32a0642="" class="dialog inactive"><div data-v-8a55a30e="" class="dialog__container" role="dialog" tabindex="0"><div data-v-8a55a30e="" class="dialog__container-img">
<img data-v-8a55a30e="" alt="" class="" data-origin="https://91dreamclub.com/assets/png/orderCancelWarn-ac58c333.png" src="https://91dreamclub.com/assets/png/orderCancelWarn-ac58c333.png"></div><div data-v-8a55a30e="" class="dialog__container-title"><h1 data-v-8a55a30e="">Invalid amount</h1></div><div data-v-8a55a30e="" class="dialog__container-content"><div data-v-c32a0642="" class="cancen_model_cnt">Please select another amount</div></div><div data-v-8a55a30e="" class="dialog__container-footer"><button data-v-8a55a30e="">Cancel</button><button data-v-8a55a30e="">OK</button></div></div><div data-v-8a55a30e="" class="dialog__outside"></div></div><!----><!----><div data-v-8a55a30e="" data-v-c32a0642="" class="dialog inactive"><div data-v-8a55a30e="" class="dialog__container" role="dialog" tabindex="0"><div data-v-8a55a30e="" class="dialog__container-img"><img data-v-8a55a30e="" alt="" class="" data-origin="https://91dreamclub.com/assets/png/forbhidden-a43247ed.png" src="https://91dreamclub.com/assets/png/forbhidden-a43247ed.png"></div><div data-v-8a55a30e="" class="dialog__container-title"><h1 data-v-8a55a30e="">You have been disabled from C2C transactions for 0 hours</h1></div><div data-v-8a55a30e="" class="dialog__container-content"><div data-v-c32a0642="" class="forbidden_tip">0 hours remaining</div><div data-v-c32a0642="" class="forbidden1">Because your transactions failed 0 times in a row</div><div data-v-c32a0642="" class="forbidden2">C2C recharge is prohibited within 0 hours</div><div data-v-c32a0642="" class="forbidden3">If you have any questions, please contact customer service</div></div><div data-v-8a55a30e="" class="dialog__container-footer"><!----><button data-v-8a55a30e="">Sure</button></div></div><div data-v-8a55a30e="" class="dialog__outside"></div></div></div><div class="customer" id="customerId" style="--36a344b0: 'Roboto', 'Inter', sans-serif; --17a7a9f6: bahnschrift;"><img onclick="window.location.href='/keFuMenu#/'" class="" data-origin="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png" src="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png"></div><!----><!----></div>
<script>
                var fivehundred = document.getElementById("500");
    var thousand = document.getElementById("1000");
    var twothousand = document.getElementById("2000");
    var fivethousand = document.getElementById("5000");
    var tenthousand = document.getElementById("10000");
    var twentythousand = document.getElementById("20000");

    fivehundred.onclick = function(){
        document.getElementById("amount").value="1000";
    }
    thousand.onclick = function(){
        document.getElementById("amount").value="3000";
    }
    twothousand.onclick = function(){
        document.getElementById("amount").value="5000";
    }
    fivethousand.onclick = function(){
        document.getElementById("amount").value="10000";
    }
    tenthousand.onclick = function(){
        document.getElementById("amount").value="30000";
    }
    twentythousand.onclick = function(){
        document.getElementById("amount").value="50000";
    }
              </script><script>



    function srcp(){
        p=document.getElementById("bonc").checked;
p1=document.getElementById("bonr").checked;
p2=document.getElementById("bona").checked;
p3=document.getElementById("bonb").checked;
p4=document.getElementById("bond").checked;
if(p){
  var payment=1;  
}else if(p1){
    var payment=2;
}else if(p2){
    var payment=3;
}else if(p3){
    var payment=4;
}else if(p4){
    var payment=5;
}
        if(payment==1){
        if( document.getElementById("amount").value>299){
         var link="/FAST-PAY?am="
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
         var link="/EKPAY?am="
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
        else if(payment==3){
             if( document.getElementById("amount").value>199){
         var link="/RIGHT-PAY?am="
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
        else if(payment==4){
             if( document.getElementById("amount").value>199){
         var link="/TB-PAY?am="
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
        else if(payment==5){
             if( document.getElementById("amount").value>499){
         var link="/EKPAY?am="
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

</script><style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
.mian .selectBox .recharge-btn[data-v-37666d52] {
    width: 70%;
    height: 1.06667rem;
    font-size: .4rem;
    margin: 0 auto;
    border: 0.02667rem solid #02a0da;
    color: #fff;
    background-color: #02a0da;
    box-shadow: 0 0 0.21333rem 0.02667rem rgba(2,160,218,.72);
}
</style>
</body></html>