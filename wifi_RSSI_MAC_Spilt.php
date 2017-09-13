 <?php
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$con= mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE)or die( "Unable to select database");
$str =$_POST["S"];
	//die(var_dump($str));
$RSSI="";
$MAC="";
$datafrom="Ellipsonic";

	
$raw = explode(',', $str);
$f = array_shift($raw);
$ff = array_pop($raw);
print_r($raw);
print nl2br("\n");
foreach($raw as $data)
{
	$a = strlen($data);
	if($a==17)
	{
	$MAC=$data;
	}
	elseif($a==3)
	{
	$RSSI=$data;
	}
}
print_r("RSSI=".$RSSI);
print nl2br("\n");
print_r("MAC=".$MAC);
print nl2br("\n");

date_default_timezone_set('Asia/Kolkata');
$current_Date=date('Y-m-d H:i:s');
$query = "INSERT INTO `wifi_rissi_mac` (`RSSI`,`MAC`,`Time`,`DataFrom`) 	
		VALUES ('$RSSI','$MAC','$current_Date','$datafrom')"; 
  	
   	mysqli_query($con,$query);
   	
	mysqli_close($con);
echo "Sucess";
?>