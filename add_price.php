<?php
$conn = new mysqli("localhost","root","","farmeta");

$crop = $_POST['crop_name'];
$price = $_POST['price'];
$district = $_POST['district'];

$sql = "INSERT INTO market_price (crop_name, price, district)
        VALUES ('$crop','$price','$district')";

if($conn->query($sql)){
    echo "success";
}else{
    echo "error";
}
?>