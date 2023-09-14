<?php

include '../connection.php';
$adminPhone= $_POST['admin_phone'];

$sqlQuery = "SELECT * FROM admins_table WHERE admin_phone = '$adminPhone'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    // row==1 existing email address is entered --error
    echo json_encode(array("phoneFound"=>true));
}
else{
    // row==0 new email address
    // the user allowed to signUP successfully
    echo json_encode(array("phoneFound"=>false));
}