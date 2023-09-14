<?php
include '../world_connection.php';

$countryId= $_POST["country_id"];
// Check the connection
if ($connectNow->connect_error) {
    die("Connection failed: " . $connectNow->connect_error);
}
$data = array();
// SQL query to get states
$sql = "SELECT id, name FROM states WHERE country_id = '$countryId'";
$result = $connectNow->query($sql);


$states = [];
if ($result->num_rows > 0) { //successfully fetched states
    
    while ($row = $result->fetch_assoc()) {
        $states[] = $row;
    }
    echo json_encode(array(
        "success"=>true,
        "states"=>$states
    ));
}
else{
    echo json_encode(array("success"=>false)); //data fatching error
}

// Close the database connection
$connectNow->close();