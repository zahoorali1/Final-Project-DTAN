<?php

session_start();


// Remove all session variables

$_SESSION = array();


// Destroy session

session_destroy();


// Return to login page

header("Location: login.php");

exit;

?>