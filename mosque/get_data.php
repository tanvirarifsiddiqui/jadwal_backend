<?php
include '../connection.php';

//Post = send/save data to mysq db
//GET = retrive/read data to mysq db

$mosqueEmail= $_POST["mosque_email"];

$sqlQuery = "SELECT * FROM mosques_table WHERE mosque_email = '$mosqueEmail'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) { //allow admin to signup
    
    $mosqueRecord = $resultOfQuery->fetch_assoc();
    echo json_encode(array(
        "success"=>true,
        "mosqueData"=>$mosqueRecord
    )); //get mosque id
}
else{
    echo json_encode(array("success"=>false)); //do not allow admin to signup
}