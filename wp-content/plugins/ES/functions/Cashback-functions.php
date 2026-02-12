<?php
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to India (IST)
// Add AJAX action
add_action('wp_ajax_Cashback_ajax_action', 'Cashback_ajax_action');
add_action('wp_ajax_nopriv_Cashback_ajax_action', 'Cashback_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Cashback_ajax_action() {
    $Cashback=$_POST['Cashback'];
	
	 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/user/get/696a0fd8d66b6a5ba6001206',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
     'Authorization: Basic Y2JwX2luZCNjbGM6WTRpR09IejJtTEE4SHZnN0FHb0E5NkR3UUd2ODJRSkEwdnprRXR4eTZucXFQWGljRzNMdjR2RklidDFkRmQ2MA=='
   ),
));
 
$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response);
if($data->status=="success"){ 
  echo json_encode([
    "status" => "success"
]);
}else{
	echo $response ;
}
    // Make sure to exit to prevent extra output
    wp_die();
}


// Add AJAX action
add_action('wp_ajax_create_transaction_ajax_action', 'create_transaction_ajax_action');
add_action('wp_ajax_nopriv_create_transaction_ajax_action', 'create_transaction_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function create_transaction_ajax_action() {
$selectedValues = $_POST['selectedValues'];

$Types = strtolower($selectedValues['createTransactionTypes']);
$Verifiers = strtolower($selectedValues['createTransactionVerifiers']);
$userID = $selectedValues['createuserid'];
$verifierID =generate_guid();
$createTotalamount = $selectedValues['createTotalamount'];
$amount = intval($createTotalamount) * 100;
$number=$selectedValues['createrewardamount'];
 
 
$numberDouble = round((float)$number, 3);
  
 
 

$reason = $selectedValues['createcashbackreason'];

$currentDateTime = date('Y-m-d\TH:i:sP');
 

$itemData = [
    "_owners" => [
        "User" => [$userID]
    ],
    "identifiers" => [
        "verifier" => $Verifiers,
        "verifier_id" => $verifierID // Set this to a valid verifier ID
    ],
    "state" => [
        "settled" => true
    ],
    "amount" => $amount,
    "reward_amount" => (float)$numberDouble, 
    "type" => $Types,
    "reward_currency" => "INR",
    "currency" => "INR",
    "name" => $reason,
    "timestamp" => $currentDateTime
];
$requestData = json_encode($itemData, JSON_PRESERVE_ZERO_FRACTION); 
 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/transaction/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$requestData,
  CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
     'Authorization: Basic Y2JwX2luZCNjbGM6WTRpR09IejJtTEE4SHZnN0FHb0E5NkR3UUd2ODJRSkEwdnprRXR4eTZucXFQWGljRzNMdjR2RklidDFkRmQ2MA=='
   ),
));
 
$response = curl_exec($curl);

curl_close($curl);
echo $response;

	   
	  wp_die();
}
 