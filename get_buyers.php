<?php
include "db.php";

$result = $conn->query("SELECT * FROM buyer_posts");

$data = array();

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>