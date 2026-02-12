<?php
ini_set('max_input_vars', '10000');
// Add AJAX action
add_action('wp_ajax_all_link_card_download_functions', 'all_link_card_download_functions');
add_action('wp_ajax_nopriv_all_link_card_download_functions', 'all_link_card_download_functions'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function all_link_card_download_functions() {
     
	$selectedValues=$_POST['selectedValues'];
	$usersIds = $selectedValues['usersIds'] ?? null;
$base64_auth = get_post_meta(12680, 'token', true); 	
	
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
      /*
	  $jsonData["query"]["field"][] = [
            "_owners.Publisher" => [
                "\$eq" => "65e9ab5e27b3b46d4a565198"
            ]
        ];
		
	  
          $jsonData["query"]["field"][] = [
            "_id" => [
                "\$ne" => null
            ]
        ];
	   */  	
		 
	   
       /*
	   $jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$gte" => 1748736327
            ]
        ];
		*/
	  $jsonData["query"]["field"][] = [
            "_id" => [
                "\$ne" => null
            ]
        ];	
	  $jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$gte" => 1751328353
            ]
        ];
	  
	$jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$lte" => 1767077708
            ]
        ];	
		
	 

    $jsonDataString = json_encode($jsonData);

$curl = curl_init();

curl_setopt_array($curl, array(
  //CURLOPT_URL => 'https://single.id/user/search',
  CURLOPT_URL => 'https://single.id/payment_card/search',
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
 