<?php
include '../connection.php';

// Ensure that the 'admin_image' field name matches the field name in your Flutter code.
$adminName = $_POST['admin_name'];
$adminAge = $_POST['admin_age'];
$adminCountry = $_POST['admin_country'];
$adminState = $_POST['admin_state'];
$adminCity = $_POST['admin_city'];
$adminAddress = $_POST['admin_address'];
$adminEmail = $_POST['admin_email'];
$adminPhone = $_POST['admin_phone'];
$adminPassword = md5($_POST['admin_password']);
$mosqueId = $_POST['mosque_id'];

// Check if an image file was uploaded.
if (isset($_FILES['admin_image'])) {
    $imageFile = $_FILES['admin_image'];

    // Get the file extension (e.g., jpg, png).
    $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

    // Generate a unique filename for the image.
    $imageName = uniqid() . '.' . $imageExtension;

    // Define the directory where you want to save the uploaded images.
    $uploadDirectory = '../images/admin_images/' . $imageName;

    // Move the uploaded image to the specified directory.
    if (move_uploaded_file($imageFile['tmp_name'], $uploadDirectory)) {
        // Image upload was successful. Use the uploaded image name.
        $imageFileName = $imageName;
    } else {
        echo json_encode(array("success" => false, "message" => "Image upload failed."));
        exit; // Exit the script
    }
} else {
    // No image file uploaded, use the default image name.
    $imageFileName = "admin.png";
}

// Insert the data into the database.
$sqlQuery = "INSERT INTO admins_table (admin_name, admin_age, admin_country, admin_state, admin_city,admin_address,admin_image,admin_email,admin_phone, admin_password,mosque_id) 
VALUES ('$adminName', '$adminAge', '$adminCountry', '$adminState','$adminCity','$adminAddress','$imageFileName','$adminEmail', '$adminPhone','$adminPassword',$mosqueId)";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
