<?php /*
*
*Template Name: location missing by sid 
*
*/ 
 
 ?>
 
  

 <?php

$curl = curl_init();

// Define the API endpoint
$endpoint = 'https://single.id/location/search';

// Set the common headers
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic Y2JwX2luZCNjbGM6SmNyZ2RZSFJjeU5QWFFtWVhYTFhnYkw0ZWVxRDd0YlZYNVVTc0d4NEhyNEdoOWNycDV1S0hQNTdNRnAzcU1reA=='
);

// Initialize variables
$offset = 0;
$limit = 199;
$allData = [];

do {
    // Set the request payload with the current offset
    $payload = '{
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
            "offset": ' . $offset . ',
            "limit": ' . $limit . '
        }
    }';

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => $headers,
    ));
curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------ 
curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------
    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        break;
    }

    $responseData = json_decode($response);


 
    $data= $responseData->data->results;
    // Add the current batch of data to the result array
    $allData = array_merge($allData, $data);

    // Increment the offset for the next request
    $offset += $limit;

} while ($offset < $responseData->data->total); // Continue until all data is retrieved

// Close cURL
curl_close($curl);
 
 
$seenNames = array();  
   
	
	
	
    foreach ($allData as $item) {
		
         
        // Access the "tracking" array for each item
        foreach ($item->tracking as $trackingData) {
            // Print the "identifiers" array using print_r
           // print_r($trackingData->identifiers);
			$name = $trackingData->identifiers;
			$seenNames[] = $name;
			
        }
         
    }
	
	$givenArray =[
  198104,183422,181958,378534,438245,508057,1127746,1181895,1026017,1126561,
  1050279,360369,664019,355658,359993,1199128,1181894,1126560,1190519,379173,
  973591,506184,1032137,1042377,1104841,1126564,550924,619010,369025,1143766,
  1134979,1170010,1143920,210944,660308,1138548,1137735,377428,974094,359797,
  1121177,690876,501270,876475,495917,1181896,510766,388096,359809,1013390,
  368016,1170376,359794,788684,942092,725560,375067,368068,1143769,393981,
  182411,1162343,390520,436549,198570,359779,374987,1162342,486108,1114731,
  731299,359792,969194,196320,1159953,182163,1159952,378620,182685,372334,
  1090346,759536,142603,359881,359793,360014,363178,205489,1105013,183260,
  669676,387080,203191,360250,973588,703215,183642,366191,182297,1126319,
  384300,669360,1105012,725570,359839,1183130,200843,1199124,362668,183061,
  359906,182620,203194,1105014,640978,1121187,1110602,209242,360769,970005,
  721242,1033831,360276,458405,449952,542159,1129583,359818,1126562,359816,
  370795,1102441,1132636,1102042,1193059,706983,1193060,1193058,1078825,1053150,
  973574,196299,1126563,463949,367971,1159958,1159959,513571,360093,1114629,
  793815,1074837,1170009,1138547,1137734,209010,1098398,973358,358736,973605,
  1031801,196601,1171353,359718,550053,1121184,1121148,1002921,359986,1072009,
  359801,1190518,372216,359736,462921,723281,360101,1134229,366395,931418,
  385639,485930,1061716,1143763,1162338,196352,359827,1126311,183095,1146007,
  1146120,359716,357996,706660,1084410,495531,461884,1121219,1121180,359722,
  1053151,1126565,181981,474397,1129570,941185,1045049,1121141,521517,1127747,
  182013,1134405,1134408,181944,387994,374593,366375,969439,1094825,375009,
  375010,376871,374959,375810,376855,375969,376024,375995,183372,374750,
  28075,1160345,371399,973573,28088,754979,1146122,359877,1146005,359930,
  365871,1126315,607230,182425,377089,375795,513462,1143768,1143854,359706,
  375978,359788,375878,363234,360211,183567,220517,366225,182183,1128706,
  364481,182727,1032133,506126,710143,981381,377134,392915,359922,375964,
  376087,360461,732312,375913,1045047,209269,538831,513520,391909,196651,
  363119,550940,198414,1027641,200718,359774,973457,115294,182845,1110600,
  182917,367983,358350,182043,361779,199524,379887,1143767,182879,379787,
  159932,182488,181893,503747,28205,538380,1125555,182818,51520,209255,
  51503,182586,358183,182320,182346,562448,51498,375930,972654,359791,
  375821,1129602,1157928,1158622,1157929,371299,1158623,1159954,1159955,1110969,
  1183129,181805,1167122,1008026,1134910,1040139,1134654,1008029,1129864,990890,
  941194,1193061,211719,505942,506548,640161,997139,508400,1171354,1116730,
  371055,1199592,456807,1143764,973593,1143765,1162339,1127635,369200,973576,
  906859,1105015,1171355,1171812,710794,1159956,1159957,1126559,651961,1149960,
  721250,1098401,1078822,1137737,1199125,1147349,1157836,1199127,1147348,1159960,
  951739,969188,1199126,1183131,943081,1137739,1146006
];
  
echo '<br>';	
 $pradeep = array();
foreach ($seenNames as $p){
	$pradeep[] = $p[2];
	 
} 
$array1 = array_values($givenArray);
$array2 = array_values($pradeep);

 
$missingValues = array_filter($array1, function($value) use ($array2) {
    return !in_array($value, $array2);
});

// Output the missing values
print_r($missingValues);
echo '<br>';	echo '<br>';	echo '<br>';	echo '<br>';	echo '<br>';	echo '<br>';	echo '<br>';	
echo count($missingValues);
 
echo '<br>';
$i=1;
foreach ($missingValues as $item) {
		
         
         echo $item;
         echo '<br>';
		 
		 $i++;
    }
?>
 

 