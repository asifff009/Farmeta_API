<?php
$conn = mysqli_connect("localhost","root","","farmeta");

if(!$conn){
    die(json_encode(["status"=>"error","message"=>"DB connection failed: ".mysqli_connect_error()]));
}

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo json_encode(["status"=>"error","message"=>"Invalid request method"]);
    exit;
}

$first_name  = isset($_POST['first_name']) ? mysqli_real_escape_string($conn,$_POST['first_name']) : '';
$last_name   = isset($_POST['last_name']) ? mysqli_real_escape_string($conn,$_POST['last_name']) : '';
$crop_name   = isset($_POST['crop_name']) ? mysqli_real_escape_string($conn,$_POST['crop_name']) : '';
$quantity    = isset($_POST['quantity']) ? mysqli_real_escape_string($conn,$_POST['quantity']) : '';
$price       = isset($_POST['price']) ? mysqli_real_escape_string($conn,$_POST['price']) : '';
$contact     = isset($_POST['contact']) ? mysqli_real_escape_string($conn,$_POST['contact']) : '';
$address     = isset($_POST['address']) ? mysqli_real_escape_string($conn,$_POST['address']) : '';
$type        = isset($_POST['type']) ? mysqli_real_escape_string($conn,$_POST['type']) : ''; // new field
$imageBase64 = isset($_POST['image']) ? $_POST['image'] : '';

if(empty($first_name) || empty($last_name) || empty($crop_name) || empty($quantity) || empty($price) || empty($contact) || empty($address) || empty($type) || empty($imageBase64)){
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}

$imageName = time() . ".jpg"; 
$uploadDir = __DIR__ . "/uploads/"; 
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0777, true);
}
$imagePath = $uploadDir . $imageName;

$decodedImage = base64_decode($imageBase64);
if(!$decodedImage || file_put_contents($imagePath, $decodedImage) === false){
    echo json_encode(["status"=>"error","message"=>"Failed to save image"]);
    exit;
}

$sql = "INSERT INTO crops(first_name, last_name, crop_name, quantity, price, contact, address, type, image) 
        VALUES('$first_name','$last_name','$crop_name','$quantity','$price','$contact','$address','$type','$imageName')";

if(mysqli_query($conn, $sql)){
    echo json_encode(["status"=>"success","message"=>"Crop uploaded successfully"]);
}else{
    echo json_encode(["status"=>"error","message"=>"DB insert failed: ".mysqli_error($conn)]);
}
?>