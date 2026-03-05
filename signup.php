<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}

$name     = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
$email    = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
$password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
$role     = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : '';

if (empty($name) || empty($email) || empty($password) || empty($role)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields required"
    ]);
    exit;
}

// check duplicate email
$check = mysqli_query($conn, "SELECT * FROM signup_info WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(["status" => "exists"]);
    exit;
}

// insert new user
$sql = "INSERT INTO signup_info (name, email, password, role) 
        VALUES ('$name', '$email', '$password', '$role')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
}
?>
