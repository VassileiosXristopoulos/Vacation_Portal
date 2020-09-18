<?php
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "portal_db";
 $mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db);

// Check connection
if (!$mysqli) {
  die("Connection failed: " . mysqli_connect_error());
}
?> 