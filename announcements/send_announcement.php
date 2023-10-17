<?php
include '../connection.php';


$adminId = $_POST['admin_id'];    
$mosqueId = $_POST['mosque_id'];    
$announcementText = $_POST['announcement_text'];
$announcementDate = $_POST['announcement_date'];

// Insert the data into the database.
$sqlQuery = "INSERT INTO announcements (mosque_id, admin_id, announcement_text, announcement_date) VALUES ($mosqueId, $adminId, '$announcementText','$announcementDate')";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
