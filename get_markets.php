<?php
include "db.php";
$sql="SELECT * FROM markets";
$res=mysqli_query($conn,$sql);
$rows=array();
while($r=mysqli_fetch_assoc($res)){ $rows[]=$r; }
echo json_encode($rows);
?>
