<?php
date_default_timezone_set('Asia/Kolkata');
require_once '../config.php';
$hostname = 'https://associated-tape.000webhostapp.com';

session_start();
if(isset($_SESSION['user']) && isset($_SESSION['role'])){
  $s_email = $_SESSION['user'];
  $s_role = $_SESSION['role'];
  $s_id = $_SESSION['id'];
}else{
  header("Location: {$hostname}/adminlogin.php");
}


?>