<?php

// You can access this file on your dev bot
// http://<dev box>/cityofheroes/api/sample_json.php?name=Jackie&org=HR
// Notice we're adding two key/value pairs in the URL, name and org 

// We can access name and title like this, notice
// we use YIV because every input we get from the user
// should be run through validation inputs.

// See http://devel.corp.yahoo.com/yahoo/doc/php/yahoo_yiv/
if ($_REQUEST['name']) {
    $name = yiv_get_stripped($_REQUEST['name']);
} else {
    // Default value
    $name = 'Marissa';
}

if ($_REQUEST['org']) {
    $title = yiv_get_stripped($_REQUEST['org']);
} else {
    $title = 'CEO';

}

header('Content-type: application/json; charset=utf-8');


$result = array(
              0 => array('Laurie', 'Search'),
              1 => array('Mike',   'Homepage & Verticals'),
              2 => array('Jeff',   'Communications'),
              3 => array('Ron',    'Legal'),
              4 => array($name,    $title),
          );

echo json_encode($result);

?>
