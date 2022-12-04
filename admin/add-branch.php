<?php 
include 'loginredirect.php';
define('TITLE', 'Add Branch');
define('PAGE', 'Add Branch');
include("includes/header.php"); 
include '../config.php';

if(isset($_REQUEST['update'])){
  if($_REQUEST['del-branch'] != ''){
    $branch_id = $_REQUEST['del-branch-id'];
    $branch_name = $_REQUEST['del-branch'];
  
    $sql2 = "UPDATE branch SET branch_name = ? WHERE branch_id = ?";
    $result2 = $conn->prepare($sql2);
    if($result2->execute(array($branch_name, $branch_id))){
      $msg = '<div class="alert alert-success">Updated successfully</div>';
    }
  }else{
    $msg = '<div class="alert alert-danger">Fill all fields</div>';
  }
}

?>

<div class="w3-container">
    <div class="row mt-5">
      <div class="col-md-4 col-sm-4">
          <form action="" method="post">
            <div class="w3-section">
              <label for="branch">Add Branch & Semester</label>
              <input type="text" class="w3-input w3-border" id="branch" name="branch" required>
            </div>
            <button type="submit" class="w3-btn w3-center w3-green" name="add_branch">Add</button>
          </form><br>
          <?php 
            if(isset($_REQUEST['add_branch'])){
              if($_REQUEST['branch'] !== ''){
                if(empty($_REQUEST['branch'])){ echo 'hello';}
                $branch = trim($_REQUEST['branch']);
                $sql = "INSERT INTO branch (branch_name, total_stu) VALUES (?,?)";
                $result = $conn->prepare($sql);
                if($result->execute(array($branch, 0))){
                  $msg1 = '<div class="alert alert-success">Branch Inserted</div>';
                }
                
              } else{
                $msg1 = '<div class="alert alert-danger">Fill all field</div>';
              }
            }

          ?>
          <?php if(isset($msg1)){ echo $msg1; } ?>
      </div>
      <div class="col-md-6 col-sm-6">
          <h5 class="w3-center">Branch & Semester</h5>
          <table class="w3-table w3-border w3-bordered w3-white">
            <thead>
              <tr><th>S.No</th><th>Name</th><th>No. of Students</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php 
                  $sql = "SELECT * FROM branch";
                  $result = $conn->prepare($sql);
                  $result->execute();
                  if($result->rowCount() > 0){
                    $num = 1;
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                <td><?php echo $num;  ?></td>
                <td><?php echo $row['branch_name'];  ?></td>
                <td class="w3-center"><?php echo $row['total_stu'];  ?></td>
                <td><label for="modalbox" id="modal-label<?php echo $row['branch_id']; ?>" class="w3-btn"><i class='fa-solid fa-edit'></i></label>
          <!-- Custom modal box -->
            <div class="cus-modal" id="modalbox<?php echo $row['branch_id']; ?>">
              <div class="cus-modal-box">
                <h5 style="display:inline">Edit</h5><span style="float:right;" id="modal-span" onclick="document.getElementById('modalbox<?php echo $row['branch_id'] ?>').style.display='none'" >x</span><hr>
                <!-- Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display:inline">
                  <input type="hidden" name="del-branch-id" value="<?php echo $row['branch_id']; ?>">
                  <input type="text" name="del-branch" value="<?php echo $row['branch_name']; ?>" class="w3-input w3-border">
          <!-- End Form --> <br><br>
                <button type="submit" class="btn w3-green w3-btn" name="update">Update</button></form>
                <button class="btn w3-grey w3-btn" onclick="document.getElementById('modalbox<?php echo $row['branch_id']; ?>').style.display='none'">Close</button>
              </div>
            </div>
            <script>
              document.getElementById('modal-label<?php echo $row['branch_id']; ?>').addEventListener('click', () => {
                document.getElementById('modalbox<?php echo $row['branch_id']; ?>').style.display = 'block';
                (this).preventDefault();
              });
            </script>
<!-- Custom modal box end -->
</td>
              </tr>
              <?php $num++;} }else{
                $msg = 'No Records';
              } ?>            
              <?php if(isset($msg)){ echo '<tr><td>'.$msg.'</td></tr>'; } ?>
              </tbody>
          </table>
      </div>
    </div>
  </div>
</div>

<script>
  if(document.querySelector('.alert')){
    setTimeout(() => {
      document.querySelector('.alert').remove();
    }, 1500);
  }
</script>

<?php include('includes/footer.php'); ?>