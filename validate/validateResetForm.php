<?php
session_start();
if (!isset($_SESSION["user_reset_email"])) {
    header("Location: forgot_password.php");
}
if (!isset($_SESSION["code_verified"])) {
    header("Location: code_verification.php");
}
require "connect.php";
require "file_uploadRegister.php";
$error = false;  // by default, a varialbe $error is false, means there is no error in our form
$fname = $lname = $email = $phone = $address = $picture = $password = $confpassword = "";
$errorFname = $errorLname = $emailError = $phoneError = $addressError = $pictureError = $passwrdErrror = $pwdLength = $confirmPwdMismatch = $confrmPasswdEmpty = "";

function cleanInputs($input)
{
    $data = trim($input); // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data); // removing tags from the string
    $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt"; 

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = cleanInputs($_POST["password"]);
    $confpassword = cleanInputs($_POST["confpassword"]);

    if (empty($password)) {
        $error = true;
        $passwrdErrror = "Password field cannot be empty!";
    } elseif (strlen($password) < 8) {
        $error = true;
        $passwrdErrror = "Password must have at least 8 ch..";
    }

    if (empty($confpassword)) {
        $error = true;
        $confrmPasswdEmpty = "Confirm password cannot be empty!";
    } elseif (strlen($confpassword) < 8) {
        $error = true;
        $confrmPasswdEmpty = "Password must have at least 8 ch..";
    } else if ($password != $confpassword) {
        $error = true;
        $confirmPwdMismatch = "Passwords do not match!";
    }
    if (!$error) {
        $password = hash("sha256", $password);
        $user_reset_email = $_SESSION["user_reset_email"];
        $sql = "UPDATE users SET password = '$password' WHERE email = '$user_reset_email';";


        if (mysqli_query($connect, $sql)) {
            $user_reset_email = $_SESSION["user_reset_email"];
            echo   "<div class='alert alert-success'>
               <p>You have successfully updated your password for email: $user_reset_email!</p>
                </div>";
            header("refresh: 3; url=login.php");
        } else {
            echo   "<div class='alert alert-danger'>
                    <p>Something went wrong, please try again later ...</p>
                </div>";
            echo mysqli_error($connect);
        }
    }
}
