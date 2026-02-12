	jQuery(document).ready(function($){
       let responseData = [];
	  $('#addemailInputform').submit(function (e) {
      e.preventDefault();
      var newH2Content = '<img height="70" width="250" src="' + pluginData.plugin_url + 'loader.gif" alt="Loading...">';

			var newH2 = $('<h2 class="no-heading  text-danger">' + newH2Content + '</h2>');
			$("#Emailsinfo h2").replaceWith(newH2);
			$('#downloadCSVButtonEmail').hide();

		    $('#downloadCSVButtonEmail').hide();
			
      var fileInput = $('#emailInput')[0];

      var file = fileInput.files[0];
       
	  
			 
	  
				if (file) {
					
					
			 
				 var reader = new FileReader();

				reader.onload = function (e) {
				var data = e.target.result;
				var workbook = XLSX.read(data, { type: 'binary' });

				// Assuming you have only one sheet in the Excel file
				var sheetName = workbook.SheetNames[0];
				var sheet = workbook.Sheets[sheetName];

				// Convert sheet data to JSON
				var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

				console.log('Extracted JSON data:', jsonData); // Check extracted JSON data in the console

				// Check if all expected columns are present in the first row
				var expectedHeading = ['Email ID']; // Replace with your expected headings
				var actualHeading = jsonData[0];

				console.log('Expected heading:', expectedHeading); // Check the expected heading
				console.log('Actual heading:', actualHeading); // Check the actual heading

				var missingColumns = expectedHeading.filter(column => !actualHeading.includes(column));

				if (missingColumns.length > 0) {

				$('#Emailsinfo').html(`
				<div class="norecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
				<p>The following expected columns are missing:<strong> ${missingColumns.join(', ')}.</strong></p>
				 
				</div>
				</div>
				</div>
				</div>
				`); 


				return;
				}


				var jsonDataKeyValue = jsonData.slice(1).map(row => {
				var rowObject = {};
				actualHeading.forEach((column, index) => {
				rowObject[column] = row[index];
				});
				return rowObject;
				});


				if (jsonDataKeyValue.length > 500) {

				$('#Emailsinfo').html(`
				<div class="norecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
				<p>Sorry, you cant upload data more than 50.</p>
				 
				</div>
				</div>
				</div>
				</div>
				`);  	  

				return;
				}

				 
			    
               $.ajax({
				type: 'POST',
				url: myAjax.ajaxurl,
				data: {
				action: 'find_email_id', 
				input:jsonDataKeyValue,
				},
				success: function (response) {
				$('#Emailsinfo').html(` `); 
				alert(response);
				console.log(response); 
				responseData = response; 

var jsonObject = JSON.parse(response);
	        var results=jsonObject.length;
			 

			var newH2Content = results + " Records found";

			var newH2 = $('<h2 class="no-heading mb-4 text-success">' + newH2Content + '</h2>');
			$("#Emailsinfo h2").replaceWith(newH2);
            
            			
			$('#downloadCSVButtonEmail').show();

				
	           		

				},
				error: function () {
				alert('An error occurred while processing the form');
				}
				});



				};

				reader.readAsBinaryString(file);
				
			  		
					
					
					
				 
				} else {

				$('#Emailsinfo').html(`
				<div class="norecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
				<p>Please select a excel file</p>
				 
				</div>
				</div>
				</div>
				</div>
				`);  	  		  

				}
    });
 
function JSONToCSV(responseData) {
    // Define the specific fields you want to export
    const fieldsToExport = ["Email","Status","Count"];

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
$('#downloadCSVButtonEmail').click(function () {
	
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