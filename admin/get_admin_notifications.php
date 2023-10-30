<?php
include '../connection.php';

$mosqueId = $_POST["mosque_id"];
$adminId = $_POST["admin_id"];
$page = isset($_POST["page"]) ? $_POST["page"] : 1; // Add support for the 'page' parameter

$itemsPerPage = 20; // Set the number of items per page

// Calculate the offset based on the page number and items per page
$offset = ($page - 1) * $itemsPerPage;

$sqlQuery = "SELECT 
user_id,
user_image,
message,
created_at
FROM (
SELECT 
    n1.user_id AS user_id,
    u.user_image AS user_image,
    n1.message AS message,
    n1.created_at AS created_at
FROM user_to_admin_notifications n1
LEFT JOIN users_table u ON n1.user_id = u.user_id
WHERE n1.mosque_id = $mosqueId
UNION
SELECT 
    NULL AS user_id,
    NULL AS user_image,
    n2.message AS message,
    n2.created_at AS created_at
FROM admin_specific_notifications n2
WHERE n2.admin_id = $adminId
UNION
SELECT 
    NULL AS user_id,
    NULL AS user_image,
    n3.message AS message,
    n3.created_at AS created_at
FROM general_notifications n3
) AS n
ORDER BY n.created_at DESC
LIMIT $itemsPerPage OFFSET $offset"; // Use LIMIT and OFFSET for pagination

$resultOfQuery = $connectNow->query($sqlQuery);

$notifications = [];
if ($resultOfQuery->num_rows > 0) { // Successfully fetched notifications
    while ($rowFound = $resultOfQuery->fetch_assoc()) {
        $notifications[] = $rowFound;
    }

    echo json_encode(array(
        "success" => true,
        "notifications" => $notifications
    ));
} else {
    echo json_encode(array("success" => false)); // Unsuccessful Data fetching
}

// Close the database connection
$connectNow->close();
