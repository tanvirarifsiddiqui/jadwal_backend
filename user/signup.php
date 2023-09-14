<?php
include '../connection.php';

// Ensure that the 'user_image' field name matches the field name in your Flutter code.
$userName = $_POST['user_name'];
$userAge = $_POST['user_age'];
$userCountry = $_POST['user_country'];
$userState = $_POST['user_state'];
$userCity = $_POST['user_city'];
$userAddress = $_POST['user_address'];
$userEmail = $_POST['user_email'];
$userPassword = md5($_POST['user_password']);

// Check if an image file was uploaded.
if (isset($_FILES['user_image'])) {
    $imageFile = $_FILES['user_image'];

    // Get the file extension (e.g., jpg, png).
    $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

    // Generate a unique filename for the image.
    $imageName = uniqid() . '.' . $imageExtension;

    // Define the directory where you want to save the uploaded images.
    $uploadDirectory = '../images/user_images/'. $imageName;

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
    $imageFileName = "userImage.png";
}

// Insert the data into the database.
$sqlQuery = "INSERT INTO users_table (user_name, user_age, user_country, user_state, user_city,user_address,user_image,user_email, user_password) 
VALUES ('$userName', '$userAge', '$userCountry', '$userState','$userCity','$userAddress','$imageFileName','$userEmail','$userPassword')";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}
?>
