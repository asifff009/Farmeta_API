<?php
$conn = mysqli_connect("localhost","root","","farmeta");

// Check DB connection
if(!$conn){ die("DB connection failed: " . mysqli_connect_error()); }

$name = $_POST['name'] ?? '';
$image = $_POST['image'] ?? '';

if(empty($name) || empty($image)){
    echo "Name or image missing";
    exit;
}

$imageName = time() . ".jpg";
$uploadDir = __DIR__ . "/uploads/";  // absolute path
$path = $uploadDir . $imageName;

// decode and save
$decodedImage = base64_decode($image);
if(file_put_contents($path, $decodedImage) === false){
    echo "Failed to save image in uploads folder";
    exit;
} else {
    echo "Saved in: $path\n"; // <-- debug message
}

// insert into DB
$sql = "INSERT INTO crops(name,image) VALUES('$name','$imageName')";
if(mysqli_query($conn,$sql)){
    echo "success";
}else{
    echo "Failed to insert into DB: " . mysqli_error($conn);
}
?>