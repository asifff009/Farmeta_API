<?php
include "db.php";

$crop_name=$_POST['crop_name'];
$market_name=$_POST['market_name'];

$csql="SELECT crop_id FROM crops WHERE crop_name='$crop_name'";
$cres=mysqli_query($conn,$csql);
$crop_id=mysqli_fetch_assoc($cres)['crop_id'];

$msql="SELECT market_id FROM markets WHERE market_name='$market_name'";
$mres=mysqli_query($conn,$msql);
$market_id=mysqli_fetch_assoc($mres)['market_id'];

$sql="SELECT price_per_kg,date FROM crop_prices WHERE crop_id='$crop_id' AND market_id='$market_id' ORDER BY date DESC";
$res=mysqli_query($conn,$sql);

$rows=array();
while($r=mysqli_fetch_assoc($res)){ $rows[]=$r; }
echo json_encode($rows);
?>
