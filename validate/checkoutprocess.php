<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
}
require "connect.php";
$error = false;  // by default, a varialbe $error is false, means there is no error in our form
$fname = $lname = $email = $phone = $country = $address = $city = $payment = "";
$errorFname = $errorLname = $emailError = $phoneError = $addressError = $countryError = $cityError = $paymentError = "";
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
    $country = cleanInputs($_POST["country"]);
    $address = cleanInputs($_POST["address"]);
    $city = cleanInputs($_POST["city"]);
    $payment = cleanInputs($_POST["payment"]);


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
    if ($country == "null") {
        $error  = true;
        $countryError = "Please select your contry.";
    }
    if (empty($address)) {
        $error = true;
        $addressError = "Address field can't be left blank!";
    }
    if ($city == "null") {
        $error  = true;
        $cityError = "Please select your city.";
    }
    if ($payment != "Cash" && $payment != "Card") {
        $error = true;
        $paymentError = "Please select the payment method.";
    }
    if ($payment == "Card") {
        $error = true;
        $paymentError = "Card payment is not available";
    }

    if (!$error) {
        // Procesimi i porosisë në databazë
        $userId = $_SESSION["user"];
        $cartProductsQuery = "SELECT product_id, quantity FROM cart WHERE user_id = '$userId'";
        $cartProductsResult = mysqli_query($connect, $cartProductsQuery);

        $productIds = array();
        $quantities = array();

        while ($cartProduct = mysqli_fetch_assoc($cartProductsResult)) {
            $productIds[] = $cartProduct["product_id"];
            $quantities[] = $cartProduct["quantity"];
        }

        $productIdsString = implode(",", $productIds);
        $quantitiesString = implode(",", $quantities);

        $insertQuery = "INSERT INTO orders (user_id, product_id, quantity, first_name, last_name, email, phone, address, country, city, payment, totalprice) 
                    VALUES ('$userId', '$productIdsString', '$quantitiesString', '$fname', '$lname', '$email', '$phone', '$address', '$country', '$city', '$payment','$totalPrice')";
        $deleteQuery = "DELETE FROM cart WHERE user_id = '$userId'";

        if (mysqli_multi_query($connect, $insertQuery . ";" . $deleteQuery)) {
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
                $mail->addAddress($email, $fname . ' ' . $lname); // Adresa dhe emri i përdoruesit
                $mail->Subject = 'Your Order Details';

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
            
            .total-price {
                font-size: 18px;
                font-weight: bold;
                margin-top: 10px;
                color: #0f9d58;
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
            <h2 class='thank-you'>Thank you for your order!</h2>
            <p><i>Here are your order details:</i></p>
            <p><b>First Name:</b> $fname</p>
            <p><b>Last Name:</b> $lname</p>
            <p><b>Email:</b> $email</p>
            <p><b>Phone:</b> $phone</p>
            <p><b>Address:</b> $address</p>
            <div class='order-details'>
                <p><b>Order Items:</b></p>";

                foreach ($productIds as $index => $productId) {
                    $productID = $productIds[$index]; // Për ta marrë emrin e produktit bazuar në ID-në e produktit
                    $quantity = $quantities[$index];

                    $emailContent .= "
                <div class='order-item'>
                    <span><b>Product with ID:</b> $productId</span>
                    <span><b>, Quantity:</b> $quantity</span>
                </div>";
                }
                $emailContent .= "
                <p class='total-price'><b>Total Price:</b> $totalPrice €</p>
            </div>
            <div class='email-footer'>
                <p><b>This email was sent by TechShop</b></p>
            </div>
        </div>
    </body>
    </html>";

                $mail->isHTML(true); // Përcaktojme se emaili është HTML
                $mail->Subject = 'Your Order Details';
                $mail->Body = $emailContent;

                $mail->send();

                $_SESSION['order_message'] = "✅The order has been completed successfully and an email has been sent to you!";
                echo "<script>window.location.href = '../products.php'</script>";
            } catch (Exception $e) {
                $_SESSION['order_message'] = "✅The order has been completed successfully, but there was an issue sending the email.";
                echo 'Email could not be sent. Error: ', $e->getMessage();
                echo "<script>window.location.href = '../products.php'</script>";
            }
        } else {
            echo "<div class='alert alert-danger'>
            <p>Something went wrong, please try again later ...</p>
            </div>";
            echo mysqli_error($connect);
        }
    }
}
