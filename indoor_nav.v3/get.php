<?php
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$from = $_GET['from'];
$to = $_GET['to'];
$con=mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE);
		//echo "connected";print nl2br("\n");
//$query = "SELECT * FROM indoor where  broadcaster_id='9c:d9:17:68:1e:70' order by  ID DESC limit 30 " ; 
//$query = "SELECT * FROM indoor WHERE date_time BETWEEN '$from' AND '$to'";
$query ="SELECT * FROM indoor where  broadcaster_id='9c:d9:17:68:1e:70' order by  date_time BETWEEN '$from' AND '$to'";
$result =mysqli_query($con,$query); 

$list = array();
if ($result != FALSE) {
	while($rec = mysqli_fetch_array($result,MYSQLI_ASSOC)):
	 $list[] = array('receiver_id' => $rec['receiver_id'], 'broadcaster_id' => $rec['broadcaster_id'],
            'signal_strength' => $rec['signal_strength'], 'date_time' => $rec['date_time']);
 endwhile;
    
} else {
	echo "No data";
}
    echo json_encode($list);
	
mysqli_close($con);
?>

