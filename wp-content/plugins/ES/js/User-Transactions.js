	jQuery(document).ready(function($){

	 

	$('#usersTransectionForm').submit(function (e) {
	e.preventDefault();


	 
	var value = $('#usersInput').val();

	idInput = value.replace(/\s/g, '');


    if (!idInput) {			 
	$('#usersvalidationMessage').text('Please enter a user id');
	return;
	}else{
	$('#usersvalidationMessage').text('');
	}   


	$.ajax({
	type: 'POST',
	url: myAjax.ajaxurl,
	data: {
	action: 'User_Transactions_ajax_action', 
	idInput:idInput,
	 

	},
	success: function (response) {
		 
	 var jsonObject = JSON.parse(response);

 
    
	if (jsonObject.length > 0) {
		 	 
			 
			 
					
				 
				 var jsonData=jsonObject;
				 var table = $('<table>').addClass('table');
        var thead = $('<thead>').appendTo(table);
        var tbody = $('<tbody>').appendTo(table);

        // Table header
        var headers = ['Name','Date and Time', 'Type', 'Amount', 'Reward','verifier','Location'];

        var headerRow = $('<tr>').appendTo(thead);
        $.each(headers, function(index, header) {
            $('<th>').text(header).appendTo(headerRow);
        });

        // Table data
        $.each(jsonData, function(index, item) {
			
            var timestamp = item._meta.created_timestamp;
			var date = new Date(timestamp * 1000);
			var options = { timeZone: 'Asia/Kolkata', hour12: false, };
			var formattedDate = date.toLocaleString('en-IN', options);
			
            var row = $('<tr>').appendTo(tbody);
            $('<td>').text(item.name + " : " + item._id).appendTo(row);
			 $('<td>').text(formattedDate).appendTo(row);
            $('<td>').text(item.type).appendTo(row);
            $('<td>').text(item.amount/100).appendTo(row);
            $('<td>').text(item.reward_amount).appendTo(row);
			$('<td>').text(item.identifiers.verifier).appendTo(row);
			if (item._owners && item._owners.Location && Array.isArray(item._owners.Location) && item._owners.Location.length > 0) {
			var valueCell = $('<td>').appendTo(row); 
			var button = $('<button id="find-location">').text('Find Location').appendTo(valueCell); 
			button.data('location', item._owners.Location[0]); 
			button.click(function() {

			var locationValue = $(this).data('location');
			 
			$.ajax({
			type: 'POST',
			url: myAjax.ajaxurl,
			data: {
			action: 'find_location_ajax_action', 
			locationValue:locationValue,


			},
			success: function (response) {
			var jsonObject = JSON.parse(response);
	        var results=jsonObject.status;
			console.log(results); 
			if(results=="success"){
				$('#locationModal').modal('show');
				var h2Element = $("<h2>").text('Name : ' + jsonObject.data._id); 
				var h2ElementOne = $("<h2>").text('Name : ' + jsonObject.data.name);
var h2ElementTwo = $("<h2>").text('Chain Identifier : ' + jsonObject.data.chain_identifier);
var h2ElementThree = $("<h2>").text('Address : ' + jsonObject.data.addresses.physical.line1 + ' Postcode: ' + jsonObject.data.addresses.physical.postcode);
var h2ElementFour = $("<h2>").text('MID:SID : ' + JSON.stringify(jsonObject.data.tracking[0].identifiers));

$("#location-finder").html(h2ElementOne.add(h2Element).add(h2ElementThree).add(h2ElementTwo).add(h2ElementFour));

				
			}
			 

			},
			error: function () {
			alert('An error occurred while processing the form');
			}
			});
			
			
			
			});

			}else{
				$('<td>').text('--').appendTo(row);
			}
        });

        // Append the table to the div with the id "usersinfo"
       $('#usersinfo').html(table);


				 
			 
			 
	 }else{
		 	$('#usersinfo').html(`
    <div class="norecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p><strong>No User or Transection details found.</strong></p>
                    
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