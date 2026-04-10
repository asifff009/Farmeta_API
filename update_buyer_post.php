<?php
$conn = new mysqli("localhost","root","","farmeta");

$post_id = $_POST['post_id'];

$name = $_POST['name'];
$contact = $_POST['contact'];
$location = $_POST['location'];

$crop = explode(",", $_POST['crop']);
$quantity = explode(",", $_POST['quantity']);
$price = explode(",", $_POST['price']);

// 1. update main
$conn->query("UPDATE buyer_posts 
SET name='$name', contact='$contact', location='$location'
WHERE id=$post_id");

// 2. delete old items
$conn->query("DELETE FROM buyer_post_items WHERE post_id=$post_id");

// 3. insert new items
for($i=0; $i<count($crop); $i++){

    $c = trim($crop[$i]);
    $q = trim($quantity[$i]);
    $p = trim($price[$i]);

    $conn->query("INSERT INTO buyer_post_items(post_id,crop_name,quantity,price)
    VALUES ($post_id,'$c','$q','$p')");
}

echo "success";
?>