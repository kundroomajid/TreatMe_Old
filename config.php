<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

	ini_set('error_reporting', E_ALL & ~E_NOTICE);
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "id6156934_users";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
