<?php
// update_prayer_time.php
include '../connection.php';

$response = array();

    // Get the posted data
    $mosqueId = $_POST["mosque_id"];
    $prayerName = $_POST["prayer_name"];
    $prayerTime = $_POST["prayer_time"];

    // Update the prayer time in the database
    $sqlQuery = "UPDATE mosques_table SET $prayerName = '$prayerTime'WHERE mosque_id = '$mosqueId'";
    
    $resultOfQuery = $connectNow->query($sqlQuery);

    if ($resultOfQuery) {
        echo json_encode(array("success"=>true));
    }
    else{
        echo json_encode(array("success"=>false));
    }
