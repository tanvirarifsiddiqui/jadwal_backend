<?php
include '../connection.php';

// Post = send/save data to MySQL db
// GET = retrieve/read data from MySQL db

$adminEmail = $_POST['admin_email'];
$adminPassword = md5($_POST['admin_password']);

$sqlQuery = "SELECT * FROM admins_table WHERE admin_email = '$adminEmail' AND admin_password = '$adminPassword'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) { // Allow admin to login
    $adminRecord = $resultOfQuery->fetch_assoc();
    
    $adminId = $adminRecord['admin_id']; // Assuming 'admin_id' is the primary key

    // Retrieve mosqueData using the admin's mosque_id
    $mosqueQuery = "SELECT
    mosques_table.*,
    (SELECT COUNT(*) FROM user_mosque_connections WHERE user_mosque_connections.mosque_id = (SELECT mosque_id FROM admins_table WHERE admin_id = '$adminId')) AS connectors
    FROM mosques_table
    WHERE mosques_table.mosque_id = (SELECT mosque_id FROM admins_table WHERE admin_id = '$adminId')";
    $mosqueResult = $connectNow->query($mosqueQuery);
    $mosqueRecord = $mosqueResult->fetch_assoc();

    echo json_encode(array(
        "success" => true,
        "adminData" => $adminRecord,
        "mosqueData" => $mosqueRecord
    ));
} else {
    echo json_encode(array("success" => false)); // Do not allow admin to login
}
?>
