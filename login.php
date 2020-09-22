<?php  //Start the Session
session_start();

require('connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
    //3.1.1 Assigning posted values to variables.
    $email = $_POST['username'];
    //passwords are always enrypted
    $password = crypt($_POST['password'], 'Hello-GFG');
  
    //Checking the values are existing in the database or not
    $query = "SELECT * FROM `users` WHERE email='$email' and user_pass='$password'";

    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    $count = mysqli_num_rows($result);
    //If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        $user = $result->fetch_object();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = $user->firstname . " ". $user->lastname;
        $_SESSION['is_admin'] = $user->is_admin;

        if($user->is_admin){
            header("Location:admin_dashboard.php"); //header to redirect to admin page
        }
        else{
            header("Location:user_dashboard.php"); //header to redirect to user page
        }
        die;
        
    }
    else{
        //If the login credentials doesn't match, he will be shown with an error message.
        echo "Invalid Login Credentials.";
    }

}

?>  