<?php
include '../connection.php';

$userId = $_POST['user_id'];    
$token = $_POST['token'];    

// Check if the token already exists in the database.
$checkQuery = "SELECT token FROM user_tokens WHERE user_id = $userId AND token = '$token'";
$checkResult = $connectNow->query($checkQuery);

if ($checkResult->num_rows == 0) {
    // Token does not exist, so we can insert it.
    $insertQuery = "INSERT INTO user_tokens (user_id, token) VALUES ($userId, '$token')";
    $insertResult = $connectNow->query($insertQuery);

    if ($insertResult) {
        echo json_encode(array("success" => true, "message" => "Successfully stored token"));
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    // Token already exists, do not insert.
    echo json_encode(array("success" => true, "message" => "Token already exists"));
}
?>
