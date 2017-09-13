<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 5/29/2015
 * Time: 4:23 PM
 */

	//include("data_to_server1.php");
	
	//include("data_to_server2.php");
	
	include("connect.php");
	$link=Connection();
  $result=mysqli_query("SELECT * FROM  ellipson_wifi.indoor",$link);
include("header.php");
?>
<div class="container">
    <h1>Position tracking through radio</h1>

    <p>Read data from Arduino and perform the analysis to calculate the position</p>

    <div class="column table">
        <button class="collapseTable">Collapse table</button>
        <table border="1" cellspacing="1" cellpadding="1" class="flat-table flat-table-1">
            <tbody>
            <tr>
                <th>&nbsp;Receiver ID&nbsp;</th>
                <th>&nbsp;Broadcaster ID&nbsp;</th>
                <th>&nbsp;Signal Strength&nbsp;</th>
                <th>&nbsp;Time&nbsp;</th>
            </tr>

            <?php
            if ($result !== FALSE) {
                while ($row = mysqli_fetch_array($result)) {
                    printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>",
                        $row["receiver_id"], $row["broadcaster_id"], $row["signal_strength"], $row["Time"]);
                }
                mysqli_free_result($result);
                mysqli_close();
            }
            ?>
            </tbody>

        </table>
    </div>

    <div class="column">
        <button id="start">Start</button>
        <canvas id="map" width="400" height="400"></canvas>
        <div id="info"></div>
    </div>
    <script src="/wisdomkraft.com/wisdomkraft.com/prudence/Indoor_nav/main1.js"></script>
</div>

<?php include("footer.php"); ?>
