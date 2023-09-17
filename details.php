<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Product Details</title>
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
            margin: 0 0 14px 0;
            /* line-height: 1.6; */
        }

        .card-text-review {
            font-size: 16px;
            text-align: left;
            color: #555;
            margin: 0 0 14px 0;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-direction: row;
        }

        .margin-btn {
            display: flex;
            justify-content: flex-start;
            padding: 0 0 0 15px;
            gap: 5px;
        }

        .btn-back {
            width: 120px;
            height: 40px;
            border: 1.5px solid #f04a23 !important;
            background-color: white;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 17px;
        }

        .btn-back:hover {
            background-color: #f04a23;
            color: white;
        }

        .fixed-area {
            height: 425px;
        }

        .border-b-1 {
            border: 1px solid rgb(189, 190, 191);
            padding: 5px;
            border-radius: 5px;
        }

        .height-card-review {
            height: 300px !important;
            overflow-y: auto !important;
        }

        .active-button {
            background-color: #f04a23;
            color: white;
        }

        .left-area {
            display: flex;
            justify-content: flex-start;
        }

        .cart-remove {
            font-size: 1.5rem;
            color: #fd4646;
            cursor: pointer;
        }

        .btn-left {
            text-align: center;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 80px;
        }

        .text-danger {
            font-size: 14px;
            color: red;
        }

        @media (max-width: 768px) {
            .row-row {
                flex-direction: column !important;
            }
        }

        @media (max-width: 600px) {
            .card-img-top {
                height: auto !important;
            }

            .fixed-area {
                height: auto !important;
            }

            .btn-back {
                width: 150px;
            }

            .margin-btn {
                padding: 0 !important;
                justify-content: center;
                gap: 5px;
            }
        }
    </style>
</head>

