<?php
require "../validate/connect.php";

if (isset($_GET["id"])) {
    $product_id = $_GET["id"];

    // Fetch the current status
    $fetch_status_query = "SELECT is_hidden FROM products WHERE id = $product_id";
    $fetch_result = mysqli_query($connect, $fetch_status_query);
    $row = mysqli_fetch_assoc($fetch_result);

    // Toggle the status and update the database
    $new_status = ($row["is_hidden"] === 'Yes') ? 'No' : 'Yes';
    $update_query = "UPDATE products SET is_hidden = '$new_status' WHERE id = $product_id";
    mysqli_query($connect, $update_query);

    // Redirect back to the previous page or wherever needed
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Invalid product ID";
}

mysqli_close($connect);
