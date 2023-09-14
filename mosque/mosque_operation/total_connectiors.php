<?php
include '../../connection.php';
$mosqueId= $_POST['mosque_id'];

$sqlQuery = "SELECT COUNT(*) AS total_connectiors FROM user_mosque_connections WHERE mosque_id = $mosqueId";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    // row==1 connection found
    echo json_encode(array("success"=>true,"data"=>$resultOfQuery->fetch_assoc()));
}
else{
    // row==0 no connection found
    // the user allowed to connect the mosque
    echo json_encode(array("success"=>false));
}