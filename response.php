<?php
require('connect.php');
require('functions.php');

// define the response text depending on the GET variables
$acctepted = $_GET['accepted'] == 'yes' ?  'accepted' : 'rejected';
// retrieve the vacation id (hashed) from the GET request
$request_id = $_GET['id'];

// retrieve the actual vacation id from the database
$request_id = getVacationIdFromHash($_GET['id']);
if($request_id == null){
    die("Invalid vacation request!");
}

// gets the vacation request from the database
$vacation_request = getRequestById($request_id);
if($vacation_request != NULL ){ // vacation request found
    
    // if status of request is pending, change it
    if($vacation_request->status == 'pending'){
        $date_submitted = $vacation_request->date_submitted;
        $employee_email = getEmployeeEmail($vacation_request->user_id);
        $responseText = createResponseText($acctepted, $date_submitted);
        updateRequestStatus($request_id, $acctepted);

        mail($employee_email, "Vacation Response", $responseText, 'From: vpxristop@gmail.com');
        echo "<script>window.close();</script>";
    }
    else{ // Do nothing for already answered requests
        die("Vacation Request already answered! ");
    }
    
}
else{
    die("Invalid or duplicate Request Id!");
}

