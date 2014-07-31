<?php
header("Content-Type: application/json; charset = UTF-8");


// Create connection
$con=mysqli_connect("localhost","root","","weathermock");

// Check connection
if (mysqli_connect_errno()) {
	exit;
  // echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// $sql = "CREATE TABLE Data 
// (
// PID INT NOT NULL AUTO_INCREMENT, 
// PRIMARY KEY(PID),
// FirstName CHAR(15),
// LastName CHAR(15),
// Age INT
// )";

// // Execute query
// if (mysqli_query($con,$sql)) {
//   echo "Table persons created successfully";
// } else {
//   echo "Error creating table: " . mysqli_error($con);
// }

mysqli_close($con);

$pattern = '$\((.*)\)$';


$count = 0;
// echo "<pre>";print_r ($_GET); echo "</pre>";

//Getting info from request
if(preg_match_all($pattern, $_GET['q'], $matches)) {
	$woeArray = split(",", $matches[1][0]);
}
$locationCount = count($woeArray);

//Populate fake data initial
$fileLoc = "mockweather.json";
$rawJsonString = file_get_contents($fileLoc);
$data = json_decode($rawJsonString, true);

//Setting the header information
$dataQuery = &$data['query'];
$dataQuery['count'] = $locationCount;
$dataQuery['created'] = date("Y-m-dTH:i:sZ");

//Getting the reselt query
$singleResult = $data['query']['results']['result'];


$newData = array();
$newData['locationString'] = "Kevin Town";
$newData['forecast'] = "fsdA";

$singleResult['location']['forecast']['day'][0]['text']['0']['content'] = "you sucks suker";

//Starting manipulation


$dataResults = &$data['query']['results']['result'];
$dataResults = array();
if($locationCount == 1) {
	$dataResults = $singleResult;
	$dataResults['location']['woeid'] = $woeArray[0];
} else {
	for($i = 0; $i < $locationCount; $i++) {
		$dataResults[$i] = $singleResult;
		$dataResults[$i]['location']['woeid'] = $woeArray[$i];
	}
}



echo json_encode($data);









?>