<?php  //Start the Session
session_start();
require('connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
    //3.1.1 Assigning posted values to variables.
    $username = $_POST['username'];
    $password = $_POST['password'];
    //3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";

    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    $count = mysqli_num_rows($result);
    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        $_SESSION['username'] = $username;
        header("Location:redirectafterlogin.php"); //header to redirect, but doesnt work
    }
    else{
    //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
    echo "Invalid Login Credentials.";
    }

}

?>  