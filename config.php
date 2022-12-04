<?php


$dsn = "mysql:host=localhost;dbname=approval2";
$db_user = "root";
$db_password = "";


// Create Connection
try{
  $conn = new PDO($dsn, $db_user, $db_password);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
  //PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, 
 // echo "Connected";
} catch(PDOException $e){
  echo "Connection Failed".$e->getMessage();
}


$hostname = 'http://localhost/approval2';

$emailUsername = 'youremail@gmail.com';
$emailPassword ='Email Password';
$emailName = 'Website name';
$websiteName = 'Approve Your Project';

?>