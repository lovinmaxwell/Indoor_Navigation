
<?php
function Connection(){
$DB_HOST="localhost";
$DB_USER="ellipson_lovin";
$DB_PASSWORD="LOVINm2xwell";
$DB_DATABASE="ellipson_wifi";
$con=mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE);
		echo "connected";
		//$t=$_POST["S"];
		//$query = "INSERT INTO `data` (`Info`) VALUES ('$t')"; 
		
   	
mysqli_query($con,$query);
mysqli_close($con);
echo "Sucess";
}	
?>