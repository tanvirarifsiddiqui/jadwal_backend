<?php
include '../connection.php';

$userId = $_POST["user_id"];
$page = isset($_POST["page"]) ? $_POST["page"] : 1; // Add support for the 'page' parameter

$itemsPerPage = 10; // Set the number of items per page

// Calculate the offset based on the page number and items per page
$offset = ($page - 1) * $itemsPerPage;

$sqlQuery = "SELECT 
a.admin_id AS admin_id,
a.mosque_id AS mosque_id,
a.admin_image AS admin_image,
a.mosque_name AS mosque_name,
a.mosque_image AS mosque_image,
a.message AS message,
a.created_at AS created_at
FROM (
SELECT 
    n.admin_id AS admin_id,
    n.mosque_id AS mosque_id,
    a.admin_image AS admin_image,
    m.mosque_name AS mosque_name,
    m.mosque_image AS mosque_image,
    n.message AS message,
    n.created_at AS created_at
FROM admin_to_user_notifications n
LEFT JOIN user_mosque_connections u ON n.mosque_id = u.mosque_id
LEFT JOIN admins_table a ON n.admin_id = a.admin_id
LEFT JOIN mosques_table m ON n.mosque_id = m.mosque_id
WHERE u.user_id = $userId
UNION
SELECT 
    NULL AS admin_id,
    NULL AS mosque_id,
    NULL AS admin_image,
    NULL AS mosque_name,
    NULL AS mosque_image,
    n2.message AS message,
    n2.created_at AS created_at
FROM user_specific_notifications n2
WHERE n2.user_id = $userId
UNION
SELECT 
    NULL AS admin_id,
    NULL AS mosque_id,
    NULL AS admin_image,
    NULL AS mosque_name,
    NULL AS mosque_image,
    n3.message AS message,
    n3.created_at AS created_at
FROM general_notifications n3
) AS a
ORDER BY a.created_at DESC
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
