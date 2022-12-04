<?php

require_once '../config.php';

session_start();  // Session start

session_unset(); // Session remove session variables

session_destroy(); // Destroy current session

header("Location: {$hostname}")

?>