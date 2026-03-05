<?php
include "db.php";

$farmer_id = $_POST['farmer_id'];
$crop_name = $_POST['crop_name'];
$start_date = $_POST['start_date'];
$expected_yield = $_POST['expected_yield'];

// Get crop_id
$sql = "SELECT crop_id FROM crops WHERE crop_name='$crop_name'";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);
$crop_id = $row['crop_id'];

// Insert into farmer_crops
$sql = "INSERT INTO farmer_crops(farmer_id,crop_id,start_date,expected_yield,status)
        VALUES('$farmer_id','$crop_id','$start_date','$expected_yield','growing')";
if(mysqli_query($conn,$sql)){
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"failed"]);
}
?>
