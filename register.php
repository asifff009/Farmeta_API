<?php
include "db.php";

$name = $_POST['name'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$role = $_POST['role'];

mysqli_query($conn,
 "INSERT INTO users(name, phone, password, role)
  VALUES('$name','$phone','$password','$role')"
);

$user_id = mysqli_insert_id($conn);

if ($role == "farmer") {
    $location = $_POST['location'];
    $land_size = $_POST['land_size'];

    mysqli_query($conn,
     "INSERT INTO farmers(user_id, location, land_size)
      VALUES('$user_id','$location','$land_size')"
    );
} else if ($role == "buyer") {
    $shop_name = $_POST['shop_name'];

    mysqli_query($conn,
     "INSERT INTO buyers(user_id, shop_name)
      VALUES('$user_id','$shop_name')"
    );
}

echo json_encode(["status"=>"success"]);
?>
