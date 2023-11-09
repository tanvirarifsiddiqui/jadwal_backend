<?php
include '../connection.php';


$adminId = $_POST['admin_id'];    
$token = $_POST['token'];    

// Check if the token already exists in the database.
$checkQuery = "SELECT token FROM admin_tokens WHERE admin_id = $adminId AND token = '$token'";
$checkResult = $connectNow->query($checkQuery);

if ($checkResult->num_rows == 0) {
    // Token does not exist, so we can insert it.
    $insertQuery = "INSERT INTO admin_tokens (admin_id, token) VALUES ($adminId, '$token')";
    $insertResult = $connectNow->query($insertQuery);

    if ($insertResult) {
        echo json_encode(array("success" => true, "message" => "Successfully stored token"));
    } else {
        echo json_encode(array("success" => false));
    }
}else{
    // Token already exists, do not insert.
    echo json_encode(array("success" => true, "message" => "Token already exists"));
}
?>
