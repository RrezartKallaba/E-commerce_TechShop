<?php
session_start();
require "connect.php";

if (isset($_SESSION["user"])) {
    $userId = $_SESSION["user"];
    // $sql1 = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = $userId";
    $sql1 = "SELECT COUNT(cart_id) AS cart_count FROM cart WHERE user_id = $userId";

    $result = mysqli_query($connect, $sql1);
    $row = mysqli_fetch_assoc($result);

    if ($row["cart_count"] !== 0) {
        echo $row["cart_count"];
    } else {
        echo "0";
    }
} else {
    // Handle the case when the user is not logged in
    echo "0";
}
