
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

 require_once "config.php";
 
 $username=$_GET["user"];
 
  $optrec="SELECT SUM(recharge) as total1 FROM dbo.dbo.recharge WHERE username='$username' AND status='Completed'";
$optresrec=$conn->query($optrec);
$sumrec= mysqli_fetch_assoc($optresrec);
if($sumrec['total1']==""){
    $recbal=0;
    
}else{
    $recbal=$sumrec['total1'];
}
  $optwith="SELECT SUM(withdraw) as total11 FROM dbo.dbo.record WHERE username='$username' AND status='Completed'";
$optreswith=$conn->query($optwith);
$sumwith= mysqli_fetch_assoc($optreswith);
if($sumwith['total11']==""){
    $withbal=0;
    
}else{
    $withbal=$sumwith['total11'];
} 
 
 $sql = "SELECT balance,nickname,withdraw FROM dbo.users WHERE username='$username'";
$resultu = $conn->query($sql);
$rowu = mysqli_fetch_array($resultu);
$nickname=$rowu['nickname'];
$withdraw=$rowu['withdraw'];
$balance=$rowu['balance'];
 
 
 
// Assuming $usercode is retrieved from some source like $_POST or $_SESSION
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';

// Now you can use $usercode in your SQL query
$opt = "SELECT count(*) as total FROM dbo.users WHERE refcode='$usercode'";
 
//$opt="SELECT count(*) as total FROM dbo.users WHERE refcode='$usercode' ";
$optres=$conn->query($opt);
$sum= mysqli_fetch_assoc($optres);
if($sum['total']==""){
    $users="0";
    
}else{
    $users=$sum['total'];
}
 $aopt="SELECT count(*) as atotal FROM dbo.users WHERE refcode='$usercode' AND balance>0 ";
$aoptres=$conn->query($aopt);
$asum= mysqli_fetch_assoc($aoptres);
if($asum['atotal']==""){
    $ausers="0";
    
}else{
    $ausers=$asum['atotal'];
}

$opt1="SELECT SUM(balance) as total1 FROM dbo.users WHERE refcode='$usercode'";
$optres1=$conn->query($opt1);
$sum1= mysqli_fetch_assoc($optres1);
if($sum1['total1']==""){
    $tbal=0;
    
}else{
    $tbal=$sum1['total1'];
} 



  
$query = "SELECT *FROM dbo.users WHERE refcode='$usercode'  ORDER BY id DESC ";  
$result = mysqli_query($conn, $query);  
  
//display the retrieved result on the webpage  
while ($row2 = mysqli_fetch_array($result)) {
    $date=date( 'd-m-Y',strtotime($row2[5]));
        $opt13="SELECT SUM(recharge) as total1 FROM dbo.dbo.recharge WHERE username='$row2[1]' AND status='Completed'";
$optres13=$conn->query($opt13);
$sum13= mysqli_fetch_assoc($optres13);
$dataRow = '';
if($sum13['total1']==""){
    $st="Not Active";
    
}else{
    $st="Active";
} 
    $dataRow = $dataRow."
             <tr>
                        <td>$row2[4]</td>
                        <td>91$row2[1]</td>
                        <td>$st</td>
                        <td>$date</td>
                    </tr>
             

";
    
}


$query8 = "SELECT *FROM dbo.users WHERE  refcode1='$usercode' ORDER BY id DESC ";  
$result8 = mysqli_query($conn, $query8);  
  
//display the retrieved result on the webpage  
while ($row28 = mysqli_fetch_array($result8)) {
    $date=date( 'd-m-Y',strtotime($row28[5]));
        $opt138="SELECT SUM(recharge) as total1 FROM dbo.dbo.recharge WHERE username='$row28[1]' AND status='Completed'";
$optres138=$conn->query($opt138);
$sum138= mysqli_fetch_assoc($optres138);
$dataRow8 = '';
if($sum138['total1']==""){
    $st="Not Active";
    
}else{
    $st="Active";
} 
    $dataRow8 = $dataRow8."
             <tr>
                        <td>$row28[4]</td>
                        <td>91$row28[1]</td>
                        <td>$st</td>
                        <td>$date</td>
                    </tr>
             

";
    
}

 
$query = "SELECT *FROM dbo.users WHERE refcode='$usercode' ORDER BY id DESC ";  
$result = mysqli_query($conn, $query);  
  
