<?php
if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseting Password</title>
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
            margin-top: 30px;
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
            <h3 class="text-center">Reseting Password</h3>
            <br><?php require "validate/validateResetForm.php" ?>
            <div class="row-2">
                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="myInput1" name="password">
                        <span class="text-danger"><?= $passwrdErrror . $confirmPwdMismatch ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confpassword">Confirm Password</label>
                        <input type="password" class="form-control" id="myInput2" name="confpassword">
                        <span class="text-danger"><?= $confrmPasswdEmpty  . $confirmPwdMismatch ?></span>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" onclick="myFunction()"> Show password</label>
                        <script>
                            function myFunction() {
                                var x = document.getElementById("myInput1");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                                var x = document.getElementById("myInput2");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                            }
                        </script>
                    </div>
                    <div class="btn-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
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
</body>

</html>