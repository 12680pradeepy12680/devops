<?php /*
*
*Template Name: testing two
*
*/ 
  
 ?>

  
 
 

 
<?php

$chain_identifier = "dil_pizzahut";
$limit = 200; // Number of records to fetch per request
$offset = 0; // Initial offset
$duplicate = array();
$seenNames = array();
$givenArray=[424604, 3908, 3913, 3914, 3915, 5100, 8420, 8423, 8427, 8454, 8469, 8443, 8467, 8445, 8450, 8440, 8446, 18077, 24167, 8444, 8455, 8441, 25128, 8436, 8470, 11130, 9501, 25822, 8465, 8507, 17227, 34245, 72855, 71277, 8494, 32157, 8472, 11879, 45060, 41125, 40582, 40710, 28560, 40074, 62632, 41386, 62901, 29161, 8480, 28827, 41889, 40888, 40280, 40777, 40284, 8488, 28303, 39062, 41702, 222439, 143668, 180006, 424739, 256654, 266241, 446422, 149392, 441469, 168151, 202099, 430841, 148605, 144057, 264166, 251374, 100754, 191095, 424798, 296536, 224785, 323646, 100950, 99735, 118159, 224907, 199538, 114382, 217651, 267587, 222566, 129505, 194401, 222455, 224786, 226222, 258032, 261510, 261812, 280942, 260241, 269500, 253883, 309572, 324122, 424614, 424737, 101113, 100957, 479743, 224951, 225176, 211272, 225301, 100640, 100965, 424794, 425014, 253830, 294036, 253963, 100825, 263766, 424740, 261381, 424567, 251483, 483236, 424707, 296751, 293381, 257565, 441807, 424680, 484360, 224777, 292876, 168377, 446246, 290147, 199904, 225820, 265521, 101256, 429043, 296274, 296731, 199447, 717810, 606259, 703516, 100430, 100631, 100712, 100749, 91850, 19240, 100618, 100772, 100966, 27416, 100698, 100708, 100846, 101091, 100566, 100756, 100791, 100810, 100815, 100956, 100991, 138785, 138659, 28401, 100607, 100949, 100959, 100848, 107461, 100935, 101398, 116529, 100561, 100687, 100951, 100841, 100954, 101099, 100984, 40320, 8442, 24237, 8497, 8487, 8448, 8452, 8425, 8422, 772336, 773000, 772063, 772149, 582341, 594175, 641168, 704060, 547627, 697921, 589565, 594364, 641182, 704889, 641176, 770255, 684770, 594178, 799659, 704008, 604257, 641030, 745417, 791411, 800630, 641070, 761898, 704267, 797314, 704888, 801079, 641044, 594444, 577497, 705020, 669269, 743512, 772996, 643003, 773005, 773002, 772023, 791402, 791415, 790981, 772998, 791397, 772993, 791413, 791406, 791409, 762026, 773007, 604252, 641162, 512860, 640982, 547619, 702061, 577400, 517336, 427646, 549883, 547566, 547626, 547692, 113147, 485365, 427645, 461701, 275988, 447495, 467346, 118185, 324617, 531404, 463008, 513271, 484220, 153439, 459058, 484500, 513610, 509537, 484906, 216561, 247076, 241776, 236721, 236711, 178839, 489198, 513122, 985070, 985060, 1015401, 1009873, 1015410, 844417, 1015415, 1015419, 1015385, 1049715, 1015407, 1015388, 1015423, 985079, 1011409, 1015381, 1015383, 985075, 956476, 956480, 956484, 1015389, 985084, 956493, 956488, 1015404, 945186, 715068, 949577, 956472, 984032, 1040991, 1041306, 1037713, 1036255, 1036389, 900821, 577364, 641084, 594318, 743510, 770935, 550450, 924035, 945177, 945190, 945183, 945180, 924033, 900674, 900686, 900659, 900667, 900679, 838819, 844415, 844329, 791404, 1065523, 1041300, 1102968, 1049728, 1041303, 1065464, 1049719, 1041297, 1049724, 1065521, 1049711, 1065522, 1102971, 1102970, 1065520, 1075620, 1061722, 1065220, 1062425, 1040995, 107561];
do {
    // Construct JSON data with offset and limit
    $jsonData = [
        "query" => [
            "field" => [
                [
                    "chain_identifier" => [
                        "\$eq" => $chain_identifier
                    ]
                ]
            ]
        ],
        "options" => [
            "offset" => $offset,
            "limit" => $limit
        ]
    ];

    // Encode JSON data
    $jsonDataString = json_encode($jsonData);

    // Initialize cURL
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://single.id/location/search',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonDataString,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic Y2JwX2luZCNjbGM6SmNyZ2RZSFJjeU5QWFFtWVhYTFhnYkw0ZWVxRDd0YlZYNVVTc0d4NEhyNEdoOWNycDV1S0hQNTdNRnAzcU1reA=='
        ),
    ));
    curl_setopt($curl, CURLOPT_CAINFO, "C:/wamp64/cacert.pem"); // <------
    curl_setopt($curl, CURLOPT_CAPATH, "C:/wamp64/cacert.pem"); // <------

    // Execute cURL request
    $response = curl_exec($curl);

    // Close cURL session
    curl_close($curl);

    // Decode JSON response
    $data = json_decode($response);

    // Check if decoding was successful and if there are results
    if (isset($data->data->results) && !empty($data->data->results)) {
          
		foreach ($data->data->results as $item) {
		
         
         foreach ($item->tracking as $trackingData) {
            
			$name = $trackingData->identifiers;
			if (in_array($name, $seenNames)) {
			 print_r($name);
			 echo $item->addresses->physical->postcode;
			 echo "<br>";
			} else {
			$seenNames[] = $name;
			}
			
        }
    }
	  
		  

        $offset += $limit;
    } else {
        // No more results, exit the loop
        break;
    }
} while (true);
$pradeep = array();
foreach ($seenNames as $p){
	$pradeep[] = $p[2];
	 
} 
$array1 = $givenArray;
$array2 = $pradeep;
echo '<pre>',print_r($array2,1),'</pre>';

 
$notInArray2 = array_diff($array1, $array2);

 
$notInArray1 = array_diff($array2, $array1);
 

if(count($notInArray2)==0){
	echo "All";
}else{
$simpleArray = array_values($notInArray2);

 
echo "-----B".json_encode($simpleArray);	
}