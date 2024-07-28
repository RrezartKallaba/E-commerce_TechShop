<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>TechShop</title>
  <style>
    .order.order-success {
      color: #155724;
      background-color: #d4edda;
      border-color: #c3e6cb;
    }

    .order {
      border: 1px solid #c3e6cb;
      border-radius: 7px;
      top: 80px;
      position: absolute;
      padding: 10px;
      margin-bottom: 10px;
      z-index: 99;
      width: 400px;
      text-align: center;
      left: 50%;
      transform: translateX(-50%);
    }

    .order.order-success p {
      margin-bottom: 0;
    }

    .order.order-success a {
      color: #0b2e13;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <?php include "includes/nav.php" ?>
  <?php
  if (isset($_SESSION['profile_message'])) {
    echo "<div id='success-alert' class='order order-success'>
      <p style='margin: 0px; font-size: 17px'>" . $_SESSION['profile_message'] . "</p>
  </div>";
    unset($_SESSION['profile_message']);
  }
  if (isset($_SESSION['profile_delete'])) {
    echo "<div id='success-alert' class='order order-success'>
      <p style='margin: 0px; font-size: 17px'>" . $_SESSION['profile_delete'] . "</p>
  </div>";
    unset($_SESSION['profile_delete']);
  }
  if (isset($_SESSION['contact_form'])) {
    echo "<div id='success-alert' class='order order-success'>
      <p style='margin: 0px; font-size: 17px'>" . $_SESSION['contact_form'] . "</p>
  </div>";
    unset($_SESSION['contact_form']);
  }
  ?>
  <script>
    setTimeout(function() {
      var successAlert = document.getElementById('success-alert');
      if (successAlert) {
        successAlert.style.display = 'none';
      }
    }, 3000); // 3000 milliseconds = 3 seconds
  </script>
  <section id="home" class="home">
    <?php include "validate/alerts.php" ?>
    <h1>The best offers in all of Kosova!</h1>
    <h6>20% discount on all products</h6>
  </section>
  <span id="about2"></span>
  <br><br>
  <section id="about" class="about">
    <h1>About us</h1>
    <p>We are a company with a simple goal - to provide our customers with quality products and service
      great In particular, we specialize in the sale of electronic products such as telephones
      cell phones,
      laptops and other devices.
      <br><br>
      In today's times, one of the main challenges for customers of electronic products is to find a business
      reliable and reasonably priced.
      <br><br>
      In addition to offering a wide product inventory and reasonable prices our dedicated staff works without
      break to answer questions and
      customer requirements.
      <br><br>
      <span id="tit" style="display: hidden;"></span>
      So, if you are looking for high quality electronic products we are the right company for you.
    </p>
  </section>

  <footer>©2023 Tech Shop</footer>
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
  <script src="main.js"></script>
</body>

</html>