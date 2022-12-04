<?php 
include 'loginredirect.php';
define('TITLE', 'Change Password');
define('PAGE', 'changepassword');
include("header.php");
include '../config.php'; 

if(isset($_REQUEST['change'])){
  if($_REQUEST['password2'] !== '' && $_REQUEST['password3'] !== ''){
    if($_REQUEST['password2'] == $_REQUEST['password3']){
      $password = $_REQUEST['password2'];
      $sql = "UPDATE `student` SET `stu_password` = ? WHERE `student`.`stu_id` = ?";
       $result = $conn->prepare($sql);
       if($result->execute(array($password, $stu_id))){
         $msg = '<div class="alert alert-success" id="msgupdate">Updated Successfully</div>';
         //echo '<script>location.href = "'.$hostname.'/student/updateprofile.php"</script>';
       }
    }else{
      $msg = '<div class="alert alert-danger" id="msgupdate">Password does not match</div>';
    }
  }else{
    $msg = '<div class="alert alert-danger" id="msgupdate">Fill All Fieldss</div>';
  }
}
?>

<header class="w3-container" style="padding-top:15px">
    <h4 class="w3-center"><b>Change password</b></h4>
</header>

<div class="w3-container">
  <div class="row justify-content-center">
      <div class="col-md-6 col-sm-6 shadow">
      <form action="" method="post">
      <div class="w3-section">
        <label for="password2">New passowrd</label>
        <input type="password" class="w3-input w3-border" id="password2" name="password2">
      </div>
      <div class="w3-section">
        <label for="password3">Confirm new password</label>
        <input type="password" class="w3-input w3-border" id="password3" name="password3">
      </div>
      <div class="row justify-content-center">
        <div class="col-sm-3 col-md-3">
            <button type="submit" class="w3-btn w3-green" name="change"><i class="fa-solid fa-check"></i> Change</button>
        </div>
        <?php if(isset($msg)){ echo $msg; } ?>
      </div>      
    </form><br>
    </div>
    </div>
  </div>
  <script>
    if(document.getElementById('msgupdate')){
    setTimeout(() => {
      document.getElementById('msgupdate').remove();
    }, 2000);
  }
  </script>

<?php include('footer.php'); ?>