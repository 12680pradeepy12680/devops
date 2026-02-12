<?php
    /**
    * Template Name: Reports 
	  
    */
	
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to India (IST)

$dateAndTime_start = "2023-10-17 00:00:00";
$timestampStart= strtotime($dateAndTime_start);

$dateAndTime_end = "2023-10-17 23:59:59";
$timestampEnd = strtotime($dateAndTime_end);	

 
$jsonData = [
    "query" => [
        "field" => [
            [
                "identifiers.verifier" => [
                    "\$eq" => "system"
                ]
            ],
            [
                "_meta.created_timestamp" => [
                    "\$gte" => $timestampStart
                ]
            ],
            [
                "_meta.created_timestamp" => [
                    "\$lte" => $timestampEnd
                ]
            ]
        ]
    ],
    "options" => [
        "offset" => 0,
        "limit" => 500
    ]
];

$jsonDataString = json_encode($jsonData);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://single.id/transaction/search',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$jsonDataString,
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
	
	$dataa = array(
        array('Date','Time','Id','Type','Name', 'Verifier', 'Amount','Reward'),
        
    );
	
    foreach ($data as $item) {
		
		$timestamp = $item->_meta->created_timestamp; // Replace with your timestamp
        $id=$item->_id;
		// Convert the timestamp to a date and time string
		$dateAndTime = date('Y-m-d H:i:s', $timestamp);

		// Separate the date and time components into different variables
		$date = date('Y-m-d', $timestamp);
		$time = date('H:i:s', $timestamp);
		
         $name= $item->name;
		 $Type=$item->type;
		 $verifier= $item->identifiers->verifier;
		 $amount= ($item->amount)/100;
		 $reward_amount= $item->reward_amount;
         $dataa[]=array($date,$time,$id,$Type,$name, $verifier, $amount,$reward_amount);
         
    }
	
	 
 $file = fopen('exported_data.csv', 'w');

    foreach ($dataa as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    // Download the CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exported_data.csv"');
    readfile('exported_data.csv');
    exit();


     
} else {
    // Handle JSON parsing error
    echo "Failed to parse JSON data";
}
    
/*  
    $data = array(
        array('Name', 'Email', 'Phone'),
        array('John Doe', 'john@example.com', '123-456-7890'),
        array('Jane Smith', 'jane@example.com', '987-654-3210'),
        // Add more data as needed
    );

    $file = fopen('exported_data.csv', 'w');

    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    // Download the CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exported_data.csv"');
    readfile('exported_data.csv');
    exit();
*/
 
?>
 