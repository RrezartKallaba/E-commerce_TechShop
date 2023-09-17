<?php
session_start();

if (isset($_SESSION['user'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <style>
            header {
                margin-top: -38%;
            }

            header {
                margin-top: 0;
                height: 60px;
                width: 100%;
                position: fixed;
            }

            #img1 {
                height: 50px;
                width: 30px;
                display: flex;
                align-items: flex-start;
                justify-content: flex-start;
                align-self: start;
                margin: 0 0 20px 35px;
            }

            svg {
                color: #4488dd;

            }

            body {
                min-height: 100vh;
                margin: 0%;
            }

            select option {
                color: #4488dd;
            }

            .text-danger {
                font-size: 14px;
                color: red;
            }

            .overflow {
                height: 360px;
                overflow-y: auto !important;
                padding: 10px;
            }
        </style>
        <title>Checkout</title>
    </head>

    <body>
        <header>
            <a href="#" onclick="history.back(); return false;">
                <svg id="img1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
            </a>
        </header>
        <div class='container'>
            <div class='window'>
                <div class='order-info'>
                    <div class='order-info-content'>
                        <h2>Cart!</h2>
                        <div class='line'></div>
                        <div class="overflow">
                            <?php
                            require "../validate/connect.php";
                            $userId = $_SESSION["user"];
                            $sql = "SELECT c.product_id, c.quantity, p.price, p.image, p.name FROM cart c
                        INNER JOIN products p ON c.product_id = p.id
                        WHERE c.user_id = $userId";

                            $result = mysqli_query($connect, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $productTotalPrice = $row["quantity"] * $row["price"];
                            ?>
                                    <table class='order-table'>
                                        <tbody>
                                            <tr>
                                                <td><img src='../pictures/<?php echo $row["image"] ?>' class='full-width'></img>
                                                </td>
                                                <td>
                                                    <br> <span class='thin'><?php echo $row["name"] ?></span>
                                                    <br> <span class='thin'>Quantity: x<?php echo $row["quantity"] ?></span>

                                                </td>

                                            </tr>
                                            <tr>
                                                <?php

                                                $formattedTotalPrice01 = number_format($productTotalPrice, 2);
                                                ?>
                                                <td>
                                                    <div class='price'><?php echo $formattedTotalPrice01 . '€'; ?></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class='line'></div>

                            <?php
                                }
                            } else {
                                echo "<p>You have no products in your cart.</p>";
                            }
                            ?>
                        </div>
                        <div class='total'>
                            <?php
                            require "../validate/connect.php";
                            $userId = $_SESSION["user"];
                            $sql = "SELECT c.quantity, p.price FROM cart c
            INNER JOIN products p ON c.product_id = p.id
            WHERE c.user_id = $userId";

                            $result = mysqli_query($connect, $sql);
                            $subtotalPrice = 0;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $subtotalPrice += $row["quantity"] * $row["price"];
                            }

                            // Llogaritja e taksës dhe shpenzimeve të transportit
                            $taxPercentage = 0.010; // 1% tax
                            $deliveryCost = 2.00; // delivery
                            $taxAmount = $subtotalPrice * $taxPercentage;
                            $totalPrice = $subtotalPrice + $taxAmount + $deliveryCost;

                            // Formatimi i totalit me 2 numra pas pikës decimale
                            $formattedTotalPrice = number_format($totalPrice, 2);
                            $formattedTaxAmount = number_format($taxAmount, 2);

                            ?>
                            <span style='float:left;'>
                                <div class='thin dense'>Tax <?php echo ($taxPercentage * 100) . '%'; ?></div>
                                <div class='thin dense'>Delivery</div>
                                TOTAL
                            </span>
                            <span style='float:right; text-align:right;'>
                                <div class='thin dense'><?php echo $formattedTaxAmount . '€'; ?></div>
                                <div class='thin dense'><?php echo $deliveryCost . '€'; ?></div>
                                <div class="total-price" style="color: black !important;">
                                    <span id="formatted-total-price"><?php echo $formattedTotalPrice . '€'; ?></span>
                                </div>
                            </span>
                        </div>

                    </div>
                </div>
                <?php
                if (isset($_SESSION['order_message'])) {
                    echo "<div id='success-alert' class='order order-success'>
                    <p style='margin: 0px; font-size: 17px'>" . $_SESSION['order_message'] . "</p>
                </div>";
                    unset($_SESSION['order_message']);
                }
                ?>
                <script>
                    setTimeout(function() {
                        var successAlert = document.getElementById('success-alert');
                        if (successAlert) {
                            successAlert.style.display = 'none';
                        }
                    }, 3003333); // 3000 milliseconds = 3 seconds
                </script>
                <div class='form-order-info'>
                    <?php require "../validate/checkoutprocess.php" ?>
                    <form method="post">
                        <div class='form-info-content'>
                            <h2 style="text-align: center;">Please provide your information</h2>
                            <div style="margin-bottom: 20px;" class='line'></div>
                            <table class='half-input-table'>
                                <tr style="height: 83px;">
                                    <td>First Name
                                        <input class='input-field' type="text" name="first_name" id="name" value="<?php if (empty($errorFname)) echo $fname; ?>" autocomplete="off">
                                        <span class="text-danger"><?= $errorFname ?></span>
                                    </td>
                                    <td>Last Name
                                        <input class='input-field' type="text" name="last_name" id="last_name" value="<?php if (empty($errorLname)) echo $lname; ?>" autocomplete="off">
                                        <span class="text-danger"><?= $errorLname ?></span>
                                    </td>
                                </tr>
                            </table>
                            <div style="height: 83px;">
                                Email
                                <input class='input-field' type="email" name="email" id="email" value="<?php if (empty($emailError)) echo $email; ?>" autocomplete="off">
                                <span class="text-danger"><?= $emailError ?></span>
                            </div>
                            <div style="height: 83px;">
                                Phone Number
                                <input class='input-field' type="text" name="phone" id="phone" value="<?php if (empty($phoneError)) echo $phone; ?>" autocomplete="off">
                                <span class="text-danger"><?= $phoneError ?></span>
                            </div>
                            <table class='half-input-table'>
                                <tr style="height: 83px;">
                                    <td> Country
                                        <select class='input-field' name="country" id="country" autocomplete="off">
                                            <option value="null">Select Country</option>
                                            <option value="Kosovo" <?= (isset($country) && $country === "Kosovo") ? 'selected' : '' ?>>Kosovo</option>
                                        </select>
                                        <span class="text-danger"><?= $countryError ?></span>
                                    </td>
                                    <td>Address
                                        <input class='input-field' type="text" name="address" id="address" value="<?php if (empty($addressError)) echo $address; ?>" autocomplete="off">
                                        <span class="text-danger"><?= $addressError ?></span>
                                    </td>
                                </tr>
                            </table>
                            <table class='half-input-table'>
                                <tr style="height: 83px;">
                                    <td>City
                                        <select class="input-field" name="city" id="city" autocomplete="off">
                                            <option value="null">Select City</option>
                                            <option value="Therandë" <?= (isset($city) && $city === "Therandë") ? 'selected' : '' ?>>Therandë</option>
                                            <option value="Prishtinë" <?= (isset($city) && $city === "Prishtinë") ? 'selected' : '' ?>>Prishtinë</option>
                                            <option value="Prizren" <?= (isset($city) && $city === "Prizren") ? 'selected' : '' ?>>Prizren</option>
                                            <option value="Ferizaj" <?= (isset($city) && $city === "Ferizaj") ? 'selected' : '' ?>>Ferizaj</option>
                                            <option value="Pejë" <?= (isset($city) && $city === "Pejë") ? 'selected' : '' ?>>Pejë</option>
                                            <option value="Gjakovë" <?= (isset($city) && $city === "Gjakovë") ? 'selected' : '' ?>>Gjakovë</option>
                                            <option value="Gjilan" <?= (isset($city) && $city === "Gjilan") ? 'selected' : '' ?>>Gjilan</option>
                                            <option value="Mitrovicë" <?= (isset($city) && $city === "Mitrovicë") ? 'selected' : '' ?>>Mitrovicë</option>
                                            <option value="Besiana" <?= (isset($city) && $city === "Besiana") ? 'selected' : '' ?>>Besiana</option>
                                            <option value="Vushtrri" <?= (isset($city) && $city === "Vushtrri") ? 'selected' : '' ?>>Vushtrri</option>
                                            <option value="Rahovec" <?= (isset($city) && $city === "Rahovec") ? 'selected' : '' ?>>Rahovec</option>
                                            <option value="Drenas" <?= (isset($city) && $city === "Drenas") ? 'selected' : '' ?>>Drenas</option>
                                            <option value="Kamenicë" <?= (isset($city) && $city === "Kamenicë") ? 'selected' : '' ?>>Kamenicë</option>
                                            <option value="Malishevë" <?= (isset($city) && $city === "Malishevë") ? 'selected' : '' ?>>Malishevë</option>
                                            <option value="Lipjan" <?= (isset($city) && $city === "Lipjan") ? 'selected' : '' ?>>Lipjan</option>
                                            <option value="Viti" <?= (isset($city) && $city === "Viti") ? 'selected' : '' ?>>Viti</option>
                                            <option value="Deçan" <?= (isset($city) && $city === "Deçan") ? 'selected' : '' ?>>Deçan</option>
                                            <option value="Istog" <?= (isset($city) && $city === "Istog") ? 'selected' : '' ?>>Istog</option>
                                            <option value="Klinë" <?= (isset($city) && $city === "Klinë") ? 'selected' : '' ?>>Klinë</option>
                                            <option value="Skënderaj" <?= (isset($city) && $city === "Skënderaj") ? 'selected' : '' ?>>Skënderaj</option>
                                            <option value="Dragash" <?= (isset($city) && $city === "Dragash") ? 'selected' : '' ?>>Dragash</option>
                                            <option value="Fushë Kosovë" <?= (isset($city) && $city === "Fushë Kosovë") ? 'selected' : '' ?>>Fushë Kosovë</option>
                                            <option value="Kaçanik" <?= (isset($city) && $city === "Kaçanik") ? 'selected' : '' ?>>Kaçanik</option>
                                            <option value="Mitrovicë Veriore" <?= (isset($city) && $city === "Mitrovicë Veriore") ? 'selected' : '' ?>>Mitrovicë Veriore</option>
                                            <option value="Shtime" <?= (isset($city) && $city === "Shtime") ? 'selected' : '' ?>>Shtime</option>
                                            <option value="Obiliç" <?= (isset($city) && $city === "Obiliç") ? 'selected' : '' ?>>Obiliç</option>
                                            <option value="Leposaviç" <?= (isset($city) && $city === "Leposaviç") ? 'selected' : '' ?>>Leposaviç</option>
                                            <option value="Graçanicë" <?= (isset($city) && $city === "Graçanicë") ? 'selected' : '' ?>>Graçanicë</option>
                                            <option value="Elez Han" <?= (isset($city) && $city === "Elez Han") ? 'selected' : '' ?>>Elez Han</option>
                                            <option value="Zveçan" <?= (isset($city) && $city === "Zveçan") ? 'selected' : '' ?>>Zveçan</option>
                                            <option value="Shtërpce" <?= (isset($city) && $city === "Shtërpce") ? 'selected' : '' ?>>Shtërpce</option>
                                            <option value="Artanë" <?= (isset($city) && $city === "Artanë") ? 'selected' : '' ?>>Artanë</option>
                                            <option value="Zubin Potok" <?= (isset($city) && $city === "Zubin Potok") ? 'selected' : '' ?>>Zubin Potok</option>
                                            <option value="Junik" <?= (isset($city) && $city === "Junik") ? 'selected' : '' ?>>Junik</option>
                                            <option value="Mamushë" <?= (isset($city) && $city === "Mamushë") ? 'selected' : '' ?>>Mamushë</option>
                                        </select>
                                        <span class="text-danger"><?= $cityError ?></span>
                                    </td>
                                    <td>Payment
                                        <select class="input-field" name="payment" id="payment" autocomplete="off">
                                            <option value="null">Selcet Payment</option>
                                            <option value="Cash" <?= (isset($payment) && $payment === "Cash") ? 'selected' : '' ?>>Cash</option>
                                            <option value="Card">Card</option>
                                        </select>
                                        <span class="text-danger"><?= $paymentError ?></span>
                                    </td>
                                </tr>
                            </table>
                            <button class='pay-btn' type='submit' name='submit'>Submit Order</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: ../index1.php");
}
?>