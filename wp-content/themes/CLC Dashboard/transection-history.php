<?php /*
*
*Template Name: Transection history 
*
*/ 
 
 ?>

<?php
 
$base64_auth = get_post_meta(12680, 'token', true); 
$TransactionType = strtolower("purchase");
$TransactionVerifier = strtolower("system");
$startdate = "2023-06-01";
$enddate = "2023-11-30";

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
    // Check if $TransactionType is set and add it to the query
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
        $dateAndTime_start = "{$startdate} 00:00:00";
        $timestampStart = strtotime($dateAndTime_start);

        $jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$gte" => $timestampStart
            ]
        ];
    }

    // Check if $enddate is set
    if ($enddate) {
        $dateAndTime_end = "{$enddate} 23:59:59";
        $timestampEnd = strtotime($dateAndTime_end);

        $jsonData["query"]["field"][] = [
            "_meta.created_timestamp" => [
                "\$lte" => $timestampEnd
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
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
	$response = curl_exec($curl);

	curl_close($curl);
 echo '<pre>'; print_r($response); echo '</pre>';

	$data = json_decode($response);

	if (isset($data->data->results) && !empty($data->data->results)) {

	// Add the retrieved records to the array
	$allRecords = array_merge($allRecords, $data->data->results);
	}

	$offset += $limit;  // Update the offset for the next request


	} while (isset($data->data->results) && count($data->data->results) == $limit); // Continue until fewer than $limit records are returned

if (!empty($allRecords)) {
 
foreach ($allRecords as &$result) {
	 
  
	 
	$timestamp=$result->_meta->created_timestamp;
	$date = date('Y-m-d', $timestamp); // Date in 'YYYY-MM-DD' format
	$time = date('H:i:s', $timestamp);
 
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
			$result->location= $result->_owners->Location[0]; 	
			$result->merchant= $name; // Change this value	
			$result->City= $city; // Change this value	

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
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response);
if (isset($data->data->contact->email)) {
    $user=$data->data->contact->email;
	$result->email= $user; 
} else {
    $result->email= "--"; 
}
	
}	
	
	echo json_encode($allRecords ) ;
 
	 
     
} else {
    echo "no_data";
}    
 
    wp_die();