<?php
session_start();

if (isset($_POST['datefrom']) and isset($_POST['dateto'])){


    echo "ready to save info..";
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