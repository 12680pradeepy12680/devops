<?php /*
*
*Template Name: Braze
*
*/ 
 
 ?>
<p><a href="https://bigbonus.app.link/NDTVBB2">Braze</a></p>
 
<br><br>


<?php
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
            "title" => "Hello Android",
            "alert" => "Your coupon code is {% promotion('KFC_COUPONS') %}",
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
?>
