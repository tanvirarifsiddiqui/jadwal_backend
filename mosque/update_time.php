<?php
// update_prayer_time.php
include '../connection.php';

$response = array();

// Get the posted data
$mosqueId = $_POST["mosque_id"];
$mosqueName = $_POST["mosque_name"];
$adminId = $_POST["admin_id"];
$adminName = $_POST["admin_name"];
$prayerName = $_POST["prayer_name"];
$prayerTime = $_POST["prayer_time"];

// Begin a database transaction
$connectNow->begin_transaction();

// Update the prayer time in the database
$sqlQuery = "UPDATE mosques_table SET $prayerName = '$prayerTime' WHERE mosque_id = '$mosqueId'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    $prayerTimeFormatted = date("h:i A", strtotime($prayerTime));
    // Build the notification message
    $notificationMessage = "$adminName updated the ". ucfirst(strtolower($prayerName)) ." time of $mosqueName. The current time of ". ucfirst(strtolower($prayerName)) ." Jama-at is $prayerTimeFormatted";

    // Insert the notification message into the admin_to_user_notifications table
    $insertQuery = "INSERT INTO admin_to_user_notifications (admin_id, mosque_id, message) VALUES ('$adminId', '$mosqueId', '$notificationMessage')";

    $insertResult = $connectNow->query($insertQuery);

    if ($insertResult) {
        // Commit the transaction
        $connectNow->commit();
        echo json_encode(array("success" => true));
    } else {
        // Rollback the transaction if there's an issue with inserting the notification
        $connectNow->rollback();
        echo json_encode(array("success" => false, "error" => "Failed to insert the notification"));
    }
} else {
    // If the prayer time update fails, rollback the transaction
    $connectNow->rollback();
    echo json_encode(array("success" => false, "error" => "Failed to update prayer time"));
}
