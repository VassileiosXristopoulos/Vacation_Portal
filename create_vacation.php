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
if($_SESSION['is_admin']){
    echo "Cannot acces page. The Create Vacation page is for Employees";
    echo '</br> <a href="/epignosis_portal/admin_dashboard.php">Go to admin dashboard </a>';
    require('footer.php');
    die;
}

$user_id = $_SESSION['user_id'];
$user_email  = $_SESSION['email'];
$fullname = $_SESSION['fullname'];
// if form is submitted
if ( isset($_POST['datefrom']) and isset($_POST['dateto']) ){
    $datefrom = $_POST['datefrom'];
    $dateto = $_POST['dateto'];
    $reason = $_POST['reason'];   
    $todays_date = date('Y-m-d');

    // Check that dates given are valid
    if(! (strtotime($dateto)- strtotime($datefrom) > 0 &&
        strtotime($datefrom) - strtotime($todays_date) > 0) ){
            $error_msg = "Error: Invalid request dates!";
    }
    else{
        // save the vacation request to the database
        $query = "INSERT INTO `vacations` (user_id, date_submitted, date_from, date_to, reason, status) 
        VALUES ($user_id, DATE '$todays_date', DATE '$datefrom', DATE '$dateto', '$reason','pending')";
        mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

        // retrieve the vacation_id of the vacation request just submitted
        $request_id = mysqli_insert_id($mysqli);


        /* Save to hashed vacations the hash id for identifying the vacation request */
        $hash_id = unique_vacation_code();
        $query = "INSERT INTO `hashed_vacations` (vacation_id, hash_id) 
                VALUES ($request_id, '$hash_id')";
        mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));


        // retrieve all the supervisor in order to send the email to all of them
        // whoever responds first gets to define the status of the request
        $supervisors = getSupervisors();
        if($supervisors != NULL){
            $text = createRequestText($fullname, $datefrom, $dateto, $reason , $hash_id); 

            // send email to all supervisors
            foreach($supervisors as $supervisor){
                mail($supervisor['email'], "Vacation Request", $text, 'From: supervisor');
            }    
        }
        else{
            die("Unexpected error: Admin account not found!");
        }


        // the email is sent to the supervisor. Redirect to user's dashboard
        header("Location:user_dashboard.php"); //header to redirect
        die;
    }
    
}

// form for creating a new vacation Request
?>
<div class="create-vacation-form">
    <h1>New Vacation Request</h1>
    <div class="error-msg"> <?php echo isset($error_msg) ? $error_msg : ""  ?> </div>
    <form action="" method="POST">
        <p><label>Date From (Y-m-d)</label>
        <input id="datefrom" type="text" name="datefrom" required /></p>

        <p><label>Date To (Y-m-d)</label>
        <input id="dateto" type="text" name="dateto" required/></p>

        <p><label>Reason</label>
        <input id="reason" type="text" name="reason"/></p>

        <div class="create-vacation-button">
            <input class="btn" type="submit" name="submit" value="Submit" />
        </div>
        
    </form>
</div>

<?php
require('footer.php');