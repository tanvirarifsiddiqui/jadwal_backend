<?php
include '../connection.php';

//Post = send/save data to mysq db
//GET = retrive/read data to mysq db

$userEmail= $_POST['user_email'];
$userPassword= md5($_POST['user_password']);

$sqlQuery = "SELECT * FROM users_table WHERE user_email = '$userEmail' AND user_password = '$userPassword'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) { //allow user to login
    
    $userRecord = array();
    while ($rowFound = $resultOfQuery->fetch_assoc()) {
        $userRecord[] = $rowFound;
    }

    echo json_encode(array(
        "success"=>true,
        "userData"=>$userRecord[0]
    )); //allow user to login
}
else{
    echo json_encode(array("success"=>false)); //do not allow user to login
}