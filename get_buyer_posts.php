<?php
$conn = new mysqli("localhost","root","","farmeta");

$result = $conn->query("SELECT * FROM buyer_posts ORDER BY id DESC");

$data = array();

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>