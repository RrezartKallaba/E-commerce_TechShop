<?php
session_start();
require "connect.php";
$productId = $_POST['product_id'];
$newQuantity = $_POST['quantity'];

$sql = "UPDATE cart SET quantity = $newQuantity WHERE product_id = $productId";
if (mysqli_query($connect, $sql)) {
    $_SESSION['update_cart_message'] = "You updated your cart!";
}
