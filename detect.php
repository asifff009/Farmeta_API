<?php
header('Content-Type: application/json');

// DB Connect
$conn = mysqli_connect("localhost","root","","farmeta");

// Receive base64 image
$image = $_POST['image'] ?? '';
if(!$image){
    echo json_encode(["error"=>"No image received"]);
    exit;
}

// Save image
$imagePath = "uploads/" . time() . ".jpg";
if(!file_put_contents($imagePath, base64_decode($image))){
    echo json_encode(["error"=>"Failed to save image"]);
    exit;
}

// Plant.id API
$api_key = "YOUR_API_KEY"; // <-- Replace this with your real API key

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

// Debugging (optional, remove later)
// echo "<pre>"; print_r($result); exit;

// Extract data safely
$disease_name = "Unknown";
$confidence = "0";
$solution = "No solution";

if(!empty($result['suggestions'][0]['diseases'])){
    $disease = $result['suggestions'][0]['diseases'][0]; // First disease
    $disease_name = $disease['name'] ?? "Unknown";
    $confidence = isset($result['suggestions'][0]['probability']) ? round($result['suggestions'][0]['probability']*100,2)."%" : "0";
    $solution = $disease['treatment']['chemical'][0] ?? "No solution";
}

// Save to DB
mysqli_query($conn,"INSERT INTO crop_disease(image,disease_name,confidence,solution)
VALUES('$imagePath','$disease_name','$confidence','$solution')");

// Send JSON Response
echo json_encode([
    "image"=>$imagePath,
    "disease"=>$disease_name,
    "confidence"=>$confidence,
    "solution"=>$solution
]);

?>