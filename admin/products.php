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
            <h2>Product List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="hidden_for_phone">Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($connect, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                    <td style="width: 70px;">' . $row["id"] . '</td>  
                    <td style="width: 250px;"  class="hidden_for_phone">' . $row["name"] . '</td>
                    <td>' . $row["price"] . '</td>
                    <td>' . $row["quantity"] . '</td>
                    <td>
                        <a href="?page=details_product&product_id=' . $row["id"] . '" class="btn btn-width btn-info">Details</a>
                        <a href="?page=update_product&product_id=' . $row["id"] . '" class="btn btn-width btn-info">Update</a>
                        <a href="?page=details_reviews&product_id=' . $row["id"] . '" class="btn btn-width btn-info">Reviews</a>
                        <a href="hide_product.php?id=' . $row['id'] . '" class="btn  btn-width btn-' . ($row['is_hidden'] === 'Yes' ? 'success' : 'warning') . '">' .
                            ($row["is_hidden"] === "Yes" ? "Unhide" : "Hide") .
                            '</a>
                        <a href="delete_product.php?product_id=' . $row["id"] . '" class="btn btn-width btn-danger" onclick="return confirm(\'Are you sure you want to delete this menu item?\')">Delete</a>
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
    header("location:../home.php");
} else {
    header("Location: ../login.php");
}
