 <?php
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$con= mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE)or die( "Unable to select database");
//$mac="98:0c:a5:d7:ac:26";
//$mac="94:65:2d:00:99:5d";
//$mac="9c:d9:17:68:1e:70";74:de:2b:33:10:93
//$mac="d8:3c:69:0c:5c:b3";
//$mac="98:0c:a5:d7:ac:26";
$mac="74:de:2b:33:10:93";
$query = "SELECT  (
    SELECT signal_strength
    FROM   ellipson_wifi.indoor
    where broadcaster_id='$mac'
	and receiver_id  = 1 
    order by ID DESC limit 1
    ) AS R1,
    (
    SELECT signal_strength
    FROM   ellipson_wifi.indoor
    where broadcaster_id='$mac'
	and receiver_id  = 2
    order by ID DESC limit 1
    ) AS R2,
    (
    SELECT signal_strength
    FROM   ellipson_wifi.indoor
    where broadcaster_id='$mac'
	and receiver_id  = 3
    order by ID DESC limit 1
    ) AS R3;"; 
  	
$result= mysqli_query($con,$query); 

$data=array();

while($rows = mysqli_fetch_array($result)):
	array_push($data,array('R1'=>$rows['R1'],'R2'=>$rows['R2'],'R3'=>$rows['R3']));
 endwhile;
$val=json_encode($data);
 echo  $val;  	
mysqli_close($con);
?>