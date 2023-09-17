<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
    require "file_upload.php";
    $error = false;
    $name = $description = $picture = $price = $quantity = $rating = $category = "";
    $errorName = $errorDescription = $errorPrice = $errorQuantity = $errorRating = $errorCategory = "";
    if (isset($_POST["create"])) {
        $name = $_POST["name"];
        $description = mysqli_real_escape_string($connect, $_POST["description"]);
        $picture = fileUpload($_FILES["picture"]);
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $category = $_POST["category"];
        $rating = $_POST["rating"];

        if (empty($name)) {
            $error = true;
            $errorName = "Field cannot be empty.";
        } elseif (strlen($name) < 3) {
            $error = true;
            $errorName = "Name must have at least 3 characters.";
        }
        if (empty($description)) {
            $error = true;
            $errorDescription = "Description field cannot be empty.";
        } elseif (strlen($description) < 10) {
            $error = true;
            $errorDescription = "Description must have at least 10 characters.";
        }
        if (empty($price)) {
            $error = true;
            $errorPrice = "Price cannot be empty.";
        } else if (!is_numeric($price)) {
            $error = true;
            $errorPrice = "Please provide numeric value for price";
        }
        if (empty($quantity)) {
            $error = true;
            $errorQuantity = "Quantity cannot be empty.";
        } else if (!is_numeric($quantity)) {
            $error = true;
            $errorQuantity = "Please provide numeric value for quantity";
        }
        if ($category == "null") {
            $error  = true;
            $errorCategory = "Please select category";
        }
        if (empty($rating)) {
            $error = true;
            $errorRating = "Rating cannot be empty.";
        } else if (!is_numeric($rating)) {
            $error = true;
            $errorRating = "Please provide numeric value for rating";
        }

        if (!$error) {
            $sql = "INSERT INTO products (name, image, description, price, quantity, rating)
            VALUES ('$name', '{$picture[0]}', '$description', '$price', '$quantity', '$rating')";


            if (mysqli_query($connect, $sql)) {
                echo "<div class='alert alert-success' role='alert'>
                Product has been created, {$picture[1]}
                </div>";
                echo "<script>window . location . href = 'dashboard.php?page=products'</script>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error found: " . mysqli_error($connect) . "</div>";
            }

            mysqli_close($connect);
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>Create New Product</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }

            .input-column {
                flex: 1;
                padding: 0 5px;
            }

            .width-btn-2 {
                width: 170px !important;
                height: 50px !important;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .bg-color-1 {
                background-color: rgba(249, 249, 249, 0.6);
                border-radius: 5px;
                padding: 30px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Për telefona (max 600px) */
            @media (max-width: 600px) {
                .container {
                    width: 100%;
                }

                .input-column {
                    flex: none;
                }

                .form-group {
                    width: 100%;
                }

            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="bg-color-1">
                <h3 style="text-align: center">Create a product</h3>
                <br>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-4 input-column">
                            <label for="name" class="form-label">Name of Product</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php if (empty($errorName)) echo $name; ?>">
                            <span class="text-danger"><?= $errorName ?></span>
                        </div>
                        <div class="col-md-4 input-column">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="null">Select category</option>
                                <option value="Laptop" <?= (isset($category) && $category === "Laptop") ? 'selected' : '' ?>>Laptop</option>
                                <option value="Headphones" <?= (isset($category) && $category === "Headphones") ? 'selected' : '' ?>>Headpones</option>
                                <option value="Phone" <?= (isset($category) && $category === "Phone") ? 'selected' : '' ?>>Phone</option>
                            </select>
                            <span class="text-danger"><?= $errorCategory ?></span>
                        </div>
                        <div class="col-md-4 input-column">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php if (empty($errorPrice)) echo $price; ?>">
                            <span class="text-danger"><?= $errorPrice ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 input-column">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php if (empty($errorDescription)) echo $description; ?></textarea>
                            <span class="text-danger"><?= $errorDescription ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-column">
                            <label for="picture" class="form-label">Picture</label>
                            <input type="file" class="form-control" id="picture" name="picture">
                        </div>
                        <div class="col-md-3 input-column">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" max="100" value="<?php if (empty($errorQuantity)) echo $quantity; ?>">
                            <span class="text-danger"><?= $errorQuantity ?></span>
                        </div>
                        <div class="col-md-3 input-column">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="<?php if (empty($errorRating)) echo $rating; ?>">
                            <span class="text-danger"><?= $errorRating ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div style="display: flex;justify-content: center;gap: 20px;" class="col-md-12 text-center">
                            <a href="dashboard.php?page=products" class="btn btn-outline-info width-btn-2" style="background-color: #0dcaf0;color: black">Back</a>
                            <button name="create" type="submit" class="btn btn-primary width-btn-2">Create product</button>
                        </div>
                    </div>
                </form>
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
