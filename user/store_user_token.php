<?php
include '../connection.php';


$userId = $_POST['user_id'];    
$token = $_POST['token'];    

// Insert the data into the database.
$sqlQuery = "INSERT INTO user_tokens (user_id, token) VALUES ($userId, '$token')";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
