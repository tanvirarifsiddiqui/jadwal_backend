<?php

include '../connection.php';
$mosqueEmail= $_POST['mosque_email'];

$sqlQuery = "SELECT * FROM mosques_table WHERE mosque_email = '$mosqueEmail'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    // row==1 existing email address is entered --error
    echo json_encode(array("emailFound"=>true));
}
else{
    // row==0 new email address
    // the user allowed to signUP successfully
    echo json_encode(array("emailFound"=>false));
}