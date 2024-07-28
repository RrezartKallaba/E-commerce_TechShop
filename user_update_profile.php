<?php
session_start();
if (isset($_SESSION["user"])) {
    require "validate/connect.php";
    require "file_uploadRegister.php";
    // session_start();
    $id = $_SESSION["user"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$result) {
        die("Error executing query: " . mysqli_error($connect));
    }

    if (isset($_POST["update"])) {
        $fname = $_POST["first_name"];
        $lname = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $picture = isset($_FILES["picture"]) ? fileUpload($_FILES["picture"]) : null;

        if ($_FILES["picture"]["error"] == 0) {
            if ($row["image"] != "user.png" && file_exists("pictures/" . $row["image"])) {
                unlink("pictures/" . $row["image"]);
            }
            $sql = "UPDATE users SET 
        first_name='$fname', 
        last_name='$lname',
        email='$email',
        phone='$phone',
        address='$address',
        image='{$picture[0]}'
        WHERE id=$id";
        } else {
            $sql = "UPDATE users SET 
        first_name='$fname', 
        last_name='$lname',
        email='$email',
        phone='$phone',
        address='$address'
        WHERE id=$id";
        }

        if (mysqli_query($connect, $sql)) {
            $_SESSION['profile_message'] = "Profile has been updated!";
            echo "<script>window . location . href = 'index.php'</script>";
        } else {
            echo "Error updating profile: " . mysqli_error($connect);
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
        <title>Update Profile</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }

            .buttons {
                display: flex;
                flex-direction: row;
                gap: 10px;
            }

            .width-btn-2 {
                width: 150px !important;
                height: 45px !important;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="text-align: center;"><i>Update user profile: <?php echo $row["email"] ?></i></h4>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name:</label>
                                            <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name:</label>
                                            <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone:</label>
                                            <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <textarea name="address" class="form-control" rows="3"><?php echo $row['address']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image:</label>
                                    <input type="file" name="picture" class="form-control">
                                    <small class="form-text text-muted">Upload a new profile image if you want to change it.</small>
                                </div>
                                <div style="display: flex;justify-content:center" class="buttons">
                                    <a style="text-decoration: none;" href="index.php" class="btn btn-outline-info width-btn-2">Back</a>
                                    <button type="submit" name="update" class="btn btn-primary  width-btn-2">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);

            document.addEventListener("keydown", function(e) {
                if (e.key == "F12") {
                    e.preventDefault();
                }
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
}
