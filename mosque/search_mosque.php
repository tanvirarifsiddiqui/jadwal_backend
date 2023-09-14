<?php
include '../connection.php';

$sqlQuery = "SELECT 
                mosques_table.mosque_id, 
                mosques_table.mosque_name, 
                mosques_table.mosque_address, 
                mosques_table.mosque_image, 
                COUNT(user_mosque_connections.user_id) AS connectors
             FROM mosques_table
             LEFT JOIN user_mosque_connections ON mosques_table.mosque_id = user_mosque_connections.mosque_id
             GROUP BY mosques_table.mosque_id, mosques_table.mosque_name, mosques_table.mosque_address, mosques_table.mosque_image";
$resultOfQuery = $connectNow->query($sqlQuery);

$mosques = [];
if ($resultOfQuery->num_rows > 0) { ////successfully fetched mosques
    while ($rowFound = $resultOfQuery->fetch_assoc()) {
        $mosques[] = $rowFound;
    }

    echo json_encode(array(
        "success"=>true,
        "mosques"=>$mosques
    )); 
}
else{
    echo json_encode(array("success"=>false)); //Unsucceessful Data faching
}
// Close the database connection
$connectNow->close();