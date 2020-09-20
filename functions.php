<?php
//TODO: Document all functions
function getDatesDifference($date1, $date2){
    $dateDiff = strtotime($date2)- strtotime($date1);
    return round($dateDiff / (60 * 60 * 24));
}
function getSupervisors(){
    require('connect.php');
    $supervisors = NULL;

    $query = "SELECT * FROM `users` WHERE is_admin='1'";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    if(mysqli_num_rows($result) > 0){
        $supervisors =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $supervisors;
}

function getEmployeeEmail($user_id){
    require('connect.php');
    $employee_email = "";

    $query = "SELECT * FROM `users` WHERE id=$user_id";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    if(mysqli_num_rows($result) == 1 ){ // user found
        $employee_email = $result->fetch_object()->email;
    }
    return $employee_email;
}

function createRequestText($fullname, $datefrom, $dateto, $reason , $request_id){
    return "Dear supervisor, employee ". $fullname. " requested some time off
    starting on ". $datefrom . " and ending on ". $dateto . ", stating the reason:" .$reason .
    ". Click on one of the bellow links to approve or reject the application
    http://localhost/epignosis_portal/response.php?id=" . $request_id . "&accepted=yes
    http://localhost/epignosis_portal/response.php?id=". $request_id . "&accepted=no";      
}

function createResponseText($acctepted, $date_submitted){
    return "Dear employee, your supervisor has ". $acctepted .
    " your application submitted on " .$date_submitted;
}

function updateRequestStatus($request_id, $status){
    require('connect.php');
    $query = "UPDATE `vacations` SET status='$status' where id=$request_id";
    mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
}


function getRequestById($request_id){
    require('connect.php');
    $ret = NULL;

    $query = "SELECT * FROM `vacations` WHERE id=$request_id";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    if(mysqli_num_rows($request) == 1 ){ // vacation reuqest found
        $ret = $request->fetch_object();
    }

    return $ret;
}

function getUserFromEmail($email){
    require('connect.php');
    $user = (object)array(
        'firstname' => "",
        'lastname' => "",
        'email' => "",
        'user_pass' => "",
        'is_admin' =>""
    );


    $query = "SELECT * FROM `users` WHERE email='$email'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if(mysqli_num_rows($request) == 1){
        $user = $request->fetch_object();
    }

    return $user;
}

function getUserFromID($id){
    require('connect.php');
    $user = (object)array(
        'firstname' => "",
        'lastname' => "",
        'email' => "",
        'user_pass' => "",
        'is_admin' =>""
    );


    $query = "SELECT * FROM `users` WHERE id='$id'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if(mysqli_num_rows($request) == 1){
        $user = $request->fetch_object();
    }

    return $user;
}


function emailUsed($email){
    require('connect.php');

    $query = "SELECT * FROM `users` WHERE email='$email'";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    $count = mysqli_num_rows($result);
    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    return $count == 1;
}


function passwordsEqual($password1, $password2){
    $hashed_password = crypt($password1); // let the salt be automatically generated
    
    return hash_equals($hashed_password, crypt($password2, $hashed_password));
}