<?php
/*
Plugin Name: ES
Description: A sample WordPress plugin with activation and deactivation code, two pages, JavaScript, and CSS.
Version: 1.0
*/

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'my_plugin_activate');
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');

// Function to run on plugin activation
function my_plugin_activate() {
	$id=12680;	 
	$auth_string = 'cbp_ind#clc:Y4iGOHz2mLA8Hvg7AGoA96DwQGv82QJA0vzkEtxy6nqqPXicG3Lv4vFIbt1dFd60';    
    update_post_meta( $id, 'token',$auth_string);
}

// Function to run on plugin deactivation
function my_plugin_deactivate() {
    $id=12680;
	delete_post_meta($id, 'token');
	 
}

// Add the function to generate GUID
function generate_guid() {
    $uuid = wp_generate_uuid4();
    return $uuid;
} 

// Add menu items for the plugin pages
function add_my_menu_items() {
    add_menu_page('ES', 'Enigmatic smile', 'manage_options', 'Home', 'ES_1');
    add_submenu_page('Home', 'User Deatils', 'User Deatils', 'manage_options', 'User-Deatils', 'user_deatils');
	add_submenu_page('Home', 'Register card', 'Register card', 'manage_options', 'Register-card', 'Register_card');
	add_submenu_page('Home', 'User Transactions', 'User Transactions', 'manage_options', 'User-Transactions', 'User_Transactions');
	add_submenu_page('Home', 'Transaction history', 'Transaction history', 'manage_options', 'Transaction-history', 'Transaction_history');
	add_submenu_page('Home', 'Cashback', 'Cashback', 'manage_options', 'Cashback', 'Cashback');
	add_submenu_page('Home', 'Location missing', 'Location missing', 'manage_options', 'Location-missing', 'Location_missing');
	add_submenu_page('Home', 'Add Location', 'Add Location', 'manage_options', 'Add-Location', 'Add_Location');
	add_submenu_page('Home', 'Card not linked', 'Card not linked', 'manage_options', 'Card-not-linked', 'Card_not_linked');
	add_submenu_page('Home', 'Bulk Upload Location', 'Bulk Upload Location', 'manage_options', 'First-Data-Add-Location', 'First_Data_Add_Location');
	add_submenu_page('Home', 'User search', 'User search', 'manage_options', 'User-search', 'User_search');
    add_submenu_page('Home', 'All link card', 'All link card', 'manage_options', 'All-link-card', 'all_link_card_download');


}
add_action('admin_menu', 'add_my_menu_items');

add_action( 'admin_menu', 'my_admin_plugin' );

function my_admin_plugin() {
		wp_enqueue_script( 'my_plugin_script', plugins_url('js/Home.js', __FILE__), array('jquery'));
		wp_localize_script( 'my_plugin_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'relataive' ))); 
		wp_enqueue_script( 'user_details_script', plugins_url('js/user-details.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'Register_card_script', plugins_url('js/Register-card.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'User_Transactions_script', plugins_url('js/User-Transactions.js', __FILE__), array('jquery')); 
		wp_enqueue_script( 'Transaction_history_script', plugins_url('js/Transaction-history.js', __FILE__), array('jquery')); 
        wp_enqueue_script( 'Transaction_history_script', plugins_url('js/User_search.js', __FILE__), array('jquery'));    		
        wp_localize_script('Transaction_history_script', 'pluginData', array('plugin_url' => plugins_url('/ES/images/')));
        wp_enqueue_script( 'Cashback_script', plugins_url('js/Cashback.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'Location_missing_script', plugins_url('js/Location-missing.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'Add_Location_script', plugins_url('js/Add-Location.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'Card_not_linked_script', plugins_url('js/Card-not-linked.js', __FILE__), array('jquery'));
        wp_enqueue_script( 'First_Data_Add_Location_script', plugins_url('js/First_Data_Add_Location.js', __FILE__), array('jquery'));
		wp_enqueue_script( 'all_link_card_download_script', plugins_url('js/all_link_card_download.js', __FILE__), array('jquery'));
		
		wp_enqueue_style('my-plugin-css', plugin_dir_url(__FILE__) . 'css/my-style.css');
		wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
		wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '', true);
		wp_enqueue_script('validate-js', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js', array('jquery'), '', true);
		wp_enqueue_script('xlsx-js', 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js', array('jquery'), '', true);

   
}



// Callback function for Page 1
function ES_1() {
    include(plugin_dir_path(__FILE__) . 'Home.php');
}

// Callback function for Page 2
function user_deatils() {
    include(plugin_dir_path(__FILE__) . 'User-Details.php');
}

function Register_card() {
    include(plugin_dir_path(__FILE__) . 'Register-card.php');
}
function User_Transactions() {
    include(plugin_dir_path(__FILE__) . 'User-Transactions.php');
}
function Transaction_history() {
    include(plugin_dir_path(__FILE__) . 'Transaction-history.php');
}
function User_search() {
    include(plugin_dir_path(__FILE__) . 'User_search.php');
}
function Cashback() {
    include(plugin_dir_path(__FILE__) . 'Cashback.php');
}
function Location_missing() {
    include(plugin_dir_path(__FILE__) . 'Location-missing.php');
}
function Add_Location() {
    include(plugin_dir_path(__FILE__) . 'Add-Location.php');
}
function Card_not_linked() {
    include(plugin_dir_path(__FILE__) . 'Card-not-linked.php');
}
function First_Data_Add_Location() {
    include(plugin_dir_path(__FILE__) . 'First_Data_Add_Location.php');
}
function all_link_card_download() {
    include(plugin_dir_path(__FILE__) . 'all_link_card_download.php');
}


require_once(plugin_dir_path(__FILE__) . 'functions/Home-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/User-details-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Register-card-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/User-Transactions-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Transaction-history-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/User_search_functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Cashback-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Location-missing-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Add-Location-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/Card-not-linked-functions.php');
require_once(plugin_dir_path(__FILE__) . 'functions/First_Data_Add_Location_functions.php'); 
require_once(plugin_dir_path(__FILE__) . 'functions/all_link_card_download_functions.php'); 
 
 

// Schedule cron if not already scheduled
add_action('init', 'es_schedule_braze_check_cron');
function es_schedule_braze_check_cron() {
    if (!wp_next_scheduled('es_braze_check_event')) {
        wp_schedule_event(time(), 'five_minutes', 'es_braze_check_event');
    }
}

// Register custom interval (5 minutes)
add_filter('cron_schedules', function($schedules) {
    $schedules['five_minutes'] = [
        'interval' => 300, // 5 minutes
        'display'  => __('Every 5 Minutes')
    ];
    return $schedules;
});

// Hook to cron event
add_action('es_braze_check_event', 'es_check_braze_api');

function es_check_braze_api() {
 /*   
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
if ($amount != 0 && $amount >= 498) {
    
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
            "title" => "Hello Pradeep",
            "alert" => "Pradeep Your coupon code is {% promotion('KFC_COUPONS') %}",
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
	*/
}
