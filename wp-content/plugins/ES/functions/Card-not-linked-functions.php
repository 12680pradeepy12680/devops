<?php

// Add AJAX action
add_action('wp_ajax_find_email_id', 'find_email_id');
add_action('wp_ajax_nopriv_find_email_id', 'find_email_id'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function find_email_id() {
$data=$_POST['input']; 
 
$base64_auth = get_post_meta(12680, 'token', true);
 
 
if ( $data ) {
 

$result = [];     
foreach ( $data as $item ) {
$contactInput= $item['Email ID'];	
	
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

//echo $response; 
$data = json_decode($response);
if ($data->data->count != 0) {
    $status = 'Found';
} else {
    $status = 'NotFound';
}

// Create the $dataToAdd array
$dataToAdd = ['Email' => $contactInput, 'Status' => $status,'Count' => strval($data->data->count)];

// Add $dataToAdd to the $result array
$result[] = $dataToAdd;

  
 
}

echo json_encode($result); 
 
}	 
  
 exit;	 
	 
}
 
 
 
 