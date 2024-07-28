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

$id = $_GET["product_id"];
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row["image"] != "product.png" && $row["image"] != "user.png") {
        unlink("../pictures/" . $row["image"]);
    }

    $delete = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($connect, $delete)) {
        header("Location: dashboard.php?page=products");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}
mysqli_close($connect);
