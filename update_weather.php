<?php
header('Content-Type: application/json');

$city = isset($_GET['city']) ? $_GET['city'] : "Dhaka";

$conn = new mysqli("localhost", "root", "", "farmeta");
if ($conn->connect_error) {
    die(json_encode(["error"=>"DB connection failed: " . $conn->connect_error]));
}

$stmt = $conn->prepare("SELECT temperature, humidity, wind_speed, description, updated_at FROM weather WHERE city=?");
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    echo json_encode([
        "city" => $city,
        "temperature" => $row['temperature'],
        "humidity" => $row['humidity'],
        "wind_speed" => $row['wind_speed'],
        "description" => $row['description'],
        "updated_at" => $row['updated_at']
    ]);
}else{
    echo json_encode(["error"=>"No data found for city: $city"]);
}

$stmt->close();
$conn->close();
?>