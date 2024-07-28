<header>
    <img id="img1" src="img/Online Shopping Logo.png" alt="" srcset="">
    <nav id="myLinks" class="menu">

        <?php if (isset($_SESSION["user"])) {
            require "validate/connect.php";
            $userId = $_SESSION["user"];
            $sql_user_image = "SELECT image FROM users WHERE id=$userId";
            $result_user_image = mysqli_query($connect, $sql_user_image);  //run the query and store results in result variable
            $row_user_image = mysqli_fetch_assoc($result_user_image);
        ?>
            <div class="user-details">
                <img class="hidd-unhidden" style="display: none;width: 40px;height:40px;border-radius: 50%" src="pictures/<?php echo $row_user_image["image"] ?>">
                <p style="display: none; color: white;" class="text-font hidd-unhidden"><?php if (isset($_SESSION['useremail'])) {
                                                                                            $perdoruesi_name = $_SESSION['useremail'];
                                                                                            echo "User: " . $perdoruesi_name;
                                                                                        } ?></p>
            </div>
        <?php } ?>
        <a href="index.php" onclick="closeMenu()">Home</a>
        <a href="products.php" onclick="closeMenu()">Products</a>
        <a href="services.php" onclick="closeMenu()">Services</a>
        <a href="contact.php" onclick="closeMenu()">Contact</a>
        <div class="right">
            <div class="nav container">
                <?php
                if (!isset($_SESSION['user'])) {
                ?>
                    <button onclick="UserNotLoggedIn()" class="action-btn klik-test">
                        <i id="cart-icon" class='bx bx-shopping-bag'></i>
                    </button>

                <?php
                } else {
                ?>
                    <button class="action-btn klik-test">
                        <i id="cart-icon" class='bx bx-shopping-bag'></i>
                        <span class="count"></span>
                        <script>
                            function updateCartCount() {
                                var xhr = new XMLHttpRequest();

                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        var countSpan = document.querySelector('.count');
                                        countSpan.textContent = xhr.responseText;
                                    }
                                };

                                xhr.open('GET', 'validate/get_cart_count.php', true);
                                xhr.send();
                            }
                            // Perditeso numrin e produkteve ne shporten e blerjeve në fillim
                            updateCartCount();
                            // Perditeso numrin e produkteve qdo 3 sekonda (3000ms)
                            setInterval(updateCartCount, 3000);
                        </script>
                    </button>
                    <!-- CART -->
                    <div class="cart">
                        <h2 class="cart-title" style="color: black !important;">Your Cart</h2>
                        <hr>
                        <div class="cart-content" style="color: black !important; height: 320px;overflow-y: auto !important;overflow-x: hidden !important;">
                            <?php
                            require "validate/connect.php";
                            $userId = $_SESSION["user"];
                            $sql = "SELECT * FROM cart WHERE user_id = $userId";

                            $result = mysqli_query($connect, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $productId = $row["product_id"];
                                    $sqlQuantity = "SELECT quantity FROM products WHERE id = $productId";
                                    $resultQuantity = mysqli_query($connect, $sqlQuantity);
                                    $rowQuantity = mysqli_fetch_assoc($resultQuantity);
                                    $availableQuantity = $rowQuantity["quantity"];
                                    include "cart_item.php";
                                }
                            } else {
                                echo "<p>You have 0 products in your cart.</p>";
                            }
                            mysqli_close($connect);
                            ?>
                        </div>
                        <!-- total -->
                        <div class="total">
                            <div class="total-title" style="color: black !important;">Total</div>
                            <?php
                            require "validate/connect.php";
                            $userId = $_SESSION["user"];
                            $sql = "SELECT c.quantity, p.price FROM cart c
                        INNER JOIN products p ON c.product_id = p.id
                        WHERE c.user_id = $userId";

                            $result = mysqli_query($connect, $sql);
                            $totalPrice = 0;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $totalPrice += $row["quantity"] * $row["price"];
                            }

                            // Formatimi i totalit me 2 numra pas pikës decimale
                            $formattedTotalPrice = number_format($totalPrice, 2);

                            ?>
                            <div class="total-price" style="color: black !important;">
                                <span id="formatted-total-price"><?php echo $formattedTotalPrice . '€'; ?></span>
                            </div>

                            <script>
                                // == Making Function
                                function ready() {
                                    // == Quantity changes
                                    var quantityInputs = document.getElementsByClassName('cart-quantity');
                                    for (var i = 0; i < quantityInputs.length; i++) {
                                        var input = quantityInputs[i];
                                        input.addEventListener('change', quantityChanged);
                                    }
                                };
                                // == Remove items from cart
                                function removeCartItem(event) {
                                    var buttonClicked = event.target;
                                    buttonClicked.parentElement.remove();
                                    updatetotal();
                                };
                                // db value quantity
                                document.querySelectorAll('.cart-quantity').forEach(function(input) {
                                    input.addEventListener('change', function(event) {
                                        var newQuantity = parseInt(event.target.value);
                                        var productId = event.target.getAttribute('data-product-id');

                                        // Perform an AJAX request to update the quantity in the cart using PHP
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', 'validate/update_cart_quantity.php', true);
                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4 && xhr.status === 200) {
                                                // Update the cart display or do any necessary actions after updating quantity
                                            }
                                        };
                                        xhr.send('product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(newQuantity));
                                    });
                                });

                                // db val...
                                // == Quantity changes
                                function quantityChanged(event) {
                                    var input = event.target;
                                    var productId = event.target.getAttribute('data-product-id');
                                    var maxQuantity = parseInt(input.getAttribute("max")); // Get the maximum allowed quantity

                                    if (isNaN(input.value) || input.value <= 0) {
                                        input.value = 1;
                                    } else if (input.value > maxQuantity) { // Limit to available quantity
                                        var errorMessage = "Only " + maxQuantity + " items are left for the product you are looking for, with product ID: " + productId;

                                        // Display the error message
                                        var errorElement = document.getElementById("demo-error-quantity");
                                        errorElement.innerHTML = errorMessage;
                                        errorElement.style.display = "block"; // Show the error message

                                        input.value = maxQuantity;

                                        // Automatically hide the error message after 3 seconds
                                        setTimeout(function() {
                                            errorElement.style.display = "none"; // Hide the error message
                                        }, 3000); // 3000 milliseconds = 3 seconds
                                    }

                                    updatetotal();
                                }
                                // == Uptade total
                                function updatetotal() {
                                    var cartContent = document.getElementsByClassName('cart-content')[0];
                                    var cartBoxes = cartContent.getElementsByClassName('cart-box');
                                    var total = 0;

                                    for (var i = 0; i < cartBoxes.length; i++) {
                                        var cartBox = cartBoxes[i];
                                        var priceElement = cartBox.getElementsByClassName('cart-price')[0];
                                        var quantityElement = cartBox.getElementsByClassName('cart-quantity')[0];
                                        var price = parseFloat(priceElement.innerText.replace('€', '').replace(',', '')); // Remove any commas for parsing
                                        var quantity = quantityElement.value;
                                        total = total + (price * quantity);
                                    }
                                    total = Math.round(total * 100) / 100;

                                    var formattedTotal = total.toLocaleString(undefined, {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + '€';

                                    document.getElementById('formatted-total-price').textContent = formattedTotal;
                                };
                            </script>
                        </div>
                        <?php
                        // Kontrollo nëse përdoruesi ka produkte në shportën e blerjeve
                        $cartProductsQuery = "SELECT COUNT(*) as total FROM cart WHERE user_id = '$userId'";
                        $cartProductsResult = mysqli_query($connect, $cartProductsQuery);
                        $cartProductsCount = mysqli_fetch_assoc($cartProductsResult)['total'];
                        ?>

                        <!-- Vendosimi i butonit dhe mesazhit bazuar në numrin e produkteve në shportë -->
                        <?php if ($cartProductsCount > 0) : ?>
                            <a href="checkout/index.php" style="margin-right: 0px; padding: 0px !important; color: white; text-decoration: none;">
                                <button style="text-align: center;" class="button-blej btn-buy">Order</button>
                            </a>
                        <?php else : ?>
                            <button class="button-blej btn-buy" onclick="OrderAlert() ">Porosit</button>
                            <script>
                                function OrderAlert() {
                                    alert("Add product to the cart to continue with the order!");
                                }
                            </script>
                        <?php endif; ?>

                        <!-- cart close -->
                        <i id="close-cart" class='bx bx-x' style="margin: 0;z-index: 99999 !important; cursor: pointer;"></i>
                        <!-- <script>
                            document.getElementById('close-cart').addEventListener('click', function() {
                                location.reload();
                            });
                        </script> -->
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="line"></div>
            <?php
            if (isset($_SESSION['user'])) {
            ?>
                <a class="user-profil" style="margin: 0;">
                    <button class="action-btn" style="position: static !important;" onclick="toggleDropdown()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <!-- Pjesa e profilit per dropdown -->
                        <script>
                            function toggleDropdown() {
                                const dropdown = document.querySelector('.dropdown-menu');
                                dropdown.classList.toggle('show');
                            }
                        </script>
                    </button></a>
                <div class="dropdown-menu">
                    <p class="text-font"><?php if (isset($_SESSION['useremail'])) {
                                                $perdoruesi_name = $_SESSION['useremail'];
                                                echo "User: " . $perdoruesi_name;
                                            } ?></p>
                    <hr style="border: 1px solid rgb(195, 195, 195);">
                    <a class="text-font" href="user_update_profile.php">Update Profile</a>
                    <hr style="border: 1px solid rgb(195, 195, 195);">
                    <a class="text-font" href="#" onclick="konfirmoFshirjen()">Delete Profile</a>
                    <hr style="border: 1px solid rgb(195, 195, 195);">
                    <a class="text-font" href="#" onclick="konfirmoDaljen()">Logout</a>

                </div>

                <script>
                    function konfirmoDaljen() {
                        if (window.confirm("Are you sure you want to logout?")) {
                            // shkatërro sesionin
                            window.location.href = "validate/logout.php";
                        } else {
                            // mos bëj asgjë
                        }
                    }

                    function konfirmoFshirjen() {
                        if (window.confirm("Are you sure you want to delete the account?")) {
                            // shkatërro sesionin
                            window.location.href = "validate/delete_profile.php";
                        } else {
                            // mos bëj asgjë
                        }
                    }
                </script>
            <?php
            } else {
            ?>
                <a style="all: unset;" href="login.php">
                    <button class="action-btn">
                        <ion-icon name="person-outline" role="img" class="md hydrated" aria-label="person outline">
                            <div class="icon-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon s-ion-icon" viewBox="0 0 512 512">
                                    <title>Login</title>
                                    <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" stroke-linecap="round" stroke-linejoin="round" class="ionicon-fill-none ionicon-stroke-width"></path>
                                    <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" stroke-miterlimit="10" class="ionicon-fill-none ionicon-stroke-width"></path>
                                </svg>
                            </div>
                        </ion-icon>
                    </button>
                </a>
            <?php
            }
            ?>
        </div>
        <?php if (isset($_SESSION["user"])) {
        ?>
            <a style="display: none;" class="hidd-unhidden" href="user_update_profile.php">Update Profile</a>
            <a style="display: none;" class="hidd-unhidden" href="#" onclick="konfirmoFshirjen()">Delete Profile</a>
            <a style="display: none;" class="hidd-unhidden" href="#" onclick="konfirmoDaljen()">Logout</a>
        <?php }
        ?>
    </nav>
    <!-- <button class="menu-icon" onclick="toggleMenu()">&#9776;</button> -->
    <button style="outline: none;background-color: transparent !important;" class="menu-icon" onclick="toggleMenu()">
        <span class="icon-hamburger">&#9776;</span>
        <span class="icon-close">&#10006;</span>
    </button>

</header>
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