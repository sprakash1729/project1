
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
$mid=trim($_GET['id']);
  $data = array(
    
    "CLIENTID"=>"21122000169",
  "USERNAME"=>"AAJGB00169",
  "PASSWORD"=>"FGZ0VWUJ",
    "merchantTranId"=>$mid
  
  );
  
  $apiurl     = 'https://api.paytfy.com/api/UPICollectionStatus/CheckStatus';
  $data_array = json_encode( $data );
  $curl       = curl_init();
  curl_setopt( $curl, CURLOPT_URL, $apiurl );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $curl, CURLOPT_POSTFIELDS, $data_array );
  curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
  $result = curl_exec( $curl );
  $err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {

   $res=json_decode( $result, true ) ;
   $data=array_values( $res[0]);
 $status=$data[5];

 if($status=="SUCCESS"){
      require_once "config.php";
   $sql3 = "SELECT username,recharge FROM recharge WHERE mid='$mid' AND status='inprocess'";
$result3 =$conn->query($sql3);
$row3 = mysqli_fetch_assoc($result3);
$user=$row3['username'];
$recharge=$row3['recharge'];
$addwin0="UPDATE users SET balance= balance +$recharge WHERE username='$user'";
$conn->query($addwin0);
$addwin="UPDATE recharge SET status='successfull' WHERE mid='$mid'";
$conn->query($addwin);

 }
  echo$status;
   
}
	
 
  curl_close( $curl );
?>
