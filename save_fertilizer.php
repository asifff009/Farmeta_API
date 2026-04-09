<?php
header("Content-Type: application/json");
error_reporting(0);

// DB connection
$conn = new mysqli("localhost", "root", "", "farmeta");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error","message"=>"DB Connection Failed"]);
    exit();
}

// Get POST data safely
$crop = isset($_POST['crop']) ? $_POST['crop'] : '';
$land_size = isset($_POST['land_size']) ? $_POST['land_size'] : '';
$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
$nitrogen = isset($_POST['nitrogen']) ? $_POST['nitrogen'] : '';
$phosphorus = isset($_POST['phosphorus']) ? $_POST['phosphorus'] : '';
$potassium = isset($_POST['potassium']) ? $_POST['potassium'] : '';

// Check required fields
if ($crop == '' || $land_size == '' || $unit == '' || $nitrogen == '' || $phosphorus == '' || $potassium == '') {
    echo json_encode(["status"=>"error","message"=>"Missing parameters"]);
    exit();
}

// Prepare statement to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO fertilizer_history (crop, land_size, unit, nitrogen, phosphorus, potassium, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sddddd", $crop, $land_size, $unit, $nitrogen, $phosphorus, $potassium);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success","message"=>"History saved successfully"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Insert failed"]);
}

$stmt->close();
$conn->close();
?>