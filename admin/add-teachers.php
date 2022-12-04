<?php 
include 'loginredirect.php';
define('TITLE', 'Add Users');
define('PAGE', 'Add Users');
include("includes/header.php");
include '../config.php';

if(isset($_REQUEST['add'])){
  if($_REQUEST['username'] !== '' && $_REQUEST['password'] !== '' && $_REQUEST['role']){

    $user = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);
    $role = $_REQUEST['role'];

    $sql = "INSERT INTO admin_tb (email, password, role) VALUES (?,?,?)";
    $result = $conn->prepare($sql);
    if($result->execute(array($user, $password, $role))){
      $msg = '<div class="alert alert-success" id="del-rem">Added Successfully</div>';
    }else{
      $msg = '<div class="alert alert-danger">Cannot added, Some technical error occured</div>';
    }
  }else{
    $msg = '<div class="alert alert-warning">Fill both fields are required</div>';
  }
}
?>

<!-- Form Start -->
<div class="w3-container">
  <div class="row mt-3 justify-content-center">
    <div class="col-md-6 col-sm-10">
      <div class="w3-light-grey w3-padding-large w3-padding-32 w3-margin-top  shadow" id="contact">
        <h3 class="w3-center">Add Users</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="w3-section">
            <label for="username">Username</label>
            <input type="text" class="w3-input w3-border" id="username" required name="username">
          </div>
          <div class="w3-section">
            <label for="password">Password</label>
            <input type="password" class="w3-input w3-border" id="password" required name="password">
          </div>
          <div class="w3-section">
            <label for="role">Role</label>
            <select name="role" id="role" class="w3-input w3-border" required>
              <option value="">Select</option>
              <?php if($s_role == 0){ ?>
              <option value="0">HOD</option>
              <?php } ?>
              <option value="1">Teacher</option>
            </select>
          </div>
          <button type="submit" class="w3-btn w3-block w3-red" name="add">Add</button>
        </form><br>
        <?php if(isset($msg)){ echo $msg; } ?>
      </div>
    </div>
  </div>
</div>
<!-- Form End -->
<script>
  if(document.getElementById('del-rem')){
    setTimeout(() => {
      document.getElementById('del-rem').remove();
    }, 2000);
  }
</script>

<?php include("includes/footer.php"); ?>