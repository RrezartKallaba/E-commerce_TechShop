<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
    require "file_upload.php";

    $id = $_GET["product_id"];
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$result) {
        die("Error executing query: " . mysqli_error($connect));
    }


    if (isset($_POST["update"])) {
        $name = $_POST["name"];
        $picture = fileUpload($_FILES["picture"]);
        $description = mysqli_real_escape_string($connect, $_POST["description"]);
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $category = $_POST["category"];
        $rating = $_POST["rating"];


        if ($_FILES["picture"]["error"] == 0) {
            /* checking if the picture name of the product is not product.png to remove it from pictures folder */
            if ($row["image"] != "user.png") {
                unlink("../pictures/" . $row["image"]);
            }
            $sql = "UPDATE products SET 
        name='$name', 
        image='{$picture[0]}', 
        description='$description', 
        price='$price', 
        quantity='$quantity', 
        category='$category',
        rating='$rating'
        WHERE id=$id";
        } else {
            $sql = "UPDATE products SET 
        name='$name', 
        description='$description', 
        price='$price', 
        quantity='$quantity', 
        category='$category',
        rating='$rating'
        WHERE id=$id";
        }

        if (mysqli_query($connect, $sql)) {
            echo "<div style='top:80px;' class='alert alert-success' role='alert'>
                Product has been updated
              </div>";
            echo "<script>window . location . href = 'dashboard.php?page=products'</script>";
        } else {
            echo "Error " . mysqli_error($connect);
        }

        mysqli_close($connect);
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

            .container {
                width: 700px;
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
                            <textarea type="text" class="form-control" id="name" name="name" rows="3" required><?php echo $row['name']; ?></textarea>
                        </div>
                        <div class="col-md-4 input-column">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="null">Select category</option>
                                <option value="Laptop" <?php if ($row['category'] === 'Laptop') echo 'selected'; ?>>Laptop</option>
                                <option value="Headphones" <?php if ($row['category'] === 'Headphones') echo 'selected'; ?>>Headpones</option>
                                <option value="Phone" <?php if ($row['category'] === 'Phone') echo 'selected'; ?>>Phone</option>
                            </select>
                        </div>
                        <div class="col-md-4 input-column">
                            <label for="picture" class="form-label">Picture</label>
                            <input type="file" class="form-control" id="picture" name="picture" value="<?php echo $row['image']; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="input-column">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-column">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>">
                        </div>
                        <div class="col-md-3 input-column">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" max="100" required value="<?php echo $row['quantity']; ?>">
                        </div>
                        <div class="col-md-3 input-column">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required value="<?php echo $row['rating']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div style="display: flex;justify-content: center;gap: 20px;" class="col-md-12 text-center">
                            <a href="dashboard.php?page=products" class="btn btn-outline-info width-btn-2" style="background-color: #0dcaf0;color: black">Back</a>
                            <button name="update" type="submit" class="btn btn-primary width-btn-2">Update Data</button>
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
?>