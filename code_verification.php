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
    <title>Code Verification</title>
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

        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }

        form button {
            margin-top: 25px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            border: none;
            padding: 9px 0;
            cursor: pointer;
            border-radius: 6px;
            pointer-events: none;
            background: #6e93f7;
            transition: all 0.2s ease;
        }

        button.active {
            background-color: #169f16 !important;
            pointer-events: auto;
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <div class="bg-color-1">
            <h3 class="text-center">Code Verification</h3>
            <br><?php require "validate/validateCodeVerification.php" ?>
            <div class="row-2">
                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <div class="input-field">
                            <?php
                            require "validate/connect.php";
                            $user_reset_email = $_SESSION["user_reset_email"];
                            $sql_attempts = "SELECT u.id,u.email,c.id,c.user_id,attempts FROM users u, code_forgot_password c WHERE u.id = c.user_id AND u.email = '$user_reset_email'";
                            $result_attempts = mysqli_query($connect, $sql_attempts);
                            $row_attempts = mysqli_fetch_assoc($result_attempts);

                            if (!is_null($row_attempts)) {
                                // Ekziston një rekord në bazën e të dhënave
                                $attempts = $row_attempts['attempts'];

                                if ($attempts > 0) {
                                    // Ky rast është kur attempts është më shumë se zero
                                    echo '<label for="code_verification">Write the code</label>';
                                    echo '<br>';
                                    echo '<input type="text" name="code_1">';
                                    echo '<input type="text" name="code_2" disabled>';
                                    echo '<input type="text" name="code_3" disabled>';
                                    echo '<input type="text" name="code_4" disabled>';
                                    echo '<input type="text" name="code_5" disabled>';
                                    echo '<input type="text" name="code_6" disabled>';
                                    echo '<br>';
                                    echo '<span>Attempts:' . $attempts . '</span>';
                                    echo '<br>';
                                    echo '<span class="text-danger">' . $errorCode . '</span>';
                                } else {
                                    // Ky rast është kur attempts është zero
                                    echo "<div class='alert alert-danger'>
                                            <p style='text-align:center;'>You have exceeded the number of attempts allowed. You can try again in 15 minutes.</p>
                                          </div>";
                                }
                            } else {
                                if (isset($_SESSION['expired_code'])) {
                                    echo "<div class='alert alert-danger'>
                                        <p style='text-align:center;'>" . $_SESSION['expired_code'] . "</p>
                                      </div>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <p style="font-size: 15px;text-align: center !important;padding: 10px 12px 0 14px">Go back to <a href="login.php">Login</a>
                    </p>
                    <div class="btn-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const inputs = document.querySelectorAll("input"),
            button = document.querySelector("button");

        // iterate over all inputs
        inputs.forEach((input, index1) => {
            input.addEventListener("keyup", (e) => {
                // This code gets the current input element and stores it in the currentInput variable
                // This code gets the next sibling element of the current input element and stores it in the nextInput variable
                // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
                const currentInput = input,
                    nextInput = input.nextElementSibling,
                    prevInput = input.previousElementSibling;

                // if the value has more than one character then clear it
                if (currentInput.value.length > 1) {
                    currentInput.value = "";
                    return;
                }
                // if the next input is disabled and the current value is not empty
                //  enable the next input and focus on it
                if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                // if the backspace key is pressed
                if (e.key === "Backspace") {
                    // iterate over all inputs again
                    inputs.forEach((input, index2) => {
                        // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                        // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                        if (index1 <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }
                // if the current input has the name "code_1" and the Backspace key is pressed
                if (e.key === "Backspace" && currentInput.name === "code_1") {
                    // Clear the current input
                    currentInput.value = "";
                    currentInput.removeAttribute("disabled");
                }

                //if the fourth input( which index number is 3) is not empty and has not disable attribute then
                //add active class if not then remove the active class.
                if (!inputs[5].disabled && inputs[5].value !== "") {
                    button.classList.add("active");
                    return;
                }
                button.classList.remove("active");
            });
        });

        //focus the first input which index is 0 on window load
        window.addEventListener("load", () => inputs[0].focus());
    </script>
</body>

</html>