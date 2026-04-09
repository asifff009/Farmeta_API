<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "farmeta");
if (!$conn) {
    die(json_encode(["status"=>"error","message"=>"DB connection failed: ".mysqli_connect_error()]));
}

$sql = "SELECT * FROM req_crops ORDER BY id DESC"; // id descending, latest first
$result = mysqli_query($conn, $sql);

$rows = array();
while($r = mysqli_fetch_assoc($result)){
    $rows[] = $r;
}

echo json_encode($rows);

mysqli_close($conn);
?>