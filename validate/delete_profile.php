<?php
session_start();
require "connect.php";

if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"];

    $sql = "DELETE FROM users WHERE id='$id'";

    if (mysqli_query($connect, $sql)) {
        session_destroy();
        session_start();
        $_SESSION['profile_delete'] = "User deleted successfully.";
        header("Location: ../home.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
} else {
    echo "There is no session open for the user.";
}
mysqli_close($connect);
