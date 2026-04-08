<?php
// DB connection
$conn = mysqli_connect("localhost", "root", "", "farmeta");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// OpenWeatherMap API
$city = "Dhaka"; // you can get city dynamically
$apiKey = "YOUR_OPENWEATHER_API_KEY";
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$apiKey}";

// Fetch weather data
$response = file_get_contents($apiUrl);
if (!$response) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch weather"]);
    exit;
}

$data = json_decode($response, true);

// Extract needed info
$temp = $data['main']['temp'];
$humidity = $data['main']['humidity'];
$wind = $data['wind']['speed'];
$description = $data['weather'][0]['description'];

// Store in DB
$sql = "INSERT INTO weather (city, temperature, humidity, wind_speed, description)
        VALUES ('$city', $temp, $humidity, $wind, '$description')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>