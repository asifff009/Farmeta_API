<?php
header("Content-Type: application/json");
error_reporting(0);

$conn = new mysqli("localhost", "root", "", "farmeta");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error","data"=>[]]);
    exit();
}

// Fetch all history
$sql = "SELECT * FROM fertilizer_history ORDER BY id DESC";
$result = $conn->query($sql);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "crop" => $row["crop"] ?? "",
            "land_size" => (double)($row["land_size"] ?? 0),
            "unit" => $row["unit"] ?? "",
            "nitrogen" => (double)($row["nitrogen"] ?? 0),
            "phosphorus" => (double)($row["phosphorus"] ?? 0),
            "potassium" => (double)($row["potassium"] ?? 0),
            "created_at" => $row["created_at"] ?? ""
        ];
    }
}

echo json_encode(["status"=>"success","data"=>$data]);

$conn->close();
?>