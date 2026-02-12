<?php
ini_set('max_input_vars', '10000');
// Add AJAX action
add_action('wp_ajax_Add_fs_location_ajax_action_pinelabs', 'Add_fs_location_ajax_action_pinelabs');
add_action('wp_ajax_nopriv_Add_fs_location_ajax_action_pinelabs', 'Add_fs_location_ajax_action_pinelabs'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Add_fs_location_ajax_action_pinelabs() {
    $data = $_POST['input']; 
    $locationType = $_POST['locationType']; 

    if ($data) {
        $result = [];     
        foreach ($data as $item) {
             

// Google Maps Geocoding API endpoint
$apiEndpoint = 'https://maps.googleapis.com/maps/api/geocode/json';

// Your Google Maps API key
$apiKey = 'AIzaSyB9rFoEBBoV4xiEFZlXg_eaWcSeOpLwuGE';

// Address to geocode
$address = $item['Address Line 1'] . ' India';
$pincode = $item['Postcode'];
            
            // Check if pincode is not already present in the address
            if (strpos($address, $pincode) === false) {
                // Concatenate address and pincode with a space
                $address .= ' ' . $pincode;
            }
			
// Build the request URL
$requestUrl = $apiEndpoint . '?address=' . urlencode($address) . '&key=' . $apiKey;

// Fetch the geocoding data
$responseJson = file_get_contents($requestUrl);

// Decode the JSON response
$response = json_decode($responseJson);

// Check if the request was successful
if ($response && $response->status === 'OK') {
    // Get latitude and longitude
    $latitude = $response->results[0]->geometry->location->lat;
    $longitude = $response->results[0]->geometry->location->lng;
	$item['lat'] = $latitude;
	$item['lng'] = $longitude;
	$result[] = $item;
    
 
} else {
    $item['lat'] = 'Unknown';
	$item['lng'] = 'Unknown';
	$result[] = $item;
    }            

             
        }

        // Encode the entire result array as JSON
        echo json_encode($result);
    }

    exit;
 
  
  	 
	 
}
 
// Function to geocode address and return latitude and longitude
function geocodeAddress($address) {
    // Replace YOUR_API_KEY with your actual Google Maps API key
    $apiKey = 'AIzaSyB9rFoEBBoV4xiEFZlXg_eaWcSeOpLwuGE';
    $address = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if response contains results
    if ($data['status'] == 'OK') {
        $lat = $data['results'][0]['geometry']['location']['lat'];
        $lng = $data['results'][0]['geometry']['location']['lng'];
        return ['lat' => $lat, 'lng' => $lng];
    } else {
        return ['lat' => null, 'lng' => null];
    }
}  