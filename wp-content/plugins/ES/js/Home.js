jQuery(document).ready(function($){
     
    $('#ajax-response').html('Loading...'); // Display a loading message
     
	 
    $.ajax({
       url: myAjax.ajaxurl,
        type: 'post',
        data: {
            action: 'home_ajax_action', // Specify your custom AJAX action
            // Additional data to send to the server if needed
        },
        success: function(response) {
            // Update the content of the #ajax-response element with the response from the server
            $('#ajax-response').html(response);
        },
    });
	
	 
	
});