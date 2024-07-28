<?php
session_start();
require "validate/connect.php";
$error = false;  // by default, a varialbe $error is false, means there is no error in our form
$fname = $lname = $email = $phone = $country = $message = "";
$errorFname = $errorLname = $emailError = $phoneError = $messageError = "";
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
    $message = cleanInputs($_POST["message"]);


    if (empty($fname)) {
        $error = true;
        $errorFname = "First Name cannot be empty.";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $errorFname = "At least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $errorFname = "Numeric values are not accepted";
    }

    if (empty($lname)) {
        $error = true;
        $errorLname = "Last Name cannot be empty.";
    } else if (strlen($lname) < 3) {
        $error = true;
        $errorLname = "At least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $errorLname = "Numeric values are not accepted";
    }

    if (empty($email)) {
        $error = true;
        $emailError = "Email field cannot be empty.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address";
    }
    if (empty($phone)) {
        $error = true;
        $phoneError = "Phone Number cannot be empty.";
    } else if (!is_numeric($phone)) {
        $error = true;
        $phoneError = "Please provide numeric value for phone";
    }

    if (empty($message)) {
        $error = true;
        $messageError = "Address field can't be left blank!";
    }

    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "INSERT INTO contactform (first_name,last_name,email,phone,message) values ('$fname', '$lname', '$email','$phone',  '$message')";


        if (mysqli_query($connect, $sql)) {
            $_SESSION["contact_form"] = "✅Contact form submitted successfully!";
            header("Location: index.php");
        } else {
            echo   "<div class='alert alert-danger'>
                    <p>Something went wrong, please try again later ...</p>
                </div>";
            echo mysqli_error($connect);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>TechShop</title>
    <style>
        .contact {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 10px;
            min-height: 100vh;
        }

        .order.order-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .order {
            border: 1px solid #c3e6cb;
            border-radius: 7px;
            top: 120px;
            position: absolute;
            padding: 10px;
            margin-bottom: 10px;
            z-index: 99;
            width: 400px;
            text-align: center;
            left: 50%;
            transform: translateX(-50%);
        }

        .order.order-success p {
            margin-bottom: 0;
        }

        .order.order-success a {
            color: #0b2e13;
            text-decoration: underline;
        }

        .text-danger {
            font-size: 14px;
            color: red;
        }

        .row {
            display: flex;
            flex-direction: row;
        }

        .col {
            display: flex;
            flex-direction: column;
        }

        .contact .row {
            gap: 10px !important;
        }
    </style>
</head>

<body>
    <?php include "includes/nav.php" ?>
    <span id="contact2"></span>
    <?php include "validate/alerts.php" ?>
    <section id="contact" class="contact">
        <div class="row">
            <div class="img-bg">
                <img src="img/customersuport.avif" alt="" srcset="">
            </div>
            <div class="contact-form">
                <form method="post">
                    <div class="row">
                        <div class="col">
                            <input type="text" name="first_name" placeholder="First Name" value="<?php echo empty($errorFname) ? $fname : ''; ?>">
                            <span class="text-danger"><?= $errorFname ?></span>
                        </div>
                        <div class="col">
                            <input type="text" name="last_name" placeholder="Last Name" value="<?php echo empty($errorLname) ? $lname : ''; ?>">
                            <span class="text-danger"><?= $errorLname ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="email" name="email" placeholder="Email" value="<?php echo empty($errorEmail) ? $email : ''; ?>">
                            <span class="text-danger"><?= $emailError ?></span>
                        </div>
                        <div class="col">
                            <input type="text" name="phone" placeholder="049-111-111" value="<?php echo empty($phoneError) ? $phone : ''; ?>">
                            <span class="text-danger"><?= $phoneError ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <textarea name="message" placeholder="Message..." cols="30" rows="10"><?php echo empty($messageError) ? $message : ''; ?></textarea>
                            <span class="text-danger"><?= $messageError ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer>©2023 Tech Shop</footer>
    <script>
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        }, false);

        document.addEventListener("keydown", function(e) {
            if (e.key == "F12") {
                e.preventDefault();
            }
        });
    </script>
    <script src="main.js"></script>
</body>


</html>