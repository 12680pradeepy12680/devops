	jQuery(document).ready(function($){
    let responseData = [];
	   
	
	$('#FSaddlocationform').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var fileInput = $('#FSlocationInput')[0];
        var file = fileInput.files[0];
		
		var locationType = $('#FSlocationType').val();
	  
			if (locationType === "") {			 
			$('#FSlocationMessage').html(`
			<div class="norecords records container-fluid p-0">
			<div class="row">
			<div class="col-12">
			<div class="content">
			<p>Please select a Location Type</p>

			</div>
			</div>
			</div>
			</div>
			`);  	  		  

			return;
			}

        if (!file) {
            //alert("Please select a file before submitting.");
			$('#FSlocationMessage').html(`
			<div class="norecords records container-fluid p-0">
			<div class="row">
			<div class="col-12">
			<div class="content">
			<p>Please select a file before submitting.</p>

			</div>
			</div>
			</div>
			</div>
			`);  	  	
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            var firstSheetName = workbook.SheetNames[0];
            var worksheet = workbook.Sheets[firstSheetName];

            var json = XLSX.utils.sheet_to_json(worksheet, {header:1});
            if (json.length > 0) {
			//console.log("First row data:", json[0]); 
			//console.log('Extracted JSON data:', json); // Check extracted JSON data in the console

			// Check if all expected columns are present in the first row
			var expectedHeading = ['SR','Address Line 1', 'Postcode']; // Replace with your expected headings
		    var actualHeading = json[0];

			//console.log('Expected heading:', expectedHeading); // Check the expected heading
			console.log('Actual heading:', actualHeading); // Check the actual heading

			var missingColumns = expectedHeading.filter(column => !actualHeading.includes(column));
            if (missingColumns.length > 0) {

				$('#FSlocationsinfo').html(`
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
			var jsonDataKeyValue = json.slice(1).map(row => {
			var rowObject = {};
			actualHeading.forEach((column, index) => {
			rowObject[column] = row[index];
			});
			return rowObject;
			});

			var input=jsonDataKeyValue;

			 function mergeArray(dataArray) {
    var mergedArray = [];

    // Group elements by MID
    var groupedData = {};
    $.each(dataArray, function(index, item) {
        if (!groupedData[item.MID]) {
            groupedData[item.MID] = [];
        }
        groupedData[item.MID].push(item);
    });

    // Iterate over each group of items
    $.each(groupedData, function(MID, items) {
        var currentTIDs = []; // Initialize the TIDs array

        // Split remaining TIDs into chunks of 19 or fewer elements for each group
        for (var i = 0; i < items.length; i += 19) {
            var chunk = items.slice(i, i + 19).map(function(item) {
                return item.TID;
            });

            // Add MID as the first element of each chunk
            chunk.unshift(MID);

            currentTIDs.push(chunk); // Add the chunk to the TIDs array
        }

        // Create merged item with TIDs array in the desired format
        var mergedItem = $.extend({}, items[0]); // Clone the first item in the group
        mergedItem.TIDs = currentTIDs.map(function(chunk) {
            return {
                "enabled": false,
                "verifier": "firstdata",
                "identifiers": chunk
            };
        });
        mergedArray.push(mergedItem); // Add the merged item to the result array
    });

    return mergedArray;
}

var mergedDataArray = mergeArray(input);

console.log("input: " + JSON.stringify(mergedDataArray));

                var input=input;
				var locationType = $('#FSlocationType').val();
				$.ajax({
				type: 'POST',
				url: myAjax.ajaxurl,
				data: {
				action: 'Add_fs_location_ajax_action_pinelabs', 
				input:input,
				locationType:locationType
				},
				success: function (response) {
				console.log("Raw Response:", response);
                responseData = response;
			var jsonObject = JSON.parse(response);
	        var results=jsonObject.length;
			 

			var newH2Content = results + " Records found";

			var newH2 = $('<h2 class="no-heading mb-4 text-success">' + newH2Content + '</h2>');
			$("#fs_info h2").replaceWith(newH2);
            
            			 
			$('#fsdownloadCSVButton').show();  
            $('#FSlocationMessage').hide();  
				},
				error: function () {
				alert('An error occurred while processing the form');
				}
				});


				
				
				} else {
                 
				$('#FSlocationMessage').html(`
			<div class="norecords records container-fluid p-0">
			<div class="row">
			<div class="col-12">
			<div class="content">
			<p>No data found in the sheet.</p>

			</div>
			</div>
			</div>
			</div>
			`);  	  	
				
            }
        };

        reader.readAsBinaryString(file);
    });
	
	
	
	function JSONToCSV(responseData) {
    // Define the specific fields you want to export
    const fieldsToExport = ["SR","Address Line 1","Postcode","lat", "lng"];

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
$('#fsdownloadCSVButton').click(function () {
	
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