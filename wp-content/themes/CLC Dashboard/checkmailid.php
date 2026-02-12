<?php /*
*
*Template Name: Check email id
*
*/ 
  
 ?>

  
 
  <?php

$ipAddress = '14.143.239.186'; // Replace this with the IP address you want to look up

// Construct the API URL
$apiUrl = "http://ipinfo.io/{$ipAddress}/json";

// Fetch data from the API
$response = file_get_contents($apiUrl);

// Parse the JSON response
$ipData = json_decode($response, true);

// Check if the data is available
if ($ipData && isset($ipData['city'])) {
    // Extract relevant information
    $city = $ipData['city'];
    $region = $ipData['region'];
    $country = $ipData['country'];
    $location = $ipData['loc'];

    // Display the information
   // echo "IP Address: $ipAddress\n";
    echo "Location: $city, $region, $country\n";
    echo "Geographical Coordinates: $location\n";
} else {
    echo "Unable to retrieve location information for IP address: $ipAddress\n";
}
?>


