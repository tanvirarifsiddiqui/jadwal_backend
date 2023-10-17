<?php
include '../../connection.php';

// Receive JSON data from the POST request
$jsonData = file_get_contents('php://input');

// Decode JSON data
$reorderedMosqueOrder = json_decode($jsonData);

// Iterate through the reordered list and update the order_index in the user_mosque_connections table
foreach ($reorderedMosqueOrder as $item) {
    $userId = $item->user_id;
    $mosqueId = $item->mosque_id;
    $orderIndex = $item->order_index;

    // Execute an SQL UPDATE query to update the order_index in the user_mosque_connections table
    $updateQuery = "UPDATE user_mosque_connections SET order_index = $orderIndex WHERE user_id = $userId AND mosque_id = $mosqueId";
    $connectNow->query($updateQuery);
}

// Close the database connection
$connectNow->close();

// Respond to the Flutter app with a success message
echo json_encode(array("success" => true));

?>
