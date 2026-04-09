<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "farmeta");
if (!$conn) {
    die(json_encode(["status"=>"error","message"=>"DB connection failed: ".mysqli_connect_error()]));
}

// Check request method
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo json_encode(["status"=>"error","message"=>"Invalid request method"]);
    exit;
}

// Get POST data
$name    = isset($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '';
$type    = isset($_POST['type']) ? mysqli_real_escape_string($conn,$_POST['type']) : '';
$address = isset($_POST['address']) ? mysqli_real_escape_string($conn,$_POST['address']) : '';
$contact = isset($_POST['contact']) ? mysqli_real_escape_string($conn,$_POST['contact']) : '';

// Validation
if(empty($name) || empty($type) || empty($address) || empty($contact)){
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}

// Insert crop into req_crops table (buyer posts)
$sql = "INSERT INTO req_crops(crop_name, type, address, contact)
        VALUES('$name','$type','$address','$contact')";

if(mysqli_query($conn, $sql)){
    echo json_encode(["status"=>"success","message"=>"Post uploaded successfully"]);
}else{
    echo json_encode(["status"=>"error","message"=>"DB insert failed: ".mysqli_error($conn)]);
}

mysqli_close($conn);
?>