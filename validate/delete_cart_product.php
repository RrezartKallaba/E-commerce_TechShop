<?php
session_start();
require "connect.php";
$cart_id = $_GET["cart_id"];
$sql = "SELECT * FROM cart WHERE cart_id = $cart_id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $delete = "DELETE FROM cart WHERE cart_id = $cart_id";
    if (mysqli_query($connect, $delete)) {
        $_SESSION['success_message'] = "✅Product deleted successfully!";
        header("Location: ../products.php");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}
mysqli_close($connect);
