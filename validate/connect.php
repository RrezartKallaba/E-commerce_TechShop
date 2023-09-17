<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "techshop";

$connect = mysqli_connect($host, $username, $password, $dbname);
mysqli_set_charset($connect, "UTF8");
// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
