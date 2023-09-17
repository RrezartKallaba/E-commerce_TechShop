<?php
if (isset($_SESSION["admin"])) {
    header("Location: admin/dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            min-height: 100vh;
            margin: 0;
        }

        .bg-color-1 {
            background-color: rgb(255 255 255 / 63%);
            /* Use rgba() to set opacity */
            border-radius: 5px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 590px;
            width: 100%;
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

        /* Për telefona (max 600px) */
        @media (max-width: 600px) {
            .container {
                margin-bottom: 30px !important;
            }

            .bg-color-1 {
                width: 90%;
                /* Bëni div të marrë më shumë vend në ekranin e telefones */
            }

            .form-control {
                /* Bëni fushat e input-it të plotësisht të gjera në pajisjet mobile */
                width: 100%;
            }

            .row-2 {
                display: flex;
                flex-direction: column;
                gap: 0px;
            }

            .form-group {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <div class="bg-color-1">
            <h3 class="text-center">Register</h3>
            <?php require "validate/validateRegister.php" ?>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="row-2">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if (empty($errorFname)) echo $fname; ?>">
                        <span class="text-danger"><?= $errorFname ?></span>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if (empty($errorLname)) echo $lname; ?>">
                        <span class="text-danger"><?= $errorLname ?></span>
                    </div>
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php if (empty($emailError)) echo $email; ?>">
                        <span class="text-danger"><?= $emailError ?></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php if (empty($phoneError)) echo $phone; ?>">
                        <span class="text-danger"><?= $phoneError ?></span>
                    </div>
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label for="picture">Picture:</label>
                        <input type="file" class="form-control" id="picture" name="picture">
                        <span class="text-danger"><?= $pictureError ?></span>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php if (empty($addressError)) echo $address; ?>">
                        <span class="text-danger"><?= $addressError ?></span>
                    </div>
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="text-danger"><?= $passwrdErrror . $confirmPwdMismatch ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confpassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confpassword" name="confpassword">
                        <span class="text-danger"><?= $confrmPasswdEmpty  . $confirmPwdMismatch ?></span>
                    </div>
                </div>

                <p style="font-size: 15px;text-align: center !important;padding: 10px 12px 0 14px">Have an account?<a href="login.php">Log in</a></p>
                <div class="btn-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>