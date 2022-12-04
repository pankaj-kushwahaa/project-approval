<?php 
include 'loginredirect.php';
define('TITLE', 'Registered Students');
define('PAGE', 'Registered Users');
include("includes/header.php"); 
include '../config.php';

$limit = 6;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;


if(isset($_REQUEST['delete'])){
  $stu_id = $_REQUEST['del-user'];
  $sql7 = "DELETE FROM enquery WHERE en_stu_id = ?";
  $result7 = $conn->prepare($sql7);
  if($result7->execute(array($stu_id))){
    $sql9 = "DELETE FROM members WHERE m_stu_id = ?";
    $result9 = $conn->prepare($sql9);
    if($result9->execute(array($stu_id))){
      $sql23 = "SELECT pro_file FROM project_request WHERE pro_stu_id = ?";
      $result23 = $conn->prepare($sql23);
      $result23->execute(array($stu_id));
      while($row23 = $result23->fetch(PDO::FETCH_ASSOC)){
          unlink('../student/upload/'.$row23['pro_file']);
      }
      $sql5 = "DELETE FROM project_status WHERE sta_stu_id = ?";
      $result5 = $conn->prepare($sql5);
      if($result5->execute(array($stu_id))){
        $sql12 = "DELETE FROM project_request WHERE pro_stu_id = ?";
        $result12 = $conn->prepare($sql12);
        if($result12->execute(array($stu_id))){
         // Select branch id for delete
         $sql11 = "SELECT stu_branch FROM student WHERE stu_id = ?";
         $result11 = $conn->prepare($sql11);
         $result11->execute([$stu_id]);
         $result11->bindColumn('stu_branch', $stu_branch);
         $row11 = $result11->fetch(PDO::FETCH_ASSOC);
         // branch id end
         $sql7 = "UPDATE branch SET total_stu = total_stu - 1 WHERE branch_id = ?";
         $result7 = $conn->prepare($sql7);
         if($result7->execute(array($stu_branch))){
             $sql13 = "SELECT stu_img FROM student WHERE stu_id = ?";
             $result13 = $conn->prepare($sql13);
             $result13->execute(array($stu_id));
             $row13 = $result13->fetch(PDO::FETCH_ASSOC);
             if($row13['stu_img'] !== 'image'){
                 unlink('../student/profilepic/'.$row13['stu_img']);
             }
            $sql10 = "DELETE FROM student WHERE stu_id = ?";
            $result10 = $conn->prepare($sql10);
            if($result10->execute(array($stu_id))){
                echo '<script>location.href = "'.$hostname.'/admin/registered-users.php";</script>';
            } 
          }  
        }
      }
    }
  }
}
?>

<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="registered-users.php" class="w3-button w3-black">All Students
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
    <a href="teachers-list.php" class="w3-button w3-white">Teachers <?php if(isset($total)){echo '('.$total['teachers'].')'; } ?></a>
  </div>
</div>

<!-- Conatainer Start -->
<div class="w3-container">
  <h5>All Registered Users</h5>
    <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-white">
    <thead>
      <tr>
          <th>S.No</th>
          <th>Email</th>
          <th>Password</th>
          <th>Phone</th>
          <th>Branch</th>
          <th>Members</th>
          <th>Action</th>
      </tr>
    </thead>
<?php
        $sql = "SELECT stu_id, stu_branch, stu_phone, stu_email, stu_password, stu_name, stu_rollno, branch_name FROM student s
        LEFT JOIN branch b ON s.stu_branch = b.branch_id
        ORDER BY stu_id DESC LIMIT ?, ?"; 
        $result = $conn->prepare($sql);
        $result->execute(array($offset, $limit));
        
        /*$value = $result->fetchAll(PDO::FETCH_ASSOC);
       echo '<pre>';
        echo print_r($value);
        echo '</pre>';*/

        if($result->rowCount()){
         $num = $offset + 1;
         $value = $result->fetchAll(PDO::FETCH_ASSOC);
          foreach($value as $row){
         ?>
    <tbody>
      <tr>
          <td><?php echo $num; ?></td>
          <?php  
            $sql1 = "SELECT * FROM members WHERE m_stu_id = ?";
            $result1 = $conn->prepare($sql1);
            $result1->execute(array($row['stu_id']));
            
            if($result1->rowCount()){
              /*$row1 = $result1->fetchAll(PDO::FETCH_ASSOC);
              echo '<pre>';
              echo print_r($row1);
              echo '</pre>';*/
              $Members = '<td>';
              $Members .= $row['stu_name'].' '.$row['stu_rollno']."<br>";
              while($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
               $Members .= $row1['m_name'].' '.$row1['m_rollno'].'<br>';
              } 
              $Members .= '</td>';
            }else{
              $Members = '<td>'.$row['stu_name'].' '.$row['stu_rollno'].'</td>';
            }
          ?>
          <td><?php if(isset($row['stu_email'])){ echo $row['stu_email']; } ?></td>
          <td><?php if(isset($row['stu_password'])){ echo $row['stu_password']; } ?></td>
          <td><?php if(isset($row['stu_phone'])){ echo $row['stu_phone']; } ?></td>
          <td><?php if(isset($row['branch_name'])){ echo $row['branch_name']; } ?></td>
          <?php if(isset($Members)){echo $Members;} ?>
          <td><label for="modalbox" id="modal-label<?php echo $row['stu_id'] ?>" class="w3-btn"><i class='fa-solid fa-trash'></i></label>
          <!-- Custom modal box -->
            <div class="cus-modal" id="modalbox<?php echo $row['stu_id'] ?>">
              <div class="cus-modal-box">
                <h5 style="display:inline">Confirm ?</h5><span style="float:right;" id="modal-span" onclick="document.getElementById('modalbox<?php echo $row['stu_id'] ?>').style.display='none'" >x</span><hr>
                <div class="alert alert-warning"> <b>Warning !</b> This will delete all information associated with the student, including projects, project statuses, enqueries, team members. </div>
                <!-- Form -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="display:inline">
                  <input type="hidden" name="del-user" value="<?php echo $row['stu_id']; ?>"><br>
                <button type="submit" class="btn w3-red w3-btn" name="delete"> Delete</button></form>
                <!-- End Form -->
                <button class="btn w3-grey w3-btn" onclick="document.getElementById('modalbox<?php echo $row['stu_id'] ?>').style.display='none'">Close</button>
              </div>
            </div>
            <script>
              document.getElementById('modal-label<?php echo $row['stu_id'] ?>').addEventListener('click', () => {
                document.getElementById('modalbox<?php echo $row['stu_id'] ?>').style.display = 'block';
                (this).preventDefault();
              });
            </script>
          <!-- Custom modal box end -->
          </td>

          <?php  $num++;
           }
          } else{
            $msg = '<td class="w3-white" style="font-size:20px;">No records</td>';
          }
         ?>
         <?php if(isset($msg)){ echo $msg; } ?>
         </tr>
        </tbody>
  </table><br>
  <!-- Table End -->

    <!-- Pagination Start -->
<div class="w3-row pagination">
  <?php
    $sql2 = "SELECT stu_id FROM student";

    $result2 = $conn->prepare($sql2);
    $result2->execute();
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-grey mx-1"><a href="registered-users.php?page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="registered-users.php?page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="registered-users.php?page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
    <!-- Pagination End -->
</div> 
  <!-- container end -->


<?php include("includes/footer.php"); ?>