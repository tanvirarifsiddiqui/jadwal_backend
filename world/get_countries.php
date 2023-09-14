<?php
include '../world_connection.php';

// Check the connection
if ($connectNow->connect_error) {
    die("Connection failed: " . $connectNow->connect_error);
}
$data = array();
// SQL query to get countries
$sql = "SELECT id, name FROM countries";
$result = $connectNow->query($sql);


$countries = [];
if ($result->num_rows > 0) { //successfully fetched countries
    
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row;
    }
    echo json_encode(array(
        "success"=>true,
        "countries"=>$countries
    ));
}
else{
    echo json_encode(array("success"=>false)); //data fatching error
}

// Close the database connection
$connectNow->close();