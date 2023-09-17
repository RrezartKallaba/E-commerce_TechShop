<?php
require "../validate/connect.php"; // Adjust the path to your connection file

// Calculate total number of orders
$query_total_orders = "SELECT COUNT(*) as total_orders FROM orders";
$result_total_orders = mysqli_query($connect, $query_total_orders);
$row_total_orders = mysqli_fetch_assoc($result_total_orders);
$total_orders = $row_total_orders['total_orders'];

// Calculate total revenue
$query_total_revenue = "SELECT SUM(totalprice) as total_revenue FROM orders";
$result_total_revenue = mysqli_query($connect, $query_total_revenue);
$row_total_revenue = mysqli_fetch_assoc($result_total_revenue);
$total_revenue = $row_total_revenue['total_revenue'];

// Calculate average order value
$average_order_value = $total_orders > 0 ? $total_revenue / $total_orders : 0;

$sql_cash = "SELECT COUNT(*) AS total_cash_sales FROM orders WHERE payment = 'Cash'";
$result_cash = mysqli_query($connect, $sql_cash);
$row_cash = mysqli_fetch_assoc($result_cash);
$totalCashSales = $row_cash['total_cash_sales'];

$sql_card = "SELECT COUNT(*) AS total_card_sales FROM orders WHERE payment = 'Card'";
$result_card = mysqli_query($connect, $sql_card);
$row_card = mysqli_fetch_assoc($result_card);
$totalCardSales = $row_card['total_card_sales'];

?>

<?php
if (isset($_SESSION["admin"])) {
    require "../validate/connect.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .statistics-container {
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                padding: 30px;
                text-align: center;
                width: 500px;
                /* Gjerësia e rregulluar */
                margin: auto;
                /* Vendosja në qendër */
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .statistics-title {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .statistic-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .statistic-label {
                font-weight: bold;
                color: #333333;
            }

            .statistic-value {
                font-size: 18px;
                color: #008CBA;
            }

            .statistic-icon {
                font-size: 24px;
                color: #008CBA;
                margin-right: 10px;
            }

            @media(max-width: 600px) {
                .statistics-container {
                    width: auto !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="statistics-container">
            <div class="statistics-title">Statistics Overview</div>
            <div class="statistic-item">
                <div class="statistic-label">Number of Orders</div>
                <div class="statistic-value"><?php echo $total_orders ?></div>
            </div>
            <div class="statistic-item">
                <div class="statistic-label">Cash Sales</div>
                <div class="statistic-value"><?php echo $totalCashSales ?></div>
            </div>
            <div class="statistic-item">
                <div class="statistic-label">Card Sales</div>
                <div class="statistic-value"><?php echo $totalCardSales ?></div>
            </div>
            <div class="statistic-item">
                <div class="statistic-label">Average Order Value</div>
                <div class="statistic-value"><?php echo number_format($average_order_value, 2) ?></div>
            </div>
            <div class="statistic-item">
                <div class="statistic-label">Total Revenue</div>
                <div class="statistic-value"><?php echo number_format($total_revenue, 2) ?></div>
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
