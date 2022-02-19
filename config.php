<?php

// assignning every thing needed in connection of database in a variable
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travels";

// establishing connection with database
$conn = new mysqli($servername, $username, $password, $dbname);

define ('DIR_PATH', realpath(dirname(__FILE__)));
define('DIR_URL', 'http://localhost/travel/');
?>
