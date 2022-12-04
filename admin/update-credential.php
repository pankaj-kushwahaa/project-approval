<?php
include 'loginredirect.php';
define('TITLE', 'Update Id & Password');
define('PAGE', 'Update Credential');
include("includes/header.php"); 

if(isset($_REQUEST['add'])){
  if($_REQUEST['username'] != '' && $_REQUEST['password'] != '' && $_REQUEST['id'] != ''){

    $user = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);
    $id = $_REQUEST['id'];

    $sql = "UPDATE admin_tb SET email = ?, password = ? WHERE id = ?";
    $result = $conn->prepare($sql);
    if($result->execute(array($user, $password, $id))){
      $msg = '<div class="alert alert-success" id="del-rem">Updated Successfully</div>';
    }else{
      $msg = '<div class="alert alert-danger">Cannot update, some technical error occured</div>';
    }
  }else{
    $msg = '<div class="alert alert-warning" id="del-rem">Fill both fields</div>';
  }
}
?>

<header class="w3-container" style="padding-top:10px">
    <h4 class="w3-center"><b>Update Profile</b></h4>
</header>

<div class="w3-container">
  <div class="row mt-3">
    <div class="col-sm-4">
      <table class="w3-table w3-bordered w3-border w3-white">
        <?php  
          $sql = "SELECT * FROM admin_tb WHERE  id = ?";
          $result = $conn->prepare($sql);       
          $result->bindColumn('email', $username);
          $result->bindColumn('password', $password);
          $result->bindColumn('role', $role);
          $result->execute(array($s_id));
          $result->fetch(PDO::FETCH_ASSOC);
        ?>
          <tr><th>Username</th><td><?php echo $username; ?></td></tr>
          <tr><th>Password</th><td><?php echo $password; ?></td></tr>
      </table>
    </div>
    <div class="col-md-6 col-sm-6 w3-border w3-white">
      <div class="w3-light w3-padding-large w3-white">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="w3-section">
            <label for="username">Username</label>
            <input type="text" class="w3-input w3-border" id="username" required name="username" value="">
          </div>
          <div class="w3-section">
            <label for="password">Password</label>
            <input type="text" class="w3-input w3-border" id="password" required name="password" value="">
            <input type="hidden" name="id" value="<?php echo $s_id; ?>">
          </div>
          <button type="submit" class="w3-btn w3-block w3-green" name="add">Update</button>
        </form><br>
        <?php if(isset($msg)){ echo $msg; } ?>
      </div>
    </div>
  </div>
</div>
<script>
  if(document.getElementById('del-rem')){
    setTimeout(() => {
      document.getElementById('del-rem').remove();
      location.href = "<?php echo $hostname; ?>/admin/update-credential.php";
    }, 1000);
  }
</script>

<?php include("includes/footer.php"); ?>