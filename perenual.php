<?php
include "db.php";

// Your Perenual API Key
$apiKey = "YOUR_PERENUAL_API_KEY";

// API endpoint example (first page)
$apiUrl = "https://perenual.com/api/species-list?key=$apiKey&page=1";

// Fetch API response
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

// Check if data exists
if(isset($data['data'])){
    foreach($data['data'] as $plant){
        $scientific_name = $conn->real_escape_string($plant['scientific_name']);
        $common_name = $conn->real_escape_string($plant['common_name']);
        $family = $conn->real_escape_string($plant['family']);
        $genus = $conn->real_escape_string($plant['genus']);
        $watering = $conn->real_escape_string($plant['watering']);
        $sunlight = $conn->real_escape_string($plant['sunlight']);
        $growth_conditions = $conn->real_escape_string($plant['growth'] ?? '');

        // Insert or update
        $sql = "INSERT INTO plants (scientific_name, common_name, family, genus, watering, sunlight, growth_conditions)
                VALUES ('$scientific_name','$common_name','$family','$genus','$watering','$sunlight','$growth_conditions')
                ON DUPLICATE KEY UPDATE 
                common_name='$common_name', family='$family', genus='$genus', watering='$watering', sunlight='$sunlight', growth_conditions='$growth_conditions'";

        $conn->query($sql);
    }
}

echo "Plant data updated successfully!";
?>