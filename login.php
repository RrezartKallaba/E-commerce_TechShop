<?php
if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
// * SHfaqja e gabimeve
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        body {
            background-image: url('validate/img/bg-1.avif');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .bg-color-1 {
            background-color: rgba(249, 249, 249, 0.6);
            /* Use rgba() to set opacity */
            border-radius: 5px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 40%;
        }

        .row-2 {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .form-control {
            height: 40px;
            width: 250px;
            font-size: 16px;
            gap: 30px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-danger {
            font-size: 14px;
            color: red;
        }

        .btn-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn {
            width: 150px;
            height: 40px;
        }

        @media (max-width:600px) {
            .bg-color-1 {
                width: 100% !important;
            }
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <div class="bg-color-1">
            <h3 class="text-center">Login</h3>
            <br><?php require "validate/validateLogin.php" ?>
            <div class="row-2">
                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php if (empty($emailError)) echo $email; ?>">
                        <span class="text-danger"><?= $emailError ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="myInput" name="password">
                        <span class="text-danger"><?= $passError ?></span>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" onclick="myFunction()"> Show password</label>
                        <script>
                            function myFunction() {
                                var x = document.getElementById("myInput");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                            }
                        </script>
                    </div>
                    <p style="font-size: 15px;text-align: center !important;padding: 10px 12px 0 14px">Don't have an account?<a href="register.php"> Sign up</a>
                        <br>
                        <a href="forgot_password.php">Forgot Password</a>
                    </p>
                    <div class="btn-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>