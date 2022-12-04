<?php 
include 'loginredirect.php';
define('TITLE', 'Registered Students');
define('PAGE', 'Registered Users');
include("includes/header.php"); 
include '../config.php';

if(isset($_REQUEST['del'])){
  $id = $_REQUEST['del-teacher'];

  $sql5 = "DELETE FROM admin_tb WHERE id = ?";
  $result5 = $conn->prepare($sql5);
  if($result5->execute(array($id))){
    $msg = '<div class="alert alert-success" id="del-rem">Deleted Successfully</div>';
  }
}
?>

<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="registered-users.php" class="w3-button w3-white">All Students
      <?php $sql8 = "SELECT stu_id, COUNT(stu_id) total_pro FROM student s INNER JOIN branch b ON s.stu_branch = b.branch_id";
            $result8 = $conn->prepare($sql8);
              if($result8->execute()){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo ' ('.$row8['total_pro'].')';
              } ?></a>
    <?php
      $sql3 = "SELECT DISTINCT branch_id, branch_name FROM branch b 
      INNER JOIN student s ON b.branch_id = s.stu_branch";
      $result3 = $conn->prepare($sql3);
      $result3->execute();
      if($result3->rowCount()){
        $value3 = $result3->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value3);
          echo '</pre>';*/
          foreach($value3 as $row3){
            $sql4 = "SELECT stu_id, COUNT(stu_id) total_stu FROM student WHERE stu_branch = ? ORDER BY stu_id";
            $result4 = $conn->prepare($sql4);
              if($result4->execute(array($row3['branch_id']))){
                $row4 = $result4->fetch(PDO::FETCH_ASSOC);
                $total_pro = $row4['total_stu'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row4);
                echo'</pre>';*/
              }
    ?>
    <a href="users-branch.php?branch_id=<?php echo $row3['branch_id'] ?>"  class="w3-button w3-white"><?php echo $row3['branch_name'].' ('.$total_pro.')'; ?></a>

    <?php }} 
      $sql6 = "SELECT email, COUNT(email) teachers FROM admin_tb WHERE role = ?";
      $result6 = $conn->prepare($sql6);
      $result6->execute([1]);
      $total = $result6->fetch(PDO::FETCH_ASSOC);
    ?>
    <a href="teachers-list.php" class="w3-button w3-black">Teachers <?php if(isset($total)){echo '('.$total['teachers'].')'; } ?></a>
  </div>
</div>

<!-- Table Container Start -->
<div class="w3-container">
  <h5>All Teachers</h5>
  <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-white">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Username</th>
        <th>Password</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      
        <?php 
          $sql2 = "SELECT email, id, password FROM admin_tb WHERE role = ?";
          $result2 = $conn->prepare($sql2);
          $result2->execute([1]);
          $num = 1;
          if($result2->rowCount()){
            while($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
        <td><?php echo $num; ?></td>
        <td><?php echo $row2['email']  ?></td>
        <td><?php echo $row2['password']  ?></td>
        <td><button type="submit" class="w3-btn w3-green w3-small" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete</button></td>

        <!-- Modal box start -->
<!-- Modal -->
<div class="container">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirm ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Delete ?
      </div>
      <div class="modal-footer">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="del-teacher" value="<?php echo $row2['id']; ?>">        
        <button type="submit" class="btn btn-primary" name="del">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Modal box end -->
        <?php $num++; }} ?>
    </tr>
  </tbody>
  </table>
  <?php if(isset($msg)){ echo $msg; } ?>
  <!-- Table End -->
</div>
<!-- Table Container End -->
<script>
  if(document.getElementById('del-rem')){
    setTimeout(() => {
      document.getElementById('del-rem').remove();
    }, 1500);
  }
</script>

<?php include("includes/footer.php"); ?>