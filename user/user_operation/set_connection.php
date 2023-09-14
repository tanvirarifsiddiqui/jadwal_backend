<?php
include '../../connection.php';

$mosqueId = $_POST['mosque_id'];
$userId = $_POST['user_id'];
// Convert the string to a boolean
$connectionStatus = filter_var($_POST['connection_status'], FILTER_VALIDATE_BOOLEAN);

$sqlQuery="";
//checking total connection is <=5
$totalConnectionQuery = "SELECT user_id FROM user_mosque_connections WHERE user_id = $userId";

if ($connectionStatus) {
    $sqlQuery = "DELETE FROM user_mosque_connections WHERE user_id = $userId and mosque_id = $mosqueId";
} else {
    //checking total connection is <=5
    $maxConnection = $connectNow->query($totalConnectionQuery);
    if ($maxConnection->num_rows < 5) //total connection is <5 allowing user to perform new connection
    {    
        $sqlQuery = "INSERT INTO user_mosque_connections (user_id, mosque_id) VALUES ($userId, $mosqueId)";
    } else {
        // row==6 connection found, user not permitted to connect new mosque
        echo json_encode(array("success" => false, "message" => "You can save a maximum of 5 connections"));
    }
}
if (!empty($sqlQuery)) {
    $resultOfQuery = $connectNow->query($sqlQuery);
if ($resultOfQuery) {
    // Connection Operaion Done successfully
    echo json_encode(array("success" => true));
} else {
    // error in operation
    echo json_encode(array("success" => false, "message" => "An Error Occured in server please try again later"));
}
}