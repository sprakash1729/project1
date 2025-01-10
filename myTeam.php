
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
    header("location: login");
    exit;
}
require_once "config.php";
//retrieve the selected results from database   
$query5 = "SELECT *FROM dbo.users WHERE refcode1='".$_SESSION['usercode']."' ORDER BY id DESC  " ;  
$result5 = mysqli_query($conn, $query5);  
  
//display the retrieved result on the webpage  
while ($row21 = mysqli_fetch_array($result5)) {  
    $dataRow1 = $dataRow1."
           
                                <div class=' pt-1 pb-1' style='display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 20px;
    margin-left: 10px;'>
                                   <div class='col-4 xtl'>$row21[1]</div>
                                    <div class='col' style='display:inline !important;' >Level 2</div>
                                    <span>$row21[5]</span>
                                </div>
             

";
    
}
$query0 =  "SELECT  * FROM dbo.users  WHERE refcode='".$_SESSION['usercode']."'";
$query1 =  "SELECT  * FROM dbo.users  WHERE refcode1='".$_SESSION['usercode']."'";


// result for method one
$result1 = mysqli_query($conn, $query0);
$result3 = mysqli_query($conn, $query1);

$rowcount=mysqli_num_rows($result1);
$rowcount2=mysqli_num_rows($result3);

//retrieve the selected results from database   
$query = "SELECT *FROM dbo.users WHERE refcode='".$_SESSION['usercode']."' ORDER BY id DESC ";  
$result = mysqli_query($conn, $query);  
  
