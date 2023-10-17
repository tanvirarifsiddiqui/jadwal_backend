<?php
include '../connection.php';

$userId = $_POST["user_id"];

$sqlQuery = "SELECT
mosques_table.mosque_id,
mosques_table.mosque_name,
mosques_table.mosque_image,
mosques_table.mosque_address,
mosques_table.fajr,
mosques_table.zuhr,
mosques_table.asr,
mosques_table.maghrib,
mosques_table.isha,
mosques_table.jumuah
FROM
user_mosque_connections
INNER JOIN
mosques_table ON user_mosque_connections.mosque_id = mosques_table.mosque_id
WHERE
user_mosque_connections.user_id = $userId ORDER BY user_mosque_connections.order_index";
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