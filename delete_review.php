<?php
require "validate/connect.php";


$product_id = $_GET["product_id"];
$review_id = $_GET["review_id"];
$sql = "SELECT * FROM reviews WHERE id = $review_id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $delete = "DELETE FROM reviews WHERE id = $review_id";
    if (mysqli_query($connect, $delete)) {
        header("Location: details.php?id=$product_id");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}
mysqli_close($connect);