//display the retrieved result on the webpage  
while ($row2 = mysqli_fetch_array($result)) {  
    $dataRow = $dataRow."
             <div class=' pt-1 pb-1' style='display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 20px;
    margin-left: 10px;'>
                                    <div class='col-4 xtl'>$row2[1]</div>
                                    <div class='col' style='display:inline !important;'>Level 1</div>
                                    <span>$row2[5]</span>
                                   
                                </div>
             

";
    
}
?>
<html translate="no" data-dpr="1" style="font-size: 40px;"><head>

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
<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="robots" content="noindex,nofollow"><meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport"><meta name="google-site-verification"><link rel="icon" href="./ico.png">
<meta name="google" content="notranslate">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="manifest">
<title>786 Number Club</title><link href="https://91dreamclub.com/css/chunk-009b4c4c.8f338b77.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-01c025bd.1667b8ce.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0258b2a7.9f3612df.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-02d640c5.16079f26.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-04d9e7e8.f2872521.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-05d395a8.27167ad5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-076af0c5.29ef0cc5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0776880e.4eccb474.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-085e8808.15897d4c.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0984719c.48994e09.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0b0fb3cd.72cfd6ac.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0b15e882.a179a30f.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0c321a94.0260d406.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0c41b112.95faab95.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0d7a320e.918d608f.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0db7c1f6.5739eac5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0e10c9c3.583c8acb.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0ecd09c6.87d344f2.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0efec584.970e752d.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-0fd8d9ae.1d9debf8.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-16f496dc.94dfae31.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-1d9dbe7b.276e1811.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-200eed29.d7ba2238.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-21c81672.44e6c68a.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-22328081.7a617a9e.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-23008c6a.4d6883d8.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2352a756.92a31d6b.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-25e66eaa.c71493da.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-264008c4.bb60e1c2.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-27122907.90238e28.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-278d59ee.e7249e90.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2c48d9e6.5807d9e5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2c510426.9caeb1a6.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2d123fa7.112a8fd8.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2de9240a.19e6b622.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-2e1544f7.4ee08851.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-30bd42b6.4346da8a.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-3315d54e.9f52a246.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-3334e104.cbcafb9c.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-3484bcc5.30d7756a.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-34baa4fa.b3a04f58.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-351dfe5b.5d055e78.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-38251dc0.5d14ab44.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-3cc70fec.2e8de1d9.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-3fcf4ae6.04566cc0.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-41cc83f4.519fd919.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-422c3438.72ff4de0.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-427a8894.df92961c.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-44abccc0.3d756849.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-44d5df02.6d92e0bb.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-45a40258.edd66dc5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-45e4acaa.08a21094.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-461a1710.e2706d03.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-467e3165.1aa205de.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-48fa2278.13a9906c.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-495c0a68.d31174e6.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4c9e3b97.3fabc1cf.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4cc5ff42.84d6f5da.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4db0772a.fd229f9d.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4e2c0e16.fa19fc14.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4eb90e66.0b2a38a2.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-4f411f1c.30a25410.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-51fd0af3.b46d3a1f.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-53841b4e.c3c35a59.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-548e69f3.bdb86635.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-58742edc.cf979edc.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-59419552.b7efea23.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-5d17b1cb.cfda8ce1.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-5e578388.2aa8f2ab.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-5fadbd2a.9529f5b5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-61d0c116.ef0e8c84.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-63bb93b0.cf2f814d.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-644ff02f.9f48865a.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-64cdf166.976ed132.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-66d5b656.7b0be418.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-685aa3e6.70510f63.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-6b43bd10.5b7d20a2.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-6f3b8caf.d564c0cc.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-71dcadf2.ec6e09e7.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-7293d7fb.cef69bd8.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-72f01a9a.5a06efac.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-74daba4d.898d2241.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-75071d1a.f1719299.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-758b4fe4.2db2fa29.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-769894e4.d83dca0e.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-76d87515.2f2511a1.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-7a3388a9.0141b5f5.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-7a43413b.54ccbe6b.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-7ad1fcf0.8cc2c21c.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-862854c0.b0596219.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-90f8a4d8.45f356ca.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-943f7cea.5763c16b.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-9ca7d0dc.0f968705.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-a718bce8.6c66860a.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-ae1ed794.e4fd2944.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-afb3fabc.8b080c82.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-b3a478b0.c6a9ccda.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-b4b2c9bc.ed6cb6bd.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-b70405a6.39dca3b3.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-c0d15508.e8e9c998.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-c7d4e1ca.7a7a2286.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-cb3e0ec2.a254d558.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-cc5799d2.9e80b6d6.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-ccd4fcae.88e701d4.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-dbf579d4.15d3b80b.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-e635d700.3bce96ee.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-f778548c.81d51502.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-f889184a.c6d7ee94.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-faa8abe2.eb4c7660.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-fd347064.2e191ec7.css" rel="prefetch"><link href="https://91dreamclub.com/css/chunk-fdbeb1dc.a3cf84fb.css" rel="prefetch"><link href="js/chunk-009b4c4c.4db5fc75.js" rel="prefetch"><link href="js/chunk-01c025bd.92f5b7d1.js" rel="prefetch"><link href="js/chunk-0258b2a7.3013b062.js" rel="prefetch"><link href="js/chunk-02d640c5.4dd13bce.js" rel="prefetch"><link href="js/chunk-04d9e7e8.70222f5b.js" rel="prefetch"><link href="js/chunk-05d395a8.f6ba6405.js" rel="prefetch"><link href="js/chunk-076af0c5.d09bfa1d.js" rel="prefetch"><link href="js/chunk-0776880e.4673e235.js" rel="prefetch"><link href="js/chunk-085e8808.102744e9.js" rel="prefetch"><link href="js/chunk-0984719c.e9759629.js" rel="prefetch"><link href="js/chunk-0b0fb3cd.c53a493c.js" rel="prefetch"><link href="js/chunk-0b15e882.686eeab4.js" rel="prefetch"><link href="js/chunk-0c321a94.89c61538.js" rel="prefetch"><link href="js/chunk-0c41b112.51bb9662.js" rel="prefetch"><link href="js/chunk-0d7a320e.77ac9b3a.js" rel="prefetch"><link href="js/chunk-0db7c1f6.df42ed56.js" rel="prefetch"><link href="js/chunk-0e10c9c3.4ee6824f.js" rel="prefetch"><link href="js/chunk-0ecd09c6.37b89859.js" rel="prefetch"><link href="js/chunk-0efec584.c8c100c5.js" rel="prefetch"><link href="js/chunk-0fd8d9ae.5d854d84.js" rel="prefetch"><link href="js/chunk-16f496dc.739a15ec.js" rel="prefetch"><link href="js/chunk-1d9dbe7b.acd78b74.js" rel="prefetch"><link href="js/chunk-200eed29.297e87f3.js" rel="prefetch"><link href="js/chunk-21c81672.8cddeb37.js" rel="prefetch"><link href="js/chunk-22328081.c99789c0.js" rel="prefetch"><link href="js/chunk-23008c6a.d065e72e.js" rel="prefetch"><link href="js/chunk-2352a756.ad42dbc7.js" rel="prefetch"><link href="js/chunk-25e66eaa.b5d17d1f.js" rel="prefetch"><link href="js/chunk-264008c4.34740ad2.js" rel="prefetch"><link href="js/chunk-27122907.7456501e.js" rel="prefetch"><link href="js/chunk-278d59ee.65dc73a9.js" rel="prefetch"><link href="js/chunk-2c48d9e6.06bbf094.js" rel="prefetch"><link href="js/chunk-2c510426.de45cba5.js" rel="prefetch"><link href="js/chunk-2d0c9b56.51c99983.js" rel="prefetch"><link href="js/chunk-2d123fa7.18a4e150.js" rel="prefetch"><link href="js/chunk-2d216257.3986ae5c.js" rel="prefetch"><link href="js/chunk-2d21d0c2.2bf78577.js" rel="prefetch"><link href="js/chunk-2de9240a.fce14682.js" rel="prefetch"><link href="js/chunk-2e1544f7.fd706d4f.js" rel="prefetch"><link href="js/chunk-30bd42b6.f21dcd67.js" rel="prefetch"><link href="js/chunk-3315d54e.efecc2ce.js" rel="prefetch"><link href="js/chunk-3334e104.35ddf131.js" rel="prefetch"><link href="js/chunk-3484bcc5.a3d148e4.js" rel="prefetch"><link href="js/chunk-34baa4fa.49082d2a.js" rel="prefetch"><link href="js/chunk-351dfe5b.ed199ef0.js" rel="prefetch"><link href="js/chunk-38251dc0.efbfb2e1.js" rel="prefetch"><link href="js/chunk-3cc70fec.f6261a1c.js" rel="prefetch"><link href="js/chunk-3fcf4ae6.4752767b.js" rel="prefetch"><link href="js/chunk-41cc83f4.83d259f4.js" rel="prefetch"><link href="js/chunk-422c3438.a3cac313.js" rel="prefetch"><link href="js/chunk-427a8894.d16dff77.js" rel="prefetch"><link href="js/chunk-44abccc0.5d45b863.js" rel="prefetch"><link href="js/chunk-44d5df02.3423448a.js" rel="prefetch"><link href="js/chunk-45a40258.54940396.js" rel="prefetch"><link href="js/chunk-45e4acaa.035ac99b.js" rel="prefetch"><link href="js/chunk-461a1710.889d7015.js" rel="prefetch"><link href="js/chunk-467e3165.d08c7dde.js" rel="prefetch"><link href="js/chunk-48fa2278.9ff57e27.js" rel="prefetch"><link href="js/chunk-495c0a68.56180b88.js" rel="prefetch"><link href="js/chunk-4c9e3b97.2a763bc4.js" rel="prefetch"><link href="js/chunk-4cc5ff42.df53a62d.js" rel="prefetch"><link href="js/chunk-4db0772a.5e02de68.js" rel="prefetch"><link href="js/chunk-4e2c0e16.822239a8.js" rel="prefetch"><link href="js/chunk-4eb90e66.c9fba7a4.js" rel="prefetch"><link href="js/chunk-4f411f1c.339bc657.js" rel="prefetch"><link href="js/chunk-51fd0af3.7c1de557.js" rel="prefetch"><link href="js/chunk-53841b4e.0fac6d48.js" rel="prefetch"><link href="js/chunk-548e69f3.1067b840.js" rel="prefetch"><link href="js/chunk-58742edc.74553bc5.js" rel="prefetch"><link href="js/chunk-59419552.552063a3.js" rel="prefetch"><link href="js/chunk-5d17b1cb.e2cc0650.js" rel="prefetch"><link href="js/chunk-5e578388.7c9b28bc.js" rel="prefetch"><link href="js/chunk-5fadbd2a.e58be934.js" rel="prefetch"><link href="js/chunk-61d0c116.aa148b76.js" rel="prefetch"><link href="js/chunk-63bb93b0.5da13e0f.js" rel="prefetch"><link href="js/chunk-644ff02f.de8882da.js" rel="prefetch"><link href="js/chunk-64cdf166.b6756f17.js" rel="prefetch"><link href="js/chunk-66d5b656.038e51cf.js" rel="prefetch"><link href="js/chunk-685aa3e6.7a245701.js" rel="prefetch"><link href="js/chunk-6b43bd10.31055044.js" rel="prefetch"><link href="js/chunk-6f3b8caf.c44ee272.js" rel="prefetch"><link href="js/chunk-71dcadf2.83971b0c.js" rel="prefetch"><link href="js/chunk-7293d7fb.ce14da7f.js" rel="prefetch"><link href="js/chunk-72f01a9a.0a2a4d20.js" rel="prefetch"><link href="js/chunk-74daba4d.75cc4461.js" rel="prefetch"><link href="js/chunk-75071d1a.aa2b1728.js" rel="prefetch"><link href="js/chunk-758b4fe4.1461c315.js" rel="prefetch"><link href="js/chunk-769894e4.58d3c8e9.js" rel="prefetch"><link href="js/chunk-76d87515.d3e1265d.js" rel="prefetch"><link href="js/chunk-7a3388a9.e7b2e9a0.js" rel="prefetch"><link href="js/chunk-7a43413b.2547a354.js" rel="prefetch"><link href="js/chunk-7ad1fcf0.cc8025cf.js" rel="prefetch"><link href="js/chunk-862854c0.4e7cd6dc.js" rel="prefetch"><link href="js/chunk-90f8a4d8.41602ed1.js" rel="prefetch"><link href="js/chunk-943f7cea.c6da161d.js" rel="prefetch"><link href="js/chunk-9ca7d0dc.788930fb.js" rel="prefetch"><link href="js/chunk-a718bce8.062d37f7.js" rel="prefetch"><link href="js/chunk-ae1ed794.c2daaa10.js" rel="prefetch"><link href="js/chunk-afb3fabc.d9266cc9.js" rel="prefetch"><link href="js/chunk-b198f854.e747f069.js" rel="prefetch"><link href="js/chunk-b3a478b0.8a38a9b6.js" rel="prefetch"><link href="js/chunk-b4b2c9bc.59d854d9.js" rel="prefetch"><link href="js/chunk-b70405a6.c68647a7.js" rel="prefetch"><link href="js/chunk-c0d15508.2c07ae03.js" rel="prefetch"><link href="js/chunk-c7d4e1ca.50835f7f.js" rel="prefetch"><link href="js/chunk-cb3e0ec2.b4da6c05.js" rel="prefetch"><link href="js/chunk-cc5799d2.0a1cfbbc.js" rel="prefetch"><link href="js/chunk-ccd4fcae.b6a9d070.js" rel="prefetch"><link href="js/chunk-dbf579d4.f62b534d.js" rel="prefetch"><link href="js/chunk-e635d700.308e9774.js" rel="prefetch"><link href="js/chunk-f778548c.15fa9d9d.js" rel="prefetch"><link href="js/chunk-f889184a.97140318.js" rel="prefetch"><link href="js/chunk-faa8abe2.20ecd202.js" rel="prefetch"><link href="js/chunk-fd347064.81d6009c.js" rel="prefetch"><link href="js/chunk-fdbeb1dc.212b57c3.js" rel="prefetch"><link href="https://91dreamclub.com/css/app.2b8fcd50.css" rel="preload" as="style"><link href="https://91dreamclub.com/css/chunk-vendors.b521b44f.css" rel="preload" as="style"><link href="js/app.90bf53ad.js" rel="preload" as="script"><link href="js/chunk-vendors.d6090956.js" rel="preload" as="script"><link href="https://91dreamclub.com/css/chunk-vendors.b521b44f.css" rel="stylesheet"><link href="https://91dreamclub.com/css/app.2b8fcd50.css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="https://91dreamclub.com/css/chunk-1d9dbe7b.276e1811.css"><link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/light.css">
    <link rel="stylesheet" href="/css/index.css"><script charset="utf-8" src="js/chunk-1d9dbe7b.acd78b74.js"></script>
