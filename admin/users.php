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

            .btn {
                width: 85px !important;
            }

            /* Stili për të bërë tabelën responsive */
            @media (max-width: 767px) {

                .table td,
                .table th {
                    font-size: 12px;
                    /* Ndryshoni madhësinë e fontit sipas preferencave tuaja */
                }

            }

            @media (max-width: 600px) {

                /*
                *Stilizimi i faqes users  */
                .btn {
                    margin: 5px 0px;
                }

                /* 
                *Stili për të bërë kolonën "Email" më të vogël dhe në drejtim vertikal*/
                .table td:nth-child(2) {
                    font-size: 12px;
                    white-space: nowrap;
                    transform: rotate(270deg);
                    transform-origin: center;
                    max-width: 50px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: transparent;
                    border: none;
                }


                .table td {
                    height: 209px;
                }

                /* 
                *Mbarimi i stilizimit te faqes users */
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Users List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($connect, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
                        <td>' . $row["email"] . '</td>  
                        <td>' . $row["address"] . '</td>
                        <td>' . $row["status"] . '</td>
                        <td>';

                        echo '<a href="?page=details_users&id=' . $row["id"] . '" class="btn btn-info">Details</a> ';
                        echo '<a href="?page=update_users&id=' . $row["id"] . '" class="btn btn-info">Update</a> ';

                        if ($row["status"] !== "admin") {
                            echo '<a href="ban_user.php?id=' . $row['id'] . '" class="btn btn-' .
                                ($row['is_banned'] === 'Yes' ? 'success' : 'warning') . '">'
                                . ($row["is_banned"] === "Yes" ? "Unban" : "Ban") .
                                '</a> ';
                        } else {
                            echo '<a href="#" class="btn btn-secondary">N/A</a> ';
                        }

                        if ($row["status"] !== "admin") {
                            echo '<a href="delete_user.php?id=' . $row["id"] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this menu item?\')">Delete</a>';
                        } else {
                            echo '<a href="#" class="btn btn-secondary">N/A</a>';
                        }

                        echo '</td>
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
