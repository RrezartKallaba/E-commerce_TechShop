<?php
session_start();
require "connect.php";

if (!isset($_SESSION["user_reset_email"])) {
    header("Location: forgot_password.php");
}

$code_1 = $code_2 = $code_3 = $code_4 = $code_5 = $code_6 = $errorCode = "";
$error = false;

function cleanInputs($input)
{
    $data = trim($input); // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data); // removing tags from the string
    $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt";

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["code_1"]) && isset($_POST["code_2"]) && isset($_POST["code_3"]) && isset($_POST["code_4"]) && isset($_POST["code_5"]) && isset($_POST["code_6"])) {
        $code_1 = cleanInputs($_POST["code_1"]);
        $code_2 = cleanInputs($_POST["code_2"]);
        $code_3 = cleanInputs($_POST["code_3"]);
        $code_4 = cleanInputs($_POST["code_4"]);
        $code_5 = cleanInputs($_POST["code_5"]);
        $code_6 = cleanInputs($_POST["code_6"]);

        if (empty($code_1) && empty($code_2) && empty($code_3) && empty($code_4) && empty($code_5) && empty($code_6)) {
            $error = true;
            $errorCode = "Code Verification must have 6 values!";
        }
        $secret_code_verification = $code_1 . $code_2 . $code_3 . $code_4 . $code_5 . $code_6;
        if (!$error) {
            $user_reset_email = $_SESSION["user_reset_email"];
            $sql_attempts = "SELECT u.id,u.email,c.id,c.user_id,c.attempts FROM users u, code_forgot_password c WHERE u.id = c.user_id AND u.email = '$user_reset_email'";
            $result_attempts = mysqli_query($connect, $sql_attempts);
            if (mysqli_num_rows($result_attempts) > 0) {
                $row_attempts = mysqli_fetch_assoc($result_attempts);
                $attempts = $row_attempts["attempts"];
            } else {
                $attempts = 0;
            }
            $user_reset_email = $_SESSION["user_reset_email"];
            $sql = "SELECT u.id, u.email, c.id, c.user_id, c.random_code, c.attempts FROM users u, code_forgot_password c WHERE u.id = c.user_id AND u.email = '$user_reset_email'";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $random_code = $row["random_code"];
                if ($secret_code_verification === $random_code) {
                    $_SESSION["code_verified"] = true;
                    $updateAttemptsQuery = "UPDATE code_forgot_password SET attempts = 0 WHERE email = '$user_reset_email'";
                    mysqli_query($connect, $updateAttemptsQuery);
                    header("Location: reset_form.php");
                } else {
                    $error = true;
                    $errorCode = "Incorrect code!";
                    $attempts--;
                    if ($attempts >= 0) {
                        $updateAttemptsQuery = "UPDATE code_forgot_password SET attempts = $attempts WHERE email = '$user_reset_email'";
                        mysqli_query($connect, $updateAttemptsQuery);
                    }
                }
            } else {
                $_SESSION["expired_code"] = "Your code has expired, please try again!";
            }
        }
    }
    mysqli_close($connect);
}
