	jQuery(document).ready(function($){
     let responseData = [];
	 $("#transactionHistoryForm").submit(function(event) {
        event.preventDefault(); // Prevent the form from actually submitting
		
             
            var newH2Content = '<img height="70" width="250" src="' + pluginData.plugin_url + 'loader.gif" alt="Loading...">';

			var newH2 = $('<h2 class="no-heading  text-danger">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
			$('#downloadCSVButton').hide();

		    $('#downloadCSVButton').hide();
			
			var value = $('#usersIds').val();
			user = value.replace(/\s/g, '');
			var selectedValues = {
				keyword: $('#keyword').val(),
				usersIds: user,
			TransactionType: $('#TransactionTypes').val(),
			TransactionVerifier: $('#TransactionVerifiers').val(),
			startdate: $('#startdate').val(),
			enddate: $('#enddate').val()
			};

			// Check if the values are empty and remove them from the selectedValues object
			for (var key in selectedValues) {
			if (selectedValues[key] === "") {
			delete selectedValues[key];
			}
			}

			$.ajax({
			type: 'POST',
			url: myAjax.ajaxurl,
			data: {
			action: 'User_search_ajax_action',
			selectedValues: selectedValues
			},
			success: function (response) {
				
			console.log('bbbbbbbbbbbbbbbbb');	
			if (response && response !== "no_data") {
			 responseData = response;
			var jsonObject = JSON.parse(response);
	        var results=jsonObject.length;
			 

			var newH2Content = results + "0000 Records found";

			var newH2 = $('<h2 class="no-heading mb-4 text-success">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
            
            			
			$('#downloadCSVButton').show();
			} else {
			var newH2Content = " No0000 records found";

			var newH2 = $('<h2 class="no-heading  text-danger">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
			$('#downloadCSVButton').hide();
			}	
				
				
				
			 
			},
			error: function (e) {
			alert('-->'+JSON.stringify(e));
			}
			});

             

	});

 
function JSONToCSV(responseData) {
    // Define the specific fields you want to export
    const fieldsToExport = ["_id","_Date","_time", "type", "name", "amount", "reward_amount","identifiers.verifier","merchant","City","location","email","tel","_owners.PaymentCard","_owners.User"];

    // Create the CSV header based on the selected fields
    const header = fieldsToExport.join(',') + '\n';

    // Extract the selected fields from the data
    const csv = responseData.map(row => {
        const values = fieldsToExport.map(field => {
            const fieldParts = field.split('.');
            let value = row;
            for (const part of fieldParts) {
                if (value) {
                    value = value[part];
                }
            }
            return value ? (typeof value === 'string' ? `"${value}"` : value) : '';
        });
        return values.join(',');
    }).join('\n');

    return header + csv;
}

// Click event for the export button
$('#downloadCSVButton').click(function () {
	
	var jsonObject = JSON.parse(responseData);
	var responseDatas=jsonObject;
     
    const csvContent = JSONToCSV(responseDatas);

    // Create a Blob containing the CSV data
    const blob = new Blob([csvContent], { type: 'text/csv' });

    // Create a download link and trigger the click event
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'data.csv';
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
});


    

	});