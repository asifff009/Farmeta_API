<?php
// DB connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "farmeta";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die(json_encode(["error"=>"DB Connection Failed"]));
}

// Read JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($data['image']) || empty($data['image'])) {
    echo json_encode(["error"=>"No image provided"]);
    exit;
}

// Decode base64
$imageBase64 = str_replace(' ', '+', $data['image']);
$imageData = base64_decode($imageBase64);
if (!$imageData) {
    echo json_encode(["error"=>"Invalid Base64"]);
    exit;
}

// Save locally
$uploadDir = __DIR__."/uploads";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
$filename = time()."_leaf.jpg";
file_put_contents($uploadDir."/".$filename, $imageData);

// Plant.id API key
$apiKey = "https://api.plant.id/v3/identification"; // <-- এখানে তোমার Plant.id API key দিবে

// Prepare JSON for Plant.id
$plantIdJson = [
    "images" => [
        base64_encode($imageData)
    ],
    "modifiers" => ["health_all"],
    "disease_details" => ["name","common_names","description","treatment"]
];

// Call Plant.id
$ch = curl_init("https://api.plant.id/v3/health_assessment");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Api-Key: $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($plantIdJson));
$response = curl_exec($ch);
curl_close($ch);

// Decode result
$resJson = json_decode($response, true);

// Default values
$disease_name = "Unknown";
$confidence = 0;
$solution = "No solution";

// Parse Plant.id disease info
if (isset($resJson['result']['disease']['suggestions'][0])) {
    $d = $resJson['result']['disease']['suggestions'][0];
    $disease_name = $d['name'];
    $confidence = $d['probability'] ?? 0;
    $solution = $d['details']['treatment'] ?? "No solution";
}

// Save to DB
$stmt = $conn->prepare("INSERT INTO crop_disease (image, disease_name, confidence, solution) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $filename, $disease_name, $confidence, $solution);
$stmt->execute();
$stmt->close();
$conn->close();

// Return response
header("Content-Type: application/json");
echo json_encode([
    "image"=>$filename,
    "disease_name"=>$disease_name,
    "confidence"=>$confidence,
    "solution"=>$solution
]);
?>