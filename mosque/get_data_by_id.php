<?php
include '../connection.php';

//Post = send/save data to mysq db
//GET = retrive/read data to mysq db

$mosqueId = $_POST["mosque_id"];

$sqlQuery = "SELECT
mosques_table.*,
(SELECT COUNT(*) FROM user_mosque_connections WHERE user_mosque_connections.mosque_id = $mosqueId) AS connectors
FROM mosques_table
WHERE mosques_table.mosque_id = $mosqueId";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) { //allow admin to signup

    $mosqueRecord = $resultOfQuery->fetch_assoc();
    echo json_encode(array(
        "success" => true,
        "mosqueData" => $mosqueRecord
    )); //get mosque id
} else {
    echo json_encode(array("success" => false)); //do not allow admin to signup
}
