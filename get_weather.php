<?php
header('Content-Type: application/json');

// Get city from GET parameter
$city = isset($_GET['city']) ? $_GET['city'] : "Dhaka";

// WeatherAPI key
$apiKey = "3aacf66ebdcf40c694353210260804";
$apiUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$city}";

// Fetch weather using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    exit;
}

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

// Connect to DB
$conn = new mysqli("localhost", "root", "", "farmeta");
if ($conn->connect_error) {
    die(json_encode(["error"=>"DB connection failed: " . $conn->connect_error]));
}

// If API is successful
if ($httpcode == 200 && isset($data['current'])) {
    $temperature = floatval($data['current']['temp_c']);
    $humidity = floatval($data['current']['humidity']);
    $wind_speed = floatval($data['current']['wind_kph']);
    $description = $data['current']['condition']['text'];

    // Call stored procedure
    $stmt = $conn->prepare("CALL insert_weather(?, ?, ?, ?, ?)");
    if(!$stmt){
        die(json_encode(["error"=>"Prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("sddds", $city, $temperature, $humidity, $wind_speed, $description);
    if(!$stmt->execute()){
        die(json_encode(["error"=>"Execute failed: " . $stmt->error]));
    }
    $stmt->close();

    // Return JSON
    echo json_encode([
        "city" => $city,
        "temperature" => $temperature,
        "humidity" => $humidity,
        "wind_speed" => $wind_speed,
        "description" => $description,
        "status" => "Saved to DB"
    ]);

} else {
    $errorMsg = isset($data['error']['message']) ? $data['error']['message'] : "Request failed";
    echo json_encode([
        "city" => $city,
        "temperature" => "N/A",
        "humidity" => "N/A",
        "wind_speed" => "N/A",
        "description" => "Data not available",
        "error" => $errorMsg
    ]);
}

$conn->close();
?>