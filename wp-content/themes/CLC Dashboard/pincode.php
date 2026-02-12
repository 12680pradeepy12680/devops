<?php /*
*
*Template Name: Pincode
*
*/ 
 
 ?>

 <?php
// Latitude and Longitude
$latitude = 19.0992662;
$longitude = 72.9176674;

// Google Maps Geocoding API endpoint
$apiEndpoint = 'https://maps.googleapis.com/maps/api/geocode/json';

// Your Google Maps API key
$apiKey = 'AIzaSyB9rFoEBBoV4xiEFZlXg_eaWcSeOpLwuGE';

// Construct the URL for the API request
$url = "{$apiEndpoint}?latlng={$latitude},{$longitude}&key={$apiKey}";

// Make the API request
$response = file_get_contents($url);
$data = json_decode($response, true);

// Check if the response contains results
if (isset($data['results']) && count($data['results']) > 0) {
    // Loop through the results to find the postal code
    foreach ($data['results'] as $result) {
        foreach ($result['address_components'] as $component) {
            if (in_array('postal_code', $component['types'])) {
                echo "Pincode: " . $component['long_name'];
                break 2; // Exit both loops once the pincode is found
            }
        }
    }
} else {
    echo "No results found.";
}
?>
