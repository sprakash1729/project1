
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
    header("location: login");
    exit;
}
require_once "config.php";

$account=$ifsc="";
$accounterr=$ifscerr="";

if (empty($_POST["account"] )== false){


                   if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   

                    if (empty($_POST["account"])) {
                      $accounterr = "Account Number is required";
                    } else {
                      $account = $_POST['account'];
                    }

                    if (empty($_POST["ifsc"])) {
                      $ifscerr = "ifsc code is required";
                    } else {
                      $ifsc = $_POST['ifsc'];
                      $name= $_POST['name'];
                      $upi= $_POST['upi'];
                      $email=$_POST['email'];
                    }
                }
                $query0 =  "SELECT  account FROM dbo.users  WHERE username!='".$_SESSION['username']."' AND account='$account'";
$result3 =$conn->query($query0);
$row3 = mysqli_fetch_assoc($result3);
$first=$row3['account'];
                if($first==''){
                      $sql = "UPDATE dbo.users SET account ='$account', ifsc ='$ifsc',name='$name',upi='$upi',email='$email' WHERE username='".$_SESSION['username']."' ";

                  if ($conn->query($sql) === TRUE) {
                  header("location: withdrawal#");
                  } else {
                    echo "Error updating record: " . $conn->error;
                  }
                    
                }else{
                      echo "<script>
     document.addEventListener('DOMContentLoaded', function(event) { 
     
                 document.getElementById('snackbar').innerHTML='Account number already linked';
          document.getElementById('snackbar').style.display= '';
        setTimeout(function () { document.getElementById('snackbar').style.display= 'none'; }, 3000);
 
});
                
     
                </script>";
                }

                

                }
                
                if($_GET["edit"]=="true"){
                    
                }else{
                    
                }


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
<title>786 Number Club</title>
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/modules-96f5a6e8.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-activity-871556fb.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-home-0d70abbb.css">
<link rel="stylesheet" href="https://91dreamclub.com/assets/css/index-08abe1f5.css">
<link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-wallet-d4d609cb.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-login-c581a4df.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-login-1f545390.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-test-b23bed1b.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-test-b38d710a.css"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-promotion-db066b5a.js"><link rel="modulepreload" as="script" crossorigin="" href="/assets/js/page-main-eac2089d.js"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-main-8cf260fb.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-promotion-24bf6ab6.css"><link rel="stylesheet" href="https://91dreamclub.com/assets/css/page-wallet-24fc13b6.css"></head>
<body style="font-size: 12px;">
<div id="app" data-v-app=""><!----><!----><div data-v-ae83d79e="" class="addBankCard__container" style="--36a344b0: 'Roboto', 'Inter', sans-serif;"><div data-v-4c21fa9e="" data-v-ae83d79e="" class="navbar"><div data-v-4c21fa9e="" class="navbar-fixed" style="background: rgb(247, 248, 255);"><div data-v-4c21fa9e="" class="navbar__content"><div onclick="window.location.href='withdrawal#'" data-v-4c21fa9e="" class="navbar__content-left"><i data-v-4c21fa9e="" class="van-badge__wrapper van-icon van-icon-arrow-left"><!----><!----><!----></i></div><div data-v-4c21fa9e="" class="navbar__content-center"><!----><div data-v-4c21fa9e="" class="navbar__content-title">Add a bank account number</div></div><div data-v-4c21fa9e="" class="navbar__content-right"></div></div></div></div><form action="" id="bankcard" method="post"><span id="mwa"></span><div data-v-ae83d79e="" class="addBankCard__container-content"><div data-v-ae83d79e="" class="addBankCard__container-content-top"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAMAAADW3miqAAAANlBMVEUAAAD/cHD/cHD/cHD/cXL/cXL/cXL/cHD/cXL/cXP/cHH/cHL/cnL/cXL/cHL/cHD/cHP/cXIabTjwAAAAEXRSTlMAECBA35/vML/PkGCPr3BwUEXfeIsAAAEBSURBVDjLtZThjoQgDIRbbEEQvJv3f9lLXNe5FUj8s/1jqt+UScMo3yndPEcgZt90goQawfIwmlIBrHtSEV32FUDVbowBJfzrHbDbsGSw1Mks3V74e7i+9do+ZqmhXTxweXEYfVWwWYCFYlSKEWQESeIXh8sYkoJyDiXeQQHxZWTDKjNIVmznafsc+jmtZCxzKCEfzwidQ4p4PAGZQwI8gp4fl5F6iG3uVsDVcgVcJiuoDJapkVrW/eIUVL7+jbawczhxWs+AyegSFZjSBC2qoQgb+CVu7RK3l5hBaNol0W+hSvYsZZ/JDhWUcXg5Yr6oiKYj5kVHi3OwYglPfj1fqT/iPw2tBKd4UAAAAABJRU5ErkJggg=="><span data-v-ae83d79e="">To ensure the safety of your funds, please bind your bank account</span></div><div data-v-ae83d79e="" class="addBankCard__container-content-item"><div data-v-ae83d79e="" class="label"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwBAMAAAClLOS0AAAAMFBMVEUAAAD/cHL/cHL/cHD/cXL/cXL/cHL/cXL/cnL/cnL/cXP/cHD/cHD/cHD/cXH/cXLOdBIbAAAAD3RSTlMAgGAQ779w35+Pz0AwIG8oRAFQAAAApklEQVQ4y2OgL2BODTLAJs495f9/jwOY4mbx/4HglzK6+E7//2DwpQfN+P9wsMgAxXg4gFiEMB4BEBbd9IcKCJtBGV96wRIw9d8YGOShzK9gCZgJnxkY7GFs4iQ+MjC8xyrxP9nwP6oEAlAq4Y8p/h0soY4p4QQUhhmGSo5KUEtCBTPYi8AS9ZgSX3BGLXUlmASxSQgqMOj/xwo+4ZZgEsQKFBhIBgBgmmU8MvjwjwAAAABJRU5ErkJggg==" class="icon"> Choose a bank</div><input data-v-ae83d79e="" type="text" name="name" placeholder="Please select a bank" maxlength="50" list="browsers" id="browser"><datalist id="browsers">
<option value="Bank of Baroda">
<option value="Bank of India">
<option value="Bank of Maharashtra">
<option value="Canara Bank">
<option value="Central Bank of India">
<option value="Indian Bank">
<option value="Indian Overseas Bank">
<option value="Punjab & Sind Bank">
<option value="Punjab National Bank">
<option value="State Bank of India">
<option value="UCO Bank">
<option value="Union Bank of India">
<option value="Axis Bank Ltd.">
<option value="Bandhan Bank Ltd.">
<option value="CSB Bank Ltd.">
<option value="City Union Bank Ltd.">
<option value="DCB Bank Ltd.">
<option value="Dhanlaxmi Bank Ltd.">
<option value="Federal Bank Ltd.">
<option value="HDFC Bank Ltd">
<option value="ICICI Bank Ltd.">
<option value="Induslnd Bank Ltd">
<option value="IDFC First Bank Ltd.">
<option value="Jammu & Kashmir Bank Ltd.">
<option value="Karnataka Bank Ltd.">
<option value="Karur Vysya Bank Ltd.">
<option value="Kotak Mahindra Bank Ltd">
<option value="Nainital Bank Ltd.">
<option value="RBL Bank Ltd.">
<option value="South Indian Bank Ltd.">
<option value="Tamilnad Mercantile Bank Ltd.">
<option value="YES Bank Ltd.">
<option value="IDBI Bank Ltd.">
<option value="Au Small Finance Bank Limited">
<option value="Capital Small Finance Bank Limited">
<option value="Equitas Small Finance Bank Limited">
<option value="Suryoday Small Finance Bank Limited">
<option value="Ujjivan Small Finance Bank Limited">
<option value="Utkarsh Small Finance Bank Limited">
<option value="Fincare Small Finance Bank Limited">
<option value="Jana Small Finance Bank Limited">
<option value="North East Small Finance Bank Limited">
<option value="Shivalik Small Finance Bank Limited">
<option value="Unity Small Finance Bank Limited">
<option value="India Post Payments Bank Limited">
<option value="Fino Payments Bank Limited">
<option value="Paytm Payments Bank Limited">
<option value="Airtel Payments Bank Limited">
<option value="Andhra Pragathi Grameena Bank">
<option value="Andhra Pradesh Grameena Vikas Bank">
<option value="Arunachal Pradesh Rural Bank">
<option value="Aryavart Bank">
<option value="Assam Gramin Vikash Bank">
<option value="Bangiya Gramin Vikas Bank">
<option value="Baroda Gujarat Gramin Bank">
<option value="Baroda Rajasthan Kshetriya Gramin Bank">
<option value="Baroda UP Bank">
<option value="Chaitanya Godavari Grameena Bank">
<option value="Chhattisgarh Rajya Gramin Bank">
<option value="Dakshin Bihar Gramin Bank">
<option value="Ellaquai Dehati Bank">
<option value="Himachal Pradesh Gramin Bank">
<option value="J&K Grameen Bank">
<option value="Jharkhand Rajya Gramin Bank">
<option value="Karnataka Gramin Bank">
<option value="Karnataka Vikas Grameena Bank">
<option value="Kerala Gramin Bank">
<option value="Madhya Pradesh Gramin Bank">
<option value="Madhyanchal Gramin Bank">
<option value="Maharashtra Gramin Bank">
<option value="Manipur Rural Bank">
<option value="Meghalaya Rural Bank">
<option value="Mizoram Rural Bank">
<option value="Nagaland Rural Bank">
<option value="Odisha Gramya Bank">
<option value="Paschim Banga Gramin Bank">
<option value="Prathama UP Gramin Bank">
<option value="Puduvai Bharathiar Grama Bank">
<option value="Punjab Gramin Bank">
<option value="Rajasthan Marudhara Gramin Bank">
<option value="Saptagiri Grameena Bank">
<option value="Sarva Haryana Gramin Bank">
<option value="Saurashtra Gramin Bank">
<option value="Tamil Nadu Grama Bank">
<option value="Telangana Grameena Bank">
<option value="Tripura Gramin Bank">
<option value="Utkal Grameen bank">
<option value="Uttar Bihar Gramin Bank">
<option value="Uttarakhand Gramin Bank">
<option value="Uttarbanga Kshetriya Gramin Bank">
<option value="Vidharbha Konkan Gramin Bank">
<option value="AB Bank Ltd.">
<option value="Abu Dhabi Commercial Bank Ltd.">
<option value="American Express Banking Corporation">
<option value="Australia and New Zealand Banking Group Ltd.">
<option value="Barclays Bank Plc.">
<option value="Bank of America">
<option value="Bank of Bahrain & Kuwait BSC">
<option value="Bank of Ceylon">
<option value="Bank of China">
<option value="Bank of Nova Scotia">
<option value="BNP Paribas">
<option value="Citibank N.A.">
<option value="Cooperatieve Rabobank U.A.">
<option value="Credit Agricole Corporate & Investment Bank">
<option value="Credit Suisse A.G">
<option value="CTBC Bank Co., Ltd.">
<option value="DBS Bank India Limited">
<option value="Deutsche Bank">
<option value="Doha Bank Q.P.S.C">
<option value="Emirates Bank NBD">
<option value="First Abu Dhabi Bank PJSC">
<option value="FirstRand Bank Ltd">
<option value="HSBC Ltd">
<option value="Industrial & Commercial Bank of China Ltd.">
<option value="Industrial Bank of Korea">
<option value="J.P. Morgan Chase Bank N.A.">
<option value="JSC VTB Bank">
<option value="KEB Hana Bank">
<option value="Kookmin Bank">
<option value="Krung Thai Bank Public Co. Ltd.">
<option value="Mashreq Bank PSC">
<option value="Mizuho& Bank Ltd.">
<option value="MUFG Bank, Ltd.">
<option value="NatWest Markets Plc">
<option value="PT Bank Maybank Indonesia TBK">
<option value="Qatar National Bank (Q.P.S.C.)">
<option value="Sberbank">
<option value="SBM Bank (India) Limited">
<option value="Shinhan Bank">
<option value="Societe Generale">
<option value="Sonali Bank Ltd.">
<option value="Standard Chartered Bank">
<option value="Sumitomo Mitsui Banking Corporation">
<option value="United Overseas Bank Ltd">
<option value="Woori Bank"></datalist>
</div><div data-v-ae83d79e="" class="addBankCard__container-content-item"><div data-v-ae83d79e="" class="label"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAOVBMVEUAAAD/cHD/cXL/cXL/cnL/cHD/cXL/cHH/cHL/cHD/cXP/cXL/cnL/cHL/cHP/cHD/cXH/cHD/cXJSxuJaAAAAEnRSTlMAEN/vjyDPcGBAv5+vgFAwv2D70HpDAAAA20lEQVRIx93UzbLCIAwFYJLwU2hrr+f9H/baGReiNMeO48Zvx+KQpgTCj5KyKJCXKbynGO70nYg0PFiEBjI6mSUinsTg2vCiuoEFL/7cjjHgdXHBwMU7AgwUJ7BiYP20Au/h7F9KwdH4OfQqO2k+SzObbjKtLNEkcKvizkrgREKamgHWiuwrX4r2eJGrYk7e7hE7jVVui7oadlEOt1cM6UGRTXFAN74/ryEKhwqbCfraJHT4kM/AqRICxvouJlAT+yL/YmRQuQsYKOsCAPf9wNketAtclfZ8DT/jHzFBP7b8CmKOAAAAAElFTkSuQmCC" class="icon"> Full recipient's name</div><input data-v-ae83d79e="" type="text" name="ifsc" autocomplete="off" placeholder="Please enter the recipient's name" maxlength="50"><!----><!----></div><div data-v-ae83d79e="" class="addBankCard__container-content-item"><div data-v-ae83d79e="" class="label"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAM1BMVEUAAAD/cHL/cHD/cHD/cXL/cXP/cHD/cHH/cHD/cHL/cHH/cXL/cXP/cnP/cnL/cHL/cXJIXFloAAAAEHRSTlMAgCBA378wkBCvYO/Pr59wVYQI0QAAAI9JREFUSMft08kKhTAMheE0U2u9Q97/ae+VQnDncSM4fNBdfiSW0o3Jt2yR1ThbAJRzXiNBxSdANuZbwNpYGA98byAHBU0jgf+VQXQYKaA+5v0CF/cEZwisTsuBg7IM/I+DwZxvYMICzaBiQeQ7VjBQJ38LtbragQOU37PA5Eay496GHoi5U+JquuFVmB6oHwU0T16VrFt9AAAAAElFTkSuQmCC" class="icon"> Bank account number</div><input data-v-ae83d79e="" type="tel" name="account" placeholder="Please enter your bank account number" autocomplete="off" maxlength="30"></div><div data-v-ae83d79e="" class="addBankCard__container-content-item"><div data-v-ae83d79e="" class="label"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwBAMAAAClLOS0AAAAFVBMVEUAAAD/cXL/cHD/cXH/cnL/cHL/cXJSBWUOAAAABnRSTlMA7yCQgIBPOFs6AAAATElEQVQ4y2OgMnBMQwHCMHHmNDTgAJVgTEI1QE0AymBLgDLg/FGJUQniJdAT3JCQSAJmAJwS9HcVI7oELHOyoksYwCLAEFVclIG6AABgTIhHP5hUHgAAAABJRU5ErkJggg==" class="icon"> UPI ID</div><input data-v-ae83d79e="" placeholder="Please enter your UPI ID" autocomplete="off" type="text" name="email" maxlength="120"></div><!----><div data-v-ae83d79e="" class="addBankCard__container-content-item"><div data-v-ae83d79e="" class="label"><img data-v-ae83d79e="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAMcSURBVHgB7ZnvedMwEMbfc/lONsBM0DJBwwRlg4YJmpQBaAcgSSdo2KCdoGECygYeoQzQHK+UQhMsOyc5sftAfh8S248s6aTT/TOwZ8//jSARHQ77QHaETI6hesRH+Uq398DiASq3/J/LdHqPHREtgJ+4HHzmVd/+FgVSvZLpeIYtYxaAE8858eu4iZcooIv33JECWyKzNNLR6BSSfW84eUfu+tHh+RBbYqMAHIzqIjNe9rAdetz3iZ67fptTq0Jc+TM2mWJn6EAmk69oQKUAS513arO1lQ9BS7V41+RMVKuQZHfY7eTh+xe5RgOCAlDvB1iz67tE+k/jJRHeAZEztInoKRIpnQHq/tGT7luhHisPos79NbKc/yfs+QNiWPqHOSJ5FXjWh50qxzTzakFzCes5yrI+f+eIJKBCByewUuNVfdiguIQV1WMkUBZAjCummG0yfxTC+ZDaNiutcyQQ2AEfWVoGvDU1U7W1S7R6plgozOODrZ0Y26XRQABvbSwjHGKHhAQoYMFgu2mSezwrRpVE0k6FDrExe6IHdWF2fffOIeYwoUlZW1mABX7AjMxCsb1beYbLEy7GBexEjPtMwJEt5pTLHqu72H50fsb/Gwr/k0/eeC+skYGgyGskEAyndfjpjjreR9sIfct4/DHmlQorpI2SjGQUA6peVHhdk9B0tAuOiJ2o8QOPIySatsZE7ESlAL4YFROMbRujELWe2AdjL1wIU2HL2/plbN8NNWcisjLnE/0cXVAhREJt1GdaztHlaJuAEE2q0wzSMua9rE6LzyFWPW/B50w39RuvDw35sUtNafWy3sY0VHBJIS6eb1uAQd+MQ1UFfmt5tQ5H0w1VkUIm47e/bxrkA3ZYPhxUePdyUSDbGBPlqzetCOAICFGavC8k03Ru6KpYvWlNAIcXgh86UDV5U/itxVqfeAHYJ+9bX3Eh/uQgre5AiLjJuxfWiwSdCrAsY0ZlbVh+QHymUwGWXy+jco9Cpl9uVh90rkI1JvZv/MEvvY8XAs/CBWfjnF0OP1lfHXH6zmR/UfDffW/uJj/Z8y/zC/nxLjSf2XvwAAAAAElFTkSuQmCC" class="icon"> IFSC code</div><input data-v-ae83d79e="" autocomplete="off" placeholder="Please enterIFSC code" type="text" name="upi" maxlength="20"></div><!----><!----><div data-v-ae83d79e="" class="addBankCard__container-content-btn"><button onclick="submit()" data-v-ae83d79e="" class="active">Save</button></form></div></div></div><div class="customer" id="customerId" style="--36a344b0: 'Roboto', 'Inter', sans-serif; --17a7a9f6: bahnschrift;"><img class="" onclick="window.location.href='/keFuMenu#/'" data-origin="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png" src="https://91dreamclub.com/assets/png/icon_sevice-9f0c8455.png"></div><!----><!----></div>
<foreignobject></foreignobject>

