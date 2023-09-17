<?php
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
}
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
}
if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}
require "../validate/connect.php";

$id = $_GET["id"];
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row["image"] != "user.png") {
        unlink("../pictures/" . $row["image"]);
    }

    $delete = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($connect, $delete)) {
        header("Location: dashboard.php?page=users");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}

mysqli_close($connect);
