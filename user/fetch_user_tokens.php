<?php
include '../connection.php';


$mosqueId = $_POST['mosque_id'];

// Insert the data into the database.
// Include your database connection code here

$sql = "SELECT token FROM user_tokens WHERE user_id IN (SELECT user_id FROM user_mosque_connections WHERE mosque_id = $mosqueId)";

$result = $connectNow->query($sql);

$tokens = array();
while ($row = $result->fetch_assoc()) {
    $tokens[] = $row['token'];
}

// $tokens now contains the FCM tokens for connected users in the specified mosque


if ($result) {
    echo json_encode(array("success" => true,
    "tokens" => $tokens));
} else {
    echo json_encode(array("success" => false));
}
?>