</head><body style="font-size: 12px;"><noscript><strong>We're sorry but colorShopGame doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id="app"><div data-v-4ab5abd9="" class="mian"><div data-v-c2022cca="" data-v-4ab5abd9="" style="background: linear-gradient(90deg,#f95959 0%,#ff9a8e 100%)!important;" class="navbar"><div data-v-c2022cca="" class="navbar-left"></div><div data-v-c2022cca="" class="navbar-title"> My Team </div><div data-v-c2022cca="" class="navbar-right"><div data-v-4ab5abd9="" data-v-c2022cca="" class="c-row"><i data-v-4ab5abd9="" data-v-c2022cca="" class="" style="font-size: 25px;"><!----></i></div></div></div><div data-v-4ab5abd9="" class="promotion"><div data-v-4ab5abd9="" class="tab"><ul data-v-4ab5abd9="" class="c-row c-row-between"><li data-v-4ab5abd9="" onclick="window.location.href='promotion#'">Data Overview</li><li data-v-4ab5abd9="" onclick="window.location.href='/myTeam?user=<?php echo  $_SESSION['username']?>'"class="action" style="color:#f95959;">My Team</li></ul></div><div data-v-4ab5abd9="" class="box"><div data-v-4ab5abd9="" class="tit c-row c-row-between">Direct Team(<?php echo $rowcount+$rowcount2?>People)</div></div><div data-v-4ab5abd9="" class="hd van-row"></div><div class="invnav">
                                <div data-v-4ab5abd9="" class="inavlist btn c-tc act" id="l1" onclick="l1()" style="font-size:20px;">Level 1</div>
                                <div data-v-4ab5abd9="" class="inavlist btn c-tc act" id="l2" style="background:#bbd2f0;font-size:20px;" onclick="l2()">Level 2</div>
                            </div>
				
				 <div class="row mr-0">
                            <div class="col-12 pa-0" id="dtaod">
                     <div id="level2" style="display:none;">
            <?php echo $dataRow1;?>
            </div>
            <div id="level1" style="display:;">
            <?php echo $dataRow;?>
            </div>
				
				</div></div></div></div></div><div data-v-7692a079="" data-v-4ab5abd9="" class="Loading c-row c-row-middle-center" style="display: none;"><div data-v-7692a079="" class="van-loading van-loading--circular"><span data-v-7692a079="" class="van-loading__spinner van-loading__spinner--circular" style="color: rgb(242, 65, 59);"><svg data-v-7692a079="" viewBox="25 25 50 50" class="van-loading__circular"><circle data-v-7692a079="" cx="50" cy="50" r="20" fill="none"></circle></svg></span></div></div></div></div><script>window.onload = function () {
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
		}</script><style>html,body{ height: 100%; width: 100%; background-color: #FFF;padding: 0;margin: 0;}</style><script src="js/chunk-vendors.d6090956.js"></script><script src="js/app.90bf53ad.js"></script>
				
				
				 <style>
  
  .nav-top, .stick {
    background: #0093ff;
}
  .inavlist.act {
    background: #0093ff;
    color: #fff;
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
    min-height: 88px;
    padding: 16px;
    color: #fff;
    font-size: 14px;
    line-height: 20px;
    white-space: pre-wrap;
    text-align: center;
    word-wrap: break-word;
    background-color: rgba(50, 50, 51, .88);
    border-radius: 8px;
    -webkit-transform: translate3d(-50%, -50%, 0);
    transform: translate3d(-50%, -50%, 0);
}
.van-toast--html, .van-toast--text {
    width: -webkit-fit-content;
    width: fit-content;
    min-width: 96px;
    min-height: 0;
    padding: 8px 12px;
}
.mian .promotion .btn[data-v-4ab5abd9] {
    height: 0.96rem;
    line-height: .96rem;
    padding: 0 0.26667rem;
    min-width: 1.6rem;
    background-color:#f95959;
    color: #fff;
    border-radius: 1.13333rem;
    box-shadow: 0 0.10667rem 0.53333rem 0.05333rem rgba(255,153,0,.27);
}
.back, .nav-back {
    background: url(/icons/back.png) no-repeat center;
    background-size: contain;
    height: 40px;
    min-width: 22px;
    display: inline-flex;
    vertical-align: text-top;
    cursor: pointer;
}
.navbar[data-v-c2022cca] {
    width: 100%;
    max-width: 10.66667rem;
    top: 0;
    height: 1.33333rem;
    line-height: 0.33333rem;
    background-image: linear-gradient(90deg,#f90,#e57201);
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    color: #fff;
    z-index: 999;
}
  </style>
				<script src="js/chunk-vendors.c557979e.js"></script><script src="js/app.0c3fc000.js"></script><script>mui.init({
      keyEventBind: {
        backbutton: true,
      }
    })
    var first = null;
    mui.back = function(){
      if(!first){
        first = new Date().getTime();
		var route_name = window.location.hash;
		if(route_name.search('mine') != -1 || route_name.search('login') != -1){
			mui.toast("Press again to exit the app");
			setTimeout(function(){
			  first = null;
			}, 500);
		}else{
			history.go(-1);
			first = null;
		};


      }else{
        if(new Date().getTime() - first < 500){
          plus.runtime.quit();
        }
      }
    }</script></body></html>
   <script>
         function l1(){
            document.getElementById("l1").style.backgroundColor="#0487E2";
            document.getElementById("l2").style.backgroundColor="#bbd2f0";
         
            
            document.getElementById("level1").style.display="";
            document.getElementById("level2").style.display="none";
           
            
        }
        function l2(){
            document.getElementById("l1").style.backgroundColor="#bbd2f0";
            document.getElementById("l2").style.backgroundColor="#0487E2";
          
            
            document.getElementById("level1").style.display="none";
            document.getElementById("level2").style.display="";
    
            
        }
   </script>
</body>

</html>