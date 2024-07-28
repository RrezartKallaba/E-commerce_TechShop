<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }

            .table-bordered thead td,
            .table-bordered thead th {
                border-bottom-width: 2px;
            }

            tbody,
            td,
            tfoot,
            th,
            thead,
            tr {
                border-color: inherit;
                border-style: solid;
                border-width: 2px;
            }

            .btn-width {
                width: 84px !important;
            }

            @media (max-width: 600px) {
                .btn {
                    margin: 5px 0px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Users Messages</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT ls.* 
                    FROM live_support ls
                    INNER JOIN (
                        SELECT user_id, MAX(created_at) AS max_created_at
                        FROM live_support
                        GROUP BY user_id
                    ) latest_msg
                    ON ls.user_id = latest_msg.user_id
                    AND ls.created_at = latest_msg.max_created_at";

                    $result = mysqli_query($connect, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                    <td style="width: 70px;">' . $row["id"] . '</td> 
                    <td style="width: 70px;">' . $row["user_id"] . '</td> 
                    <td>' . $row["user_fullname"] . '</td>
                    <td>' . $row["user_email"] . '</td>
                    <td>' . $row["message"] . '</td>
                    <td>' . $row["created_at"] . '</td>
                    <td>
                        <a href="?page=details_admin_messages_to_user&user_messages_id=' . $row["user_id"] . '" class="btn btn-width btn-info">Details</a>
                        <a href="delete_user_messages.php?user_messages_id=' . $row["user_id"] . '" class="btn btn-width btn-danger" onclick="return confirm(\'Are you sure you want to delete this chat?\')">Delete</a>
                    </td>
                </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>

    </html>
<?php
} else if (isset($_SESSION["user"])) {
    header("location:../index.php");
} else {
    header("Location: ../login.php");
}