//display the retrieved result on the webpage  
while ($row2 = mysqli_fetch_array($result)) {
    $user=$row2[1];
    $opt1="SELECT SUM(recharge) as total1 FROM dbo.dbo.recharge WHERE username='$user' AND status='Completed'";
$optres1=$conn->query($opt1);
$sum1= mysqli_fetch_assoc($optres1);
$data = '';
if($sum1['total1']==""){
    $rbal=0;
    
}else{
    $rbal=$sum1['total1'];
} 
    //$data = $data+"$rbal";
    $data .= "$rbal";
}



$query5 = "SELECT *FROM dbo.users WHERE refcode='$usercode' ORDER BY id DESC ";  
$result5 = mysqli_query($conn, $query5);  
  
//display the retrieved result on the webpage  
while ($row25 = mysqli_fetch_array($result5)) {
    $user=$row25[1];
    $opt15="SELECT SUM(withdraw) as total1 FROM dbo.dbo.record WHERE username='$user' AND status='Completed'";
$optres15=$conn->query($opt15);
$sum1= mysqli_fetch_assoc($optres15);
$data5 = '';
if($sum1['total1']==""){
    $wbal=0;
    
}else{
    $wbal=$sum1['total1'];
} 
    //$data5 = $data5+"$wbal
    $data5 .= "$wbal";        
             

    
}
$optu = '';
$optu = "SELECT SUM(amount) as total FROM dbo.betting  WHERE username='$username'";
$optresu=$conn->query($optu);
$sumu= mysqli_fetch_assoc($optresu);
$red=round($sumu['total'],2);

$optg="SELECT SUM(amount) as total FROM dbo.beconebetting  WHERE username='$username'";
$optresg=$conn->query($optg);
$sumg= mysqli_fetch_assoc($optresg);
$green=round($sumg['total'],2);

$optv="SELECT SUM(amount) as total FROM dbo.saprebetting  WHERE username='$username'";
$optresv=$conn->query($optv);
$sumv= mysqli_fetch_assoc($optresv);
$violet=round($sumv['total'],2);

$opt0="SELECT SUM(amount) as total FROM dbo.emredbetting WHERE username='$username'";
$optres0=$conn->query($opt0);
$sum0= mysqli_fetch_assoc($optres0);
$zero=round($sum0['total'],2);

$sql = "SELECT  balance FROM dbo.users WHERE username='".$_SESSION['username']."'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$balance=round($row['balance'],2);
echo ""

