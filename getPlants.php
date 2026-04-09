<?php
include "db.php";

// Get all plants
$result = $conn->query("SELECT * FROM plants ORDER BY common_name ASC");

$plants = [];
while($row = $result->fetch_assoc()){
    $plants[] = $row;
}

header('Content-Type: application/json');
echo json_encode($plants);
?>