<?php

// Add AJAX action
add_action('wp_ajax_Add_location_ajax_action_pinelabs', 'Add_location_ajax_action_pinelabs');
add_action('wp_ajax_nopriv_Add_location_ajax_action_pinelabs', 'Add_location_ajax_action_pinelabs'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Add_location_ajax_action_pinelabs() {
$data=$_POST['input']; 
$locationType=$_POST['locationType']; 
$base64_auth = get_post_meta(12680, 'token', true);
 
 
if ( $data ) {
 

$result = [];     
foreach ( $data as $item ) {
$merchantID= $item['merchantID'];		
$Combined= $item['Combined'];
$MID= $item['Merchant ID'];
$SID= $item['Store ID'];

 	
 
 
$itemData = [

"_owners"=> [
	"Merchant"=> [$merchantID]
],
"_geo"=> [
	"type"=> "Point",
	"coordinates"=> [
		(float) $cleanItem['Latitude'],
		(float) $cleanItem['Longitude']
	]
],
"type"=> "merchant",
"name"=> $item['Merchant Name'],
"active"=> false,
"mcc"=> "",
"chain_identifier"=> $item['Chain Identifier'],
"addresses"=> [
	"physical"=> [
		"line1"=>$item['Store Address1'],
		"line2"=> $item['Store Address2'],
		"city"=> $item['City'],
		"postcode"=> $item['Pincode'],
		"country"=> "IND"
	],
	"virtual"=> [
		[
			"site_name" => "homepage",
			"url" => "https://example.in/"
		]
	]
],
"text"=> [
	"description"=> "--",
	"short_description"=> "--",
	"keywords"=> [
		"--",
		"--",
		"--",
		"--"
	],
	"categories"=> [
	]
],
"contact"=> [
	"tel"=> $item['Phone'],
	"email"=> "example@gmail.com"
],
"accepted_payment_channels"=> [
	"instant_giftcard"=> false,
	"request_for_payment"=> false,
	"payment_card_tracking"=> true
],
"accepted_payment_types"=> [
	"visa_debit"=> false,
	"visa_credit"=> false,
	"mastercard_debit"=> false,
	"mastercard_credit"=> false,
	"diners_club"=> false,
	"maestro"=> false,
	"dankort"=> false,
	"rupay"=> false,
	"vsc"=> false,
	"vow"=> false
],
"opening_hours"=> [
	"recurring"=> [
		"mon"=> [
			"open"=> true,
			"times"=> [
				[
					"from"=> "11:00",
					"to"=> "20:00"
				]
			]
		]  
	]
],
"rewards"=> [
	"first_visit"=> [
		"enabled"=> true,
		"rate"=> 5,
		"minimum_spend"=> 100000,
		"maximum_reward"=> 50000,
		"margin"=> 0
	],
	"standard"=> [
		"enabled"=> true,
		"rate"=> 5,
		"minimum_spend"=> 100000,
		"maximum_reward"=> 50000,
		"margin"=> 0
	]
],
"facilities"=> [
	"wifi"=> false,
	"disabled_access"=> false,
	"wc"=> false,
	"baby_changing"=> false,
	"parking"=> false
],
"tracking"=> [
	[
		"enabled"=> true,
		"verifier"=> "pinelabs",
		"identifiers" => [
			$Combined,   
			"$MID",   
			"$SID",   
		]
	]
],
"products"=> [
	"giftcard"=> [
		"enabled"=> false,
		"identifiers"=> []
	]
]
];
 
$curl = curl_init();

$requestData = json_encode($itemData);
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://single.id/location/create',
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
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
$response = curl_exec($curl);

curl_close($curl);
echo $response;	
 
}

 
 
}	 
  
 exit;	 
	 
}
 
 
 
// Add AJAX action
add_action('wp_ajax_Add_location_ajax_action_innoviti', 'Add_location_ajax_action_innoviti');
add_action('wp_ajax_nopriv_Add_location_ajax_action_innoviti', 'Add_location_ajax_action_innoviti'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Add_location_ajax_action_innoviti() {
$data=$_POST['input']; 
$locationType=$_POST['locationType']; 
$base64_auth = get_post_meta(12680, 'token', true);
 
 
if ( $data ) {
	
$uniqueEntries = [];
$identifiers = [];

foreach ($data as $entry) {
    $sr = $entry["SR"];
    $utid = $entry["utid"];

    if (!isset($uniqueEntries[$sr])) {
        $uniqueEntries[$sr] = $entry;
        $identifiers[$sr] = [$utid];
    } else {
        $identifiers[$sr][] = $utid;
    }
}

$result = array_values($uniqueEntries);
foreach ($result as &$entry) {
    $sr = $entry["SR"];
    $entry["identifiers"] = $identifiers[$sr];
}


foreach ($result as &$entry) {
    $identifiers = $entry["identifiers"];
    $chunkedIdentifiers = array_chunk($identifiers, 20);

    $tracking = [];
    foreach ($chunkedIdentifiers as $chunk) {
        $tracking[] = [
            "enabled" => false,
            "verifier" => "innoviti",
            "identifiers" => $chunk
        ];
    }

    $entry["tracking"] = $tracking;
    unset($entry["identifiers"]);
}

//echo json_encode($result, JSON_PRETTY_PRINT);

 
foreach ( $result as $item ) {
$merchantID= $item['merchantID'];		
$tracking= $item['tracking'];
 

 	
 
 
$itemData = [

"_owners"=> [
	"Merchant"=> [$merchantID]
],
"_geo"=> [
	"type"=> "Point",
	"coordinates"=> [
		77.32089669999999,
		11.1379084
	]
],
"type"=> "merchant",
"name"=> $item['Merchant Name'],
"active"=> false,
"mcc"=> "",
"chain_identifier"=> $item['Chain Identifier'],
"addresses"=> [
	"physical"=> [
		"line1"=>$item['Store Address1'],
		"line2"=> $item['Store Address2'],
		"city"=> $item['City'],
		"postcode"=> $item['Pincode'],
		"country"=> "IND"
	],
	"virtual"=> [
		[
			"site_name" => "homepage",
			"url" => "https://example.in/"
		]
	]
],
"text"=> [
	"description"=> "--",
	"short_description"=> "--",
	"keywords"=> [
		"--",
		"--",
		"--",
		"--"
	],
	"categories"=> [
	]
],
"contact"=> [
	"tel"=> "",
	"email"=> "example@gmail.com"
],
"accepted_payment_channels"=> [
	"instant_giftcard"=> false,
	"request_for_payment"=> false,
	"payment_card_tracking"=> true
],
"accepted_payment_types"=> [
	"visa_debit"=> false,
	"visa_credit"=> false,
	"mastercard_debit"=> false,
	"mastercard_credit"=> false,
	"diners_club"=> false,
	"maestro"=> false,
	"dankort"=> false,
	"rupay"=> false,
	"vsc"=> false,
	"vow"=> false
],
"opening_hours"=> [
	"recurring"=> [
		"mon"=> [
			"open"=> true,
			"times"=> [
				[
					"from"=> "11:00",
					"to"=> "20:00"
				]
			]
		]  
	]
],
"rewards"=> [
	"first_visit"=> [
		"enabled"=> true,
		"rate"=> 5,
		"minimum_spend"=> 100000,
		"maximum_reward"=> 50000,
		"margin"=> 0
	],
	"standard"=> [
		"enabled"=> true,
		"rate"=> 5,
		"minimum_spend"=> 100000,
		"maximum_reward"=> 50000,
		"margin"=> 0
	]
],
"facilities"=> [
	"wifi"=> false,
	"disabled_access"=> false,
	"wc"=> false,
	"baby_changing"=> false,
	"parking"=> false
],
"tracking"=>$tracking ,
"products"=> [
	"giftcard"=> [
		"enabled"=> false,
		"identifiers"=> []
	]
]
];
 
$curl = curl_init();

$requestData = json_encode($itemData);
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://single.id/location/create',
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
'Authorization: Basic Y2JwX2luZCNjbGM6SmNyZ2RZSFJjeU5QWFFtWVhYTFhnYkw0ZWVxRDd0YlZYNVVTc0d4NEhyNEdoOWNycDV1S0hQNTdNRnAzcU1reA=='
),
));
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
$response = curl_exec($curl);

curl_close($curl);
echo $response;	
 
} 
 

 
 
}	 
  
 exit;	 
	 
}