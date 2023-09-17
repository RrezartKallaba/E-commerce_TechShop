<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

            * {
                font-family: "Poppins", sans-serif;
            }

            .left-column {
                width: 20%;
                border-right: 1px solid #ccc;
                padding: 20px;
                height: 100%;
                position: fixed;
                top: 0;
                left: 0;
                display: block;
            }

            .right-column {
                width: 75%;
                padding: 20px;
                margin-left: 20%;
            }

            .menu {
                position: fixed;
                display: block;
                top: 0;
                left: 0;
                background-color: #fff;
                width: 20%;
                border-right: 1px solid #ccc;
                padding: 20px;
                height: 100%;
            }

            .sidebar-menu {
                list-style: none;
                padding: 0;
            }

            .sidebar-menu li {
                margin-bottom: 10px;
            }

            .sidebar-menu li a {
                display: block;
                padding: 5px;
                background-color: #f7f7f7;
                color: #333;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .sidebar-menu li a:hover {
                background-color: #e0e0e0;
            }

            .page-content {
                background-color: #f7f7f7;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-bottom: 20px;
            }

            .sidebar-menu li.active a {
                background-color: rgb(17, 119, 209);
                color: white;
            }

            @media (min-width: 1200px) {

                .container,
                .container-lg,
                .container-md,
                .container-sm,
                .container-xl {
                    max-width: 1350px !important;
                }
            }

            @media (max-width: 900px) {

                /* 
                *CSS për ekrane me gjerësi maksimale 600px */
                .left-column {
                    width: 100%;
                    height: 0% !important;
                    z-index: 999;
                }

                .menu {
                    width: 100%;
                    display: none;
                    overflow: auto;
                }

                .menu-icon {
                    display: block !important;
                    position: fixed;
                    top: 1%;
                    right: 5%;
                    width: 60px;
                    height: 50px;
                    font-size: 2em;
                    color: #000;
                    cursor: pointer;
                    z-index: 1;
                    background-color: white;
                    border-radius: 10px;
                    border: 1px solid gray;
                }

                .menu-icon .icon-close {
                    display: none;
                }

                .right-column {
                    width: 100%;
                    margin-left: 0;
                }



                .sidebar-menu {
                    padding-left: 0;
                }

                .sidebar-menu li {
                    margin-bottom: 5px;
                }

                .sidebar-menu li a {
                    padding: 10px;
                    text-align: center;
                }

                /* 
                *Stilizimi i faqes products */
                .hidden_for_phone {
                    display: none !important;
                }

                .card-img-top {
                    height: auto !important;
                    max-height: 300px !important;
                }

                /*
                * Mbarimi i stilizimit te faqes products */
            }
        </style>
    </head>

    <body>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'users';

        // The function that will check if the link is active and add the "active" class
        function isActive($currentPage, $pageName)
        {
            // if ($currentPage === $pageName) {
            //     echo ' active';
            // }
            if ($currentPage === $pageName || ($pageName === 'animals' && $currentPage === 'update_animal') || ($pageName === 'animals' && $currentPage === 'details_animal')) {
                echo 'active';
            }
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col left-column">
                    <nav id="myLinks" class="menu">
                        <h3>Dashboard</h3>
                        <br>
                        <ul class="sidebar-menu">
                            <li class="<?php isActive($page, 'users'); ?>"><a href="?page=users">Users</a></li>
                            <li class="<?php isActive($page, 'create_user'); ?>"><a href="?page=create_user">Create a user</a></li>
                            <li class="<?php isActive($page, 'products'); ?>"><a href="?page=products">Products</a></li>
                            <li class=" <?php isActive($page, 'create_product'); ?>"><a href="?page=create_product">Create a product</a></li>
                            <li class="<?php isActive($page, 'statistics'); ?>"><a href="?page=statistics">Statistics</a></li>
                            <li class="<?php isActive($page, 'profile'); ?>"><a href="?page=profile">Profile</a></li>
                            <li><a href="#" onclick="konfirmoDaljen()">Logout</a></li>
                            <script>
                                function konfirmoDaljen() {
                                    if (window.confirm("Are you sure you want to logout?")) {
                                        window.location.href = "../validate/logout.php";
                                    } else {
                                        // Do nothing
                                    }
                                }
                            </script>
                        </ul>
                    </nav>
                    <button class="menu-icon" onclick="toggleMenu()">
                        <span class="icon-hamburger">&#9776;</span>
                        <span class="icon-close">&#10006;</span>
                    </button>
                </div>

                <div class="col right-column">
                    <?php
                    if ($page === 'users') {
                        include "users.php";
                    } elseif ($page === 'products') {
                        include "products.php";
                    } elseif ($page === 'profile') {
                        include "profile.php";
                    } elseif ($page === 'create_product') {
                        include "create_product.php";
                    } elseif ($page === 'create_user') {
                        include "create_user.php";
                    } elseif ($page === 'details_reviews') {
                        include "details_reviews.php";
                    } elseif ($page === 'statistics') {
                        include "statistics.php";
                    } elseif ($page === 'update_product') {
                        // Check if the "product_id" query parameter is set
                        if (isset($_GET['product_id'])) {
                            // Include "update_animal.php" and pass the "product_id" to the included file
                            $product_id = $_GET['product_id'];
                            include "update_product.php";
                        } else {
                            // Redirect or display an error message if "product_id" is not provided
                            echo "Error: Product ID not provided.";
                        }
                    } elseif ($page === 'details_product') {
                        // Check if the "product_id" query parameter is set
                        if (isset($_GET['product_id'])) {
                            // Include "update_animal.php" and pass the "product_id" to the included file
                            $product_id = $_GET['product_id'];
                            include "details_product.php";
                        } else {
                            // Redirect or display an error message if "product_id" is not provided
                            echo "Error: Product ID not provided.";
                        }
                    } elseif ($page === 'update_users') {
                        // Check if the "product_id" query parameter is set
                        if (isset($_GET['id'])) {
                            // Include "update_animal.php" and pass the "product_id" to the included file
                            $id = $_GET['id'];
                            include "update_users.php";
                        } else {
                            // Redirect or display an error message if "product_id" is not provided
                            echo "Error: Product ID not provided.";
                        }
                    } elseif ($page === 'details_users') {
                        // Check if the "product_id" query parameter is set
                        if (isset($_GET['id'])) {
                            // Include "update_animal.php" and pass the "product_id" to the included file
                            $product_id = $_GET['id'];
                            include "details_users.php";
                        } else {
                            // Redirect or display an error message if "product_id" is not provided
                            echo "Error: Product ID not provided.";
                        }
                    } else {
                        // default
                        include "users.php";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="../main.js"></script>
    </body>

    </html>
<?php
} else if (isset($_SESSION["user"])) {
    header("location:../home.php");
} else {
    header("Location: ../login.php");
}
