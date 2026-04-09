<?php
header("Content-Type: application/json");
error_reporting(0);

$conn = new mysqli("localhost", "root", "", "farmeta");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error","message"=>"DB Connection Failed"]);
    exit();
}

// Delete entries older than 2 days
$sql = "DELETE FROM fertilizer_history WHERE created_at < NOW() - INTERVAL 2 DAY";
if ($conn->query($sql)) {
    echo json_encode(["status"=>"success","message"=>"Old history deleted"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Delete failed"]);
}

$conn->close();
?>