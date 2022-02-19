<?php

// starting the session
session_start();
// unsetting the session so that the user goes back to the login page
unset($_SESSION['user']);

// redirecting the user to the login page
header("location:./login.php");

?>