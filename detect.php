<?php

$conn = mysqli_connect("localhost","root","","farmeta");

$image = $_POST['image']; // base64 image

$imagePath = "uploads/" . time() . ".jpg";
$decodedImage = base64_decode($image);
file_put_contents($imagePath, $decodedImage);

// Plant.id API Call
$api_key = "YOUR_API_KEY";

$data = [
    "images" => [base64_encode(file_get_contents($imagePath))],
    "modifiers" => ["disease"],
    "plant_language" => "en",
    "disease_details" => ["description", "treatment"]
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.plant.id/v2/identify");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Api-Key: $api_key"
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// Extract data
$disease_name = $result['health_assessment']['diseases'][0]['name'] ?? "Unknown";
$confidence = $result['health_assessment']['diseases'][0]['probability'] ?? "0";
$solution = $result['health_assessment']['diseases'][0]['treatment']['chemical'][0] ?? "No solution";

// Save to DB
mysqli_query($conn,"INSERT INTO crop_disease(image,disease_name,confidence,solution)
VALUES('$imagePath','$disease_name','$confidence','$solution')");

// Response
echo json_encode([
    "image"=>$imagePath,
    "disease"=>$disease_name,
    "confidence"=>$confidence,
    "solution"=>$solution
]);

?>