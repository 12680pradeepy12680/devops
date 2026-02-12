<?php

// Add AJAX action
add_action('wp_ajax_User_Transactions_ajax_action', 'User_Transactions_ajax_action');
add_action('wp_ajax_nopriv_User_Transactions_ajax_action', 'User_Transactions_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function User_Transactions_ajax_action() {
$idInput=$_POST['idInput']; 
$base64_auth = get_post_meta(12680, 'token', true);


$data = json_encode([
    "query" => [
        "field" => [
            [
                "_owners.User" => [
                    "\$eq" => $idInput
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => 0,
        "limit" => 100
    ]
]);
 
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
  CURLOPT_POSTFIELDS =>$data,
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
echo json_encode($data->data->results);
}else{


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/transaction/get/'.$idInput,
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
$allRecords = []; 
	if ($data->status == "success") {
		 
		$records = json_decode($response);  
		$x=$records->data;
		$allRecords[]=$x;
		echo json_encode($allRecords);
	}else{
		echo json_encode($allRecords);
	}

  
}
     
    wp_die();
}
 
 
 
 
// Add AJAX action
add_action('wp_ajax_find_location_ajax_action', 'find_location_ajax_action');
add_action('wp_ajax_nopriv_find_location_ajax_action', 'find_location_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function find_location_ajax_action() {
$locationValue=$_POST['locationValue']; 
$base64_auth = get_post_meta(12680, 'token', true); 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/location/get/'.$locationValue,
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
echo $response;

  

     
    wp_die();
} 