 <?php
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$con= mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE)or die( "Unable to select database");
//$mac="98:0c:a5:d7:ac:26";
//$mac="94:65:2d:00:99:5d";
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
	$toAndroid = array();

while ($row = mysqli_fetch_array($result)) {	
  echo $row{'R1'}."<br>";
   echo $row{'R2'}."<br>";
   echo $row{'R3'}."<br>"; 
 // $toAndroid[]=$row;

  // array_push($toAndroid,array($row[0],$row[1],$row[2]));
}


//close the connection
//$val=json_encode($toAndroid);

//echo  $val; //encode the php array to json and return in Json format

   	
	mysqli_close($con);


?>