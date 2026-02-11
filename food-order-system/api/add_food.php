<?php
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['food_name']);
    $price = $conn->real_escape_string($_POST['price']);
    
    // Tengeneza jina la picha
    $image_name = time() . "_" . $_FILES['food_image']['name'];
    $target = "../assets/images/" . $image_name;

    // Hakikisha folder lipo
    if (!is_dir("../assets/images/")) {
        mkdir("../assets/images/", 0777, true);
    }

    if (move_uploaded_file($_FILES['food_image']['tmp_name'], $target)) {
        // Tumia majina mapya ya column
        $sql = "INSERT INTO menu_items (food_name, price, image_url) VALUES ('$name', '$price', '$image_name')";
        if ($conn->query($sql)) {
            header("Location: ../admin_dashboard.php?status=success");
            exit();
        }
    } else {
        echo "Kosa: Picha haikuweza kuhifadhiwa kwenye folder la assets/images.";
    }
}
?>