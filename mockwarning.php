<?php
    header("Content-Type: text/html; charset = UTF-8");
    // require_once("constants.php");

    if(isset($_POST['data'])) {
        startStoring();
    }
    function startStoring() {
        $con = mysql_connect("localhost","root","","weathermock");
        $con->set_charset('utf8');

        // Check connection
        if (mysql_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysql_connect_error();
          exit;
        }
        

        $table = "warning";
        $sql = "CREATE TABLE IF NOT EXISTS `warning` (
              `id` varchar(31) NOT NULL,
              `ip` varchar(31) NOT NULL,
              `data` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ";
        // Execute query
        if (mysql_query($con,$sql)) {
          echo "Table persons created successfully";
        } else {
          echo "Error creating table: " . mysql_error($con);
        }


        //inserting data
        $ip = $_SERVER['REMOTE_ADDR']; 
        $data = $_POST['data'];
        $sql = "INSERT IGNORE INTO $table (id, ip, data) VALUES ('$ip', '$ip', '$data') ON DUPLICATE KEY UPDATE `id`= '$ip', `ip`='$ip', `data`='$data'";
        // Execute query
        if (mysql_query($con,$sql)) {
          echo "Table persons created successfully";
        } else {
          echo "Error creating table: " . mysql_error($con);
        }

        mysql_close($con);
        exit;
    }
?>