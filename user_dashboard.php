<?php
session_start();
require('connect.php');


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `vacations` WHERE user_id='$user_id'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$vacations = mysqli_fetch_all($result, MYSQLI_ASSOC);

print_r($vacations);
?>

<a href="/epignosis_portal/create_vacation.php" > Create new vacation </a>

<?php
mysqli_free_result($result);

