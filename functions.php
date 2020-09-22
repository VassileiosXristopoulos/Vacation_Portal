<?php
//TODO: Document all functions

/**
 * Given 2 dates at string format, computes and returns their difference in days
 */
function getDatesDifference($date1, $date2){
    $dateDiff = strtotime($date2)- strtotime($date1);
    return round($dateDiff / (60 * 60 * 24));
}

/**
 * Returns an array with all the supervisors of the application
 */
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

/**
 * Gets an employee id and returns their email
 */
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

/**
 * Creates the text that will be included in the email for vacation request
 */
function createRequestText($fullname, $datefrom, $dateto, $reason , $request_id){
    return "Dear supervisor, employee ". $fullname. " requested some time off starting on ". $datefrom . " and ending on ". $dateto . ", stating the reason:" .$reason .
    ". Click on one of the bellow links to approve or reject the application
    http://localhost/epignosis_portal/response.php?id=" . $request_id . "&accepted=yes
    http://localhost/epignosis_portal/response.php?id=". $request_id . "&accepted=no";      
}

/**
 * Creates the text that will be included in the email for accepting/rejecting a vacation request
 */
function createResponseText($acctepted, $date_submitted){
    return "Dear employee, your supervisor has ". $acctepted .
    " your application submitted on " .$date_submitted;
}

/**
 * Updates the status of a vacation request depending on the admin's response
 */
function updateRequestStatus($request_id, $status){
    require('connect.php');
    $query = "UPDATE `vacations` SET status='$status' where id=$request_id";
    mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
}

/**
 * Given a vacation request id, returns the vacation request object from the database
 */
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


/**
 * Returns a user object from their ID. If ID is null, an empty user object is returned
 */
function getUserFromID($id){
    require('connect.php');
    $user = (object)array(
        'firstname' => "",
        'lastname' => "",
        'email' => "",
        'user_pass' => "",
        'is_admin' =>""
    );


    if($id != null){
        $query = "SELECT * FROM `users` WHERE id='$id'";
        $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    
        if(mysqli_num_rows($request) == 1){
            $user = $request->fetch_object();
        }
    }

    return $user;
}

/**
 * Finds if a certain email is used by a user
 */
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
/**
 * Returns a unique key for a vacation id
 */
function unique_vacation_code(){
  require('connect.php');
  $limit = 20;
  $found = false;
  $new_hashKey = "";
  do{
      // generate key and then check if the same key is generated again (uncertain - corner case)
    // if the generated key is unique, return it
    $new_hashKey = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 20);
    $query = "SELECT * FROM `hashed_vacations` WHERE hash_id='$new_hashKey'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    $found = mysqli_num_rows($request) > 0;
  }while($found);
  return $new_hashKey;
}
/**
 * Returns a unique key for a user id
 */
function unique_user_code(){
    require('connect.php');
    $limit = 20;
    $found = false;
    $new_hashKey = "";
    // generate key and then check if the same key is generated again (uncertain - corner case)
    // if the generated key is unique, return it
    do{
      $new_hashKey = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 20);
      $query = "SELECT * FROM `hashed_users` WHERE hashed_id='$new_hashKey'";
      $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
      $found = mysqli_num_rows($request) > 0;
    }while($found);
    return $new_hashKey;
  }


function getVacationIdFromHash($hash){
    require('connect.php');

    $id = null;

    $query = "SELECT * FROM `hashed_vacations` WHERE hash_id='$hash'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if(mysqli_num_rows($request) == 1){
        $id = $request->fetch_object()->vacation_id;
    }
    // TODO: What if error occurs and we have more than 1 hash??

    return $id;
}

function getUserIdFromHash($hash){
    require('connect.php');

    $id = null;

    $query = "SELECT * FROM `hashed_users` WHERE hashed_id='$hash'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if(mysqli_num_rows($request) == 1){
        $id = $request->fetch_object()->user_id;
    }

    return $id;
}



function getUserHashFromId($id){
    require('connect.php');

    $hash_key = null;

    $query = "SELECT * FROM `hashed_users` WHERE user_id='$id'";
    $request = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    if(mysqli_num_rows($request) == 1){
        $hash_key = $request->fetch_object()->hashed_id;
    }

    return $hash_key;

}