<?php
$conn = new mysqli("localhost","root","","farmeta");

$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$location = $_POST['location'];
$crop = $_POST['crop'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "UPDATE buyer_posts 
        SET name=?, contact=?, location=?, crop=?, quantity=?, price=? 
        WHERE email=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss",
    $name,
    $contact,
    $location,
    $crop,
    $quantity,
    $price,
    $email
);

echo $stmt->execute() ? "success" : "failed";
?>