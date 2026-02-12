<?php /*
*
*Template Name: Kfc Transection
*
*/ 
 
 ?>
 

<?php

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




$jsonData["query"]["field"][] = [
"_id" => [
"\$ne" => null
]
];

$startdate="2025-10-23";
$dateTime = new DateTime("{$startdate} 00:00:00", new DateTimeZone('+05:30'));
$isoTimestamp = $dateTime->format(DateTime::ATOM); 

$jsonData["query"]["field"][] = [
"timestamp" => [
"\$gte" => $isoTimestamp
]
];



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





$lastRecord = end($allRecords);

// Output it
//echo json_encode($lastRecord);

$amount=$lastRecord->amount/100;
if ($amount != 0 && $amount >= 499) {

if (isset($lastRecord->_owners->Location)) {
$Location = $lastRecord->_owners->Location[0];
//echo $Location;
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

$responselocation = curl_exec($curl);

curl_close($curl);
$datalocation = json_decode($responselocation);
$Merchant= $datalocation->data->_owners->Merchant[0];
if($Merchant == "6639c7dff05cd438ed4a45b3"){
//echo "Amount is valid: $amount";
$User = $lastRecord->_owners->User[0];


// Braze API configuration
$api_key = "8039cc11-aaa9-450d-aa04-bd8957ed9476";  // replace with your API key
$rest_endpoint = "https://rest.fra-02.braze.eu"; // replace with your region endpoint




$url = $rest_endpoint . "/messages/send";

// Replace with actual user IDs and any optional audience/segment filters
$data = [
"broadcast" => false,
"external_user_ids" => ["678a33310cebd65ac2659673"], // your user
"messages" => [
"android_push" => [
"title" => "Hello Dhiraj",
"alert" => "Dhiraj Your coupon code is {% promotion('KFC_COUPONS') %}",
"sound" => "default"
],
"apple_push" => [
"alert" => "Your coupon code is {% promotion('KFC_COUPONS') %}",
"sound" => "default"
]
]

];

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
"Content-Type: application/json",
"Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute request
$response = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
} else {
echo "Response: " . $response;
}
curl_close($ch);











}

} 	


} 	 

}      

wp_die();