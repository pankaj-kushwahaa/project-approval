<?php
date_default_timezone_set('Asia/Kolkata');
include '../config.php';
session_start();
if(isset($_SESSION['s_email']) && isset($_SESSION['s_name'])){
  $stu_email = $_SESSION['s_email'];
  $stu_id = (int)$_SESSION['s_id'];
  $stu_name = $_SESSION['s_name'];
  $stu_branch = (int)$_SESSION['s_branch'];
  $stu_img = $_SESSION['s_img'];
  $stu_rollno = $_SESSION['s_rollno'];
  $stu_phone = $_SESSION['s_phone'];
}else{
  header("Location: {$hostname}/");
}


?>