	jQuery(document).ready(function($){
     let responseData = [];
	 $("#all_link_card_download").submit(function(event) {
        event.preventDefault(); // Prevent the form from actually submitting
		
       // alert("aaaaaaaaaaaaa");     
            var newH2Content = '<img height="70" width="250" src="' + pluginData.plugin_url + 'loader.gif" alt="Loading...">';

			var newH2 = $('<h2 class="no-heading  text-danger">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
			$('#downloadCSVButtoncardlink').hide();

		    $('#downloadCSVButtoncardlink').hide();
			
			var value = $('#usersIdscard').val();
			user = value.replace(/\s/g, '');
			var selectedValues = {
				usersIds: user
			};

			 

			$.ajax({
			type: 'POST',
			url: myAjax.ajaxurl,
			data: {
			action: 'all_link_card_download_functions',
			selectedValues: selectedValues
			},
			success: function (response) {
				 
				console.log(response);	
			if (response && response !== "no_data") {
			 responseData = response;
			var jsonObject = JSON.parse(response);
	        var results=jsonObject.length;
			 

			var newH2Content = results + " Records found";

			var newH2 = $('<h2 class="no-heading mb-4 text-success">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
            
            			
			$('#downloadCSVButtoncardlink').show();
			} else {
			var newH2Content = " No records found";

			var newH2 = $('<h2 class="no-heading  text-danger">' + newH2Content + '</h2>');
			$("#es_info h2").replaceWith(newH2);
			$('#downloadCSVButtoncardlink').hide();
			}	
				
				
				
			 
			},
			error: function (e) {
			alert('-->'+JSON.stringify(e));
			}
			});

             

	});

 
function JSONToCSV(responseData) {
    // Define the specific fields you want to export
   // const fieldsToExport = ["_id","_Date","_time", "type", "name", "amount", "reward_amount","identifiers.verifier","_owners.Publisher","tel","email","_owners.PaymentCard","_owners.User"];
   //const fieldsToExport = ["_id","identifiers.account_number","_owners.Publisher","personal.first_name", "personal.last_name", "contact.email", "contact.tel","consent.email_marketing","_meta.created_timestamp"];
 const fieldsToExport = ["_id","name_on_card", "type", "last_four","_meta.created_timestamp","_owners.User"];

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
			
			// Ensure phone numbers are treated as text by adding quotes
            if (field === "contact.tel" && value) {
                return `"${value}"`; // Wrap phone numbers in quotes
            }
			// Convert timestamp to Month
            if (field === "_meta.created_timestamp" && value) {
                const date = new Date(value * 1000); // seconds → ms
                const month = date.toLocaleString('default', { month: 'long' });
                return `"${month}"`;
            }
			
            return value ? (typeof value === 'string' ? `"${value}"` : value) : '';
        });
        return values.join(',');
    }).join('\n');

    return header + csv;
}

// Click event for the export button
$('#downloadCSVButtoncardlink').click(function () {
	
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