	jQuery(document).ready(function($){

	  $('#addlocationform').submit(function (e) {
      e.preventDefault();

      var fileInput = $('#locationInput')[0];

      var file = fileInput.files[0];
      var locationType = $('#locationType').val();
	  
			if (locationType === "") {			 
			$('#locationsinfo').html(`
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
	  
				if (file) {
					
					
			if(locationType=="pinelabs"){
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
				var expectedHeading = ['Merchant Name','merchantID', 'Store Name', 'Chain Identifier', 'Store Address1', 'Store Address2', 'City', 'State', 'Pincode', 'Store ID', 'Merchant ID', 'Combined']; // Replace with your expected headings
				var actualHeading = jsonData[0];

				console.log('Expected heading:', expectedHeading); // Check the expected heading
				console.log('Actual heading:', actualHeading); // Check the actual heading

				var missingColumns = expectedHeading.filter(column => !actualHeading.includes(column));

				if (missingColumns.length > 0) {

				$('#locationsinfo').html(`
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


				if (jsonDataKeyValue.length > 250) {

				$('#locationsinfo').html(`
				<div class="norecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
				<p>Sorry, you cant upload data more than 250 P.</p>
				 
				</div>
				</div>
				</div>
				</div>
				`);  	  

				return;
				}

				//console.log('-->'+typeof(jsonDataKeyValue));
				var input=jsonDataKeyValue;
				var locationType = $('#locationType').val();
				
				var successCounter = 1;
				$.ajax({
				type: 'POST',
				url: myAjax.ajaxurl,
				data: {
				action: 'Add_location_ajax_action_pinelabs', 
				input:jsonDataKeyValue,
				locationType:locationType
				},
				success: function (response) {
				$('#locationsinfo').html(` `); 
				//alert(response);
				var jsonObject = JSON.parse(response);


				 
				
				 if(jsonObject.status=='success'){
				var currentCounter = successCounter++;	 
				$('#locationsinfo').html(`
				<div class="yesrecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
					<p>Card is registered in the name of user<strong> ${currentCounter}.</strong></p>
					 
				</div>
				</div>
				</div>
				</div>
				`);
				}else{
				$('#locationsinfo').html(`
				<div class="norecords records container-fluid p-0">
				<div class="row">
				<div class="col-12">
				<div class="content">
					<p><strong>No card is registered</strong></p>
					
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



				};

				reader.readAsBinaryString(file);
				
			}else if(locationType="innoviti"){
				
				
				var reader = new FileReader();

				reader.onload = function (e) {
				var data = e.target.result;
				var workbook = XLSX.read(data, { type: 'binary' });

				// Assuming you have only one sheet in the Excel file
				var sheetName = workbook.SheetNames[0];
				var sheet = workbook.Sheets[sheetName];

				// Convert sheet data to JSON
				var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

				//console.log('Extracted JSON data:', jsonData); // Check extracted JSON data in the console

				// Check if all expected columns are present in the first row
				var expectedHeading = ['Merchant Name','merchantID', 'Store Name', 'Chain Identifier', 'Store Address1', 'Store Address2', 'City', 'Pincode', 'utid']; // Replace with your expected headings
				var actualHeading = jsonData[0];

				//console.log('Expected heading:', expectedHeading); // Check the expected heading
				//console.log('Actual heading:', actualHeading); // Check the actual heading

				var missingColumns = expectedHeading.filter(column => !actualHeading.includes(column));

				if (missingColumns.length > 0) {

				$('#locationsinfo').html(`
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


				if (jsonDataKeyValue.length > 120) {

				$('#locationsinfo').html(`
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

				console.log('-->'+jsonDataKeyValue);
				var input=jsonDataKeyValue;
				var locationType = $('#locationType').val();
				$.ajax({
				type: 'POST',
				url: myAjax.ajaxurl,
				data: {
				action: 'Add_location_ajax_action_innoviti', 
				input:jsonDataKeyValue,
				locationType:locationType
				},
				success: function (response) {
				console.log("Raw Response:", response);
               $('#locationsinfo').html(` `);  

				},
				error: function () {
				alert('An error occurred while processing the form');
				}
				});



				};

				reader.readAsBinaryString(file);
				
				
			}else{
				alert("Location type not supported");
			}		
					
					
					
				 
				} else {

				$('#locationsinfo').html(`
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

	});