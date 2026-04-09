<?php
$conn = new mysqli("localhost","root","","farmeta");

$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$location = $_POST['location'];
$crop = $_POST['crop'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "INSERT INTO buyer_posts(name,email,contact,location,crop,quantity,price)
VALUES('$name','$email','$contact','$location','$crop','$quantity','$price')";

if($conn->query($sql)){
    echo "success";
}else{
    echo "error";
}
?>