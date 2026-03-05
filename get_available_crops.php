<?php
include "db.php";

$sql = "SELECT fc.fc_id, c.crop_name, fc.expected_yield, fc.start_date, f.farmer_id, u.name as farmer_name
        FROM farmer_crops fc
        JOIN crops c ON fc.crop_id=c.crop_id
        JOIN farmers f ON fc.farmer_id=f.farmer_id
        JOIN users u ON f.user_id=u.user_id
        WHERE fc.status='growing'";
$res = mysqli_query($conn,$sql);

$rows = array();
while($r=mysqli_fetch_assoc($res)){ $rows[]=$r; }
echo json_encode($rows);
?>
