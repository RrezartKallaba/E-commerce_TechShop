<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .dangerUserNotLoggedIn {
            border: 1px solid #c3e6cb;
            border-radius: 7px;
            top: 80px;
            position: fixed;
            padding: 10px;
            margin-bottom: 10px;
            z-index: 99;
            width: 400px;
            text-align: center;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
        }

        .dangerUserNotLoggedIn.alert-dangerUserNotLoggedIn {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .dangerUserNotLoggedIn.alert-dangerUserNotLoggedIn p {
            margin-bottom: 0;
        }

        .dangerUserNotLoggedIn.alert-dangerUserNotLoggedIn a {
            color: #491217;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div style="display: none;" id='UserNotLoggedIn' class='dangerUserNotLoggedIn alert-dangerUserNotLoggedIn'>
        <p id="UserNotLoggedIn" style='margin: 0px; font-size: 17px;'>You need to login first!</p>
    </div>
    <script>
        function UserNotLoggedIn() {
            var errorElement = document.getElementById("UserNotLoggedIn");
            errorElement.style.display = "block"; // Show the error message

            setTimeout(function() {
                errorElement.style.display = "none"; // Hide the error message after 8 seconds
            }, 6000);
        }
    </script>
</body>

</html>