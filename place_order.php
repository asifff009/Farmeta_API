<?php
include "db.php";

$buyer_id = $_POST['buyer_id'];
$farmer_id = $_POST['farmer_id'];
$crop_id = $_POST['crop_id'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$total_amount = $quantity * $price;

// Insert order
mysqli_query($conn,"INSERT INTO orders(buyer_id,farmer_id,order_date,total_amount) VALUES('$buyer_id','$farmer_id',NOW(),'$total_amount')");
$order_id = mysqli_insert_id($conn);

// Insert order item
mysqli_query($conn,"INSERT INTO order_items(order_id,crop_id,quantity,price) VALUES('$order_id','$crop_id','$quantity','$price')");

// Update farmer_crops status to sold
mysqli_query($conn,"UPDATE farmer_crops SET status='sold' WHERE farmer_id='$farmer_id' AND crop_id='$crop_id'");

echo json_encode(["status"=>"success"]);
?>
