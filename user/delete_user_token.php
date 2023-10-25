<?php
include '../connection.php';


$token = $_POST['token'];    

// Insert the data into the database.
$sqlQuery = "DELETE FROM user_tokens WHERE token = '$token'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
