 <?php
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$con= mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE)or die( "Unable to select database");
$str =$_POST["S"];
	//die(var_dump($str));
$signal_strength="";
$broadcaster_id="";
$receiver_id="1";

	
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
	$broadcaster_id=$data;
	}
	elseif($a==3)
	{
	$signal_strength=-$data;
	}
}
print_r("signal_strength=".$signal_strength);
print nl2br("\n");
print_r("broadcaster_id=".$broadcaster_id);
print nl2br("\n");

date_default_timezone_set('Asia/Kolkata');
$current_Date=date('Y-m-d H:i:s');
$query = "INSERT INTO `indoor` (`receiver_id`,`broadcaster_id`,`signal_strength`,`date_time`) 	
		VALUES ('$receiver_id','$broadcaster_id','$signal_strength','$current_Date')"; 
 /*  	$query = "SELECT * FROM indoor order by  broadcaster_id='98:0c:a5:aa:5c:3f' desc limit 1 " ;
	$result = mysqli_query($query);
$list = array(); */
   	mysqli_query($con,$query);
   	
	mysqli_close($con);
echo "Sucess";
 ?>