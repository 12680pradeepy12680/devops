<?php

// Add AJAX action
add_action('wp_ajax_Register_card_ajax_action', 'Register_card_ajax_action');
add_action('wp_ajax_nopriv_Register_card_ajax_action', 'Register_card_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function Register_card_ajax_action() {
$cardInput=$_POST['cardInput']; 
$base64_auth = get_post_meta(12680, 'token', true);
 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/payment_card/get/'.$cardInput,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
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
 