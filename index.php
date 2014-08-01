<?php
    header("Content-Type: text/html; charset = UTF-8");

    if(isset($_POST['data'])) {
        startStoring();
    }
    function startStoring() {
        $con = mysqli_connect("localhost","root","","weathermock");
        $con->set_charset('utf8');

        // Check connection
        if (mysqli_connect_errno()) {
            exit;
          // echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $ip = $_SERVER['REMOTE_ADDR']; 
        $data = $_POST['data'];
        $sql = "INSERT IGNORE INTO data (id, ip, data) VALUES ('$ip', '$ip', '$data') ON DUPLICATE KEY UPDATE `id`= '$ip', `ip`='$ip', `data`='$data'";

        // Execute query
        if (mysqli_query($con,$sql)) {
          echo "Table persons created successfully";
        } else {
          echo "Error creating table: " . mysqli_error($con);
        }

        mysqli_close($con);
        exit;
    }

?>

<!doctype html>
<html ng-app="JSONedit">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script src="lib/jquery.min.js"></script>
    <script src="lib/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="lib/angular.min.js"></script>
    <script src="lib/angular-ui/angular-ui.js"></script>
    <script src="lib/angular-ui/multiSortable.js"></script>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <script src="js/directives.js"></script>
    <script src="js/json2.js"></script>
    <script src="js/JSONedit.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="mainView" ng-controller="MainViewCtrl" ng-init="init(1)">
        <div class="submitBar">            
            <input name="Submit" value="Submit" type="button" ng-click="postData()" /> 
        </div>
        <h2 class="title">Location MockData</h2>
        <div class="jsonView" defocus>
            <json child="jsonData" type="'object'"></json>
        </div>

        <h3>Text JSON</h3>
        <div>
            <textarea ng-model="jsonString"></textarea>
            <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
        </div>

    </div>
</body>
</html>
