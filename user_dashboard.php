<?php
session_start();
require('connect.php');
require('functions.php');


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `vacations` WHERE user_id='$user_id'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$vacations = mysqli_fetch_all($result, MYSQLI_ASSOC);

//TODO: make table scrollable
?>
 <table style="width:50%">
    <tr>
        <th>Date Submitted</th>
        <th>Date From</th>
        <th>Date To</th>
        <th>Days requested</th>
        <th>Status</th>
    </tr>
    <?php foreach($vacations as $vacation){ ?>

        <tr>
        <th><?php echo $vacation['date_submitted']; ?></th>
        <th><?php echo $vacation['date_from']; ?></th>
        <th><?php echo $vacation['date_to']; ?></th>
        <th><?php echo getDatesDifference($vacation['date_from'], $vacation['date_to'])?></th>
        <th><?php echo $vacation['status']; ?></th>
    </tr>

    <?php } ?>
</table>
<a href="/epignosis_portal/create_vacation.php" > Create new vacation </a>

<?php
mysqli_free_result($result);

