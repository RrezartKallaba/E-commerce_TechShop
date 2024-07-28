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

        /* live suport code start */
        .open-button {
            background-color: #f04a23;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 60px;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 15px;
            width: 330px;
            height: 430px;
            border: 1px solid #d5d5d5;
            border-radius: 10px;
            z-index: 9;
            background-color: white;
        }



        .chat-popup .top-content {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            background-color: #f04a23;
            border-radius: 10px 10px 0 0;
            text-align: center;
            color: white;
            margin: 0;
        }

        .chat-popup .top-content h1 {
            font-size: 24px;
        }


        .chat-popup .top-content h1 i {
            margin-right: 5px;
        }

        .chat-popup .top-content .close-btn-livechat {
            cursor: pointer;
        }

        .chat-popup .message-content {
            max-height: 260px;
            height: 250px;
            overflow: auto;
            padding: 10px;
            margin: 10px 0;
            /* border: 1px solid black; */
            display: flex;
            flex-direction: column;
        }


        .chat-popup .message-content .user_messages {
            background-color: #d4edda;
            padding: 0 10px;
            border-radius: 10px;
            max-width: 200px;
            width: auto;
            height: auto;
            margin-left: auto;
            margin-top: 10px;
            text-align: right;
        }

        .chat-popup .message-content .user_messages span,
        .chat-popup .message-content .admin_messages span {
            font-size: 10px;
        }

        .chat-popup .message-content .user_messages p,
        .chat-popup .message-content .admin_messages p {
            margin: 0;
            padding: 5px 0;
        }

        .chat-popup .message-content .admin_messages {
            background-color: #d4edda;
            padding: 0 10px;
            border-radius: 10px;
            max-width: 200px;
            width: auto;
            height: auto;
            margin-right: auto;
            margin-top: 10px;
            text-align: left;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            width: 100%;
            padding: 0 15px;
            background-color: white;
            position: absolute;
            bottom: 10px;
        }

        .chat-popup .form-container .send-message {
            display: flex;
            align-items: center;
            flex-direction: row;
        }

        .chat-popup .form-container .send-message .send-msg-input,
        .chat-popup .form-container .send-message .btn-livechat {
            height: 42px;
            outline: none;
            box-sizing: border-box;
        }

        .chat-popup .form-container .send-message .send-msg-input {
            width: 100%;
            padding: 0 0 0 10px;
            margin-bottom: 0;
            border-radius: 20px 0 0 20px;

        }

        .chat-popup .form-container .send-message .btn-livechat {
            width: 60px;
            padding: 0px;
            border-radius: 0 20px 20px 0;
        }

        /* live suport code end */
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

    <!-- Live Suport Code START-->
    <button class="open-button" onclick="openForm()"><i style='font-size:24px' class='far'>&#xf4ad;</i></button>

    <div class="chat-popup" id="myForm">
        <div class="top-content">
            <h1><i style='font-size:24px' class='far'>&#xf4ad;</i>Live Support</h1>
            <i onclick="closeForm()" style="font-size:24px" class="fa close-btn-livechat">&#xf00d;</i>
        </div>
        <div class="message-content" id="message-content">
            <?php
            if (isset($_SESSION["user"])) {

                require "validate/connect.php";
                $user_id = $_SESSION["user"];
                $chatMessages = "";

                $sql = "SELECT * FROM live_support WHERE user_id = '$user_id' ORDER BY created_at";
                $sql_admin = "SELECT * FROM admin_msg_live_support WHERE user_id = '$user_id' ORDER BY created_at";
                $result = mysqli_query($connect, $sql);
                $result_admin = mysqli_query($connect, $sql_admin);

                $messages = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    $messages[] = array(
                        'message' => $row['message'],
                        'created_at' => $row['created_at'],
                        'type' => 'user'
                    );
                }

                while ($row = mysqli_fetch_assoc($result_admin)) {
                    $messages[] = array(
                        'message' => $row['message'],
                        'created_at' => $row['created_at'],
                        'type' => 'admin'
                    );
                }

                usort($messages, function ($a, $b) {
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                });

                foreach ($messages as $message) {
                    if ($message['type'] === 'user') {
                        $chatMessages .= '<div class="user_messages">
                <p>' . $message['message'] . '</p>
                <span>' . $message['created_at'] . '</span>
                </div>';
                    } else {
                        $chatMessages .= '<div class="admin_messages">
                <p>' . $message['message'] . '</p>
                <span>' . $message['created_at'] . '</span>
                </div>';
                    }
                }

                echo $chatMessages;
            ?>
                <script type="text/javascript">
                    // Ngjarja DOMContentLoaded siguron se JavaScript ekzekutohet pas ngarkimit te dokumentit
                    document.addEventListener("DOMContentLoaded", function() {
                        function refreshChat() {
                            var chatContainer = document.getElementById('message-content');
                            var xhr = new XMLHttpRequest();

                            // Cakto llojin e kerkeses dhe URL-ne
                            xhr.open('GET', 'validate/refresh_chat_messages.php', true);

                            // Percakto funksionin qe do te thirret kur kerkesa perfundoje me sukses
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Pergjigja nga serveri eshte ne xhr.responseText
                                    var response = xhr.responseText;
                                    // Perditeso faqen tuaj ose beni çfare deshironi me pergjigjen
                                    chatContainer.innerHTML = response;
                                    // Levizni ne fund per te shfaqur mesazhet me te fundit.
                                    chatContainer.scrollTop = chatContainer.scrollHeight;
                                }
                            };

                            // Dergo kerkesen
                            xhr.send();
                        }

                        // Refresh chat çdo 5 sekonda
                        setInterval(refreshChat, 5000);
                    });
                </script>
            <?php
            } else {
                echo "<p>You need to login first!</p>";
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION["user"])) {
        ?>
            <form method="post" class="form-container" onsubmit="return false;">
                <div class="send-message">

                    <input type="text" name="live-message" class="send-msg-input" placeholder="Write your message...">
                    <button type="submit" class="btn-livechat"><i style="font-size:24px" class="fa">&#xf138;</i></button>
                </div>
            </form>
        <?php
        } else {
        ?>
            <form class="form-container" onsubmit="return false;">
                <div class="send-message">
                    <input type="text" style="cursor: not-allowed;" disabled class="send-msg-input" placeholder="Write your message...">
                    <button style="cursor: not-allowed;" class="btn-livechat"><i style="font-size:24px" class="fa">&#xf138;</i></button>
                </div>
            </form>
        <?php
        }
        ?>
    </div>
    <script>
        // JavaScript code for chat form handling
        function sendMessage(e) {
            e.preventDefault();

            var messageInput = document.querySelector(".send-msg-input");
            var message = messageInput.value;

            if (message.trim() === "") {
                return;
            }

            // Krijoni nje objekt XMLHttpRequest.
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "validate/validateLiveSupport.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response (add the sent message to the chat display).
                    var response = xhr.responseText;
                    var messageContent = document.getElementById("message-content");
                    messageContent.innerHTML = response; // Perditeso mesazhin me pergjigjen e serverit.

                    // Clear the input field.
                    messageInput.value = "";

                    // Scroll to the bottom to show the latest messages.
                    messageContent.scrollTop = messageContent.scrollHeight;
                }
            };

            // Send the message to the server.
            xhr.send("live-message=" + message);
        }

        // Add an event listener for form submission
        var chatForm = document.querySelector(".form-container");
        chatForm.addEventListener("submit", sendMessage);

        // Function to open the chat form.
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        // Function to close the chat form without closing it entirely.
        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
    </script>


    <!-- Lice Suport Code END -->


    <footer>©2023 Tech Shop</footer>
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
    <script src="main.js"></script>
</body>

</html>