<?php

// Add AJAX action
add_action('wp_ajax_user_details_ajax_action', 'user_details_ajax_action');
add_action('wp_ajax_nopriv_user_details_ajax_action', 'user_details_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function user_details_ajax_action() {
$contactType=$_POST['contactType'];
$contactInput=$_POST['contactInput'];
$base64_auth = get_post_meta(12680, 'token', true);	
if($contactType == "phone"){
	$jsonData = [
    "query" => [
        "field" => [
            [
                "contact.tel" => [
                    "\$eq" => "+91".$contactInput
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => 0,
        "limit" => 500
    ]
];
}elseif($contactType == "email"){
	$jsonData = [
    "query" => [
        "field" => [
            [
                "contact.email" => [
                    "\$eq" => $contactInput
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => 0,
        "limit" => 500
    ]
];
}elseif($contactType == "account_number"){
	$jsonData = [
    "query" => [
        "field" => [
            [
                "identifiers.account_number" => [
                    "\$eq" => $contactInput
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => 0,
        "limit" => 500
    ]
];
}
 

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
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
$response = curl_exec($curl);

curl_close($curl);

echo $response;

// Make sure to exit to prevent extra output
wp_die();
}



// Add AJAX action
add_action('wp_ajax_user_wallet_ajax_action', 'user_wallet_ajax_action');
add_action('wp_ajax_nopriv_user_wallet_ajax_action', 'user_wallet_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function user_wallet_ajax_action() {
 $user_id=$_POST['user_id'];   
$base64_auth = get_post_meta(12680, 'token', true);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/clc/get_user_wallet_balance/'. $user_id,
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