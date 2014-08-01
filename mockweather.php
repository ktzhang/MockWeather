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
        $table = "warning";

        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
              `id` varchar(31) NOT NULL,
              `ip` varchar(31) NOT NULL,
              `data` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ";
        // Execute query
        if (mysqli_query($con,$sql)) {
          echo "Table persons created successfully";
        } else {
          echo "Error creating table: " . mysqli_error($con);
        }




        $ip = $_SERVER['REMOTE_ADDR']; 
        $data = $_POST['data'];
        $sql = "INSERT IGNORE INTO $table (id, ip, data) VALUES ('$ip', '$ip', '$data') ON DUPLICATE KEY UPDATE `id`= '$ip', `ip`='$ip', `data`='$data'";

        // Execute query
        if (mysqli_query($con,$sql)) {
          echo "Dtat success";
        } else {
          echo "Error creating table: " . mysqli_error($con);
        }

        mysqli_close($con);
        exit;
    }

?>