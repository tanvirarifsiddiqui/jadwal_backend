<?php
include '../world_connection.php';

$stateId= $_POST["state_id"];
// Check the connection
if ($connectNow->connect_error) {
    die("Connection failed: " . $connectNow->connect_error);
}
$data = array();
// SQL query to get cities
$sql = "SELECT id, name FROM cities WHERE state_id = '$stateId'";
$result = $connectNow->query($sql);


$cities = [];
if ($result->num_rows > 0) { //successfully fetched cities
    
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
    echo json_encode(array(
        "success"=>true,
        "cities"=>$cities
    ));
}
else{
    echo json_encode(array("success"=>false)); //data fatching error
}

// Close the database connection
$connectNow->close();