<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
    require "file_upload.php";
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
    if (isset($_POST["create"])) {
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
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
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
               <p>New user account has been created, $picture[1]</p>
                </div>";
                echo "<script>window . location . href = 'dashboard.php?page=users'</script>";
                // header("refresh: 2; url=dashboard.php?page=users");
            } else {
                echo   "<div class='alert alert-danger'>
                    <p>Something went wrong, please try again later ...</p>
                </div>";
                echo mysqli_error($connect);
            }
        }
        // Close the database connection
        mysqli_close($connect);
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create a user</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


        <style>
            body {
                background-image: url('../validate/img/bg-1.avif');
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
                <h3 class="text-center">Create a user</h3>
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
                    <div class="btn-center">
                        <button type="submit" class="btn btn-primary" name="create">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
<?php
} else if (isset($_SESSION["user"])) {
    header("location:../index.php");
} else {
    header("Location: ../login.php");
}
