<?php
session_start();
if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
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
    $fname = cleanInputs($_POST["first_name"]);
    $lname = cleanInputs($_POST["last_name"]);
    $email = cleanInputs($_POST["email"]);
    $phone = cleanInputs($_POST["phone"]);
    $address = cleanInputs($_POST["address"]);
    $picture = fileUpload($_FILES["picture"]);
    $password = $_POST["password"];
    $confpassword = $_POST["confpassword"];


    if (empty($fname)) {
        $error = true;
        $errorFname = "First Name field cannot be empty.";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $errorFname = "Name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $errorFname = "Name must contain only letters and spaces.";
    }

    if (empty($lname)) {
        $error = true;
        $errorLname = "Last name field cannot be empty.";
    } else if (strlen($lname) < 3) {
        $error = true;
        $errorLname = "Name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $errorLname = "Name must contain only letters and spaces.";
    }

    if (empty($email)) {
        $error = true;
        $emailError = "Email field cannot be empty.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        // if email is already exists in the database, error will be true
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Provided Email is already in use";
        }
    }
    if (empty($phone)) {
        $error = true;
        $phoneError = "Phone Number cannot be empty.";
    } else if (!is_numeric($phone)) {
        $error = true;
        $phoneError = "Please provide numeric value for phone";
    }

    if (empty($_FILES['picture']['name'])) {
        $error = true;
        $pictureError = "Picture field cannot be empty";
    }
    if (empty($address)) {
        $error = true;
        $addressError = "Address field can't be left blank!";
    }
    if (empty($password)) {
        $error = true;
        $passwrdErrror = "Password field cannot be empty!";
    } elseif (strlen($password) < 8) {
        $error = true;
        $passwrdErrror = "Password must have at least 8 ch..";
    }

    if (empty($confpassword)) {
        $error = true;
        $confrmPasswdEmpty = "Confirm pw cannot be empty!";
    } elseif (strlen($confpassword) < 8) {
        $error = true;
        $confrmPasswdEmpty = "Password must have at least 8 ch..";
    } else if ($password != $confpassword) {
        $error = true;
        $confirmPwdMismatch = "Passwords do not match!";
    }
    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "INSERT INTO users (first_name,last_name,email,phone,address,image,password) values ('$fname', '$lname', '$email','$phone',  '$address' , '{$picture[0]}','$password')";


        if (mysqli_query($connect, $sql)) {
            echo   "<div class='alert alert-success'>
               <p>Account has been created, $picture[1]</p>
                </div>";
        } else {
            echo   "<div class='alert alert-danger'>
                    <p>Something went wrong, please try again later ...</p>
                </div>";
            echo mysqli_error($connect);
        }
    }
}
