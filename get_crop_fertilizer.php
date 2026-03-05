<?php
include "db.php";

$crop_name = $_POST['crop_name'];

// Get crop_id
$sql = "SELECT crop_id FROM crops WHERE crop_name='$crop_name'";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);
$crop_id = $row['crop_id'];

// Get fertilizers
$sql = "SELECT f.name as fertilizer_name, cf.amount_per_acre 
        FROM crop_fertilizer cf 
        JOIN fertilizers f ON cf.fertilizer_id=f.fertilizer_id 
        WHERE cf.crop_id='$crop_id'";
$result = mysqli_query($conn,$sql);

$rows = array();
while($r=mysqli_fetch_assoc($result)){
    $rows[]=$r;
}

echo json_encode($rows);
?>
