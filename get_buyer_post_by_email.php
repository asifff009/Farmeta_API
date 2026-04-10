<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost","root","","farmeta");
if($conn->connect_error){
    echo json_encode(["success"=>false,"error"=>"DB connection failed"]);
    exit;
}

$email = $_GET['email'];

$sql = "SELECT bp.id, bp.name, bp.email, bp.contact, bp.location,
        GROUP_CONCAT(bpi.crop SEPARATOR ',') as crop,
        GROUP_CONCAT(bpi.quantity SEPARATOR ',') as quantity,
        GROUP_CONCAT(bpi.price SEPARATOR ',') as price
        FROM buyer_posts bp
        LEFT JOIN buyer_post_items bpi ON bp.id = bpi.post_id
        WHERE bp.email='$email'
        GROUP BY bp.id
        LIMIT 1";

$result = $conn->query($sql);
if($result && $result->num_rows>0){
    $row = $result->fetch_assoc();
    echo json_encode(["success"=>true,"data"=>$row]);
}else{
    echo json_encode(["success"=>false,"error"=>"No post found for this email"]);
}
$conn->close();
?>