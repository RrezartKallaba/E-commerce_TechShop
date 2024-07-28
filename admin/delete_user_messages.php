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

$id = $_GET["user_messages_id"];
$sql = "SELECT * FROM live_support WHERE user_id = $id";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $delete = "DELETE FROM live_support WHERE user_id = $id";
    if (mysqli_query($connect, $delete)) {
        header("Location: dashboard.php?page=admin_messages_to_user");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "Record not found";
}
mysqli_close($connect);
