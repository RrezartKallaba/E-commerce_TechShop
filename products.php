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
    <style>
        .alert.alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert {
            border: 1px solid #c3e6cb;
            border-radius: 7px;
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 10px;
            margin-bottom: 10px;
            width: 25%;
        }

        .alert.alert-success p {
            margin-bottom: 0;
        }

        .alert.alert-success a {
            color: #0b2e13;
            text-decoration: underline;
        }

        .danger {
            border: 1px solid #c3e6cb;
            border-radius: 7px;
            position: absolute;
            padding: 10px;
            margin-bottom: 10px;
            width: 22%;
        }

        .danger.alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .danger.alert-danger p {
            margin-bottom: 0;
        }

        .danger.alert-danger a {
            color: #491217;
            text-decoration: underline;
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
    </style>
</head>

<body>
    <?php include "includes/nav.php" ?>
    <?php include "validate/alerts.php" ?>
    <span id="products2"></span>
    <br><br>
    <section id="products" class="products">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<div id='success-alert' class='alert alert-success'>
    <p style='margin: 0px; font-size:17px'>" . $_SESSION['success_message'] . "</p>
    </div>";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['add_cart_message'])) {
            echo "<div id='success-alert' class='alert alert-success'>
    <p style='margin: 0px; font-size:17px'>" . $_SESSION['add_cart_message'] . "</p>
    </div>";
            unset($_SESSION['add_cart_message']);
        }
        if (isset($_SESSION['update_cart_message'])) {
            echo "<div id='success-alert' class='alert alert-success'>
                    <p style='margin: 0px; font-size: 17px'>" . $_SESSION['update_cart_message'] . "</p>
                </div>";
            unset($_SESSION['update_cart_message']);
        }
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
            }, 3000); // 3000 milliseconds = 3 seconds
        </script>

        <h1>Products</h1>

        <div class="products-container">
            <!-- Faqja e pare e produkteteve -->
            <?php
            require "validate/connect.php";
            $sql = "SELECT * FROM products WHERE is_hidden = 'No'";

            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="products-box" data-grupi="grupi-1">
                        <div class="products-details">
                            <?php
                            if (isset($_SESSION['error_product_id']) && $_SESSION['error_product_id'] == $row['id']) {
                                echo "<div id='alert-danger' class='danger alert-danger'>
                                        <p style='margin: 0px; font-size:17px'>" . $_SESSION['error_message'] . "</p>
                                        </div>";
                                unset($_SESSION['error_product_id']);
                                unset($_SESSION['error_message']);
                            }
                            ?>
                            <script>
                                setTimeout(function() {
                                    var alertdanger = document.getElementById('alert-danger');
                                    if (alertdanger) {
                                        alertdanger.style.display = 'none';
                                    }
                                }, 3000); // 3000 milliseconds = 3 seconds
                            </script>
                            <div class="products-photo">
                                <img id="img2" class="product-img" src="pictures/<?php echo $row["image"]; ?>" alt="" srcset="">
                            </div>
                            <h4 style="height: 70px!important;" class="product-title"> <?php echo $row["name"]; ?></h4>
                            <span style="color: red;" class="price"> <?php echo $row["price"] . '€'; ?></span>
                            <span id="kodi-produktit">Product id: <?php echo $row["id"]; ?></span>
                            <hr>
                            <form action="validate/add-cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $row["id"]; ?>" autocomplete="off">
                                <input type="hidden" name="image" value="<?php echo $row["image"]; ?>" autocomplete="off">
                                <textarea style="display:none;" name="name" autocomplete="off"><?php echo $row["name"]; ?></textarea>
                                <input type="hidden" name="price" value="<?php echo $row["price"]; ?>" autocomplete="off">
                                <?php if (isset($_SESSION["user"])) {
                                ?>
                                    <a style="text-decoration: none;" href='products.php?id=<?php echo $row["id"]; ?>'><button class="button-blej add-cart" name="add_to_cart" type="submit">Add to cart</button></a>
                                <?php
                                } else { ?>
                                    <a style="text-decoration: none;"><button onclick="UserNotLoggedIn()" class="button-blej add-cart" name="add_to_cart" type="button">Add to cart</button></a>
                                <?php } ?>
                            </form>
                            <div class="buttons">
                                <a style="text-decoration: none;" href='details.php?id=<?php echo $row["id"]; ?>'><button class="details-button">Details</button></a>
                                <?php if (isset($_SESSION["user"])) {
                                ?>
                                    <form action="validate/favorite.php" method="post">
                                        <input type="hidden" name="product_id_favorite" value="<?php echo $row["id"]; ?>">
                                        <a style="text-decoration: none;" href='products.php?id=<?php echo $row["id"]; ?>'>
                                            <button name="favorite" class="fav" id="favorite"><i class="fa fa-heart" aria-hidden="true"></i></button>
                                        </a>
                                    </form>
                                <?php
                                } else { ?>
                                    <a style="text-decoration: none;">
                                        <button style="background-color: white !important;" onclick="UserNotLoggedIn()" name="favorite" class="fav" id="favorite"><i style="color: #f04a23 !important;" class="fa fa-heart" aria-hidden="true"></i></button>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No results found</p>";
            }
            mysqli_close($connect);
            ?>
        </div>
        <!-- Mbarimi i faqes se pare te produkteteve -->
        <div class="numbers">
            <a href="">&laquo;</a>
            <a class="active" id="numri-1" href="#tit">1</a>
            <!-- <a id="numri-2" href="#tit">2</a> -->
            <a href="">&raquo;</a>
        </div>
    </section>
    <footer>©2023 Tech Shop</footer>
    <script src="main.js"></script>
</body>

</html>