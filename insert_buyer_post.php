<?php
$conn = new mysqli("localhost","root","","farmeta");

$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$location = $_POST['location'];
$crop = $_POST['crop'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$stmt = $conn->prepare("INSERT INTO buyer_posts(name,email,contact,location,crop,quantity,price) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss",$name,$email,$contact,$location,$crop,$quantity,$price);

if($stmt->execute()){
    echo json_encode(["status"=>"success"]);
}else{
    echo json_encode(["status"=>"failed"]);
}
?>