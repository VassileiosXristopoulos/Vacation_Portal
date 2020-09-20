<?php 
session_start();
require('header.php');
require('connect.php');
require('functions.php');

$query = "SELECT * FROM `users`";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$users = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>
<a href="/epignosis_portal/user.php?user=new_user" > Create new user </a>

<table style="width:50%">
<tr>
    <th>User first name</th>
    <th>User last name</th>
    <th>User email</th>
    <th>User type</th>
</tr>

<?php //TODO: Make row clickable and redirect via javascript! ?>
<?php foreach($users as $user){
    $user_page = "/epignosis_portal/user.php?user=". $user['id'];
    ?>
    
    <tr>
        <th>
            <a href="<?php echo $user_page ?>">
                <?php echo $user['firstname']; ?>
            </a>
        </th>
        <th>
            <a href="<?php echo $user_page ?>">
                <?php echo $user['lastname']; ?>
            </a>
        </th>
        <th>
            <a href="<?php echo $user_page ?>">
                <?php echo $user['email']; ?>
            </a>
        </th>
        <a href="<?php echo $user_page ?>">
            <th><?php echo $user['is_admin'] == 1 ? "admin" : "employee"; ?></th>
        </a>
    </tr>
    

<?php } ?>
</table>

<?php
require('footer.php');