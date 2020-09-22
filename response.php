<?php
require('connect.php');
require('functions.php');


$acctepted = $_GET['accepted'] == 'yes' ?  'accepted' : 'rejected';
$request_id = $_GET['id'];

$request_id = getVacationIdFromHash($_GET['id']);
if($request_id == null){
    die("Invalid vacation request!");
}

$query = "SELECT * FROM `vacations` WHERE id=$request_id";
$request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$vacation_request = getRequestById($request_id);
if($vacation_request != NULL ){ // vacation reuqest found
    
    if($vacation_request->status == 'pending'){
        $date_submitted = $vacation_request->date_submitted;
        $employee_email = getEmployeeEmail($vacation_request->user_id);
        $responseText = createResponseText($acctepted, $date_submitted);
        updateRequestStatus($request_id, $acctepted);

        mail($employee_email, "Vacation Response", $responseText, 'From: vpxristop@gmail.com');
        echo "<script>window.close();</script>";
    }
    else{
        die("Vacation Request already answered! ");
    }
    
}
else{
    die("Invalid or duplicate Request Id!");
}

