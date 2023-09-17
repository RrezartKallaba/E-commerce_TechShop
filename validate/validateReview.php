<?php
require "connect.php";
$review = "";
$error_message_review = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user'];
    $review = $_POST["review"];

    if (empty($review)) {
        $error = true;
        $error_message_review = "Review cannot be empty.";
    }
    if (!$error) {
        $sql = "INSERT INTO reviews(user_id, product_id, review) VALUES('$user_id', '$product_id', '$review')";
        if (mysqli_query($connect, $sql)) {
            echo "<script>window.location.href = 'details.php?id=$product_id'</script>";
            exit();
        } else {
            $error = true;
            $error_message_review = "Error in the process of adding review.";
        }
    }
}
