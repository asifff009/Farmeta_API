<?php
$conn = new mysqli("localhost","root","","farmeta");

$district = $_GET['district'] ?? "";
$city = $_GET['city'] ?? "";
$temp = $_GET['temp'] ?? "";
$humidity = $_GET['humidity'] ?? "";
$wind = $_GET['wind'] ?? "";
$desc = $_GET['desc'] ?? "";

if($district){
    // Update if exists, else insert
    $sql = "INSERT INTO weather_info (district, city, temp, humidity, wind, description) 
            VALUES ('$district','$city','$temp','$humidity','$wind','$desc')
            ON DUPLICATE KEY UPDATE city='$city', temp='$temp', humidity='$humidity', wind='$wind', description='$desc'";
    $conn->query($sql);
    echo "Saved";
}
?>