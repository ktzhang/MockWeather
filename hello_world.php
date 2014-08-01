<?php
header("Content-Type: application/json; charset = UTF-8");
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['type'])) {
	$type = $_POST['type'];
} else {
	if(isset($_GET['w'])) {
		$type = 2;
	}
	if(isset($_GET['q'])) {
		$type = 1;
	}
}

// Create connection
$con = mysqli_connect("localhost","root","","weathermock");
$con->set_charset('utf8');

// Check connection
if (mysqli_connect_errno()) {
	exit;
  // echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Setting table name
if($type == 2) {
	$table = 'warning';
} else if ($type == 1) {
	$table = 'data';
}


$sql = "SELECT * FROM `$table` WHERE `ip` = '$ip'";
$result = mysqli_query($con,$sql);
if (!$result) {
	echo "Error: " . mysqli_error($con);
}

$singleResult = "";
if(mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$singleResult = json_decode(substr($row['data'], 1, -1), true);
}
mysqli_close($con);

if($type == 2) {
	//Reading from file
	$fileLoc = "mockwarning.json";
	$rawJsonString = file_get_contents($fileLoc);
	$data = json_decode($rawJsonString, true);
		// print_r($data);


	if($singleResult == "") {
		$singleResult = $data['woeids']['result']['0']['12520191']['warnings'];
	}

	//Getting woeArray
	if(isset($_GET['w'])) {
		$woeArray = split(",", $_GET['w']);
	}
	$locationCount = count($woeArray);


	$dataResults = &$data['woeids']['result']['0'];
	$dataResults = array();
	for($i = 0; $i < $locationCount; $i++) {
		$dataResults[$woeArray[$i]]['warnings'] = $singleResult;
	}
	// print_r($data);
	echo json_encode($data);
	exit();
}


if($type == 1) {
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

	//Setting default if not working
	if($singleResult == "") {
		$singleResult = $data['query']['results']['result'];
	}


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

	//Echoing the result
	echo json_encode($data);
	exit();
}


?>