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

            @media (max-width: 600px) {
                .btn {
                    margin: 5px 0px;
                    width: 75px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Reviews List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Review</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_GET["product_id"];
                    $sql = "SELECT * FROM reviews WHERE product_id=$id";
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                <td>' . $row["id"] . '</td>
                                <td>' . $row["user_id"] . '</td>
                                <td>' . $row["product_id"] . '</td>
                                <td>' . $row["review"] . '</td>
                                <td>
                                <a href="dashboard.php?page=products" class="btn btn-info">Back</a>
                                    <a href="delete_review.php?review_id=' . $row["id"] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this review?\')">Delete</a>
                                </td>
                              </tr>';
                        }
                    } else {
                        echo '<tr >
                                    <td style="text-align: center;" colspan="5">This product has 0 reviews</td>
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
