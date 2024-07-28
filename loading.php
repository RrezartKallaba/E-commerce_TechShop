<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
} else {
    header("refresh: 4; url=index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Russo+One&display=swap");

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        svg {
            font-family: "Russo One", sans-serif;
            width: 100%;
            height: 100%;
        }

        svg text {
            animation: stroke 4s alternate;
            stroke-width: 2;
            fill: rgba(38, 88, 139, 1);
            stroke: #365FA0;
            font-size: 100px;
        }

        @keyframes stroke {
            0% {
                fill: rgba(38, 88, 139, 0);
                stroke: rgba(54, 95, 160, 1);
                stroke-dashoffset: 25%;
                stroke-dasharray: 0 50%;
                stroke-width: 2;
            }

            70% {
                fill: rgba(38, 88, 139, 0);
                stroke: rgba(54, 95, 160, 1);
            }

            80% {
                fill: rgba(38, 88, 139, 0);
                stroke: rgba(54, 95, 160, 1);
                stroke-width: 3;
            }

            100% {
                fill: rgba(38, 88, 139, 1);
                stroke: rgba(54, 95, 160, 0);
                stroke-dashoffset: -25%;
                stroke-dasharray: 50% 0;
                stroke-width: 0;
            }
        }

        .wrapper {
            background-color: #FFFFFF;
            width: 100%;
        }

        @media(max-width: 600px) {
            svg text {
                font-size: 70px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <svg>
            <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                TechShop
            </text>
        </svg>
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