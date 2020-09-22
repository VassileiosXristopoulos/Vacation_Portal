<?php
session_start();

require('constants.php');
require('header.php');
require('connect.php');
require('functions.php');

// check if a logged in user requested that page, if not redirect to home page
if(!isset($_SESSION['user_id'])) {
    header("Location: /".$currentDir."/index.php");
    exit();
}

// check if the logged in user is employee. If not they should not see this page
if($_SESSION['is_admin']){
    echo "Cannot acces page. The Create Vacation page is for Employees";
    echo '</br> <a href="/'.$currentDir.'/admin_dashboard.php">Go to admin dashboard </a>';
    require('footer.php');
    die;
}

//retrieve all the vacation requests a user has submitted
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `vacations` WHERE user_id='$user_id'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$vacations = mysqli_fetch_all($result, MYSQLI_ASSOC);
// display the vacation requests of the user
?>
 <table class="portal-table vacations-table">
 <thead>
    <tr>
        <th>Date Submitted</th>
        <th>Date From</th>
        <th>Date To</th>
        <th>Days requested</th>
        <th>Status</th>
    </tr>
<thead>
<tbody>
    <?php foreach($vacations as $vacation){ ?>

        <tr>
        <th><?php echo $vacation['date_submitted']; ?></th>
        <th><?php echo $vacation['date_from']; ?></th>
        <th><?php echo $vacation['date_to']; ?></th>
        <th><?php echo getDatesDifference($vacation['date_from'], $vacation['date_to'])?></th>
        <th><?php echo $vacation['status']; ?></th>
    </tr>

    <?php } ?>
</tbody>
</table>
<a id="new_vacation" href="/<?php echo $currentDir ?>/create_vacation.php" > Create new vacation </a>

<?php
mysqli_free_result($result);

require('footer.php');