<div></div><!----><!----><style>.addBankCard__container-content-item .selectB[data-v-ae83d79e] {
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    justify-content: space-between;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    font-size: .37333rem;
    color: #fff;
    background-color: #ff807a;
    height: .93333rem;
    width:9.4rem;
    line-height: .86667rem;
    border-radius: .13333rem;
    padding: 0 .26667rem;
}
      .van-toast--html, .van-toast--text {
    width: -webkit-fit-content;
    width: fit-content;
    min-width: 200px;
    min-height: 0;
    padding: 8px 12px;
}
.van-toast {
    position: fixed;
    top: 50%;
    left: 50%;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
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
    width: 88px;
    max-width: 70%;
    min-height: 10px;
    padding: 16px;
    color: #fff;
    font-size: 14px;
    line-height: 20px;
    white-space: pre-wrap;
    text-align: center;
    word-wrap: break-word;
    background-color:#ff4440;
    border-radius: 8px;
    -webkit-transform: translate3d(-50%, -50%, 0);
    transform: translate3d(-50%, -50%, 0);
}
  </style><script>
        function submit(){
            document.getElementById("bankcard").submit();
        }
    </script>
</body>

</html><script>window.onload = function () {
			let cfg  = JSON.parse(localStorage.getItem('clientCfg'));
			// console.log(cfg)
			if (cfg) {
				var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
				// var meta = document.querySelector("meta[name*='google-site-verification']") || document.createElement('meta');
				// meta.content = '是十四'
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = cfg.WebIco;//'http://47.56.7.183:5001/img/tatalogo.jpg';
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
		}</script><style>html,body{ height: 100%; width: 100%; background-color: #fff;padding: 0;margin: 0;}</style><style>
.lookPwd[data-v-55c0a38e] {
    height: 0.96rem;
    width: 0.96rem;
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
}
 .float{ 
       z-index: 99;
    position: fixed;
    width: 46px;
    height: 46px;
    bottom: 99px;
    right: 5px;
    text-align: center;
}


  .floattext {
    display: flex;
    background: #02a0da;
    color: #fff;
    padding: 5px 3px;
    font-size: 8px;
    font-weight:700;
    width: auto;
    border-radius: 2px;
    height: 16px;
    line-height: 6px;
    margin-top: 53px;
    box-shadow: 0 0 0.21333rem 0.02667rem rgba(2,160,218,.72);
    
}
.mian .bank .bank-btn .btn[data-v-1ea51620] {
    height: 1.01333rem;
    border: 0.02667rem solid #5cba47;
    color: #fff;
    width: 60%;
    background-color: #5cba47;
    box-shadow: 0 0 0.21333rem 0.02667rem rgba(92,186,71,.72);
}
.navbar[data-v-c2022cca] {
    width: 100%;
    max-width: 10.66667rem;
    top: 0;
    height: 1.33333rem;
    line-height: 1.33333rem;
    background-image: linear-gradient(90deg,#cd0103,#f64841);
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    color: #fff;
    z-index: 999;
}
.mian .bank .box .item .input .ipt[data-v-1ea51620] {
    width: 100%;
    padding: 0 0.4rem;
    height: 0.93333rem;
    line-height: .93333rem;
    border-radius: 0.13333rem;
    border: .05333rem solid rgba(255,153,0,.27);
}
.mian .bank .box .item .input .ipt[data-v-1ea51620] {
    width: 100%;
    padding: 0 0.4rem;
    height: 0.93333rem;
    line-height: .93333rem;
    border-radius: 0.13333rem;
    border: .05333rem solid rgba(255,153,0,.27);
}
.mian .bank .box .txt[data-v-4e9463e6] {
    color: #f90;
}
.my-float{
	margin-top:22px;
}</style> 
</body></html>