
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
require_once "config.php";
$sqlr = "SELECT api FROM dbo.otp WHERE id='1'";
$resultr = $conn->query($sqlr);
$rowr = mysqli_fetch_array($resultr);
$api=$rowr[api];
if(isset($_GET['num'])){
function genOtp(){
   

    $tn = rand(10000,99999);
    $otp=$tn;
    
    return $otp;
    
    }
  
$otp= genOtp(); 

$num=$_GET["num"];

$rec="INSERT INTO dbo.verify (username,otp) VALUES ('$num','$otp')";
$conn->query($rec);


$fields = array(
    "variables_values" => "$otp",
    "route" => "otp",
    "numbers" => "$num",
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: JVM70gPTzoZYm67GRziC7HCrrJ7EbBy2e2mFbr9MzWoEK9e7p2QnDyGL2Ppf ",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response=curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}
?>