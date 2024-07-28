<?php
session_start();
require 'vendor/autoload.php';
require "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: index.php");
}

$email = $passError = $emailError = "";
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
    $_SESSION["user_reset_email"] = $email;
    if (empty($email)) {
        $error = true;
        $emailError = "Email field cannot be empty.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query_email = "SELECT email FROM users WHERE email='$email'";
        $result_email = mysqli_query($connect, $query_email);
        if (mysqli_num_rows($result_email) != 1) {
            $error = true;
            $emailError = "The given email address does <br> not exist on our website";
        }
    }

    // Kontrollojme nese ka nje rresht ekzistues me email te njejte ne tabelen `code_forgot_password`
    $attempts_check = "SELECT id FROM code_forgot_password WHERE user_id IN (SELECT id FROM users WHERE email = '$email')";
    $attempts_result = mysqli_query($connect, $attempts_check);

    if (mysqli_num_rows($attempts_result) > 0) {
        $error = true;
        $emailError = "";
        echo "<div class='alert alert-danger'>
            <p style='text-align: center;'>You have an activated code in your email. Please check email for further details.</p>
            </div>";
        header("refresh: 5,url=code_verification.php");
    }
    if (!$error) {
        // Kontrollojme nese ka nje rresht ekzistues me email te njejte ne tabelen `code_forgot_password`
        $existingRowQuery = "SELECT id FROM code_forgot_password WHERE user_id IN (SELECT id FROM users WHERE email = '$email')";
        $existingRowResult = mysqli_query($connect, $existingRowQuery);

        if (mysqli_num_rows($existingRowResult) > 0) {
            // Fshij rreshtin ekzistues me email të njëjtë
            $deleteQuery = "DELETE FROM code_forgot_password WHERE user_id IN (SELECT id FROM users WHERE email = '$email')";
            mysqli_query($connect, $deleteQuery);
        }

        // Procesimi i porosisë në databaze
        // Pergatitni nje grup karakteresh per te perdorur ne gjenerimin e kodit
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@/!#$%';

        // Percaktoni gjatesine e kodit (9 karaktere)
        $code_length = 6;

        // Gjeneroni nje kod të rastësishëm me 9 karaktere
        $random_code = '';
        for ($i = 0; $i < $code_length; $i++) {
            $random_code .= $characters[rand(0, strlen($characters) - 1)];
        }
        $select_query = "SELECT id,first_name FROM users WHERE email = '$email'";
        $result_id = mysqli_query($connect, $select_query);
        $row_id = mysqli_fetch_assoc($result_id);
        $userId = $row_id["id"];
        $first_name_user = $row_id["first_name"];

        $insertQuery = "INSERT INTO code_forgot_password (user_id,email, random_code) 
                    VALUES ('$userId', '$email', '$random_code')";
        if (mysqli_query($connect, $insertQuery)) {
            $_SESSION["user_reset_email"] = $email;
            // Dërgimi i emailit te përdoruesi
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'usertesttemail@gmail.com';
                $mail->Password = 'ozgrevgoayadyrgt';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('usertesttemail@gmail.com', 'TechShop');
                $mail->addAddress($email); // Adresa dhe emri i përdoruesit
                $mail->Subject = 'Your Secret Code To Reset Password';

                // Krijimi i përmbajtjes së emailit
                $emailContent = "
    <html>
    <head>
        <style>
            /* Stilizime CSS për email */
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
            }
            .email-content {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                padding: 20px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: 0 auto;
            }
    
            .thank-you {
                color: #4285f4;
                font-size: 24px;
                text-align: center;
            }
    
            b {
                font-weight: bold;
            }
            .order-details {
                margin-top: 20px;
                border-top: 1px solid #ddd;
            }
            .order-item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }
            
            .request-code {
                font-size: 18px;
                font-weight: bold;
                margin-top: 10px;
                color: black;
                text-align: center;
                border-top: 1px solid #ddd;
                padding-top: 15px;
            }
            
            .email-footer {
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #ddd;
                text-align: center;
                font-size: 12px;
                color: #999;
            }
        
            .signature {
                margin-top: 20px;
                text-align: center;
            }
            .signature img {
                max-width: 150px;
            }
        </style>
    </head>
    <body>
        <div class='email-content'>
            <h2 class='thank-you'>Update your password</h2>
            <p><b>Hi </b> $first_name_user</p>
            <p>We received a request that you would like to update your password. If you have not made this request, you do not need to do anything.</p>
            <p>This code expires in 15 minutes.</p>
            <p class='request-code'><b>Code:</b> $random_code</p>
            <div class='email-footer'>
                <p><b>This email was sent by TechShop</b></p>
            </div>
        </div>
    </body>
    </html>";

                $mail->isHTML(true); // Përcaktojme se emaili është HTML
                $mail->Subject = 'Your Secret Code To Reset Password';
                $mail->Body = $emailContent;

                $mail->send();

                $_SESSION['order_message'] = "✅The order has been completed successfully and an email has been sent to you!";
                echo "<script>window.location.href = 'code_verification.php'</script>";
            } catch (Exception $e) {
                $_SESSION['order_message'] = "✅The order has been completed successfully, but there was an issue sending the email.";
                echo 'Email could not be sent. Error: ', $e->getMessage();
                echo "<script>window.location.href = 'code_verification.php'</script>";
            }
        } else {
            echo "<div class='alert alert-danger'>
            <p>Something went wrong, please try again later ...</p>
            </div>";
            echo mysqli_error($connect);
        }
    }
}
