<?php
include '../connection.php';

$userId = $_POST["user_id"];

$sqlQuery = "SELECT
mosques_table.mosque_id,
mosques_table.mosque_name,
mosques_table.mosque_image,
admin.latest_admin_name AS admin_name,
admin.latest_announcement_text AS announcement_text,
admin.latest_announcement_date AS announcement_date
FROM
mosques_table
INNER JOIN
user_mosque_connections ON mosques_table.mosque_id = user_mosque_connections.mosque_id
LEFT JOIN (
SELECT
  a.mosque_id,
  a.admin_id,
  admins_table.admin_name AS latest_admin_name,
  a.announcement_text AS latest_announcement_text,
  a.announcement_date AS latest_announcement_date
FROM
  announcements a
INNER JOIN (
  SELECT
    mosque_id,
    MAX(announcement_date) AS max_date
  FROM
    announcements
  GROUP BY
    mosque_id
) b ON a.mosque_id = b.mosque_id AND a.announcement_date = b.max_date
LEFT JOIN
  admins_table ON a.admin_id = admins_table.admin_id
) AS admin ON mosques_table.mosque_id = admin.mosque_id
WHERE
user_mosque_connections.user_id = $userId;";
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