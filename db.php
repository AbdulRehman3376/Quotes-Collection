<?php
$serverName = "Localhost";
$userName = "root";
$password = "";
$db_name = "quote_app";
$con = new mysqli($serverName, $userName, $password, $db_name);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>