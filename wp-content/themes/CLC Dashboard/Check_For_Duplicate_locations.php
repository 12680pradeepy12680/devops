<?php /*
*
*Template Name: Check For Duplicate locations 
*
*/ 
 
 ?>
 
 <?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/location/search',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "query": {
    "field": [
      {
        "chain_identifier": {
          "$eq": "cobb_apparels"
        }
      }
    ]
  },
  "options": {
    "offset": 0,
    "limit": 100000
  }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic Y2JwX2luZCNjbGM6SmNyZ2RZSFJjeU5QWFFtWVhYTFhnYkw0ZWVxRDd0YlZYNVVTc0d4NEhyNEdoOWNycDV1S0hQNTdNRnAzcU1reA=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 
$data = json_decode($response);



// Check if decoding was successful
if ($data !== null) {
    // Access the "status" property and display it
	
	//echo "<pre>";    print_r($data->data->results);    echo "</pre>";
	
	$seenNames = array(); // To keep track of seen names
    $data= $data->data->results;
	
	
	
    foreach ($data as $item) {
		
         
        // Access the "tracking" array for each item
        foreach ($item->tracking as $trackingData) {
            // Print the "identifiers" array using print_r
           // print_r($trackingData->identifiers);
			$name = $trackingData->identifiers;
			if (in_array($name, $seenNames)) {
			 print_r($name);
			 echo "<br>";

			} else {
			$seenNames[] = $name;
			}
			
        }
         
    }
	
	 
 


     
} else {
    // Handle JSON parsing error
    echo "Failed to parse JSON data";
}
?>
 