<?php
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to India (IST)
// Add AJAX action
add_action('wp_ajax_Transaction_history_ajax_action', 'Transaction_history_ajax_action');
add_action('wp_ajax_nopriv_Transaction_history_ajax_action', 'Transaction_history_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Transaction_history_ajax_action() {
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
/*	data by name of merchant
$jsonData["query"] = [
            "text" => [
                "term" => "Shoppers Stop"
            ]
			 
        ];
		
*/		

/*	
	 
        $jsonData["query"]["field"][] = [
            "_owners.User" => [
                "\$eq" => "6561a94aa75e3e264347f923"
            ]
        ];
    
*/	
    // Check if $TransactionType is set and add it to the query
	
	 if ($keyword) {
        $jsonData["query"] = [
            "text" => [
                "term" => $keyword
            ]
			 
        ];
    }
	
	 if ($usersIds) {
         $jsonData["query"]["field"][] = [
            "_owners.User" => [
                "\$eq" => $usersIds
            ]
        ];
    }
	
    if ($TransactionType) {
        $jsonData["query"]["field"][] = [
            "type" => [
                "\$eq" => $TransactionType
            ]
        ];
    }

    // Check if $TransactionVerifier is set and add it to the query
    if ($TransactionVerifier) {
        $jsonData["query"]["field"][] = [
            "identifiers.verifier" => [
                "\$eq" => $TransactionVerifier
            ]
        ];
    }

    // Check if $startdate is set
    if ($startdate) {
        // Convert to ISO 8601 with timezone (+05:30)
    $dateTime = new DateTime("{$startdate} 00:00:00", new DateTimeZone('+05:30'));
    $isoTimestamp = $dateTime->format(DateTime::ATOM); 

        $jsonData["query"]["field"][] = [
            "timestamp" => [
                "\$gte" => $isoTimestamp
            ]
        ];
    }

    // Check if $enddate is set
    if ($enddate) {
        // Convert to ISO 8601 with timezone (+05:30)
    $dateTime = new DateTime("{$enddate} 23:59:59", new DateTimeZone('+05:30'));
    $isoTimestampend = $dateTime->format(DateTime::ATOM); 

        $jsonData["query"]["field"][] = [
            "timestamp" => [
                "\$lte" => $isoTimestampend
            ]
        ];
    }

    $jsonDataString = json_encode($jsonData);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/transaction/search',
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
 
foreach ($allRecords as &$result) {
	 
  
	 
	$timestamp=$result->timestamp;
	
	$dateTime = new DateTime($timestamp);

	// Extract date and time in separate variables
	$date = $dateTime->format('Y-m-d');
	$time = $dateTime->format('H:i:s');


	 
 
  if (isset($result->_owners->Location) && is_array($result->_owners->Location) && count($result->_owners->Location) > 0) {
			$Location = $result->_owners->Location[0];
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://single.id/location/get/'.$Location,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($base64_auth),
  ),
			));
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
			$responselocation = curl_exec($curl);

			curl_close($curl);
			$datalocation = json_decode($responselocation);
			$name= $datalocation->data->name;
			$city= $datalocation->data->addresses->physical->city;
			$mid= $datalocation->data->tracking[0]->identifiers[0];
			$result->location= $result->_owners->Location[0]; 	
			$result->merchant= $name; // Change this value	
			$result->City= $city; // Change this value	
						$result->MID=$mid;

} else {
             $result->location= '--'; 	
			$result->merchant= '--'; // Change this value	
			$result->City= '--'; // Change this value	
}

 	
		
		
	 
	$result->_Date= $date; // Change this value
	$result->_time= $time; // Change this value
	 
 
	 

}

foreach ($allRecords as &$result) {
	 
  
	$id=$result->_owners->User[0];
	curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/user/get/'.$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($base64_auth),
  ),
));
 
$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response);
if (isset($data->data->contact->email)) {
    $user=$data->data->contact->email;
	$result->email= $user; 
} else {
    $result->email= "--"; 
}
if (isset($data->data->contact->tel)) {
    
	$tel=$data->data->contact->tel;
	
	$result->tel= $tel; 
} else {
    
	$result->tel= "--"; 
}	
}	
	
	echo json_encode($allRecords ) ;
 
	 
     
} else {
    echo "no_data";
}    
 
    wp_die();
}
 