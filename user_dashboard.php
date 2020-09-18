<?php
session_start();
require('connect.php');


$email = $_SESSION['username'];
$query = "SELECT * FROM `users` WHERE email='$email'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
print_r($result);

