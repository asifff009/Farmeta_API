<?php
$conn = new mysqli("localhost","root","","farmeta");

$result = $conn->query("SELECT * FROM market_price ORDER BY date DESC");

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>