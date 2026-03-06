<?php
$conn = mysqli_connect("localhost","root","","farmeta");

$result = mysqli_query($conn,"SELECT * FROM crops");
$data = array(); 

while($row = mysqli_fetch_assoc($result)){ 
    $data[] = $row; 
}

echo json_encode($data);
?>