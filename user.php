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

// get the actual user id from the hashed value
$user = isset($_GET['user']) ? getUserIdFromHash($_GET['user']) : null; 

// retrieve the user object from the database
$user = getUserFromID($user);

$isNewUser = $user->email ==""; // email cannot be blank at registered user

// if the user form is set
if ( isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['email'])
 and isset($_POST['password']) and isset($_POST['confirm_password']) ){


    // encrypt the passwords given in order to save them in the database
    $password = crypt($_POST['password'], 'Hello-GFG');
    $confirm_password  = crypt($_POST['confirm_password'], 'Hello-GFG');

    
    if($isNewUser && emailUsed($_POST['email'])){ // check if the email given for the user is already used
        $error_msg = "This email is already used by another user!";
    }
    else if(!hash_equals($password, $confirm_password)){ // check if the passwords match
        $error_msg =  "Passwords do not match!";
    }
    else if(!$isNewUser && !hash_equals($password, $user->user_pass)){ // if not new user, check if the password given is corrent
        $error_msg = "Wrong password!" ;
    }
    else{ // if all information given is valid, update the database
        if(!$isNewUser){ // the user is already registered, update their information
            $query = "UPDATE `users`
            SET firstname='$_POST[firstname]', lastname='$_POST[lastname]', email='$_POST[email]',
            user_pass='$password'
            where id = $user->id";
            mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
        }
        else{ // the user is new, create the user entry
            $query = "INSERT INTO `users` (firstname, lastname, email, user_pass, is_admin) 
            VALUES ('$_POST[firstname]', '$_POST[lastname]', '$_POST[email]', '$password', '$_POST[user_type]')";            
            mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
            
            $user_id = mysqli_insert_id($mysqli);

             /* Save to hashed users the hash id for identifying the user id */
            $hash_id = unique_user_code();
            $query = "INSERT INTO `hashed_users` (user_id, hashed_id) 
                    VALUES ($user_id, '$hash_id')";
            mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
        }      
            
        header("Location:admin_dashboard.php"); //header to redirect
        die;
    }
    
}
?>

<div class="create-user-form">
    <h1>
        <?php echo $isNewUser ? "Create new user" : "Edit User"  ?>
    </h1>
    <div class="error-msg"> <?php echo isset($error_msg) ? $error_msg : ""  ?> </div>
    <form action="" method="POST">
        <p><label>First Name</label>
        <input id="firstname" type="text" name="firstname" required  value="<?php echo isset($_POST['firstname'])? $_POST['firstname'] : $user->firstname; ?>"/></p>

        <p><label>Last Name</label>
        <input id="lastname" type="text" name="lastname" required  value="<?php echo isset($_POST['lastname'])? $_POST['lastname'] : $user->lastname ?>" /></p>

        <p><label>Email</label>
        <input id="email" type="text" name="email" required value="<?php echo isset($_POST['email'])? $_POST['email'] :  $user->email ?>" /></p>

        <p><label>Password</label>
        <input id="password" type="password" name="password" required/></p>

        <p><label> Confirm Password</label>
        <input id="confirm_password" type="password" name="confirm_password" required /></p>

        <p><label> User type </label>
        <select name="user_type" id="user_type">
            <option value="0" <?php echo $user->is_admin ? "" : "selected"; ?>>Employee</option>
            <option value="1"<?php echo $user->is_admin ? "selected" : ""; ?>>Admin</option>
        </select> 
        </p>
        <div id="submit-btn">
            <input class="btn" type="submit" name="submit" value="Submit" />
        </div>
    </form>
</div>

<?php
require('footer.php');