<?php
//error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Kolkata');
//error_reporting(0);
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "medicine";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}else{
	//echo "Connected successfully";
}
?>