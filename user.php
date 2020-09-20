<?php
require('header.php');
require('connect.php');
require('functions.php');

$user = getUserFromID($_GET['user']);
$isNewUser = $user->email =="";

if ( isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['email'])
 and isset($_POST['password']) and isset($_POST['confirm_password']) ){


    $password = crypt($_POST['password'], 'Hello-GFG');
    $confirm_password  = crypt($_POST['confirm_password'], 'Hello-GFG');
    if(!hash_equals($password, $confirm_password)){
        die("Passwords do not match!");
    }
    if(!$isNewUser && !hash_equals($password, $user->user_pass)){
        die("Wrong password!");
    }
    

    if(emailUsed($_POST['email'])){
        $query = "UPDATE `users`
        SET firstname='$_POST[firstname]', lastname='$_POST[lastname]', email='$_POST[email]',
        user_pass='$password'
        where id = $user->id";
    }
    else{
        $query = "INSERT INTO `users` (firstname, lastname, email, user_pass, is_admin) 
        VALUES ('$_POST[firstname]', '$_POST[lastname]', '$_POST[email]', '$password', '$_POST[user_type]')";            
    }      
    // update or create user!
    mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    header("Location:admin_dashboard.php"); //header to redirect
    die;
}
?>

<div class="create-user-form">
    <h1>
        <?php echo $isNewUser ? "Create new user" : "Edit User"  ?>
    </h1>
    <form action="" method="POST">
        <p><label>First Name</label>
        <input id="firstname" type="text" name="firstname" required  value="<?php echo $user->firstname; ?>"/></p>

        <p><label>Last Name&nbsp;&nbsp; : </label>
        <input id="lastname" type="text" name="lastname" required  value="<?php echo $user->lastname ?>" /></p>

        <p><label>Email&nbsp;&nbsp; : </label>
        <input id="email" type="text" name="email" required value="<?php echo $user->email ?>" /></p>

        <p><label>Password&nbsp;&nbsp; : </label>
        <input id="password" type="password" name="password" required/></p>

        <p><label> Confirm Password&nbsp;&nbsp; : </label>
        <input id="confirm_password" type="password" name="confirm_password" required /></p>

        <p><label> User type&nbsp;&nbsp; : </label>
        <select name="user_type" id="user_type">
            <option value="0" <?php echo $user->is_admin ? "" : "selected"; ?>>Employee</option>
            <option value="1"<?php echo $user->is_admin ? "selected" : ""; ?>>Admin</option>
        </select> 
        <input class="btn" type="submit" name="submit" value="Submit" />
    </form>
</div>

<?php
require('footer.php');