<?php 
include 'loginredirect.php';
define('TITLE', 'Add Members');
define('PAGE', 'addmember');
include("header.php"); 
// Add members
if(isset($_POST['add_member'])){
  if($_POST['membername'] !== '' && $_POST['memberrollno']){

    $membername = $_POST['membername'];
    $memberrollno = $_POST['memberrollno'];
    $m_stu_id = $_SESSION['s_id'];

    $sql = "INSERT INTO members (m_name, m_rollno, m_stu_id) VALUE (?, ?, ?)";
    $result = $conn->prepare($sql);
    if($result->execute([$membername, $memberrollno, $m_stu_id])){
      $msg = '<div class="alert alert-success" id="msg">Member Added</div>';
    }else{
      $msg = '<div class="alert alert-danger">There is some technical error</div>';
    }
  }else{
    $msg = '<div class="alert alert-danger">Fill both fields</div>';
  }
}

// Show members
if(isset($_POST['remove_member'])){
  $m_id = $_POST['m_id'];
  $sql2 = "DELETE FROM members WHERE m_id = ?";
  $result2 = $conn->prepare($sql2);
  if($result2->execute([$m_id])){
    $msg2 = '<div class="alert alert-success" id="msg1">Deleted successfully</div>';
  }else{
    $msg2 = '<div class="alert alert-danger">Unable to delete, some error</div>';
  }
}
?>
<header class="w3-container" style="padding-top:15px">
    <h4 ><b>Add team members <br> (Name & Roll no)</b></h4>
</header>

<div class="w3-container">
    <div class="row mt-3">
      <div class="col-md-4 col-sm-4">
          <form action="" method="post">
            <div class="w3-section">
              <label for="membername">Member name</label>
              <input type="text" class="w3-input w3-border" id="membername" required name="membername">
            </div>
            <div class="w3-section">
              <label for="memberrollno">Roll no.</label>
              <input type="number" class="w3-input w3-border" rows="10"  id="memberrollno" required name="memberrollno">      
            </div>
            <button type="submit" class="w3-btn w3-center w3-green" name="add_member">Add</button>
          </form><br>
          <?php if(isset($msg)){ echo $msg; } ?>
      </div>
      <div class="col-md-6 col-sm-6">
          <h5 class="w3-center">Team Members</h5>
          <table class="w3-table w3-border w3-bordered w3-white">
            <thead>
              <tr><th>S.No</th><th>Name</th><th>Roll No.</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php
                $sql1 = "SELECT m_name, m_rollno, m_id FROM members WHERE m_stu_id = ?";
                $result1 = $conn->prepare($sql1);
                $result1->execute([$stu_id]);
                $i = 1;
                if($result1->rowCount() > 0){
                  while($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$row1['m_name'].'</td>';
                    echo '<td>'.$row1['m_rollno'].'</td>';
                    echo '<td><form action="" method="post"><input type="hidden" value="'.$row1['m_id'].'" name="m_id"><button type="submit" class="w3-btn" name="remove_member"><i class="fa-solid fa-trash"></i></button></form></td>';
                    echo '</tr>';
                    $i++;
                  } 
                }else{
                  echo '<tr><td colspan="4"class="w3-white w3-center">No records</td></tr>';
                }
              ?>
            </tbody>
          </table><br>
          <?php if(isset($msg2)){ echo $msg2; }  ?>
      </div>
    </div>
  </div>
</div>

<script>
  if(document.getElementById('msg')){
    setTimeout(() => {
      const message = document.getElementById('msg');
      message.remove();
    }, 1500);
  }

  if(document.getElementById('msg1')){
    setTimeout(() => {
      const message1 = document.getElementById('msg1');
      message1.remove();
    }, 1500);
  }
</script>

<?php include('footer.php'); ?>