<?php
session_start();
require "connect.php";
if (isset($_POST["add_to_cart"])) {
    $product_id = $_POST["product_id"];
    $image = $_POST["image"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $userId = $_SESSION["user"]; // Get user ID from session or wherever applicable

    $sql = "SELECT product_id FROM cart WHERE product_id='$product_id' AND user_id='$userId'";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) != 0) {
        $_SESSION['error_product_id'] = $product_id;
        $_SESSION['error_message'] = "You have already added this item to the cart!";
        header("Location: ../products.php");
    } else {
        $query = "INSERT INTO cart (user_id, product_id, image, name, price) VALUES ('$userId', '$product_id', '$image', '$name', '$price')";
        mysqli_query($connect, $query);
        $_SESSION['add_cart_message'] = "✅Product successfully added to cart!";
        header("Location: ../products.php");
    }
    exit();
}
