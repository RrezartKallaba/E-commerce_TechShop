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
        <title>Users Details</title>
        <style>
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

            .card-img-top {
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                height: 350px;
                width: 65%;
            }

            .card-body {
                padding: 20px;
            }

            .card-title {
                font-size: 24px;
                font-weight: bold;
                color: #333;
                text-align: left;
            }

            .card-text {
                font-size: 16px;
                text-align: left;
                color: #555;
                line-height: 1.6;
            }

            .btn-back {
                display: flex;
                justify-content: center;
                width: 90px;
                text-align: left;
                color: #fff;
                background-color: #0a5a6a;
                border: none;
                border-radius: 6px;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .btn-back:hover {
                background-color: #0e7490;
            }

            .col {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 90vh;
            }

            @media (max-width: 768px) {
                .row-row {
                    flex-direction: column !important;
                }
            }

            @media (max-width: 600px) {
                .card-body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                }
            }
        </style>
    </head>

    <body>
        <?php
        require "../validate/connect.php";
        // Getting data from the database
        $id = $_GET["id"];
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        mysqli_close($connect);
        ?>
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6">
                    <img src="../pictures/<?php echo $row['image']; ?>" class="card-img-top" alt="User Image">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
                        <br>
                        <div>
                            <p class="card-text">Email: <?php echo $row['email']; ?></p>
                            <p class="card-text">Phone: <?php echo $row['phone']; ?></p>
                            <p class="card-text">Address: <?php echo $row['address']; ?></p>
                            <p class="card-text">Status: <?php echo $row['status']; ?></p>
                            <a style="text-decoration: none;" href="dashboard.php?page=users" class="btn-back">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else if (isset($_SESSION["user"])) {
    header("location:../home.php");
} else {
    header("Location: ../login.php");
}
