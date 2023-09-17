<?php
session_start();
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
</head>

<body>
    <?php include "includes/nav.php" ?>
    <?php include "validate/alerts.php" ?>
    <section id="services" class="services">
        <h1>Services</h1>
        <div class="service-container">
            <div class="service-box">
                <div class="service-detail">
                    <div class="service-icon">
                        <i class="fa fa-shipping-fast"></i>
                    </div>
                    <h4>Fast deliveries</h4>
                    <p>We also offer free shipping on products purchased in our country, so you don't have to pay
                        extra for shipping.</p>

                </div>
            </div>
            <div class="service-box">
                <div class="service-detail">
                    <div class="service-icon">
                        <i class="fa-regular fa-credit-card"></i>
                    </div>
                    <h4>Secure payments</h4>
                    <p>With us, you can be sure that your payments will be made safely and reliably.</p>
                </div>
            </div>
            <div class="service-box">
                <div class="service-detail">
                    <div class="service-icon">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h4>Warranty and product return</h4>
                    <p>If you are not satisfied with your product, we offer a product return policy within a period
                        certain time, giving you the opportunity to return the product and receive a refund of the payment
                        purchase or another product instead.
                    </p>
                </div>
            </div>
        </div>
        <h3>If you have any questions or concerns about our service, please contact us and we will be
            pleased to help you.</h3>
    </section>

    <footer>©2023 Tech Shop</footer>
    <script src="main.js"></script>
</body>

</html>