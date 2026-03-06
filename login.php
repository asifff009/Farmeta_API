<?php
include "db.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo json_encode(["status"=>"error","message"=>"Invalid request method"]);
    exit;
}

$email = isset($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '';
$password = isset($_POST['password']) ? mysqli_real_escape_string($conn,$_POST['password']) : ''; 

if(empty($email) || empty($password)){
    echo json_encode(["status"=>"error","message"=>"Email and Password required"]);
    exit;
}

$sql = "SELECT * FROM signup_info WHERE email='$email' AND password='$password'";
$res = mysqli_query($conn,$sql);

if(mysqli_num_rows($res) > 0){ 
    $user = mysqli_fetch_assoc($res); 
    echo json_encode([
        "status"=>"success",
        "user_id"=>$user['user_id'],
        "name"=>$user['name'],
        "role"=>$user['role']
    ]);
}else{
    echo json_encode(["status"=>"fail","message"=>"Invalid credentials"]);
}
?>
