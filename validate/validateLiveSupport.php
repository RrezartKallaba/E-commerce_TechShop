<?php
session_start();
require "connect.php";
$error = false;
$livechat_support = "";
$livechat_error = "";
function cleanInputs($input)
{
    $data = trim($input); // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data); // removing tags from the string
    $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt"; 

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $livechat_support = cleanInputs($_POST["live-message"]);

    if (empty($livechat_support)) {
        echo "Message can't be empty!";
    } else {
        $user_id = $_SESSION["user"];
        $user_fullname = $_SESSION["username"];
        $user_email = $_SESSION["useremail"];
        $status = $_SESSION["status"];
        $sql = "INSERT INTO live_support (status, user_id, user_fullname, user_email, message) values ('$status','$user_id', '$user_fullname', '$user_email', '$livechat_support')";

        if (mysqli_query($connect, $sql)) {
            // Në vend të 'echo' mesazhit, përgatit një përgjigje HTML që përmban të gjitha mesazhet të formatuara në formatin e duhur.
            $chatMessages = "";
            $sql = "SELECT * FROM live_support WHERE user_id = '$user_id' ORDER BY created_at";
            $sql_admin = "SELECT * FROM admin_msg_live_support WHERE user_id = '$user_id' ORDER BY created_at";
            $result = mysqli_query($connect, $sql);
            $result_admin = mysqli_query($connect, $sql_admin);

            $messages = array();

            // Ruaj mesazhet nga tabela 'live_support' në një array
            while ($row = mysqli_fetch_assoc($result)) {
                $messages[] = array(
                    'message' => $row['message'],
                    'created_at' => $row['created_at'],
                    'type' => 'user'
                );
            }

            // Ruaj mesazhet nga tabela 'admin_msg_live_support' në array të njëjtë
            while ($row = mysqli_fetch_assoc($result_admin)) {
                $messages[] = array(
                    'message' => $row['message'],
                    'created_at' => $row['created_at'],
                    'type' => 'admin'
                );
            }

            // Rendit array-in e mesazheve sipas kohës së krijimit
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
        } else {
            echo "Something went wrong, please try again later...";
            echo mysqli_error($connect);
        }
    }
}

mysqli_close($connect);
