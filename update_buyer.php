<?php
include "db.php";

$id = $_POST['id'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$location = $_POST['location'];
$crop = $_POST['crop'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "UPDATE buyer_posts SET 
name='$name',
contact='$contact',
location='$location',
crop='$crop',
quantity='$quantity',
price='$price'
WHERE id='$id'";

if($conn->query($sql)){
    echo "success";
} else {
    echo "error";
}
?>