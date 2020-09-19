<?php
session_start();
require('connect.php');
require('functions.php');

$user_id = $_SESSION['user_id'];
$user_email  = $_SESSION['email'];
$fullname = $_SESSION['fullname'];

if ( isset($_POST['datefrom']) and isset($_POST['dateto']) ){
    $datefrom = $_POST['datefrom'];
    $dateto = $_POST['dateto'];
    $reason = $_POST['reason'];   
    $todays_date = date('Y-m-d');

    //TODO: what to do if no supervisor
    
    $query = "INSERT INTO `vacations` (user_id, date_submitted, date_from, date_to, reason, status) 
                VALUES ($user_id, DATE '$todays_date', DATE '$datefrom', DATE '$dateto', '$reason','pending')";

    mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    $request_id = mysqli_insert_id($mysqli);
    $supervisor_email = getSupervisorEmail();
    $text = createRequestText($fullname, $datefrom, $dateto, $reason , $request_id); 
        
    mail($supervisor_email, "Vacation Request", $text, 'From: vpxristop@gmail.com');

    header("Location:user_dashboard.php"); //header to redirect
    die;
}
?>

<div class="create-vacation-form">
    <h1>Submit new Vacation Request</h1>
    <form action="" method="POST">
        <p><label>Date From : </label>
        <input id="datefrom" type="text" name="datefrom" required /></p>

        <p><label>Date To&nbsp;&nbsp; : </label>
        <input id="dateto" type="text" name="dateto" required/></p>

        <p><label>Reason&nbsp;&nbsp; : </label>
        <input id="reason" type="text" name="reason"/></p>

        <input class="btn" type="submit" name="submit" value="Submit" />
    </form>
</div>