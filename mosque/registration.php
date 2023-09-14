<?php
include '../connection.php';

// Ensure that the 'mosque_image' field name matches the field name in your Flutter code.
$mosqueName = $_POST['mosque_name'];
$mosqueCountry = $_POST['mosque_country'];
$mosqueState = $_POST['mosque_state'];
$mosqueCity = $_POST['mosque_city'];
$mosqueAddress = $_POST['mosque_address'];
$mosqueEmail = $_POST['mosque_email'];

// Check if an image file was uploaded.
if (isset($_FILES['mosque_image'])) {
    $imageFile = $_FILES['mosque_image'];

    // Get the file extension (e.g., jpg, png).
    $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

    // Generate a unique filename for the image.
    $imageName = uniqid() . '.' . $imageExtension;

    // Define the directory where you want to save the uploaded images.
    $uploadDirectory = '../images/mosque_images/'. $imageName;

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
    $imageFileName = "mosque_image.png";
}

// Insert the data into the database.
$sqlQuery = "INSERT INTO mosques_table (mosque_name, mosque_country, mosque_state, mosque_city,mosque_address,mosque_image,mosque_email) 
VALUES ('$mosqueName', '$mosqueCountry', '$mosqueState','$mosqueCity','$mosqueAddress','$imageFileName','$mosqueEmail')";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
