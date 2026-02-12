<?php /*
*
*Template Name: Add location  
*
*/ 
 
 ?>
 

<?php



$merchantID= "6515555093d8692b64420188";		
$Combined= "11205:1190899";
$MID= 11205;
$SID= 1190899;

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
"name"=> "COBB APPARELS",
"active"=> false,
"mcc"=> "",
"chain_identifier"=> "cobb_apparels",
"addresses"=> [
	"physical"=> [
		"line1"=>"--",
		"line2"=> "--",
		"city"=> "--",
		"postcode"=> "421201",
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
'Authorization: Basic Y2JwX2luZCNjbGM6SmNyZ2RZSFJjeU5QWFFtWVhYTFhnYkw0ZWVxRDd0YlZYNVVTc0d4NEhyNEdoOWNycDV1S0hQNTdNRnAzcU1reA=='
),
));
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
$response = curl_exec($curl);

curl_close($curl);
echo $response;	

?>