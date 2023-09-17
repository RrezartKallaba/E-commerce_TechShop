<?php
session_start();
require "connect.php";
if (isset($_POST["favorite"])) {
    $product_id = $_POST["product_id_favorite"];
    $userId = $_SESSION["user"]; // Get user ID from session or wherever applicable
    $sql = "SELECT * FROM favorite_products WHERE product_id='$product_id' AND user_id=$userId";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 0) {
            // Product not marked as favorite, so insert it
            $insertQuery = "INSERT INTO favorite_products (user_id, product_id, favorite) VALUES ('$userId', '$product_id', 'Yes')";
            mysqli_query($connect, $insertQuery);
        } else {
            $row = mysqli_fetch_assoc($result);
            if ($row['favorite'] == "No") {
                // Update the preference to "Yes"
                $updateQuery = "UPDATE favorite_products SET favorite = 'Yes' WHERE product_id = $product_id";
                mysqli_query($connect, $updateQuery);
            } else {
                // Update the preference to "No"
                $updateQuery = "UPDATE favorite_products SET favorite = 'No' WHERE product_id = $product_id";
                mysqli_query($connect, $updateQuery);
            }
        }
        header("Location: ../products.php");
    } else {
        echo "Error executing the query: " . mysqli_error($connect);
        // Handle the error as needed
    }
    exit();
}
