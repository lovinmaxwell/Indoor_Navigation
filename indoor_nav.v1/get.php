<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 6/10/2015
 * Time: 1:01 PM
 */
$from = $_GET['from'];
$to = $_GET['to'];
include("data_to_server1.php");
include("data_to_server2.php");
include("data_to_server3.php");
//$link = Connection();
$query = "SELECT * FROM indoor WHERE Time BETWEEN '$from' AND '$to'";
$result = mysqli_query($query, $link);
$list = array();
if ($result === FALSE) {
    echo "No data";
} else {
    while ($rec = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $list[] = array('receiver_id' => $rec['receiver_id'], 'broadcaster_id' => $rec['broadcaster_id'],
            'signal_strength' => $rec['signal_strength'], 'Time' => $rec['current_Date']);
    }
    echo json_encode($list);
}