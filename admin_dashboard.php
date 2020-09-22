<?php 
session_start();
// check if a logged in user requested that page, if not redirect to home page
if(!isset($_SESSION['user_id'])) {
    header("Location: /epignosis_portal/index.php");
    exit();
}
require('header.php');
require('connect.php');
require('functions.php');

// check if the logged in user is administrator. If not they should not see this page
if(!$_SESSION['is_admin']){
    echo "Cannot acces page. The Create Vacation page is for Admins";
    echo '</br> <a href="/epignosis_portal/user_dashboard.php">Go to user dashboard </a>';
    require('footer.php');
    die;
}


// retrieve all the users from the database in order to display them
$query = "SELECT * FROM `users`";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// create the users' table and display them
?>
<a id="new_user" href="/epignosis_portal/user.php" > Create new user </a>

<table class="portal-table users-table">
<thead>
    <tr>
        <th>User first name</th>
        <th>User last name</th>
        <th>User email</th>
        <th>User type</th>
    </tr>
</thead>
<tbody>
    <?php foreach($users as $user){
        // the link that will be requested when a user is clicked
        // as parameter is given the user id in order to populate the correct information

        $hashedKey = getUserHashFromId($user['id']) ;
        $userID = $hashedKey != null ? $hashedKey : $user['id'];
        $user_page = "/epignosis_portal/user.php?user=". $userID;


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
</tbody>
</table>

<?php
require('footer.php');