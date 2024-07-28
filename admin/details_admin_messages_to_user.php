<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";

    // Getting data from the database
    $id = $_GET["user_messages_id"];
    $sql = "SELECT * FROM live_support WHERE user_id=$id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION["user_id"] = $row["user_id"];
    $_SESSION["user_email"] = $row["user_email"];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Animal Details</title>
        <link rel="stylesheet" href="../css/style.css">
        <style>
            @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css");
            @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/fontawesome.min.css");

            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }

            .row {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .container {
                padding-top: 20px;
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
                display: block;
                position: fixed;
                bottom: 30px;
                width: 430px;
                height: 530px;
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
                padding: 15px;
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
                max-height: 360px;
                height: 350px;
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
                max-width: 420px;
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
            @media (max-width: 768px) {
                .row-row {
                    flex-direction: column !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="container text-center">
            <div class="row">
                <!-- Live Suport Code START-->
                <!-- <button class="open-button" onclick="openForm()"><i style='font-size:24px' class='far'>&#xf4ad;</i></button> -->

                <div class="chat-popup" id="myForm">
                    <div class="top-content">
                        <?php
                        $user_email = $_SESSION["user_email"];
                        ?>
                        <h1><i style='font-size:24px' class='far'>&#xf4ad;</i>User: <?php echo $user_email; ?></h1>
                        <!-- <i onclick="closeForm()" style="font-size:24px" class="fa close-btn-livechat">&#xf00d;</i> -->
                    </div>
                    <div class="message-content" id="message-content">
                        <?php
                        require "../validate/connect.php";
                        $user_id = $_SESSION["user_id"];
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
                            // Ngjarja DOMContentLoaded siguron se JavaScript ekzekutohet pas ngarkimit të dokumentit
                            document.addEventListener("DOMContentLoaded", function() {
                                function refreshChat() {
                                    var chatContainer = document.getElementById('message-content');
                                    var xhr = new XMLHttpRequest();

                                    // Cakto llojin e kërkesës dhe URL-në
                                    xhr.open('GET', 'refresh_chat_messages.php', true);

                                    // Përcakto funksionin që do të thirret kur kërkesa përfundojë me sukses
                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            // Përgjigja nga serveri është në xhr.responseText
                                            var response = xhr.responseText;
                                            // Përditëso faqen tuaj ose bëni çfarë dëshironi me përgjigjen
                                            chatContainer.innerHTML = response;
                                            // Levizni ne fund per te shfaqur mesazhet me te fundit.
                                            chatContainer.scrollTop = chatContainer.scrollHeight;
                                        }
                                    };

                                    // Dërgo kërkesën
                                    xhr.send();
                                }

                                // Refresh chat çdo 5 sekonda
                                setInterval(refreshChat, 5000);
                            });
                        </script>
                    </div>
                    <form method="post" class="form-container" onsubmit="return false;">
                        <div class="send-message">
                            <input type="text" name="live-message" class="send-msg-input" placeholder="Write your message...">
                            <!-- <?php
                                    // $user_id = $_GET["user_messages_id"];
                                    ?>
                            <input type="hidden" name="user_id_msg" value="<?php echo $user_id; ?>"> -->
                            <button type="submit" class="btn-livechat"><i style="font-size:24px" class="fa">&#xf138;</i></button>
                        </div>
                    </form>
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

                        // Krijoni një objekt XMLHttpRequest.
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "validateLiveSupport.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Handle the response (add the sent message to the chat display).
                                var response = xhr.responseText;
                                var messageContent = document.getElementById("message-content");
                                messageContent.innerHTML = response; // Përditëso mesazhin me përgjigjen e serverit.

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
                    // function openForm() {
                    //     document.getElementById("myForm").style.display = "block";
                    // }

                    // // Function to close the chat form without closing it entirely.
                    // function closeForm() {
                    //     document.getElementById("myForm").style.display = "none";
                    // }
                </script>


                <!-- Lice Suport Code END -->

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
