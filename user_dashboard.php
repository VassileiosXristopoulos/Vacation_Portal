<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: /epignosis_portal/index.php");
    exit();
}

require('header.php');
require('connect.php');
require('functions.php');


if($_SESSION['is_admin']){
    echo "Cannot acces page. The Create Vacation page is for Employees";
    echo '</br> <a href="/epignosis_portal/admin_dashboard.php">Go to admin dashboard </a>';
    require('footer.php');
    die;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `vacations` WHERE user_id='$user_id'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$vacations = mysqli_fetch_all($result, MYSQLI_ASSOC);

//TODO: make table scrollable
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
<?php // TODO: check for better way of writting path ?>
<a id="new_vacation" href="/epignosis_portal/create_vacation.php" > Create new vacation </a>

<?php
mysqli_free_result($result);

require('footer.php');

