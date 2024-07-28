<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
    require "../file_uploadRegister.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form field values
        $user_id = $_POST["user_id"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $picture = fileUpload($_FILES["picture"]);

        // Perform any input validation if required.

        // Update the user's profile in the database
        $sql = "UPDATE users SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                email = '$email', 
                phone = '$phone', 
                address = '$address',
                image = '$picture[0]'
            WHERE id = $user_id";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo "<div class='alert alert-success' role='alert'>
        Profile has ben updated</div>";
            echo "<script>window . location . href = 'dashboard.php?page=profile'</script>";
            exit;
        } else {
            // Handle errors if the update fails.
            echo "Error updating profile. Please try again.";
        }
    }
    $user_id = $_SESSION["admin"];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>Profile Update</title>
        <style>
            .btn {
                width: 140px !important;
            }

            .buttons-profile {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="text-align: center;">Update Profile</h4>
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
                                    <textarea name="address" class="form-control"><?php echo $row['address']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image:</label>
                                    <input type="file" name="picture" class="form-control">
                                    <small class="form-text text-muted">Upload a new profile image if you want to change it.</small>
                                </div>
                                <div class="buttons-profile" style="display: flex;justify-content: center;gap: 10px;">
                                    <a href="dashboard.php?page=users" class="btn btn-outline-info width-btn-2" style="background-color: #0dcaf0;color: black">Back</a>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else if (isset($_SESSION["user"])) {
    header("location:../index.php");
} else {
    header("Location: ../login.php");
}
