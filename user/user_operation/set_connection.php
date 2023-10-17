<?php
include '../../connection.php';

$mosqueId = $_POST['mosque_id'];
$userId = $_POST['user_id'];
$userName = $_POST['user_name'];
// Convert the string to a boolean
$connectionStatus = filter_var($_POST['connection_status'], FILTER_VALIDATE_BOOLEAN);

$sqlQuery = "";
$message = "$userName connected this mosque.";

// Begin a database transaction
$connectNow->begin_transaction();

// Checking total connections
$totalConnectionQuery = "SELECT user_id FROM user_mosque_connections WHERE user_id = $userId";

if ($connectionStatus) {
    $sqlQuery = "DELETE FROM user_mosque_connections WHERE user_id = $userId and mosque_id = $mosqueId";

    // Remove the notification message when disconnected
    $removeNotificationQuery = "DELETE FROM user_to_admin_notifications WHERE user_id = $userId AND mosque_id = $mosqueId";
    $connectNow->query($removeNotificationQuery);
} else {
    // Checking total connections is <= 5
    $maxConnection = $connectNow->query($totalConnectionQuery);
    if ($maxConnection->num_rows < 5) {    
        $sqlQuery = "INSERT INTO user_mosque_connections (user_id, mosque_id) VALUES ($userId, $mosqueId)";

        // Insert the notification message when connected
        $insertNotificationQuery = "INSERT INTO user_to_admin_notifications (user_id, mosque_id, message) VALUES ($userId, $mosqueId, '$message')";
        $connectNow->query($insertNotificationQuery);
    } else {
        // More than 5 connections are not allowed
        $connectNow->rollback();
        echo json_encode(array("success" => false, "message" => "You can have a maximum of 5 connections"));
        exit;
    }
}

if (!empty($sqlQuery)) {
    $resultOfQuery = $connectNow->query($sqlQuery);

    if ($resultOfQuery) {
        // Commit the transaction if successful
        $connectNow->commit();
        echo json_encode(array("success" => true));
    } else {
        // Error in the operation
        $connectNow->rollback();
        echo json_encode(array("success" => false, "message" => "An error occurred on the server. Please try again later"));
    }
}
