<?php
include '../connection.php';

$mosqueId = $_POST["mosque_id"];
$page = isset($_POST["page"]) ? $_POST["page"] : 1; // Add support for the 'page' parameter

$itemsPerPage = 10; // Set the number of items per page

// Calculate the offset based on the page number and items per page
$offset = ($page - 1) * $itemsPerPage;

$sqlQuery = "SELECT
    announcements.*,
    admins_table.admin_name,
    admins_table.admin_image
FROM
    announcements
INNER JOIN
    admins_table ON announcements.admin_id = admins_table.admin_id
WHERE
    admins_table.mosque_id = $mosqueId
ORDER BY announcements.announcement_date DESC
LIMIT $itemsPerPage OFFSET $offset"; // Use LIMIT and OFFSET for pagination

$resultOfQuery = $connectNow->query($sqlQuery);

$announcements = [];
if ($resultOfQuery->num_rows > 0) { // Successfully fetched announcements
    while ($rowFound = $resultOfQuery->fetch_assoc()) {
        $announcements[] = $rowFound;
    }

    echo json_encode(array(
        "success" => true,
        "announcements" => $announcements
    ));
} else {
    echo json_encode(array("success" => false)); // Unsuccessful Data fetching
}

// Close the database connection
$connectNow->close();
