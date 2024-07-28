<?php
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
}
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
}
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}
require "../validate/connect.php";

$review_id = $_GET["review_id"];
$sql = "SELECT * FROM reviews WHERE id = $review_id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $delete = "DELETE FROM reviews WHERE id = $review_id";
    if (mysqli_query($connect, $delete)) {
        header("Location: dashboard.php?page=products");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}
mysqli_close($connect);
