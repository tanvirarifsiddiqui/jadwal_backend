<?php
include '../connection.php';


$adminId = $_POST['admin_id'];    
$token = $_POST['token'];    

// Insert the data into the database.
$sqlQuery = "INSERT INTO admin_tokens (admin_id, token) VALUES ($adminId, '$token')";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
