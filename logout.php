<?php
session_start();
session_unset();
session_destroy();
require('constants.php');
header("Location: /".$currentDir."/index.php");