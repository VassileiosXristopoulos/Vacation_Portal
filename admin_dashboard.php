<?php 
session_start();
require('connect.php');
require('functions.php');


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `users`";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>



<table style="width:50%">
<tr>
    <th>User first name</th>
    <th>User last name</th>
    <th>User email</th>
    <th>User type</th>
</tr>
<?php foreach($users as $user){ ?>

    <tr>
    <th><?php echo $user['firstname']; ?></th>
    <th><?php echo $user['lastname']; ?></th>
    <th><?php echo $user['email']; ?></th>
    <th><?php echo $user['is_admin'] == 1 ? "admin" : "employee"; ?></th>
</tr>

<?php } ?>
</table>
