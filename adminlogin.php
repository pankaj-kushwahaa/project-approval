<?php
include 'config.php';
session_start();
if(isset($_SESSION['user']) && isset($_SESSION['role'])){
  header("Location: {$hostname}/admin/dashboard.php");
}

if(isset($_REQUEST['login'])){
  if(($_POST['email'] !== '') && ($_POST['password'] !== '') && ($_POST['role'] !== '')){
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
   
    try{
      $sql = "SELECT * FROM admin_tb WHERE email = ? AND password = ? AND role = ?";
      $result = $conn->prepare($sql);
      $result->execute(array($email, $password, $role));
      if($result->rowCount() > 0){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['id'] = $row['id'];
        header("Location: {$hostname}/admin/dashboard.php");
      } else{
        $msg = '<div class="alert alert-warning w3-yellow">Invalid Credential</div>';
      }  
    } catch(PDOException $e){
      echo $e->getMessage();
    }
  } else{
    $msg = '<div class="alert alert-danger">Fill all fields</div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="css/bootstrap.css">
  <!-- Font awesome css -->
  <link rel="stylesheet" href="css/fontawesome.css">
  <!-- w3 css -->
  <link rel="stylesheet" href="css/w3css.css">
  <!-- Custome Css -->
  <link rel="stylesheet" href="css/style.css">
  <title>Login</title>
</head>
<body>
  <p class="text-center mt-5 mx-2" style="font-size:30px;"><i class="fas fa-user-secret text-danger"></i> Admin Login</p>


<div class="container-fluid">
  <div class="row justify-content-center mt-5">
    <div class="col-sm-6 col-sm-4">
      <form action="" method="post" class="w3-light-grey shadow p-4">
        <div class="form-group my-2"><i class="fas fa-user"></i>
            <label for="email" class="font-weight-bold pl-2">&nbsp;Username</label>
            <input type="text" name="email" id="email" class="w3-input w3-border" required>
          <div class="form-group my-2"><i class="fas fa-key"></i>
            <label for="pass" class="font-weight-bold pl-2">&nbsp;Password</label>
            <input type="password" name="password" id="pass" class="w3-input w3-border" required>
          </div>
          <div class="form-group my-2">
            <label for="role">Role</label>
            <select name="role" id="role" class="w3-input w3-border" required>
              <option value="">Select</option>
              <option value="0">HOD</option>
              <option value="1">Teacher</option>
            </select>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="w3-red mt-3 font-weight-bold btn-block w3-btn shadow-sm" name="login" id="log1">Login</button>
          </div><br>
          <div id="div1"><?php if(isset($msg)){ echo $msg; } ?></div>    
        </div>
      </form>
      <div class="text-center"><a href="index.php" class="btn btn-info mt-5 shadow-btn font-weight-bold">Back to Home</a></div>
    </div>
  </div>
</div>
<!-- JavaScript files start -->
  <script src="js/all.min.js"></script>
  <script src="js/bootstrapbundle.js"></script>
<!-- JavaScript files end -->
<script>
 document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
});
    
</script>
</body>
</html>