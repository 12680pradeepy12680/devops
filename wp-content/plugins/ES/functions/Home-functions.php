<?php

// Add AJAX action
add_action('wp_ajax_home_ajax_action', 'home_ajax_action');
add_action('wp_ajax_nopriv_home_ajax_action', 'home_ajax_action'); // Allow non-logged-in users to use the AJAX action

// AJAX request handler
function home_ajax_action() {
    // Your server-side logic for the AJAX request
    $response = 'Please click on the button below.';

    // Return the response to the client
    echo $response;

    // Make sure to exit to prevent extra output
    wp_die();
}
 