<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 5/29/2015
 * Time: 4:24 PM
 */
    function Connection(){
        $server="localhost";
        $user="ellipson_lovin";
        $pass="LOVINm2xwell";
        $db="ellipson_wifi";

        $connection = mysql_connect($server, $user, $pass);

        if (!$connection) {
            die('MySQL ERROR: ' . mysql_error());
        }

        mysql_select_db($db) or die( 'MySQL ERROR: '. mysql_error() );

        return $connection;
    }
?>
