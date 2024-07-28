<?php
session_start();
require "connect.php";


if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: index.php");
}

$email = $password = $passError = $emailError = "";
$error = false;

function cleanInputs($input)
{
    $data = trim($input); // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data); // removing tags from the string
    $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt";

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = cleanInputs($_POST["email"]);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // if the provided text is not a format of an email, error will be true
        $error = true;
        $emailError = "Please enter a valid email address";
    }

    // simple validation for the "password"
    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    }
    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($row["is_banned"] === 'Yes') {
                echo "<div class='alert alert-danger'>
                    <p style='text-align: center;'>You are banned from this site.</p>
                </div>";
            } else {
                if ($row["status"] == "user") {
                    $_SESSION["user"] = $row["id"];
                    $_SESSION["useremail"] = $row["email"];
                    $_SESSION["username"] = $row["first_name"] . " " . $row["last_name"];
                    $_SESSION["status"] = $row["status"];


                    $user_id = $_SESSION["user"];
                    $user_email = $_SESSION["useremail"];
                    $status = $_SESSION["status"];
                    $login_time = date('H:i:s', strtotime('+2 hours')); // Merr kohën aktuale dhe shton 2 orë
                    $login_date = date('Y-m-d');

                    $sql_insert01 = "INSERT INTO time_datelogin (user_id, user_email, status, time, date) VALUES ('$user_id', '$user_email', '$status', '$login_time', '$login_date')";
                    mysqli_query($connect, $sql_insert01);

                    header("Location: loading.php");
                } else {
                    $_SESSION["admin"] = $row["id"];
                    $_SESSION["adminemail"] = $row["email"];
                    $_SESSION["adminfullname"] = $row["first_name"] . " " . $row["last_name"];
                    $_SESSION["status"] = $row["status"];

                    $admin_id = $_SESSION["admin"];
                    $admin_email = $_SESSION["adminemail"];
                    $admin_fullname = $_SESSION["adminfullname"];
                    $status = $_SESSION["status"];
                    $login_time = date('H:i:s', strtotime('+2 hours')); // Merr kohën aktuale dhe shton 2 orë
                    $login_date = date('Y-m-d');

                    $sql_insert01 = "INSERT INTO time_datelogin (user_id, user_email, status, time, date) VALUES ('$admin_id', '$admin_email', '$status', '$login_time', '$login_date')";
                    mysqli_query($connect, $sql_insert01);

                    header("Location: admin/dashboard.php");
                }
            }
        } else {
            echo "<div class='alert alert-danger'>
                <p>Wrong credentials, please try again ...</p>
            </div>";
        }
    }
}
