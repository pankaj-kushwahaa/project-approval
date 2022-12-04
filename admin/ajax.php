

<?php 
include '../config.php';

$data = file_get_contents("php://input");
$mydata = json_decode($data , true);
$en_id = $mydata['del'];

$sql = "DELETE FROM enquery WHERE en_id = ?";
$result = $conn->prepare($sql);
if($result->execute(array($en_id))){
  echo 1;
}

?>