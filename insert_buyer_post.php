<?php
$conn = new mysqli("localhost","root","","farmeta");

$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$location = $_POST['location'];

$crop = explode(",", $_POST['crop']);
$quantity = explode(",", $_POST['quantity']);
$price = explode(",", $_POST['price']);

// 1. Insert main post
$stmt = $conn->prepare("INSERT INTO buyer_posts(name,email,contact,location) VALUES (?,?,?,?)");
$stmt->bind_param("ssss",$name,$email,$contact,$location);
$stmt->execute();

$post_id = $stmt->insert_id;

// 2. Insert items
for($i=0; $i<count($crop); $i++){

    $c = trim($crop[$i]);
    $q = trim($quantity[$i]);
    $p = trim($price[$i]);

    $stmt2 = $conn->prepare("INSERT INTO buyer_post_items(post_id,crop_name,quantity,price) VALUES (?,?,?,?)");
    $stmt2->bind_param("isss",$post_id,$c,$q,$p);
    $stmt2->execute();
}

echo "success";
?>