<body>
    <?php include "validate/alerts.php" ?>
    <?php
    require "validate/connect.php";
    // Getting data from the database
    $id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6">
                <img src="pictures/<?php echo $row['image']; ?>" class="card-img-top" alt="Animal Image">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="fixed-area" id="change-text">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <hr>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <div>
                            <p class="card-text"><strong>Price:</strong> <?php echo $row['price'] . "€"; ?></p>
                            <p class="card-text"><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                            <p class="card-text"><strong>Rating:</strong><?php $ratingValue = $row['rating'];
                                                                            $stars = "";
                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                if ($i <= $ratingValue) {
                                                                                    $stars .= "<img style='height:16px !important' src='img/star.png'>";
                                                                                } else {
                                                                                    $stars .= "<img style='height:16px !important' src='img/star-no-color.png'>";
                                                                                }
                                                                            }
                                                                            echo $stars; ?>
                            </p>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div class="fixed-area" id="description-content" style="display: none;">
                        <h5 class="card-title">Reviews</h5>
                        <hr>
                        <div class="height-card-review">
                            <?php
                            $product_id = $_GET['id'];
                            $sql2 = "SELECT reviews.review, users.first_name, users.last_name, users.email
                    FROM reviews
                    INNER JOIN users ON reviews.user_id = users.id
                    WHERE reviews.product_id = $product_id";
                            $result2 = mysqli_query($connect, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                            ?>
                                    <div class="border-b-1">
                                        <p class="card-text-review"><strong>Reviewer: </strong><?php echo $row2["first_name"] . " " .  $row2["last_name"] ?></p>
                                        <p class="card-text-review"><strong>Review: </strong><?php echo $row2["review"] ?></p>
                                        <?php
                                        if (isset($_SESSION["user"])) {

                                            if (isset($_SESSION['useremail'])) {
                                                $useremail = $_SESSION["useremail"];
                                            }
                                            $sql21 = "SELECT *
                                            FROM reviews WHERE reviews.product_id = $product_id";
                                            $result21 = mysqli_query($connect, $sql21);

                                            $row21 = mysqli_fetch_assoc($result21);
                                            $reviewId = $row21['id'];

                                            if ($row2["email"] === $useremail) {
                                                echo '<a href="delete_review.php?product_id=' . $product_id . '&review_id=' . $row21["id"] . '" class="btn btn-danger btn-left" onclick="return confirm(\'Are you sure you want to delete this review?\')">Delete</a>';
                                            }
                                        }
                                        ?>

                                    </div>
                                    <br>
                            <?php
                                }
                            } else {
                                echo "<p>No results found</p>";
                            }
                            ?>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div class="fixed-area" id="add-review-content" style="display: none;">
                        <h5 class="card-title">Add Review</h5>
                        <hr>
                        <div class="height-card-review">
                            <?php
                            $product_id = $_GET['id'];
                            $sql = "SELECT name FROM Products WHERE id = $product_id";
                            $result3 = mysqli_query($connect, $sql);
                            $row3 = mysqli_fetch_assoc($result3)
                            ?>
                            <?php
                            ?>
                            <?php if (isset($_SESSION["user"])) {
                            ?>
                                <form method="post">
                                    <p class="card-text"><?php if (isset($_SESSION['username'])) {
                                                                $perdoruesi_name = $_SESSION['username'];
                                                                echo "<b>User: </b>" . $perdoruesi_name;
                                                            } ?></p>
                                    <p class="card-text"><?php echo "<b>Review for: </b>"  . $row3["name"] ?></p>
                                    <?php
                                    $product_id = $_GET['id'];
                                    $user_id = $_SESSION['user'];

                                    $query_check_purchase = "SELECT COUNT(*) as total FROM orders WHERE user_id = '$user_id' AND product_id = '$product_id'";
                                    $result_check_purchase = mysqli_query($connect, $query_check_purchase);
                                    $row_check_purchase = mysqli_fetch_assoc($result_check_purchase);

                                    if ($row_check_purchase['total'] > 0) {
                                        require "validate/validateReview.php";
                                        echo '<textarea style="width: 100%;" class="card-text left-area" name="review" id="review" cols="35" rows="5" placeholder="Give your rating..."></textarea>';
                                        echo '<p class="text-danger">' . $error_message_review . '</p>';
                                        echo '<button name="add-review" type="submit">Submit</button>';
                                    } else {
                                        echo '<textarea style="width: 100%;" class="card-text left-area" name="review" disabled cols="35" rows="5">You need to buy the product first to leave a review!</textarea>';
                                    }
                                    ?>

                                </form>
                            <?php } else {
                            ?>
                                <p class="card-text"><?php echo "<b>Review for: </b>"  . $row3["name"] ?></p>
                                <p class="card-text"><a href="login.php"><b>Login to add review</b></a></p>
                            <?php } ?>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div class="row margin-btn">
                        <div class="row margin-btn">
                            <button class="btn-back active-button" onclick="myFunction(true)" id="description-button">Description</button>
                            <button class="btn-back" onclick="myFunction(false, false)" id="reviews-button">Reviews</button>
                            <button class="btn-back" onclick="myFunction(false, true)" id="add-review-button">Add Review</button>
                            <button class="btn-back" onclick="goToProducts()">Back</button>
                        </div>
                    </div>
                </div>

                <script>
                    function myFunction(showDescription, showAddReview) {
                        if (showDescription) {
                            document.getElementById("change-text").style.display = "block";
                            document.getElementById("description-content").style.display = "none";
                            document.getElementById("add-review-content").style.display = "none";
                            document.getElementById("description-button").classList.add("active-button");
                            document.getElementById("reviews-button").classList.remove("active-button");
                            document.getElementById("add-review-button").classList.remove("active-button");
                        } else if (showAddReview) {
                            document.getElementById("change-text").style.display = "none";
                            document.getElementById("description-content").style.display = "none";
                            document.getElementById("add-review-content").style.display = "block";
                            document.getElementById("description-button").classList.remove("active-button");
                            document.getElementById("reviews-button").classList.remove("active-button");
                            document.getElementById("add-review-button").classList.add("active-button");
                        } else {
                            document.getElementById("change-text").style.display = "none";
                            document.getElementById("description-content").style.display = "block";
                            document.getElementById("add-review-content").style.display = "none";
                            document.getElementById("description-button").classList.remove("active-button");
                            document.getElementById("reviews-button").classList.add("active-button");
                            document.getElementById("add-review-button").classList.remove("active-button");
                        }
                    }

                    function goToProducts() {
                        window.location.href = 'products.php';
                    }
                </script>

            </div>
        </div>
    </div>
</body>

</html>