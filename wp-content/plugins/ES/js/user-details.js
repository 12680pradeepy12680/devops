	jQuery(document).ready(function($){

	$('#contactType').change(function () {
	$('#validationMessage').text('');
	$('#contactInput').val('');
	});


	$('#validationForm').submit(function (e) {
	e.preventDefault();


	var contactType = $('#contactType').val();
	var value = $('#contactInput').val();

	contactInput = value.replace(/\s/g, '');


	if (contactType === 'phone') {
	var phoneRegex = /^\d{10}$/;  
	if (!contactInput.match(phoneRegex)) {
	$('#validationMessage').text('Enter a correct phone number');
	return;
	}else{
	$('#validationMessage').text('');
	}
	} else if (contactType === 'email') {
	var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
	if (!contactInput.match(emailRegex)) {
	$('#validationMessage').text('Enter a correct email address');
	return;
	}else{
	$('#validationMessage').text('');
	}
	}else if (contactType === 'account_number') {

	var regexPattern = /^[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}$/;

	if (contactInput.match(regexPattern) == null) {			 
	$('#validationMessage').text('Account number is valid');
	return;
	}else{
	$('#validationMessage').text('');
	}  

	} 


	$.ajax({
	type: 'POST',
	url: myAjax.ajaxurl,
	data: {
	action: 'user_details_ajax_action', 
	contactType:contactType,
	contactInput:contactInput,

	},
	success: function (response) {
	 
     
	 
var jsonObject = JSON.parse(response);

if (jsonObject.data.count != 0){
 
var results = jsonObject.data.results;
var tableHtml = '<table class="table">' +
    '<thead>' +
    '<tr>' +
    '<th>User ID</th>' +
	'<th>Account No.</th>' +
    '<th>Name</th>' +
    '<th>Email</th>' +
    '<th>Phone</th>' +
    '<th>Balance</th>' +
    '</tr>' +
    '</thead>' +
    '<tbody>';

var ajaxRequestsCompleted = 0;

$.each(results, function (index, result) {
    var user_id = result._id;
    var firstName = result.personal.first_name;
	 var account_number = result.identifiers.account_number;
    var lastName = result.personal.last_name;
    var email = result.contact.email;
    var tel = result.contact.tel;

    $.ajax({
        type: 'POST',
        url: myAjax.ajaxurl,
        data: {
            action: 'user_wallet_ajax_action',
            user_id: user_id
        },
        success: function (wallet_response) {
			//alert(wallet_response);
            var walletarray = JSON.parse(wallet_response);
			
			if (walletarray.data && walletarray.data.length > 0) {
			var wallet = walletarray.data[0].balance;
			} else {
			var wallet = "--";
			}
			
            

            tableHtml += '<tr><td>' + user_id + '</td><td>' + account_number + '</td><td>' + firstName+' '+ lastName + '</td><td>' + email + '</td><td>' + tel + '</td><td>' + wallet + '</td></tr>';
            
            ajaxRequestsCompleted++;

            if (ajaxRequestsCompleted === results.length) {
                tableHtml += '</tbody></table>';
                $('#info').html(tableHtml);
            }
        },
        error: function () {
            alert('An error occurred while processing the form');
        }
    });
});

 
    
	}else{
		$('#info').html(`
    <div class="norecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p><strong>No user found</strong></p>
                    <p>Please check your phone number,email address and account number</p>
                </div>
            </div>
        </div>
    </div>
`);
 




	}
	 	 
	 
	},
	error: function () {
	alert('An error occurred while processing the form');
	}
	});
	});


	});