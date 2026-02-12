<?php
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to India (IST)
// Add AJAX action
add_action('wp_ajax_User_search_ajax_action', 'User_search_ajax_action');
add_action('wp_ajax_nopriv_User_search_ajax_action', 'User_search_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function User_search_ajax_action() {
$selectedValues=$_POST['selectedValues'];
$base64_auth = get_post_meta(12680, 'token', true); 
$keyword = $selectedValues['keyword'];
$usersIds = $selectedValues['usersIds'];
$TransactionType = strtolower($selectedValues['TransactionType']);
$TransactionVerifier = strtolower($selectedValues['TransactionVerifier']);
$startdate = $selectedValues['startdate'];
$enddate = $selectedValues['enddate'];

$limit = 500;  // Maximum records per request
$offset = 0;  // Initial offset

$allRecords = [];  // To store all retrieved records

 do {
    $jsonData = [
        "query" => [
            "field" => []
        ],
        "options" => [
            "offset" => $offset,
            "limit" => $limit
        ]
    ];
   
	
	  
         $jsonData["query"]["field"][] = [
            "_id" => [
                "\$ne" => null
            ]
        ];
     
	    $jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$gte" => 1739989800
            ]
        ];
	   
     

    $jsonDataString = json_encode($jsonData);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/user/search',
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
 