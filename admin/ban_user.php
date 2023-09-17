<?php
require "../validate/connect.php";

if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    // Fetch the current status
    $fetch_status_query = "SELECT is_banned FROM users WHERE id = $user_id";
    $fetch_result = mysqli_query($connect, $fetch_status_query);
    $row = mysqli_fetch_assoc($fetch_result);

    // Toggle the status and update the database
    $new_status = ($row["is_banned"] === 'Yes') ? 'No' : 'Yes';
    $update_query = "UPDATE users SET is_banned = '$new_status' WHERE id = $user_id";
    mysqli_query($connect, $update_query);

    // Redirect back to the previous page or wherever needed
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Invalid user ID";
}

mysqli_close($connect);