?>
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
<link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-wallet-d4d609cb.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-login-c581a4df.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-login-1f545390.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-test-b23bed1b.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-test-b38d710a.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-promotion-db066b5a.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-main-eac2089d.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-main-8cf260fb.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-promotion-24bf6ab6.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-wallet-24fc13b6.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/home-c9e2cd52.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/activity-46c093bd.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/promotion-5577fd39.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/wallet-d91dc187.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/main-b43b53ed.js"></head>
<body style="font-size: 12px;">
<div id="app" data-v-app=""><!----><!----><div data-v-8a579e82="" class="wallet-container" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div data-v-8a579e82="" class="wallet-container-header"><div data-v-4c21fa9e="" data-v-8a579e82="" class="navbar"><div data-v-4c21fa9e="" class="navbar-fixed wc" style="background: linear-gradient(90deg, rgb(249, 89, 89) 0%, rgb(255, 154, 142) 100%);"><div data-v-4c21fa9e="" class="navbar__content"><div data-v-4c21fa9e="" class="navbar__content-left" style="display:none;"><i data-v-4c21fa9e="" class="van-badge__wrapper van-icon van-icon-arrow-left"><!----><!----><!----></i></div><div data-v-4c21fa9e="" class="navbar__content-center"><!----><div data-v-4c21fa9e="" class="navbar__content-title">Wallet</div></div><div data-v-4c21fa9e="" class="navbar__content-right"></div></div></div></div><div data-v-8a579e82="" class="wallet-container-header-belly"><img data-v-8a579e82="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAACgCAMAAAC8EZcfAAAAaVBMVEUAAAD////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8G612AAAAInRSTlMAZkAmxmDucBAMv7J5Lh8Z1p9ZUUs5jn+qM8UG45b137yA+ifzJQAAAt1JREFUeNrt2oluozAQgOEZJ9iY+wgJ5Gzn/R9yl2alqNqEs/FMJX9P8MuDLYMAz/M8z/M818K0rlUKQoUm0tS7lRnIo/aaHqQlhgdN3+kaxAiDiJ4wIEM/2ucU8AsPBb2kQ+AVqogGfQKjx2hFLmF4+G/xJO0TFdE0MTB4jHbcDVwLTURzgFsq0kRiA9NDXyc18D5asYGq1ERiA7Ov0UoNvI9WbODXkSc28H4HFRtY96OVG2g0keDALCKSHBhoEh14IBIdeCDZgTXJDsxuwgNLkh2YkfDAUnhgRsIDA+mBkfRALTwwJeGBSnpgTc/oc7FdbPNEntsf28RFuzf4DrsmXx+oY4NvVCm7KlCX+HbKLg68xuhEtzBQJ+hIZZcEHg06E6TzA2N0qpsbGKNj3bzAIzq3mROoDToXhDMCE2RQnSYHxsiimxqokYmdGFgik920QI1s7KTAEtk0kwITZBNMCSyQUT4hsEVGzYTAPTLaTQhETgGM2iErC2MaZJWvCTSxppnOLc6TwZjN674zzbTg5rZZEXikRbauAhNayDgKvNBCFx94Z2ihxG+Sf4ymBc5ujpm79kwz6digm8Dlfnfgvt1+1+6DUExg8nGlJ25GSGB8pRcOEgKTgl6r+QMTTQMK/sAzDUq5A2MaFjAHJiQ88Cg8MCHhgRfpgR/SAwsf6AP9JhlWSg80V+GB+CE9MLkKD8SWhtXcgXgUfmEdKbzxX/mHL9WBhEDca3rhU8JrZ68s6Akt5cW9l1zi7TdtKejTx2/4eOQDfaAP9IGuZTAmR1Y5jLHIKoQxJ2QF4ypkVMM4hYwUgOxtvAGQ/RBaANG/9uzgL8knYQYgegkrANlLuAEQvYQ7mMoGyCCwMFmKDFJ4kPiTXgNfxD6GO5jnVKNT9Ql6YqesTjBfh86ksIit0Ikqh6U6B4lBByvYzZsTg+4EK+XqbY1Vk8OPsFnaqB/WpJkFz/M8z/O8tf4AbNgTpaPK6qwAAAAASUVORK5CYII=" alt=""><div data-v-8a579e82="">₹<?php echo $balance?></div><span data-v-8a579e82="">Total balance</span><div data-v-8a579e82=""><div data-v-8a579e82=""><p data-v-8a579e82="" class="total">₹<?php echo $withbal;?></p><p data-v-8a579e82="">Total withdraw amount</p></div><div data-v-8a579e82=""><p data-v-8a579e82="" class="total">₹<?php echo $recbal;?></p><p data-v-8a579e82="">Total deposit amount</p></div></div></div></div><div data-v-8a579e82="" class="wallet-container-content"><div data-v-8a579e82="" class="container"><div data-v-8a579e82="" class="progressBars"><div data-v-8a579e82="" class="progressBarsL"><div data-v-8a579e82="" class="van-circle"><svg viewBox="0 0 1100 1100"><defs><linearGradient id="van-circle-0" x1="100%" y1="0%" x2="0%" y2="0%"><stop offset="0%" stop-color="#FA5A5A"></stop><stop offset="100%" stop-color="#FF998D"></stop></linearGradient></defs><path class="van-circle__layer" d="M 550 550 m 0, -500 a 500, 500 0 1, 1 0, 1000 a 500, 500 0 1, 1 0, -1000" style="fill: none; stroke: rgb(216, 216, 216); stroke-width: 100px;"></path><path d="M 550 550 m 0, -500 a 500, 500 0 1, 1 0, 1000 a 500, 500 0 1, 1 0, -1000" class="van-circle__hover" stroke="url(#van-circle-0)" style="stroke: url(&quot;#van-circle-0&quot;); stroke-width: 101px; stroke-linecap: butt; stroke-dasharray: 3140px, 3140px;"></path></svg><div class="van-circle__text">100%</div></div><h3 data-v-8a579e82="">₹<?php echo $balance?></h3><span data-v-8a579e82="">Main wallet</span></div><div data-v-8a579e82="" class="progressBarsR"><div data-v-8a579e82="" class="van-circle"><svg viewBox="0 0 1100 1100"><defs><linearGradient id="van-circle-1" x1="100%" y1="0%" x2="0%" y2="0%"><stop offset="0%" stop-color="#FA5A5A"></stop><stop offset="100%" stop-color="#FF998D"></stop></linearGradient></defs><path class="van-circle__layer" d="M 550 550 m 0, -500 a 500, 500 0 1, 1 0, 1000 a 500, 500 0 1, 1 0, -1000" style="fill: none; stroke: rgb(216, 216, 216); stroke-width: 100px;"></path><path d="M 550 550 m 0, -500 a 500, 500 0 1, 1 0, 1000 a 500, 500 0 1, 1 0, -1000" class="van-circle__hover" stroke="url(#van-circle-1)" style="stroke: url(&quot;#van-circle-1&quot;); stroke-width: 101px; stroke-linecap: butt; stroke-dasharray: 0px, 3140px;"></path></svg><div class="van-circle__text">0%</div></div><h3 data-v-8a579e82="">₹0.00</h3><span data-v-8a579e82="">3rd party wallet</span></div></div><div data-v-8a579e82="" class="recycleBtnD" style="display:none;"><button data-v-8a579e82="" class="recycleBtn">Main wallet transfer</button></div><div data-v-8a579e82="" class="userDetail"><div onclick="window.location.href='/recharge#';" data-v-8a579e82=""><div data-v-8a579e82="" class="imgD"><img data-v-8a579e82="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAAAjVBMVEUAAAD3eAD3dwD4dgD5dwD2dgD4dgD0bwD4eQD4dwD4dwD4dwD7dwD5dwD2dgD5dgD4dwDtcQD5dgD2eAD5dwD4dwD4dwD4dwD4dwD4eAD3eAD4dgD/dAD3dQDqbgD5dwD3dgD4dwD5eQD5dwD5dwD4dwD5dwD6dgD4dwD4dgD6eQD7dgD4eAD2dAD4dwAMGSgcAAAALnRSTlMAZsyZxU2mEkxrQN9yn3OMcg19OfPqv6+UWTImHxoI0YZULfiE2HlfuI9fQnM4FNyjywAAAtFJREFUaN7s1u9ymkAUBfDdPYBDKAERkdZ/WFF0THn/x2sTSy5JENiF64eMvxc4c+7smVnx8PDw8O1N7chJlEqcQP6airuZykTV4Oda3IVdxRLsJoKdVA32sf9b8HpWDbzyn20hGEnVJC7feP5KMLFVk235zn8SHNaJajIva7yCoXbQUpjE/or30PS0vhj5jS9Uo33ZwF/dvTBFMxeOyxu8grXwobztPGEsPC9beCuGwrQl3mRH52mR7cBrb/4ojS3VnYW5pR3ipFmYPAlDsxCArzS3RBLD2AyvFi1b4qi8DnFlaW+JqEj7gV1Q0d8SmQO23ksOUUn0C5M9AFej9CRDxTfZEnEA5BODXNMtUTAla+XCMtsSBVOyRu6wLVEw8o3oFoIYPi2C/0LRyUaNY7glmlPl0nlo1J0GFvZQ6fwYRCCmWyIW0PPYM9QtzLZEFiBL0SZDnTWwcIyacHDhQ9nXAehZ+QfG2xJdurvyBF+elnXynU+sHraHuLo02fS89Mlyghdp7JimKT649Lt0cHTlUMeg361BqOswL7XWZ3HDEpU0kmS81uuu787ZlSNy30vPRLMdrnJXjivC1U40c/GGzjx2ctH6qHPJIMer57bgQLIIuoJTV7Io0o7gSDIJ24MzySZqDXYlGzdtCc4ko+PfdukYx2EQCsLwmwI50ESsKyAgmWJX8v0PuE2aFOPYjqeJ+C7wa6TZCHsIeR6+Q+pOw7+Q+qFhDynPwh5inoT/ILaS8AKxhYQdXn1P+DbCI/w0wiM8wiO8OxxAqMMzxAIJd4jNJFwg1kl4gtiDhBvEJiMStIwJkLoZ0yE1GxMhVY1yEErGZQgF4xqEJiPIr8Wf1t+r2qYMkWDbWoJEivbGBIlib3UIZNshi7tcFne5mnChtdtuMeAyLtoR0eESqdhRMayfr612yiMsOG11vdl5rZYc3HJkfEouzCXaMAzDt/kHbN7wdhAVLO0AAAAASUVORK5CYII="></div><span data-v-8a579e82="">Deposit</span></div><div onclick="window.location.href='/withdrawal#';" data-v-8a579e82=""><div data-v-8a579e82="" class="imgD"><img data-v-8a579e82="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAAAXVBMVEUAAABcpf9cpv9bpv9cpv9cpv9dpv9cpv9bpf9dpv9ZpP9cpv9cp/9cpf9bpP9Yp/9cp/9ZoP9cpv9cpv9cp/9Ypf9Ynf9Onf9cpv9cpf9bpf9dpv9fpP9ao/9cpv/+vZV2AAAAHnRSTlMAZoxfTb9Z3yY/H/DFeXAazxGWj4I5DQbZvJ9wRkB5MVsiAAABcklEQVRo3u3T3XKCMBCG4Q0/ASMoiIBa3fu/zHac2nQwESzZHHS+5zAHvGwWCAAAAOBJm3Z5wasUeZe19J5NzoHk6TvZhgMqlqZNzoFdzKJxtxxcsaFZKYtIV3RFyxsW8/K2TcFitob8Liwoj77g+csuWFQReeD5kXN2kd+yYXEtuWQsLiWXjsV1cVds5TF/pvkfiiNAGOEHhP9ZWEWAMMIPCCOMMMIII4zwD4QRRhhhhBH2ho+JZU93iUsdLnzY8i/bw3e2YbdqFyhc88TxflyxT7M+7C6c7eu47cKETzxxUl8S9kvChM9PS7yvmP3qv4X19JN2P7dhn0rN0eSSLfyqK3ZrPtScjFx69SSxjva0Tlxs1q8nl1KJM+QyKnEjeZYsLCO3vRJWkodWojRR/JHtwPG3fCO/IVVi9EBWzMtu6aVSWYILli/b7qxWq+D0nhYYbiqwbKBlSh00u6flzDVy1hpNn+mVm7325UgAAAAAU5/94mxKVD2pxAAAAABJRU5ErkJggg=="></div><span data-v-8a579e82="">Withdraw</span></div><div data-v-8a579e82="" onclick="window.location.href='/rechargerecord#';"><div data-v-8a579e82="" class="imgD"><img data-v-8a579e82="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAACgCAMAAAC8EZcfAAAAbFBMVEX6WloAAAD5WFj7WFj6WVn/W1v7Wlr6Wlr7W1v6Wlr6XFz6Wlr5WFj8W1v6WVn6WVn5WVn/VVX7W1v+XV36WVn4WFj6W1v5WVn5WVn7Wlr6W1v8XFz7WVn9XV3/SUn6WVn6Wlr/XFz4WVn5WVlMptElAAAAI3RSTlNmAJ9AxQxNWXkzJRn1X9eOsgZGE+u8cOzigl9ZOSwHqZ8ycDPAW1MAAAL6SURBVHja7dzbbuMgFIXh5WBjAz47SZNOjvX7v+NI7QVSpwkQbGBm9n8bX3zCiVEks5ElHgEJ6BgBk4uABHSMgMnlBiwmeRbsM2ycAvtMCKmGTLcgcFAn/g7dZnZqA907P6mFgYPUOC+gbpTLAYe71nkDdSUrfIGatyhQxwp/4FnzlgeilJ7AYQTWBAJs8AEWJdYGoiwMQINvXaBZCINvZaBZCINvbaAWugM5QgHBXwEKhAPi7A4sEBLYFM5AFhQI7gpUCAuEcgSOoYHcDVggNBCTE5CFB96dgGV4YOMCVAgPhHIAihjAuwOQxwByByBiAJvBGjhFAWKyBso4QGkNFHGAJ2vgGAfIrIE8DpCnDiytgWXqQMQBgoAEJCABCbg2sO73+1udLnB7BIDqLVXgtgK+hGkCv3xfwhSBh0p/WB3SA7Z7QPdxSA2Y41t5WsAd/qhPCdjjh/p0gD1+rE8FeMWDrkkA6xsedksAWB/xpGMdDdjp7fdxelPpggNx0NubWbhFeGDVznNb2V4XAQjs97YXAhGALhHw5whIQAIaIiABCWiIgAQkoKG/Gdjt8mfturjAqp1NHaqYwMNsro0I7GabunjAnRVwFw+YWwFzWkHP72AVD4jewtcjIhDXNwOvvsbe6rrNs7o9QHsxQEACEtAQAQlIQEMEJCABn9a19fxqdV55AUvv/x1m4nHlN9E3s2f1x7rv8rezb1cPIIOx2bsc3xutgScYq1cACmugDHGLbx5HhiYY63x928rj0NXQRHnMLHvwD7d2XvZBzR2AAhESDkCFCCkzUNcgeGX2AJjKPWZOwAnBK2yAOo7AjdlDYBo/E/UQmMYSMvdRGg1CVtgCdWcE7J49ASZwk/lrA3F+IUDmgTjxhYaRQtGFpqFMsYTa5zUYjGHlxovnaDW56iI2Z//hdAXDWjXikvkANVGvYkieBpqT49I6Li8Lz8BUJ94shTsprTMCXbooKQTzSJzlVGSf/Z9jTs0RMLkISEDHCJhcBPzngb8BncLoIXGJNNsAAAAASUVORK5CYII="></div><span data-v-8a579e82="" >Deposit history</span></div><div onclick="window.location.href='/withdrawalrecord#';" data-v-8a579e82=""><div data-v-8a579e82="" class="imgD"><img data-v-8a579e82="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAMAAAANIilAAAAAYFBMVEUAAAD6Wlr5WFj7Wlr5WVn6WVn7W1v4WFj/VFT5WVn5WVn5WVn6WVn6WVn7W1v7WVn7W1v7WVn6Wlr/XFz5WFj7W1v/XV39XFz6WVn/Zmb5WFj5WVn5WVn6Wlr5WVn5WVnIvMgnAAAAH3RSTlMAZp9M2u0/vg2zcBnFjHlfWTkzMpZGLCYfCvVTz6h5gltZtQAAAP1JREFUSMft1d2OgjAQhuFOa1so8iciuO4u93+XcqBIMmP9Ih6o4T1/MikzCWrtFTlvh1nW97gtB1aJ2t5ybBN8MC8AMGvayks4PZldEqeGxrYS3tKYifAdURSPNQ8seQl7YlqypCW8p0sHyR7pWpBWRVPSux1NFZbZgqaMPPim9Wbebxpo1pHhjuD4q1scO4YNjtsl2Kz4K3CuWf8o9gPvJ4DYDkIaxKk0uQAx7TUrfMCqPhTPLywXMH5hfxzjF7bhGL+wlFn8wvI3X5Vb8rs54LhjOMFxolgGfzIvwwcL1ZhtlJiDP/WTs2t1t66K0ypTsXp3IrmyqjO1tqgzPZ0xAYt3JnkAAAAASUVORK5CYII="></div><span data-v-8a579e82="">Withdrawal history</span></div></div></div><div data-v-8a579e82="" class="gameList"><div data-v-8a579e82="" class="box select" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.25</h3><span data-v-8a579e82="">Lottery</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">TB_Chess</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">Wickets9</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">MG</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">JDB</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">AG_Video</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">TB</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">JILI</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">EVO_Video</span></div><div data-v-8a579e82="" class="box" style="display:none;"><h3 data-v-8a579e82="" class="money"> 0.00</h3><span data-v-8a579e82="">PG</span></div></div></div></div><div class="customer" id="customerId" style="--36a344b0: 'Roboto', 'Inter', sans-serif; --17a7a9f6: bahnschrift;"><img class="" onclick="window.location.href='/keFuMenu#';" data-origin="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png" src="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png"></div><div data-v-67fe8f9c="" class="tabbar__container" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div data-v-67fe8f9c="" onclick="window.location.href='/indexlogin.php/';" class="tabbar__container-item"><svg data-v-67fe8f9c="" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 46 44" class=""><circle cx="27" cy="28" r="18" fill="#FFF4F4"></circle><path fill="#FFCDCB" fill-rule="evenodd" d="m23.66 5.278-17.9 12.08v25.507h10.08v-10.44a5.04 5.04 0 0 1 5.04-5.04h6.36a5.04 5.04 0 0 1 5.04 5.04v4.38h-3.36v-4.38a1.68 1.68 0 0 0-1.68-1.68h-6.36a1.68 1.68 0 0 0-1.68 1.68v11.16a2.64 2.64 0 0 1-2.64 2.64H5.04a2.64 2.64 0 0 1-2.64-2.64v-26.61a2.64 2.64 0 0 1 1.163-2.188L22.437 2.05a2.16 2.16 0 0 1 2.382-.023L44.514 14.77a2.64 2.64 0 0 1 1.206 2.217v26.598a2.64 2.64 0 0 1-2.64 2.64H30.6v-3.36h11.76V17.379l-18.7-12.1Z" clip-rule="evenodd"></path><path fill="#FFCDCB" d="M32.4 44.545a1.68 1.68 0 1 1-3.36 0 1.68 1.68 0 0 1 3.36 0ZM32.28 36.745a1.68 1.68 0 1 1-3.36 0 1.68 1.68 0 0 1 3.36 0Z"></path></svg><!----><span data-v-67fe8f9c="">Home</span></div><div data-v-67fe8f9c="" class="tabbar__container-item" onclick="window.location.href='/activity#/';"><svg data-v-67fe8f9c="" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 46 44" class=""><circle cx="27" cy="24" r="18" fill="#FFF4F4"></circle><path fill="#FFCDCB" fill-rule="evenodd" d="M10.512 5.2h26.975a4.8 4.8 0 0 1 4.796 4.6l.51 12.2h3.203L45.48 9.666A8 8 0 0 0 37.489 2H10.511A8 8 0 0 0 2.52 9.666l-1.17 28A8 8 0 0 0 9.34 46h29.317a8 8 0 0 0 7.993-8.334L46.331 30h-3.203l.326 7.8a4.8 4.8 0 0 1-4.796 5H9.341a4.8 4.8 0 0 1-4.795-5l1.17-28a4.8 4.8 0 0 1 4.796-4.6Z" clip-rule="evenodd"></path><path fill="#FFCDCB" fill-rule="evenodd" d="M13.92 16.64c.466 5.158 4.8 9.2 10.08 9.2 5.279 0 9.614-4.042 10.078-9.2h-3.522a6.621 6.621 0 0 1-13.113 0h-3.522Z" clip-rule="evenodd"></path><path fill="#FFCDCB" d="M34.092 16.65a1.75 1.75 0 0 1-1.75 1.75c-.967 0-1.795-.784-1.795-1.75 0-.967.828-1.75 1.795-1.75.966 0 1.75.783 1.75 1.75ZM17.449 16.648c0 .966-.766 1.75-1.733 1.75-.966 0-1.795-.784-1.795-1.75 0-.967.829-1.75 1.795-1.75.967 0 1.733.783 1.733 1.75ZM46 22a1.6 1.6 0 1 1-3.2 0 1.6 1.6 0 0 1 3.2 0ZM46.33 30.044a1.6 1.6 0 1 1-3.2 0 1.6 1.6 0 0 1 3.2 0Z"></path></svg><!----><span data-v-67fe8f9c="">Activity</span></div><div data-v-67fe8f9c="" onclick="window.location.href='/promotion#/';" class="tabbar__container-item">
<svg data-v-67fe8f9c="" xmlns="http://www.w3.org/2000/svg" width="57" height="49" fill="none" viewBox="0 0 57 49" class=""><path fill="#fff" fill-rule="evenodd" d="M8.939 1.501A4 4 0 0 1 12.062 0h32.155a4 4 0 0 1 3.124 1.501l7.738 9.673c.427.533.749 1.12.968 1.735H.233a5.99 5.99 0 0 1 .967-1.735L8.94 1.501ZM0 16.091h56.28a5.985 5.985 0 0 1-1.277 2.673l-23.79 28.549a4 4 0 0 1-6.146 0l-23.79-28.55A5.984 5.984 0 0 1 0 16.092Zm20.556 5.936 7.195 10.102a.5.5 0 0 0 .816-.002l7.118-10.093a2.44 2.44 0 0 1 4.435 1.406v.2h-.223c-.326 0-.782.248-1.304.93-.506.663-6.466 8.724-9.651 13.035a.975.975 0 0 1-1.563.007L17.32 24.26s-.394-.62-1.06-.62h-.14v-.195a2.445 2.445 0 0 1 4.436-1.418Z" clip-rule="evenodd"></path></svg><div data-v-67fe8f9c="" class="promotionBg"></div><span data-v-67fe8f9c="">Promotion</span></div><div data-v-67fe8f9c="" onclick="window.location.href='/wallet#/';" class="tabbar__container-item active"><svg data-v-67fe8f9c="" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 46 44" class="wallet"><circle cx="28" cy="24" r="18" fill="#FFF4F4"></circle><path stroke="#FFCDCB" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.2" d="M3 23c0-5.984 3.526-10.164 9.008-10.868.56-.088 1.14-.132 1.742-.132h21.5c.559 0 1.096.022 1.612.11C42.41 12.77 46 16.972 46 23v11c0 6.6-4.3 11-10.75 11h-21.5C7.3 45 3 40.6 3 34v-2.178"></path><path stroke="#FFCDCB" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.2" d="M46 23.724h-6.452c-2.366 0-4.301 1.862-4.301 4.138S37.182 32 39.548 32H46m-9-20c-.516-.083-1.194 0-1.753 0H14c-.602 0-1.44-.083-2 0 0 0 .731-.648 1.247-1.145l6.99-6.745A7.737 7.737 0 0 1 25.571 2c1.997 0 3.914.758 5.333 2.11l3.764 3.662C36.045 9.076 39.548 12 37 12Z"></path></svg><!----><span data-v-67fe8f9c="">Wallet</span></div><div data-v-67fe8f9c="" onclick="window.location.href='/main#/';" class="tabbar__container-item"><svg data-v-67fe8f9c="" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 46 44" class=""><circle cx="28" cy="24" r="18" fill="#FFF4F4"></circle><path fill="#FFCDCB" fill-rule="evenodd" d="M24.08 5.28C13.741 5.28 5.36 13.661 5.36 24c0 10.339 8.381 18.72 18.72 18.72 10.339 0 18.72-8.381 18.72-18.72v-8.76h3.36V24c0 12.194-9.886 22.08-22.08 22.08C11.886 46.08 2 36.194 2 24 2 11.806 11.886 1.92 24.08 1.92h20.28v3.36H24.08Z" clip-rule="evenodd"></path><path fill="#FFCDCB" d="M46.16 3.6a1.68 1.68 0 1 1-3.36 0 1.68 1.68 0 0 1 3.36 0ZM46.16 15.12a1.68 1.68 0 1 1-3.36 0 1.68 1.68 0 0 1 3.36 0Z"></path><path fill="#FFCDCB" fill-rule="evenodd" d="M15.806 29.582a1.68 1.68 0 0 1 2.372.144c1.15 1.298 2.748 2.794 5.462 2.794 2.872 0 4.857-1.428 5.805-2.533a1.68 1.68 0 0 1 2.55 2.186c-1.451 1.695-4.314 3.707-8.355 3.707-4.198 0-6.647-2.424-7.977-3.926a1.68 1.68 0 0 1 .143-2.372Z" clip-rule="evenodd"></path></svg><!----><span data-v-67fe8f9c="">Account</span></div></div><!----></div>
<style>.wallet-container-content .container[data-v-8a579e82] {
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: start;
    -webkit-align-items: flex-start;
    align-items: flex-start;
    min-height: 8rem;
    padding: .62667rem .18667rem .26667rem;
    font-family: bahnschrift;
    border-radius: .26667rem;
    background-color: #fff;
    box-shadow: 0 .05333rem .21333rem #d0d0ed5c;
    position: absolute;
    width: 92%;
    top: -.33333rem;
}</style>
<foreignobject></foreignobject>

</body></html>