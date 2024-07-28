<?php
session_start();
require "../validate/connect.php";

$user_id = $_SESSION["user_id"];
$chatMessages = "";

// SQL query për të marrë mesazhet e chat-it
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

// Sorto mesazhet sipas kohës
usort($messages, function ($a, $b) {
    return strtotime($a['created_at']) - strtotime($b['created_at']);
});

// Krijo HTML për mesazhet
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

// Ktheji përgjigjen si HTML
echo $chatMessages;
