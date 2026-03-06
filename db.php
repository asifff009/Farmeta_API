<?php
error_reporting(0); 
header('Content-Type: application/json'); 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "farmeta"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die(json_encode(["status"=>"error","message"=>"Database connection failed: ".mysqli_connect_error()]));
    
    
    }
?>
