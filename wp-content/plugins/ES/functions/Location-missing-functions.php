<?php
// Add AJAX action
add_action('wp_ajax_missing_location_ajax_action', 'missing_location_ajax_action');
add_action('wp_ajax_nopriv_missing_location_ajax_action', 'missing_location_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function missing_location_ajax_action() {
$selectedValues = $_POST['selectedValues'];
$base64_auth = get_post_meta(12680, 'token', true); 	

$chain_identifier = strtolower($selectedValues['chain_identifier']);
 

$limit = 200;  // Maximum records per request
$offset = 0;  // Initial offset

$allRecords = [];  // To store all retrieved records

 do {
	 
$jsonData = [
    "query" => [
        "field" => [
            [
                "chain_identifier" => [
                    "\$eq" => $chain_identifier
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => $offset,
            "limit" => $limit
    ]
];
 
 

$jsonDataString = json_encode($jsonData);	 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/location/search',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$jsonDataString,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($base64_auth),
  ),
));
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------

$response = curl_exec($curl);

	curl_close($curl);

	$data = json_decode($response);

	if (isset($data->data->results) && !empty($data->data->results)) {

	// Add the retrieved records to the array
	$allRecords = array_merge($allRecords, $data->data->results);
	}

	$offset += $limit;  // Update the offset for the next request

} while (isset($data->data->results) && count($data->data->results) == $limit); // Continue until fewer than $limit records are returned


if (!empty($allRecords)) {
 
 
  
 	
	
	echo json_encode($allRecords ) ;
 
	 
     
} else {
    echo "no_data";
}    
 
    wp_die();
}
 