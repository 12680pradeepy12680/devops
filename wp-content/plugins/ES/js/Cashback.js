	
	
jQuery(document).ready(function($){
     $("#Okay").click(function() {
        location.reload(); // Reload the current page
    });
	   

	$('#CashbackForm').submit(function (e) {
	e.preventDefault();


	 
	var value = $('#Cashback').val();

	Cashback = value.replace(/\s/g, '');


    if (!Cashback) {			 
	$('#CashbackFormvalidationMessage').text('Please enter a User Id');
	return;
	}else{
	$('#CashbackFormvalidationMessage').text('');
	}   


	$.ajax({
	type: 'POST',
	url: myAjax.ajaxurl,
	data: {
	action: 'Cashback_ajax_action', 
	Cashback:Cashback,
	 

	},
	success: function (response) {
		//alert(response);
	 var jsonObject = JSON.parse(response);
    console.log(jsonObject);
 
     //alert(JSON.stringify(jsonObject.data.name_on_card));
	 if(jsonObject.status=='success'){
		 	$('#Cashbackinfo').html(`
    <div class="yesrecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p>This user id belongs to<strong> </strong></p>
                     <p>Current wallet balance is </p> 
                </div>
				<form id="createtransection" class="Esform" action="#"  method="post">
        <select id="createTransactionTypes" name="createTransactionTypes">
		    <option value="">Transaction Type</option>
            <option value="Purchase">Purchase</option>
			<option value="Authorisation">Authorisation</option>
            <option value="Bonus">Bonus</option>
			<option value="Credit">Credit</option>
			<option value="Debit">Debit</option>
            <option value="Lift">Lift</option>
			<option value="Partial refund">Partial refund</option>
            <option value="Refund">Refund</option>
			<option value="Transfer">Transfer</option>
			<option value="Withdrawal">Withdrawal</option>
            <option value="Withdrawal credit">Withdrawal credit</option>
			 
			 
        </select>
		<select id="createTransactionVerifiers" name="createTransactionVerifiers">
		    <option value="">Transaction Verifier</option>
		    <option value="System">System</option>
            <option value="First data">First data</option>
            <option value="Innoviti">Innoviti</option>
			<option value="Mobiversa">Mobiversa</option>
			<option value="Pinelabs">Pinelabs</option>
            <option value="Storebox">Storebox</option>
			<option value="Teller">Teller</option>
            <option value="Verrency">Verrency</option>
			<option value="Visa VDP / VOP">Visa VDP / VOP</option>
			<option value="Zaakpay">Zaakpay</option>
             
			 
        </select>
        <input type="hidden" id="createuserid" name="startdate" placeholder="Search" autocomplete="off" value="${jsonObject.data._id} ">
		<input type="text" id="createTotalamount" name="createTotalamount" placeholder="Total amount" autocomplete="off">
		<input type="text" id="createrewardamount" name="createrewardamount" placeholder="Reward amount" autocomplete="off">
		<input type="text" id="createcashbackreason" name="createcashbackreason" placeholder="Reason" autocomplete="off">
          
        <input type="submit" value="Submit">  
    </form>
	<span id="transeactionvalidationMessage"></span>
            </div>
        </div>
    </div>
`);

 $('#createtransection').submit(function (e) {
e.preventDefault();
var createTransactionTypes = $('#createTransactionTypes').val();
var createTransactionVerifiers = $('#createTransactionVerifiers').val();
var value=$('#createuserid').val();
var createuserid = value.replace(/\s/g, '');
var createTotalamount = $('#createTotalamount').val();
var createrewardamount = $('#createrewardamount').val();
var createcashbackreason=$('#createcashbackreason').val();

if (!createTransactionTypes) {
$('#transeactionvalidationMessage').text('Please select Transaction Type');
return;
} else {
$('#transeactionvalidationMessage').text('');
}

if (!createTransactionVerifiers) {
$('#transeactionvalidationMessage').text('Please select Transaction Verifier');
return;
} else {
$('#transeactionvalidationMessage').text('');
}

if (!createTotalamount) {
$('#transeactionvalidationMessage').text('Please enter total amount');
return;
} else {
	if (/^\d+(\.\d+)?$/.test(createTotalamount)) {
	$('#transeactionvalidationMessage').text('');
	} else {
	 
	$('#transeactionvalidationMessage').text('Please enter a valid Total amount.');
	return;
	}
}

if (!createrewardamount) {
$('#transeactionvalidationMessage').text('Please enter Reward amount');
return;
} else { 
/*
var decimalPattern = /^-?\d+\.\d+$/;
  

if (createrewardamount.match(decimalPattern)) {
     $('#transeactionvalidationMessage').text('');
} else {
    $('#transeactionvalidationMessage').text('Please enter a valid Reward amount and it should be decimal value.');
	return;
}
*/

$('#transeactionvalidationMessage').text('');
}

if (!createcashbackreason) {
$('#transeactionvalidationMessage').text('Please enter reason for transaction.');
return;
} else {
$('#transeactionvalidationMessage').text('');
}
var confirmation = window.confirm('Are you sure you want to proceed?');
if (confirmation) {
    
	var selectedValues = {
	createTransactionTypes: createTransactionTypes,
	createTransactionVerifiers: createTransactionVerifiers,
	createuserid: createuserid,
	createTotalamount: createTotalamount,
	createrewardamount:createrewardamount,
	createcashbackreason:createcashbackreason	
	};
	
	$.ajax({
			type: 'POST',
			url: myAjax.ajaxurl,
			data: {
			action: 'create_transaction_ajax_action',
			selectedValues: selectedValues
			},
			success: function (response) {
				
			console.log(response); 
			var jsonObject = JSON.parse(response);
	        var results=jsonObject.status;
			  
			if(results=="success"){
				$('#myModal').modal('show');
			var settings = {
			"url": "https://single.id/clc/get_user_wallet_balance/"+createuserid,
			"method": "GET",
			"timeout": 0,
			"headers": {
			"Authorization": "Basic Y2JwX2luZCNjbGM6WTRpR09IejJtTEE4SHZnN0FHb0E5NkR3UUd2ODJRSkEwdnprRXR4eTZucXFQWGljRzNMdjR2RklidDFkRmQ2MA=="
			},
			};

			$.ajax(settings).done(function (response) {
			console.log(response);
		 
			for (var i = 0; i < response.data.length; i++) {
			if (response.data[i].currency === "INR") {
			var balanceINR = response.data[i].balance;
			
			var newH2Content = " New Balance is " + balanceINR;

			var newH2 = $('<h2 class="no-heading mb-4 text-white"> ' + newH2Content + '</h2>');
			$("#es_balance h2").replaceWith(newH2);
			
			console.log("Balance in INR: " + balanceINR);
			break; // Exit the loop once we've found the balance for 'INR'
			}
			}
			
			});
			}else{
				
			}
			},
			error: function (e) {
			alert('An error occurred while processing the form');
			}
			});
    
}


  });
	 }else{
		 	$('#Cashbackinfo').html(`
    <div class="norecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p><strong>No user found.</strong></p>
                    
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
	
	 